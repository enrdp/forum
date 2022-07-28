<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class CreateChat extends Component
{
    public $users;
    public $message = 'Test';

    public function checkconversation($receiverId)
    {
        $checkedConversation = Conversation::where('receiver_id', auth()->user()->id)
            ->where('sender_id', $receiverId)
            ->orWhere('receiver_id', $receiverId)
            ->where('sender_id', auth()->user()->id)
            ->get();

        if (count($checkedConversation) == 0) {
            $createdConversation = Conversation::create([
                'receiver_id' => $receiverId,
                'sender_id' => auth()->user()->id,
                'last_time_message' => now()
            ]);

//            $createdMessage = Message::create([
//                'conversation_id' => $createdConversation->id,
//                'sender_id' => auth()->user()->id,
//                'receiver_id' => $receiverId,
//                'body' => $this->message
//            ]);
//
//
//            $createdConversation->last_time_message = $createdMessage->created_at;
            $createdConversation->save();

            return redirect()->route('chat');
        }
//        } else if (count($checkedConversation) > 0) {
//        }
    }

    public function render()
    {
        $this->users = User::where('id','!=', auth()->user()->id)
            ->get();
        return view('livewire.chat.create-chat');
    }
}
