<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerContract;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerChatController extends Controller
{
        /**
     * Display the messages between the customer and a specific receiver.
     *
     * This method retrieves the sender and receiver details, as well as the most recent message
     * between them. It then passes this data to the view for display.
     *
     * @param int $receiver_id The ID of the receiver (another user)
     * @return \Illuminate\View\View
     */
    public function messages($receiver_id)
    {
        $receiver = User::where('id', $receiver_id)->first();
        $sender = User::where('id', auth()->user()->id)->first();
        $last_message_date = Message::where('sender_id', $sender->id)->where('receiver_id', $receiver->id)->orderby('id', 'desc')->first();
        return view('customer.messages', compact('receiver_id', 'receiver', 'sender', 'last_message_date'));
    }
/**
     * Display the list of chats for the customer.
     *
     * This method retrieves the list of accepted customer contracts and maps through the conversations
     * to get unique attorneys involved with the customer. For each attorney, it retrieves the last message
     * exchanged and counts the unread messages.
     *
     * @return \Illuminate\View\View
     */
    public function chat_list()
    {
        // Step 1: Fetch the conversations
        $conversations = CustomerContract::with(['getAttornies.getUserDetails'])
            ->where('customer_id', auth()->user()->id)
            ->where('status', 'Accepted')
            ->get();

        // Step 2: Get unique conversations based on attorney_id
        $uniqueConversations = $conversations->unique('attorney_id');

        // Step 3: Map through the unique conversations to get the last message
        $converse = $uniqueConversations->map(function ($conversation) {
            $attorney = $conversation->getAttornies;

            $unreadCount = Message::where('sender_id', $attorney->id)
                        ->where('receiver_id', auth()->id())
                        ->where('is_read', false)
                        ->count();

            // Step 4: Get the last chat message between the customer and the attorney
            $getLastChatMessage = Message::where(function ($query) use ($conversation, $attorney) {
                $query->where('sender_id', $conversation->customer_id)
                    ->where('receiver_id', $attorney->id)
                    ->orWhere(function ($query) use ($conversation, $attorney) {
                        $query->where('sender_id', $attorney->id)
                            ->where('receiver_id', $conversation->customer_id);
                    });
            })
                ->latest()
                ->first();

            // Step 5: Return the attorney and the last message
            return [
                'attorney' => $attorney,
                'lastMessage' => $getLastChatMessage,
                'unreadCount' => $unreadCount,
            ];
        });
        return view('customer.chat', compact('converse'));
    }
}
