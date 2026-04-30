@extends('backend.layout.fraccional')
@section('content')
<main class="px-6 py-12">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold mb-2 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
            Mediación de disputas
        </h1>
        <p class="text-gray-600 mb-6">Casos pendientes que requieren resolución de Pipol.</p>

        <div class="space-y-3">
            @forelse($pending as $entry)
                <a href="{{ route('admin.fraccional.mediation.show', $entry) }}"
                   class="block bg-white rounded-2xl p-5 border border-gray-100 hover:border-purple-300 transition">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">Contrato #{{ $entry->contract_id }}</p>
                            <p class="font-medium mt-1">
                                {{ $entry->contract->engagement->company->name }}
                                <span class="text-gray-400">vs</span>
                                {{ $entry->contract->engagement->professional->name }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $entry->hours }} hs del {{ $entry->worked_on->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">
                                En mediación
                            </span>
                            <p class="text-xs text-gray-500 mt-2">
                                Esperando hace {{ $entry->professional_responded_at->diffForHumans(null, true) }}
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center text-gray-500">
                    No hay disputas pendientes de mediación.
                </div>
            @endforelse
        </div>

        {{ $pending->links() }}
    </div>
</main>
@endsection