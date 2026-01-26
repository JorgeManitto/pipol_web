<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class Chat extends Component
{
    public $conversations;
    public $activeConversation;
    public $messages = [];
    public $message = '';
    public $chatMessages = [];


    protected $rules = [
        'message' => 'required|string|max:2000',
    ];

    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $this->conversations = Conversation::where('participant_1_id', auth()->id())
            ->orWhere('participant_2_id', auth()->id())
            ->orderByDesc('last_message_at')
            ->get();
        $conversation = request()->query('conversation');
        if ($conversation) {
            $this->selectConversation($conversation);   
        }

    }

    public function selectConversation($conversationId)
    {
        $this->activeConversation = Conversation::findOrFail($conversationId);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->chatMessages = $this->activeConversation
            ->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();
    }



    public function sendMessage()
    {
        $this->validate();

        Message::create([
            'conversation_id' => $this->activeConversation->id,
            'sender_id' => auth()->id(),
            'content' => $this->message,
        ]);

        $this->activeConversation->update([
            'last_message_at' => now(),
        ]);

        $this->message = '';
        $this->loadMessages();
        $this->loadConversations();
    }

    public function render()
    {
        return view('livewire.chat');
    }

    public function getOrCreateConversation($userId)
    {
        return Conversation::firstOrCreate(
            [
                ['participant_1_id', auth()->id()],
                ['participant_2_id', $userId],
            ],
            [
                'participant_1_id' => auth()->id(),
                'participant_2_id' => $userId,
            ]
        );
    }

    public function createNewConversation($userId)
    {
        $conversation = $this->getOrCreateConversation($userId);
        // $this->selectConversation($conversation->id);
        return redirect()->route('admin.chat.index', ['conversation'=>$conversation->id]);
    }

}
