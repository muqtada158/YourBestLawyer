<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use App\Models\CustomerContract;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class AttorneyChatController extends Controller
{
    /**
 * Displays the message page for a specific conversation.
 *
 * @param int $receiver_id The ID of the receiver of the message.
 * @return \Illuminate\View\View The view displaying the message conversation.
 */
    public function messages($receiver_id)
    {
        $receiver= User::where('id',$receiver_id)->first();
        $sender= User::where('id',auth()->user()->id)->first();
        $last_message_date = Message::where('sender_id',$sender->id)->where('receiver_id',$receiver->id)->orderby('id','desc')->first();
        return view('attorney.messages',compact('receiver_id','receiver','sender','last_message_date'));
    }
/**
 * Displays the list of all chat conversations with the customer.
 *
 * @return \Illuminate\View\View The view displaying the chat list.
 */
    public function chat_list()
    {
        // Step 1: Fetch the conversations
        $conversations = CustomerContract::with(['getCustomer.getUserDetails'])
            ->where('attorney_id', auth()->user()->id)
            ->where('status', 'Accepted')
            ->get();

        // Step 2: Get unique conversations based on attorney_id
        $uniqueConversations = $conversations->unique('customer_id');

        // Step 3: Map through the unique conversations to get the last message
        $converse = $uniqueConversations->map(function ($conversation) {
            $customer = $conversation->getCustomer;

            $unreadCount = Message::where('sender_id', $customer->id)
                        ->where('receiver_id', auth()->id())
                        ->where('is_read', false)
                        ->count();

            // Step 4: Get the last chat message between the customer and the customer
            $getLastChatMessage = Message::where(function ($query) use ($conversation, $customer) {
                $query->where('sender_id', $conversation->attorney_id)
                    ->where('receiver_id', $customer->id)
                    ->orWhere(function ($query) use ($conversation, $customer) {
                        $query->where('sender_id', $customer->id)
                            ->where('receiver_id', $conversation->attorney_id);
                    });
            })
                ->latest()
                ->first();

            // Step 5: Return the customer and the last message
            return [
                'customer' => $customer,
                'lastMessage' => $getLastChatMessage,
                'unreadCount' => $unreadCount,
            ];
        });

        return view('attorney.chat', compact('converse'));
    }
}
