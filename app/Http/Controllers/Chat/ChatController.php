<?php

namespace App\Http\Controllers\Chat;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\CustomerContract;
use App\Models\Message;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class ChatController extends Controller
{

    /**
     * Handles the authentication of the Pusher presence channel.
     *
     * @param Request $request The HTTP request containing the socket ID, channel name, and user ID.
     * @return \Illuminate\Http\JsonResponse The JSON response containing authentication data or error messages.
     */
    public function pusherAuth(Request $request)
    {
        try {
            $socketId = $request->input('socket_id');
            $channelName = $request->input('channel_name');
            $userId = $request->input('user_id');
            // Retrieve user_id from headers or authentication
            // $userId = $request->header('user_id');
            if (!$userId) {
                return response()->json([
                    'status' => false,
                    'message' => 'User ID is required in the headers.'
                ], 422);
            }

            // Build user data for the presence channel
            $userData = [
                'user_id' => $userId, // Mandatory for presence channels
                'user_info' => [      // Optional user metadata
                    'name' => 'User ' . $userId, // Replace with actual name from DB
                    'avatar' => 'default-avatar.png', // Replace with actual avatar from DB
                ],
            ];

            $key = 'eaaf59b964fbd682eab8'; // Your Pusher App Key
            $secret = '0ce5d033bb4ee0011b98'; // Your Pusher App Secret

            // Generate the authentication signature
            $stringToSign = "{$socketId}:{$channelName}:" . json_encode($userData);
            $signature = hash_hmac('sha256', $stringToSign, $secret);

            // Return the response required by Pusher
            return response()->json([
                'auth' => "{$key}:{$signature}",
                'channel_data' => json_encode($userData), // JSON encoded user data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Sends a new message to the receiver and broadcasts it to the appropriate Pusher channel.
     *
     * @param Request $request The HTTP request containing the sender, receiver, message, and optional attachments.
     * @return \Illuminate\Http\JsonResponse The response containing the message status or error messages.
     */
    public function sendMessage(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'sender_id' => 'required|exists:users,id',
                    'receiver_id' => 'required|exists:users,id',
                    'message' => 'required_without:attachments',
                    'attachments' => 'nullable',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $getAvatar = UserDetail::where('user_id', $request->sender_id)->first('image');

            $message = new Message();
            $message->sender_id = $request->sender_id;
            $message->receiver_id = $request->receiver_id;
            $message->message = $request->message ?? ' ';
            $message->avatar = $getAvatar->image ?? null;
            $message->is_read = false;

            if ($request->hasFile('attachments')) {
                /** Upload new attachments */
                $upload_location = '/storage/chat-attachments/';
                $file = $request->attachments;
                $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . $upload_location, $name_gen);
                $save_url = $upload_location . $name_gen;
                /** Saving in DB */
                $message->attachments = $save_url;
            }

            $message->save();

            broadcast(new MessageSent($message))->toOthers();


            // Pusher instance
            $pusher = new Pusher(
                'eaaf59b964fbd682eab8',
                '0ce5d033bb4ee0011b98',
                '1824635',
                ['cluster' => 'ap2', 'useTLS' => true]
            );

            // Presence channel name
            $roomId = 'room_' . min($message->sender_id, $message->receiver_id) . '_' . max($message->sender_id, $message->receiver_id);
            $channelName = 'presence-ChatAppForYBL.' . $roomId;

            // Check for online users in the channel
            $presenceData = $pusher->get('/channels/' . $channelName . '/users');

            $onlineUserIds = [];
            if (isset($presenceData->users)) {
                // Accessing the 'users' as an array within the object
                $onlineUserIds = array_map(function ($user) {
                    return $user->id;  // Accessing the 'id' property of each user object
                }, (array) $presenceData->users);  // Cast the object to an array if necessary
            }

            if (!in_array($message->receiver_id, $onlineUserIds)) {
                $this->sendNotificationChat([$message->receiver_id], $request->message ?? ' ', null, null, $message->Sender, $message->Sender->getUserDetails);
            }

            return response()->json([
                'status' => true,
                'message' => $message
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Retrieves all messages between the specified sender and receiver.
     *
     * @param Request $request The HTTP request containing the sender and receiver IDs.
     * @return \Illuminate\Http\JsonResponse The response containing the messages or error messages.
     */
    public function getMessages(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'sender_id' => 'required|exists:users,id',
                    'receiver_id' => 'required|exists:users,id',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $userId = $request->sender_id;
            $otherUserId = $request->receiver_id;

            // Get messages
            $messages = Message::where(function ($query) use ($userId, $otherUserId) {
                $query->where([
                    ['sender_id', '=', $userId],
                    ['receiver_id', '=', $otherUserId]
                ])
                    ->orWhere([
                        ['sender_id', '=', $otherUserId],
                        ['receiver_id', '=', $userId]
                    ]);
            })
                ->orderBy('created_at', 'asc')
                ->get();

            // Collect all user IDs involved in the messages
            $userIds = $messages->pluck('sender_id')->merge($messages->pluck('receiver_id'))->unique();

            // Fetch user avatars in a single query
            $userAvatars = UserDetail::whereIn('user_id', $userIds)->pluck('image', 'user_id');

            // Assign avatars to the messages
            foreach ($messages as $message) {
                $message->avatar = $userAvatars[$message->sender_id] ?? null;
            }

            return response()->json([
                'status' => true,
                'messages' => $messages
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Fetches all conversations for a customer, including the last message in each conversation.
     *
     * @param Request $request The HTTP request containing the customer ID.
     * @return \Illuminate\Http\JsonResponse The response containing the conversations or error messages.
     */
    public function conversationsForCustomer(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'customer_id' => 'required|exists:users,id',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $conversations = CustomerContract::with(['getAttornies.getUserDetails'])
                ->where('customer_id', $request->customer_id)
                ->where('status', 'Accepted')
                ->get();

            $converse = $conversations->map(function ($conversation) {
                $getLastChatMessage = Message::where(function ($query) use ($conversation) {
                    $query->where('sender_id', $conversation->customer_id)
                        ->where('receiver_id', $conversation->getAttornies->id)
                        ->orWhere(function ($query) use ($conversation) {
                            $query->where('sender_id', $conversation->getAttornies->id)
                                ->where('receiver_id', $conversation->customer_id);
                        });
                })
                    ->latest()
                    ->first();

                // Count unread messages (where is_read = 0)
                $unreadMessageCount = Message::where(function ($query) use ($conversation) {
                    $query->where('sender_id', $conversation->customer_id)
                        ->where('receiver_id', $conversation->getAttornies->id)
                        ->orWhere(function ($query) use ($conversation) {
                            $query->where('sender_id', $conversation->getAttornies->id)
                                ->where('receiver_id', $conversation->customer_id);
                        });
                })
                    ->where('is_read', 0) // Only count unread messages
                    ->count();

                return [
                    'attorney' => $conversation->getAttornies,
                    'lastMessage' => $getLastChatMessage,
                    'unreadMessageCount' => $unreadMessageCount, // Add unread count
                ];
            });


            return response()->json([
                'status' => true,
                'conversation' => $converse
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Retrieves conversations for a specific attorney, including the last message exchanged with the customer.
     *
     * @param Request $request The HTTP request containing the attorney ID.
     * @return \Illuminate\Http\JsonResponse The response containing the conversations or error messages.
     */
    public function conversationsForAttorney(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'attorney_id' => 'required|exists:users,id',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $conversations = CustomerContract::with(['getCustomer.getUserDetails'])
                ->where('attorney_id', $request->attorney_id)
                ->where('status', 'Accepted')
                ->get();

            $converse = $conversations->map(function ($conversation) {
                $getLastChatMessage = Message::where(function ($query) use ($conversation) {
                    $query->where('sender_id', $conversation->attorney_id)
                        ->where('receiver_id', $conversation->getCustomer->id)
                        ->orWhere(function ($query) use ($conversation) {
                            $query->where('sender_id', $conversation->getCustomer->id)
                                ->where('receiver_id', $conversation->attorney_id);
                        });
                })
                    ->latest()
                    ->first();

                // Count unread messages (where is_read = 0)
                $unreadMessageCount = Message::where(function ($query) use ($conversation) {
                    $query->where('sender_id', $conversation->attorney_id)
                        ->where('receiver_id', $conversation->getCustomer->id)
                        ->orWhere(function ($query) use ($conversation) {
                            $query->where('sender_id', $conversation->getCustomer->id)
                                ->where('receiver_id', $conversation->attorney_id);
                        });
                })
                    ->where('is_read', 0) // Only count unread messages
                    ->count();

                return [
                    'customer' => $conversation->getCustomer,
                    'lastMessage' => $getLastChatMessage,
                    'unreadMessageCount' => $unreadMessageCount, // Add unread count
                ];
            });

            return response()->json([
                'status' => true,
                'conversation' => $converse
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Marks messages as read between a sender and a receiver.
     *
     * @param Request $request The HTTP request containing the sender ID and receiver ID.
     * @return \Illuminate\Http\JsonResponse The response indicating the status of the update.
     */

    public function chatMarkAsRead(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'sender_id' => 'required',
                    'receiver_id' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            Message::where(function ($query) use ($request) {
                $query->where('sender_id', $request->sender_id)
                      ->where('receiver_id', $request->receiver_id);
            })
            ->orWhere(function ($query) use ($request) {
                $query->where('sender_id', $request->receiver_id)
                      ->where('receiver_id', $request->sender_id);
            })
            ->where('is_read', 0)
            ->update(['is_read' => 1]);


            return response()->json([
                'status' => true,
                'read' => 'success'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Marks all messages as read between a specific sender and receiver.
     *
     * @param int $sender The sender's user ID.
     * @param int $receiver The receiver's user ID.
     * @return \Illuminate\Http\JsonResponse The response indicating the status of the update.
     */
    public function markAsRead($sender, $receiver)
    {
        Message::where('sender_id', $sender)
            ->where('receiver_id', $receiver)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
    }
}
