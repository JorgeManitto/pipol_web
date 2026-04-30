<?php
namespace App\Http\Controllers\Backend\Fraccional;

use App\Http\Controllers\Controller;
use App\Models\Fraccional\Engagement;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function show(Engagement $engagement)
    {
        $this->guard($engagement);

        $engagement->load([
            'conversation.messages.sender',
            'company', 'professional',
            'contract.timeEntries.professional',
        ]);

        $engagement->conversation->messages()
            ->where(fn($q) => $q->where('sender_id', '!=', auth()->id())->orWhereNull('sender_id'))
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('backend.fraccional.chat.show', compact('engagement'));
    }

    /**
     * Endpoint de polling: devuelve mensajes nuevos desde after_id.
     */
    public function messages(Request $request, Engagement $engagement)
    {
        $this->guard($engagement);
        $afterId = (int) $request->query('after_id', 0);

        $messages = $engagement->conversation->messages()
            ->with('sender:id,name,last_name,avatar')
            ->where('id', '>', $afterId)
            ->orderBy('id')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'type'       => $m->type,
                'body'       => $m->body,
                'sender_id'  => $m->sender_id,
                'sender'     => $m->sender ? [
                    'id'     => $m->sender->id,
                    'name'   => $m->sender->name,
                    'avatar' => $m->sender->avatar
                        ? asset('storage/avatars/'.$m->sender->avatar)
                        : asset('images/default-avatar.png'),
                ] : null,
                'is_own'     => $m->sender_id === auth()->id(),
                'created_at' => $m->created_at->toIso8601String(),
                'time'       => $m->created_at->format('H:i'),
            ]);

        // Marcar como leídos los ajenos
        $engagement->conversation->messages()
            ->where('id', '>', $afterId)
            ->where(fn($q) => $q->where('sender_id', '!=', auth()->id())->orWhereNull('sender_id'))
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $pendingCount = 0;
        if ($engagement->contract && auth()->id() === $engagement->company_id) {
            $pendingCount = $engagement->contract->timeEntries()
                ->where('status', 'pending')
                ->count();
        }

        return response()->json([
            'messages'           => $messages,
            'engagement_status'  => $engagement->fresh()->status,
            'pending_time_count' => $pendingCount,
            'server_time'        => now()->toIso8601String(),
        ]);
    }

    public function send(Request $request, Engagement $engagement)
    {
        $this->guard($engagement);
        $data = $request->validate(['body' => 'required|string|max:2000']);

        $message = $engagement->conversation->messages()->create([
            'sender_id' => auth()->id(),
            'type'      => 'text',
            'body'      => $data['body'],
        ]);
        $engagement->conversation->update(['last_message_at' => now()]);

        if ($request->wantsJson()) {
            return response()->json([
                'id'         => $message->id,
                'body'       => $message->body,
                'type'       => 'text',
                'is_own'     => true,
                'time'       => $message->created_at->format('H:i'),
            ]);
        }

        return back();
    }

    protected function guard(Engagement $e): void
    {
        abort_unless($e->involves(auth()->id()), 403);
        abort_if(in_array($e->status, ['rejected','cancelled']), 403);
        abort_unless($e->conversation, 404);
    }
}