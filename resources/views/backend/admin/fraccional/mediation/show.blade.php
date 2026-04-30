@extends('backend.layout.fraccional')
@section('content')
<main class="px-6 py-12">
    <div class="max-w-4xl mx-auto">

        <a href="{{ route('admin.fraccional.mediation.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mb-4 inline-block">← Volver</a>

        <h1 class="text-2xl font-bold mb-6">Caso de mediación #{{ $entry->id }}</h1>

        <div class="grid md:grid-cols-2 gap-6">
            {{-- Postura de la empresa --}}
            <div class="bg-white rounded-2xl p-6 border border-orange-200">
                <h3 class="font-medium mb-3 text-orange-700">📎 Empresa: {{ $entry->contract->engagement->company->name }}</h3>
                <p class="text-sm text-gray-700 mb-3"><span class="font-medium">Reclamo original:</span></p>
                <p class="text-sm text-gray-600 mb-4 whitespace-pre-line">{{ $entry->dispute_reason }}</p>

                @if($entry->evidence_files)
                    <p class="text-sm font-medium mb-2">Evidencia:</p>
                    <div class="space-y-1">
                        @foreach($entry->evidence_files as $file)
                            <a href="{{ asset('storage/' . $file['path']) }}" target="_blank"
                               class="block text-sm text-blue-600 hover:underline">
                                📎 {{ $file['original_name'] }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Postura del profesional --}}
            <div class="bg-white rounded-2xl p-6 border border-blue-200">
                <h3 class="font-medium mb-3 text-blue-700">💼 Profesional: {{ $entry->contract->engagement->professional->name }}</h3>
                <p class="text-sm text-gray-700 mb-3"><span class="font-medium">Descripción de las horas:</span></p>
                <p class="text-sm text-gray-600 mb-4">
                    {{ $entry->hours }} hs el {{ $entry->worked_on->format('d/m/Y') }}<br>
                    <em>"{{ $entry->description }}"</em>
                </p>

                <p class="text-sm font-medium mb-2">Respuesta a la evidencia:</p>
                <p class="text-sm text-gray-600 whitespace-pre-line">{{ $entry->professional_response }}</p>
            </div>
        </div>

        {{-- Form de resolución --}}
        <form action="{{ route('admin.fraccional.mediation.resolve', $entry) }}" method="POST"
              class="mt-6 bg-white rounded-2xl p-6 border border-gray-200" x-data="{ outcome: '' }">
            @csrf
            <h3 class="font-medium mb-4">Resolución</h3>

            <div class="space-y-2 mb-4">
                <label class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="outcome" value="company" x-model="outcome" required class="mt-0.5">
                    <div>
                        <p class="font-medium">A favor de la empresa</p>
                        <p class="text-xs text-gray-500">Las {{ $entry->hours }} hs no se cobran.</p>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="outcome" value="professional" x-model="outcome" required class="mt-0.5">
                    <div>
                        <p class="font-medium">A favor del profesional</p>
                        <p class="text-xs text-gray-500">Se aprueban las {{ $entry->hours }} hs completas.</p>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="outcome" value="partial" x-model="outcome" required class="mt-0.5">
                    <div class="flex-1">
                        <p class="font-medium">Resolución parcial</p>
                        <p class="text-xs text-gray-500">Aprobar solo una parte de las horas.</p>
                        <input type="number" name="approved_hours" step="0.25" min="0" max="{{ $entry->hours }}"
                               x-show="outcome === 'partial'" x-cloak required
                               placeholder="Horas aprobadas"
                               class="mt-2 w-full rounded border px-2 py-1 text-sm">
                    </div>
                </label>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Notas de mediación (visibles para ambas partes)</label>
                <textarea name="mediation_notes" rows="4" required minlength="10" maxlength="2000"
                          class="w-full rounded-lg border px-3 py-2 text-sm"
                          placeholder="Explicá la decisión, qué pesó más, etc."></textarea>
            </div>

            <button type="submit" class="w-full py-2.5 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg">
                Resolver y cerrar caso
            </button>
        </form>
    </div>
</main>
@endsection