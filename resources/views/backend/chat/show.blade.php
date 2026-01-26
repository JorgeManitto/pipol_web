@extends('backend.chat.index')

@section('chat_content')

<div class="container mx-auto p-6 flex flex-col h-[80vh]">


    <div class="border-b pb-3 mb-3">
    <h2 class="text-xl font-semibold">Chat con {{ $other->name ?? $other->username }}</h2>
    </div>


    <div id="messages" class="flex-1 overflow-y-auto space-y-3 mb-4 flex flex-col-reverse">
    @foreach($messages as $message)
    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
    <div class="max-w-[70%] px-4 py-2 rounded-lg
    {{ $message->sender_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
    <p class="text-sm">{{ $message->content }}</p>
    <span class="text-xs opacity-70 block mt-1">
    {{ $message->created_at->format('H:i') }}
    </span>
    </div>
    </div>
    @endforeach
    </div>


    <form id="chat-form" class="flex gap-2">
    @csrf
    <input type="text" id="content" class="flex-1 border rounded px-3 py-2" placeholder="Escribe un mensaje...">
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Enviar</button>
    </form>
</div>
    @endsection


    @section('scripts')
<script>
    const form = document.getElementById('chat-form');
    const input = document.getElementById('content');
    const messages = document.getElementById('messages');


    form.addEventListener('submit', async e => {
    e.preventDefault();


    if (!input.value.trim()) return;


    const res = await fetch("{{ route('admin.chat.store', $conversation->id) }}", {
    method: 'POST',
    headers: {
    'X-CSRF-TOKEN': '{{ csrf_token() }}',
    'Content-Type': 'application/json'
    },
    body: JSON.stringify({ content: input.value })
    });


    const data = await res.json();


    if (data.success) {
    const msg = document.createElement('div');
    msg.className = 'flex justify-end';
    msg.innerHTML = `
    <div class="max-w-[70%] px-4 py-2 rounded-lg bg-blue-500 text-white">
    <p class="text-sm">${data.message.content}</p>
    <span class="text-xs opacity-70 block mt-1">Ahora</span>
    </div>`;
    messages.prepend(msg);
    input.value = '';
    }
    });
</script>

@endsection