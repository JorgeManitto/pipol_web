{{-- <div>
   <div class="space-y-3">
    @foreach($conversations as $conversation)
        @php
            $user = $conversation->otherUser(auth()->id());
        @endphp

        <div
            wire:click="selectConversation({{ $conversation->id }})"
            class="flex items-center gap-3 p-3 rounded-xl cursor-pointer
            {{ optional($activeConversation)->id === $conversation->id ? 'bg-purple-600/10 border-2 border-accent-purple' : 'hover:bg-gray-50' }}">
            
            <div class="w-12 h-12 rounded-full bg-purple-500 text-white flex items-center justify-center font-bold">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>

            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-sm">{{ $user->name }}</h3>
                <p class="text-xs text-gray-500 truncate">
                    {{ optional($conversation->messages->last())->content }}
                </p>
            </div>
        </div>
        @endforeach
    </div>
    @if($activeConversation)
        @php $user = $activeConversation->otherUser(auth()->id()); @endphp

        <h3 class="font-bold">{{ $user->name }}</h3>
    @endif

    <div class="flex-1 overflow-y-auto p-6 space-y-4" wire:poll.3s="loadMessages">
        @foreach($chatMessages as $msg)
            @if($msg->sender_id === auth()->id())
                <!-- Mensaje enviado -->
                <div class="flex flex-row-reverse gap-3">
                    <div class="bg-purple-600 text-white rounded-2xl px-4 py-2 max-w-md">
                        {{ $msg->content }}
                    </div>
                </div>
            @else
                <!-- Mensaje recibido -->
                <div class="flex gap-3">
                    <div class="bg-gray-100 rounded-2xl px-4 py-2 max-w-md">
                        {{ $msg->content }}
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    @if($activeConversation)
        <form wire:submit.prevent="sendMessage" class="flex gap-3">
            <input
                wire:model.defer="message"
                type="text"
                placeholder="Escribe un mensaje..."
                class="flex-1 bg-gray-100 rounded-xl px-4 py-3"
            >
            <button class="bg-purple-600 text-white px-6 rounded-xl">
                Enviar
            </button>
        </form>
    @endif



</div> --}}

<div class="flex-1 flex p-2 md:p-4 lg:p-8 gap-2 md:gap-4 lg:gap-6 overflow-hidden">

    <!-- SIDEBAR -->
    <div
        id="chatList"
        class="w-full md:w-80 bg-white rounded-2xl p-4 md:p-6 text-primary-dark
               absolute md:static inset-0 z-30 md:z-auto hidden md:block">

        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Conversaciones</h2>
        </div>

        <div class="space-y-3">
            @foreach($conversations as $conversation)
                @php
                    $user = $conversation->otherUser(auth()->id());
                    $lastMessage = $conversation->messages->last();
                @endphp

                <div
                    wire:click="selectConversation({{ $conversation->id }})"
                    class="flex items-center gap-3 p-3 rounded-xl cursor-pointer transition
                    {{ optional($activeConversation)->id === $conversation->id
                        ? 'bg-purple-600/10 border-2 border-purple-500'
                        : 'hover:bg-gray-50' }}">

                    <!-- Avatar -->
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-pink-400
                                flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm">{{ $user->name }}</h3>
                        <p class="text-xs text-gray-500 truncate">
                            {{ $lastMessage?->content }}
                        </p>
                    </div>

                    <!-- Hora -->
                    @if($lastMessage)
                        <div class="text-right">
                            <span class="text-xs text-gray-400">
                                {{ $lastMessage->created_at->format('H:i') }}
                            </span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- CHAT WINDOW -->
    <div class="flex-1 bg-white rounded-2xl flex flex-col overflow-hidden">

        @if($activeConversation)
            @php $user = $activeConversation->otherUser(auth()->id()); @endphp

            <!-- HEADER -->
            <div class="px-4 md:px-6 py-4 border-b flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400
                                flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-sm md:text-base">{{ $user->name }}</h3>
                        <p class="text-xs text-green-500 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            En línea
                        </p>
                    </div>
                </div>
            </div>

            <!-- MENSAJES -->
            <div class="flex-1 overflow-y-auto p-3 md:p-6 space-y-4"
                 wire:poll.3s="loadMessages">

                @foreach($chatMessages as $msg)
                    @if($msg->sender_id === auth()->id())
                        <!-- ENVIADO -->
                        <div class="flex flex-row-reverse gap-2 md:gap-3">
                            <div class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-purple-600
                                        flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>

                            <div class="flex flex-col items-end max-w-[75%] md:max-w-md">
                                <div class="bg-purple-600 text-white rounded-2xl rounded-tr-none
                                            px-3 md:px-4 py-2 md:py-3">
                                    <p class="text-sm">{{ $msg->content }}</p>
                                </div>
                                <span class="text-xs text-gray-400 px-2">
                                    {{ $msg->created_at->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    @else
                        <!-- RECIBIDO -->
                        <div class="flex gap-2 md:gap-3">
                            <div class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-400
                                        flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>

                            <div class="flex flex-col max-w-[75%] md:max-w-md">
                                <div class="bg-gray-100 rounded-2xl rounded-tl-none
                                            px-3 md:px-4 py-2 md:py-3">
                                    <p class="text-sm">{{ $msg->content }}</p>
                                </div>
                                <span class="text-xs text-gray-400 px-2">
                                    {{ $msg->created_at->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- INPUT -->
            <form wire:submit.prevent="sendMessage"
                  class="p-3 md:p-4 border-t flex gap-3 items-center">

                <input
                    wire:model.defer="message"
                    type="text"
                    placeholder="Escribe un mensaje..."
                    class="flex-1 px-4 py-3 bg-gray-100 rounded-xl
                           focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">

                <button
                    type="submit"
                    class="px-6 py-3 bg-purple-600 text-white rounded-xl
                           hover:bg-purple-700 transition text-sm font-medium cursor-pointer">
                    Enviar
                </button>
            </form>
        @else
            <!-- SIN CONVERSACIÓN -->
            <div class="flex-1 flex items-center justify-center text-gray-400">
                Seleccioná una conversación
            </div>
        @endif
    </div>
</div>
