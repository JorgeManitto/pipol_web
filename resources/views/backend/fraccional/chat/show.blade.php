{{-- resources/views/backend/fraccional/chat/show.blade.php --}}
@extends('backend.layout.fraccional')
@section('content')
@php
    $isCompany      = auth()->id() === $engagement->company_id;
    $isProfessional = auth()->id() === $engagement->professional_id;
    $other          = $isCompany ? $engagement->professional : $engagement->company;
    $contract       = $engagement->contract;

    // Payload inicial para Alpine
    $initialMessages = $engagement->conversation->messages->map(fn($m) => [
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
        'time'       => $m->created_at->format('H:i'),
    ])->values();
@endphp

@php
    $isCompany      = auth()->id() === $engagement->company_id;
    $isProfessional = auth()->id() === $engagement->professional_id;
    $other          = $isCompany ? $engagement->professional : $engagement->company;
    $contract       = $engagement->contract;

    // Payload inicial para Alpine
    $initialMessages = $engagement->conversation->messages->map(fn($m) => [
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
        'time'       => $m->created_at->format('H:i'),
    ])->values();

    $chatConfig = [
        'engagementId'    => $engagement->id,
        'initialMessages' => $initialMessages,
        'lastId'          => $initialMessages->last()['id'] ?? 0,
        'urls' => [
            'fetch' => route('fraccional.chat.messages', $engagement),
            'send'  => route('fraccional.chat.send', $engagement),
        ],
        'csrf'          => csrf_token(),
        'initialStatus' => $engagement->status,
    ];
@endphp

<main class="px-6 py-8" x-data="chatApp({{ json_encode($chatConfig, JSON_HEX_APOS | JSON_HEX_QUOT) }})">
    @if(request('redirect_status') === 'succeeded')
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-4">
            ✅ Pago procesado correctamente. El servicio ya está activo.
        </div>
    @endif
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ $isCompany ? route('fraccional.engagement.sent') : route('fraccional.engagement.received') }}"
               class="inline-flex items-center gap-2 text-gray-200 hover:text-gray-900 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Volver
            </a>
            <div class="ml-auto flex items-center gap-3">
                <span x-show="connected" class="flex items-center gap-1.5 text-xs text-green-600">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                    En vivo
                </span>
                <span x-show="!connected" x-cloak class="flex items-center gap-1.5 text-xs text-gray-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                    Reconectando...
                </span>
                @include('backend.fraccional.partials._status-badge', ['status' => $engagement->status])
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- CHAT --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col"
                     style="height: calc(100vh - 180px); min-height: 500px;">

                    {{-- Header chat --}}
                    <div class="flex items-center gap-3 p-4 border-b border-gray-100">
                        <img src="{{ $other->avatar ? asset('storage/avatars/'.$other->avatar) : asset('images/default-avatar.png') }}"
                             class="w-10 h-10 rounded-full object-cover" alt="{{ $other->name }}">
                        <div>
                            <p class="font-medium">{{ $other->name }} {{ $other->last_name }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $other->currentPosition ?? $other->profession ?? $other->email }}
                            </p>
                        </div>
                    </div>

                    {{-- Mensajes --}}
                    <div x-ref="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-3">
                        <template x-for="msg in messages" :key="msg.id">
                            <div>
                                {{-- Mensaje del sistema --}}
                                <template x-if="msg.type === 'system'">
                                    <div class="flex justify-center my-2">
                                        <div class="bg-purple-50 border border-purple-100 text-purple-800 rounded-full px-4 py-1.5 text-xs max-w-[85%] text-center">
                                            <span x-text="msg.body"></span>
                                        </div>
                                    </div>
                                </template>

                                {{-- Mensaje normal --}}
                                <template x-if="msg.type === 'text'">
                                    <div class="flex" :class="msg.is_own ? 'justify-end' : 'justify-start'">
                                        <div class="max-w-[75%]">
                                            <div :class="msg.is_own
                                                ? 'bg-gray-100 text-gray-900'
                                                : 'bg-gray-100 text-gray-900'"
                                                 class="rounded-2xl px-4 py-2.5 text-sm whitespace-pre-wrap break-words"
                                                 x-text="msg.body"></div>
                                            <p class="text-[10px] text-gray-400 mt-1"
                                               :class="msg.is_own ? 'text-right' : 'text-left'"
                                               x-text="msg.time"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <div x-show="messages.length === 0" class="flex items-center justify-center h-full text-gray-400 text-sm">
                            Iniciá la conversación definiendo objetivos y alcance.
                        </div>
                    </div>

                    {{-- Input --}}
                    @if(in_array($engagement->status, ['rejected','cancelled','completed']))
                        <div class="p-4 border-t border-gray-100 bg-gray-50 text-center text-sm text-gray-500">
                            El chat está cerrado.
                        </div>
                    @else
                        <form @submit.prevent="sendMessage"
                              class="p-4 border-t border-gray-100 flex gap-2">
                            <input type="text" x-model="newMessage" required maxlength="2000" autocomplete="off"
                                   :disabled="sending"
                                   class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-purple-500 focus:outline-none disabled:bg-gray-50"
                                   placeholder="Escribí un mensaje...">
                            <button type="submit" :disabled="sending || !newMessage.trim()"
                                    class="inline-flex items-center gap-1 rounded-lg px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m3 3 3 9-3 9 19-9Z"/><path d="M6 12h16"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- PANEL LATERAL: tabs Contrato / Horas --}}
            <aside class="lg:col-span-1" x-data="{ panelTab: 'contract' }">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 sticky top-6">

                    {{-- Tabs solo si hay contrato activo --}}
                    @if($contract && $engagement->status === 'active')
                        <div class="flex bg-gray-100 m-4 rounded-xl p-1">
                            <button @click="panelTab = 'contract'" :class="panelTab === 'contract' ? 'bg-white shadow-sm' : ''"
                                    class="flex-1 text-sm font-medium py-2 px-3 rounded-lg transition">Contrato</button>
                            <button @click="panelTab = 'hours'" :class="panelTab === 'hours' ? 'bg-white shadow-sm' : ''"
                                class="flex-1 text-sm font-medium py-2 px-3 rounded-lg transition relative">
                                Horas
                                @if($contract->pendingHours() > 0 && auth()->id() === $engagement->company_id)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-medium w-5 h-5 rounded-full flex items-center justify-center animate-pulse">
                                        {{ $contract->timeEntries()->where('status', 'pending')->count() }}
                                    </span>
                                @else
                                    <span class="ml-1 text-xs text-purple-600">({{ number_format($contract->totalHours(), 0) }})</span>
                                @endif
                            </button>
                        </div>
                    @endif

                    {{-- Panel: Contrato --}}
                    <div x-show="panelTab === 'contract'">
                        @include('backend.fraccional.chat.partials._contract-panel', [
                            'engagement' => $engagement,
                            'contract' => $contract,
                            'isCompany' => $isCompany,
                            'isProfessional' => $isProfessional,
                        ])
                    </div>

                    {{-- Panel: Horas --}}
                    @if($contract && $engagement->status === 'active')
                        <div x-show="panelTab === 'hours'" x-cloak>
                            @include('backend.fraccional.chat.partials._hours-panel', [
                                'engagement' => $engagement,
                                'contract' => $contract,
                                'isProfessional' => $isProfessional,
                            ])
                        </div>
                    @endif

                </div>
            </aside>
        </div>
    </div>
</main>

<script>
function chatApp(config) {
    return {
        engagementId: config.engagementId,
        messages: config.initialMessages,
        lastId: config.lastId,
        urls: config.urls,
        csrf: config.csrf,
        engagementStatus: config.initialStatus,
        newMessage: '',
        sending: false,
        connected: true,
        pollInterval: null,

        init() {
            this.$nextTick(() => this.scrollToBottom());
            this.startPolling();

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) this.stopPolling();
                else this.startPolling();
            });
        },

        startPolling() {
            if (this.pollInterval) return;
            this.pollInterval = setInterval(() => this.fetchMessages(), 3000);
        },

        stopPolling() {
            if (this.pollInterval) {
                clearInterval(this.pollInterval);
                this.pollInterval = null;
            }
        },

        async fetchMessages() {
            try {
                const res = await fetch(`${this.urls.fetch}?after_id=${this.lastId}`, {
                    headers: { 'Accept': 'application/json' },
                });
                if (!res.ok) throw new Error();
                const data = await res.json();
                this.connected = true;

                if (data.messages.length > 0) {
                    const nearBottom = this.isNearBottom();
                    this.messages.push(...data.messages);
                    this.lastId = data.messages[data.messages.length - 1].id;
                    if (nearBottom) this.$nextTick(() => this.scrollToBottom());
                }

                // Si cambió el status del engagement, recargar para actualizar panel lateral
                if (data.engagement_status !== this.engagementStatus) {
                    window.location.reload();
                }
            } catch {
                this.connected = false;
            }
        },

        async sendMessage() {
            if (!this.newMessage.trim() || this.sending) return;
            const body = this.newMessage.trim();
            this.sending = true;

            // Optimistic UI
            const tempId = 'tmp-' + Date.now();
            this.messages.push({
                id: tempId, type: 'text', body, is_own: true,
                time: new Date().toLocaleTimeString('es-AR', { hour: '2-digit', minute: '2-digit' }),
            });
            this.newMessage = '';
            this.$nextTick(() => this.scrollToBottom());

            try {
                const res = await fetch(this.urls.send, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrf,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ body }),
                });
                if (!res.ok) throw new Error();
                const saved = await res.json();

                // Reemplazar el temporal con el real
                const idx = this.messages.findIndex(m => m.id === tempId);
                if (idx !== -1) {
                    this.messages[idx] = { ...saved, is_own: true };
                    this.lastId = Math.max(this.lastId, saved.id);
                }
            } catch {
                // Rollback
                this.messages = this.messages.filter(m => m.id !== tempId);
                this.newMessage = body;
                alert('No se pudo enviar el mensaje. Intentá de nuevo.');
            } finally {
                this.sending = false;
            }
        },

        isNearBottom() {
            const c = this.$refs.messagesContainer;
            if (!c) return true;
            return c.scrollHeight - c.scrollTop - c.clientHeight < 150;
        },

        scrollToBottom() {
            const c = this.$refs.messagesContainer;
            if (c) c.scrollTop = c.scrollHeight;
        },
    };
}
</script>
@endsection