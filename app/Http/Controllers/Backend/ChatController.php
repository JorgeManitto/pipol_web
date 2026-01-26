<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        // $user = Auth::user();

        // $conversations = Conversation::query()
        //     ->where('participant_1_id', $user->id)
        //     ->orWhere('participant_2_id', $user->id)
        //     ->with(['participant1', 'participant2', 'messages' => function ($q) {
        //         $q->latest()->limit(1);
        //     }])
        //     ->latest('last_message_at')
        //     ->get()
        //     ->map(function ($conv) use ($user) {
        //         $other = $conv->otherParticipant($user->id);
        //         return [
        //             'id'              => $conv->id,
        //             'name'            => $other->name ?? $other->username,
        //             'avatar'          => $other->avatar ?? 'default-avatar.jpg',
        //             'last_message'    => optional($conv->messages->first())->content ?? '',
        //             'last_message_at' => $conv->last_message_at?->diffForHumans(),
        //             'unread_count'    => $conv->messages()
        //                 ->where('sender_id', '!=', $user->id)
        //                 ->whereNull('read_at')
        //                 ->count(),
        //         ];
        //     });

        // // 👇 usuarios para iniciar chat
        // $users = User::where('id', '!=', $user->id)
        //     ->orderBy('name')
        //     ->get();

        return view('backend.chat.index');
    }


    public function show(Request $request, $conversationId)
    {
        // 👇 si viene user_id, creamos o buscamos conversación
        if ($request->has('user')) {
            $conversation = $this->getOrCreateConversation($request->user);
        } else {
            $conversation = Conversation::findOrFail($conversationId);
        }

        $this->authorizeConversation($conversation);

        $messages = $conversation->messages()
            ->with('sender')
            ->latest()
            ->paginate(30);

        $conversation->messages()
            ->where('sender_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('backend.chat.show', [
            'conversation' => $conversation,
            'messages'     => $messages,
            'other'        => $conversation->otherParticipant(auth()->id()),
        ]);
    }


    public function store(Request $request, Conversation $conversation)
    {
        $this->authorizeConversation($conversation);

        $request->validate(['content' => 'required|string|max:5000']);

        $message = $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'content'   => $request->content,
        ]);

        $conversation->update(['last_message_at' => now()]);

        // Aquí iría el broadcast si tienes realtime

        return response()->json([
            'message' => $message->load('sender'),
            'success' => true,
        ]);
    }

    private function authorizeConversation(Conversation $conversation): void
    {
        if (
            $conversation->participant1_id !== auth()->id() &&
            $conversation->participant2_id !== auth()->id()
        ) {
            abort(403, 'No tienes acceso a esta conversación');
        }

    }
    protected function getOrCreateConversation($otherUserId)
    {
        $authId = auth()->id();

        return Conversation::where(function ($q) use ($authId, $otherUserId) {
            $q->where('participant_1_id', $authId)
            ->where('participant_2_id', $otherUserId);
        })->orWhere(function ($q) use ($authId, $otherUserId) {
            $q->where('participant_1_id', $otherUserId)
            ->where('participant_2_id', $authId);
        })->firstOrCreate([
            'participant_1_id' => $authId,
            'participant_2_id' => $otherUserId,
        ], [
            'last_message_at' => now(),
        ]);
    }


}
