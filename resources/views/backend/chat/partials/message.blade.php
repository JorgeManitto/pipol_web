<div class="flex items-start gap-3 {{ $msg->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">

    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0
                {{ $msg->sender_id === auth()->id() ? 'bg-purple-600' : 'bg-gradient-to-br from-purple-400 to-pink-400' }}">
        {{ strtoupper(substr($msg->sender->name ?? 'U', 0, 2)) }}
    </div>

    <div class="flex flex-col gap-1 max-w-[70%] {{ $msg->sender_id === auth()->id() ? 'items-end' : '' }}">
        <div class="{{ $msg->sender_id === auth()->id() 
                        ? 'bg-purple-600 text-white rounded-2xl rounded-tr-none' 
                        : 'bg-white rounded-2xl rounded-tl-none shadow-sm' }} 
                    px-4 py-3">
            <p class="text-sm">{{ $msg->content }}</p>
        </div>
        <span class="text-xs text-gray-400 px-2">
            {{ $msg->created_at->format('H:i') }}
            @if($msg->sender_id === auth()->id())
                <span class="ml-1">✓✓</span> <!-- Puedes cambiar por leído/no leído -->
            @endif
        </span>
    </div>
</div>