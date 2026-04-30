{{-- resources/views/livewire/chat.blade.php --}}

<div class="chat-wrapper">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    .chat-wrapper {
        font-family: 'Inter', sans-serif;
        --bg-main: #0F071A;
        --bg-card: #140A24;
        --bg-elevated: #1C1030;
        --bg-input: #20152E;
        --accent: #8B5CF6;
        --accent-hover: #7C3AED;
        --accent-subtle: rgba(139, 92, 246, 0.12);
        --accent-glow: rgba(139, 92, 246, 0.25);
        --text-primary: #FFFFFF;
        --text-secondary: #A78BFA;
        --text-muted: rgba(255, 255, 255, 0.4);
        --border: rgba(255, 255, 255, 0.08);
        --border-active: rgba(139, 92, 246, 0.4);
        --sent-bg: #8B5CF6;
        --sent-text: #FFFFFF;
        --received-bg: #1C1030;
        --received-text: rgba(255, 255, 255, 0.9);
        --radius: 16px;
    }

    .chat-wrapper * {
        box-sizing: border-box;
    }

    .chat-container {
        display: flex;
        height: 88vh;
        max-height: 860px;
        gap: 10px;
        padding: 10px;
        background: var(--bg-main);
        border-radius: 20px;
    }

    /* ─── SIDEBAR ─── */
    .chat-sidebar {
        width: 340px;
        min-width: 300px;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .sidebar-header {
        padding: 24px 24px 16px;
        border-bottom: 1px solid var(--border);
    }

    .sidebar-header h2 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.02em;
        margin: 0;
    }

    .sidebar-header p {
        font-size: 0.78rem;
        color: var(--text-muted);
        margin: 4px 0 0;
    }

    .conversation-list {
        flex: 1;
        overflow-y: auto;
        padding: 8px;
    }

    .conversation-list::-webkit-scrollbar {
        width: 4px;
    }
    .conversation-list::-webkit-scrollbar-track {
        background: transparent;
    }
    .conversation-list::-webkit-scrollbar-thumb {
        background: rgba(139, 92, 246, 0.2);
        border-radius: 4px;
    }

    .conversation-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 14px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        position: relative;
    }

    .conversation-item:hover {
        background: var(--accent-subtle);
    }

    .conversation-item.active {
        background: var(--accent-subtle);
        border-color: var(--border-active);
        box-shadow: 0 0 20px rgba(139, 92, 246, 0.08);
    }

    .conversation-item.active .conv-name {
        color: var(--accent);
    }

    .conv-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 0.03em;
        flex-shrink: 0;
        color: #fff;
    }

    .avatar-1 { background: linear-gradient(135deg, #8B5CF6, #6D28D9); }
    .avatar-2 { background: linear-gradient(135deg, #EC4899, #DB2777); }
    .avatar-3 { background: linear-gradient(135deg, #6366F1, #4338CA); }
    .avatar-4 { background: linear-gradient(135deg, #F59E0B, #D97706); }
    .avatar-5 { background: linear-gradient(135deg, #10B981, #059669); }

    .conv-info {
        flex: 1;
        min-width: 0;
    }

    .conv-name {
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--text-primary);
        margin: 0;
        line-height: 1.3;
    }

    .conv-preview {
        font-size: 0.76rem;
        color: var(--text-muted);
        margin: 3px 0 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 170px;
    }

    .conv-time {
        font-size: 0.68rem;
        color: var(--text-muted);
        flex-shrink: 0;
        align-self: flex-start;
        margin-top: 4px;
    }

    /* ─── CHAT PANEL ─── */
    .chat-panel {
        flex: 1;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .chat-header {
        padding: 18px 28px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: rgba(20, 10, 36, 0.6);
        backdrop-filter: blur(10px);
    }

    .chat-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .chat-header-avatar {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.78rem;
        color: #fff;
    }

    .chat-header-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text-primary);
        margin: 0;
        letter-spacing: -0.01em;
    }

    .chat-header-status {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.72rem;
        color: #10B981;
        margin: 2px 0 0;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10B981;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.5);
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    /* ─── MESSAGES ─── */
    .messages-area {
        flex: 1;
        overflow-y: auto;
        padding: 28px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        background:
            radial-gradient(ellipse at 20% 80%, rgba(139, 92, 246, 0.04) 0%, transparent 50%),
            radial-gradient(ellipse at 80% 20%, rgba(99, 102, 241, 0.03) 0%, transparent 50%),
            var(--bg-card);
    }

    .messages-area::-webkit-scrollbar {
        width: 4px;
    }
    .messages-area::-webkit-scrollbar-track {
        background: transparent;
    }
    .messages-area::-webkit-scrollbar-thumb {
        background: rgba(139, 92, 246, 0.2);
        border-radius: 4px;
    }

    .msg-row {
        display: flex;
        gap: 10px;
        max-width: 70%;
        animation: msg-in 0.25s ease-out;
    }

    @keyframes msg-in {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .msg-row.sent {
        align-self: flex-end;
        flex-direction: row-reverse;
    }

    .msg-row.received {
        align-self: flex-start;
    }

    .msg-avatar-sm {
        width: 28px;
        height: 28px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.6rem;
        color: #fff;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .msg-content {
        display: flex;
        flex-direction: column;
    }

    .msg-row.sent .msg-content {
        align-items: flex-end;
    }

    .msg-bubble {
        padding: 12px 18px;
        font-size: 0.86rem;
        line-height: 1.55;
        word-break: break-word;
    }

    .msg-row.sent .msg-bubble {
        background: linear-gradient(135deg, #8B5CF6, #7C3AED);
        color: var(--sent-text);
        border-radius: 18px 4px 18px 18px;
        box-shadow: 0 2px 12px rgba(139, 92, 246, 0.25);
    }

    .msg-row.received .msg-bubble {
        background: var(--received-bg);
        color: var(--received-text);
        border-radius: 4px 18px 18px 18px;
        border: 1px solid var(--border);
    }

    .msg-time {
        font-size: 0.66rem;
        color: var(--text-muted);
        margin-top: 4px;
        padding: 0 4px;
    }

    /* ─── INPUT ─── */
    .chat-input-bar {
        padding: 16px 24px 20px;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(20, 10, 36, 0.4);
    }

    .chat-input-bar input {
        flex: 1;
        padding: 14px 20px;
        background: var(--bg-input);
        border: 1px solid var(--border);
        border-radius: 12px;
        font-size: 0.86rem;
        font-family: 'Inter', sans-serif;
        color: var(--text-primary);
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .chat-input-bar input::placeholder {
        color: var(--text-muted);
    }

    .chat-input-bar input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-glow);
    }

    .send-btn {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #8B5CF6, #7C3AED);
        border: none;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        flex-shrink: 0;
        box-shadow: 0 2px 12px rgba(139, 92, 246, 0.3);
    }

    .send-btn:hover {
        background: linear-gradient(135deg, #7C3AED, #6D28D9);
        transform: scale(1.04);
        box-shadow: 0 4px 20px rgba(139, 92, 246, 0.4);
    }

    .send-btn:active {
        transform: scale(0.96);
    }

    .send-btn svg {
        width: 19px;
        height: 19px;
    }

    /* ─── EMPTY STATE ─── */
    .empty-state {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        color: var(--text-muted);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--accent-subtle);
        border: 1px solid var(--border);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-icon svg {
        width: 34px;
        height: 34px;
        color: var(--accent);
    }

    .empty-state h3 {
        font-size: 1.05rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
    }

    .empty-state p {
        font-size: 0.82rem;
        margin: 0;
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 768px) {
        .chat-container {
            flex-direction: column;
            height: 100vh;
            max-height: none;
            border-radius: 0;
            padding: 0;
            gap: 0;
        }

        .chat-sidebar {
            width: 100%;
            min-width: unset;
            max-height: 280px;
            border-radius: 0;
            border-left: 0;
            border-right: 0;
            border-top: 0;
        }

        .chat-panel {
            border-radius: 0;
            flex: 1;
            border-left: 0;
            border-right: 0;
            border-bottom: 0;
        }

        .messages-area {
            padding: 16px;
        }

        .msg-row {
            max-width: 85%;
        }

        .chat-input-bar {
            padding: 12px 16px 16px;
        }
    }
</style>

    <div class="chat-container">

        {{-- ── SIDEBAR ── --}}
        <div class="chat-sidebar" id="chatList">
            <div class="sidebar-header">
                <h2>Mensajes</h2>
                <p>{{ $conversations->count() }} conversaciones</p>
            </div>

            <div class="conversation-list">
                @foreach($conversations as $index => $conversation)
                    @php
                        $user = $conversation->otherUser(auth()->id());
                        $lastMessage = $conversation->messages->last();
                        $avatarClass = 'avatar-' . (($index % 5) + 1);
                    @endphp

                    <div
                        wire:key="conv-{{ $conversation->id }}"
                        wire:click="selectConversation({{ $conversation->id }})"
                        class="conversation-item {{ optional($activeConversation)->id === $conversation->id ? 'active' : '' }}">

                        <div class="conv-avatar {{ $avatarClass }}">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>

                        <div class="conv-info">
                            <p class="conv-name">{{ $user->name }}</p>
                            @if($lastMessage)
                                <p class="conv-preview">{{ $lastMessage->content }}</p>
                            @endif
                        </div>

                        @if($lastMessage)
                            <span class="conv-time">
                                {{ $lastMessage->created_at->format('H:i') }}
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── CHAT PANEL ── --}}
        <div class="chat-panel">
            @if($activeConversation)
                @php
                    $user = $activeConversation->otherUser(auth()->id());
                    $avatarClass = 'avatar-' . (($conversations->search(fn($c) => $c->id === $activeConversation->id) % 5) + 1);
                @endphp

                {{-- Header --}}
                <div class="chat-header">
                    <div class="chat-header-left">
                        <div class="chat-header-avatar {{ $avatarClass }}">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="chat-header-name">{{ $user->name }}</p>
                            <div class="chat-header-status">
                                <span class="status-dot"></span>
                                En línea
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Messages --}}
                <div class="messages-area" wire:poll.3s="loadMessages">
                    @foreach($chatMessages as $msg)
                        @if($msg['sender_id'] === auth()->id())
                            <div class="msg-row sent" wire:key="msg-{{ $msg['id'] }}">
                                <div class="msg-avatar-sm" style="background: linear-gradient(135deg, #8B5CF6, #6D28D9);">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                                <div class="msg-content">
                                    <div class="msg-bubble">{{ $msg['content'] }}</div>
                                    <span class="msg-time">{{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}</span>
                                </div>
                            </div>
                        @else
                            <div class="msg-row received" wire:key="msg-{{ $msg['id'] }}">
                                <div class="msg-avatar-sm {{ $avatarClass }}">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="msg-content">
                                    <div class="msg-bubble">{{ $msg['content'] }}</div>
                                    <span class="msg-time">{{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Input --}}
                <form wire:submit.prevent="sendMessage" class="chat-input-bar">
                    <input
                        wire:model.defer="message"
                        type="text"
                        placeholder="Escribe un mensaje..."
                        autocomplete="off">

                    <button type="submit" class="send-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </form>

            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <h3>Seleccioná una conversación</h3>
                    <p>Elegí un chat de la lista para comenzar</p>
                </div>
            @endif
        </div>

    </div>
</div>