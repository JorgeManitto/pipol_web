<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class Chat extends Component
{
    public $activeConversationId = null;
    public $message = '';
    public $chatMessages = [];

    protected $rules = [
        'message' => 'required|string|max:2000',
    ];

    public function mount()
    {
        $conversation = request()->query('conversation');
        if ($conversation) {
            $this->selectConversation($conversation);
        }
    }

    // Computed-style: se carga fresco en cada render
    public function getConversationsProperty()
    {
        return Conversation::where('participant_1_id', auth()->id())
            ->orWhere('participant_2_id', auth()->id())
            ->with(['messages' => fn($q) => $q->latest()->limit(1)])
            ->orderByDesc('last_message_at')
            ->get();
    }

    public function getActiveConversationProperty()
    {
        if (!$this->activeConversationId) {
            return null;
        }

        return Conversation::find($this->activeConversationId);
    }

    public function selectConversation($conversationId)
    {
        $this->activeConversationId = $conversationId;
        // dd($this->activeConversation);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if (!$this->activeConversationId) {
            $this->chatMessages = [];
            return;
        }

        $this->chatMessages = Message::where('conversation_id', $this->activeConversationId)
            ->with('sender')
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }

    public function sendMessage()
    {
        $this->validate();

        Message::create([
            'conversation_id' => $this->activeConversationId,
            'sender_id'       => auth()->id(),
            'content'         => $this->message,
        ]);

        Conversation::where('id', $this->activeConversationId)
            ->update(['last_message_at' => now()]);

        $this->message = '';
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat', [
            'conversations'      => $this->conversations,
            'activeConversation' => $this->activeConversation,
        ]);
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
        return redirect()->route('admin.chat.index', ['conversation' => $conversation->id]);
    }
}