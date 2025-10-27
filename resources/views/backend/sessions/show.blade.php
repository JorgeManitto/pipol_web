@extends('backend.layout.app')
@section('page_title', 'Mis Sesiones')
 
@section('main_content')
<div class="max-w-3xl mx-auto px-4 py-8 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Detalle de sesión</h1>

    <p><strong>Mentor:</strong> {{ $session->mentor->name }}</p>
    <p><strong>Mentee:</strong> {{ $session->mentee->name }}</p>
    <p><strong>Estado:</strong> {{ ucfirst($session->status) }}</p>
    <p><strong>Precio:</strong> {{ $session->currency }} {{ number_format($session->price, 2) }}</p>
    <p><strong>Fecha:</strong> {{ optional($session->scheduled_at)->format('d/m/Y H:i') ?? 'Sin definir' }}</p>
    <p><strong>Detalle:</strong> {{ $session->details }}</p>

    <div class="mt-6 space-x-2">
        @if ($session->status === 'pending' && Auth::id() === $session->mentor_id)
            <form method="POST" action="{{ route('sessions.confirm', $session->id) }}" class="inline">
                @csrf
                <button class="bg-blue-600 text-white px-3 py-1 rounded">Confirmar</button>
            </form>
        @endif

        @if ($session->status === 'confirmed')
            <form method="POST" action="{{ route('sessions.complete', $session->id) }}" class="inline">
                @csrf
                <button class="bg-green-600 text-white px-3 py-1 rounded">Marcar como completada</button>
            </form>
        @endif

        @if ($session->status !== 'cancelled' && $session->status !== 'completed')
            <form method="POST" action="{{ route('sessions.cancel', $session->id) }}" class="inline">
                @csrf
                <button class="bg-red-500 text-white px-3 py-1 rounded">Cancelar</button>
            </form>
        @endif
    </div>

    @if ($session->status === 'completed' && Auth::id() === $session->mentee_id && !$session->review)
        <hr class="my-6">
        <form method="POST" action="{{ route('sessions.review', $session->id) }}">
            @csrf
            <h2 class="font-semibold mb-2">Dejar valoración</h2>
            <label>Rating (1–5):</label>
            <input type="number" name="rating" min="1" max="5" required class="border rounded p-1 w-20">
            <textarea name="comment" class="w-full border rounded p-2 mt-2" placeholder="Comentario opcional"></textarea>
            <button class="bg-blue-600 text-white px-3 py-1 rounded mt-2">Enviar</button>
        </form>
    @endif
</div>
@endsection
