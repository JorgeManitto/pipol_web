@extends('backend.layout.fraccional')
@section('title', '¿Cómo seguimos?')
@section('content')
@php
    $tx = $engagement->transactions()->latest()->first();
    $hasPartialRelease = $tx && $tx->status === 'partially_released';
@endphp

<main class="px-6 py-12" x-data="{ tab: null, refundOpen: false, similarOpen: false }">
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-100 to-pink-100 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-3 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                Servicio finalizado
            </h1>
            <p class="text-gray-600 text-lg">
                Tu trabajo con {{ $engagement->professional->name }} se completó.
                <br>¿Cómo querés continuar?
            </p>
        </div>

        {{-- 3 opciones --}}
        <div class="grid md:grid-cols-3 gap-4 mb-8">

            {{-- 1. Continuar con el mismo profesional --}}
            <form action="{{ route('fraccional.closure.continue', $engagement) }}" method="POST"
                  onsubmit="return confirm('¿Querés enviar una nueva solicitud a {{ $engagement->professional->name }} para extender la contratación?')">
                @csrf
                <button type="submit"
                        class="w-full h-full bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-400 hover:shadow-lg transition text-left group">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-green-50 group-hover:bg-green-100 transition mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"/>
                            <path d="M21 3v5h-5"/>
                        </svg>
                    </div>
                    <h3 class="font-medium mb-2">Seguir trabajando juntos</h3>
                    <p class="text-sm text-gray-600">
                        Renová la contratación con {{ $engagement->professional->name }} con nuevos términos.
                    </p>
                </button>
            </form>

            {{-- 2. Buscar otro profesional --}}
            <button @click="similarOpen = true"
                    class="bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-400 hover:shadow-lg transition text-left group">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-purple-50 group-hover:bg-purple-100 transition mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>
                </div>
                <h3 class="font-medium mb-2">Otro profesional</h3>
                <p class="text-sm text-gray-600">
                    Te mostramos perfiles similares con la opción de ajustar seniority o presupuesto.
                </p>
            </button>

            {{-- 3. Devolución --}}
            @if(!$hasPartialRelease)
                <button @click="refundOpen = true"
                        class="bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-red-300 hover:shadow-lg transition text-left group">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-red-50 group-hover:bg-red-100 transition mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 7v6h6"/>
                            <path d="M21 17a9 9 0 0 0-15-6.7L3 13"/>
                        </svg>
                    </div>
                    <h3 class="font-medium mb-2">Solicitar devolución</h3>
                    <p class="text-sm text-gray-600">
                        Devolvemos el monto retenido a tu medio de pago original.
                    </p>
                </button>
            @else
                <div class="bg-gray-50 rounded-2xl p-6 border-2 border-gray-100 opacity-60">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gray-200 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <h3 class="font-medium mb-2 text-gray-700">Devolución no disponible</h3>
                    <p class="text-sm text-gray-500">
                        Ya hubo liberación parcial. Para reembolsos, contactá a soporte.
                    </p>
                </div>
            @endif
        </div>

        {{-- Cerrar sin más acciones --}}
        <div class="text-center">
            <form action="{{ route('fraccional.closure.finish', $engagement) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 underline">
                    Solo cerrar y volver al historial
                </button>
            </form>
        </div>

        {{-- ============================ --}}
        {{-- Modal: buscar similar --}}
        {{-- ============================ --}}
        <div x-show="similarOpen" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 overflow-y-auto"
             @click.self="similarOpen = false">
            <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full my-8">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-xl font-medium">Buscar perfiles similares</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Vamos a usar tu diagnóstico original más estos ajustes para encontrar mejores opciones.
                    </p>
                </div>

                <form action="{{ route('fraccional.closure.similar', $engagement) }}" method="POST" class="p-6 space-y-4"
                      x-data="{ pref: 'similar' }">
                    @csrf

                    <div class="space-y-2">
                        <label class="flex items-start gap-3 p-3 border-2 rounded-lg cursor-pointer transition"
                               :class="pref === 'similar' ? 'border-purple-500 bg-purple-50' : 'border-gray-200'">
                            <input type="radio" name="preference" value="similar" x-model="pref" class="mt-1">
                            <div>
                                <p class="font-medium text-sm">Similar al anterior</p>
                                <p class="text-xs text-gray-500">Misma seniority y rango de tarifa.</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 border-2 rounded-lg cursor-pointer transition"
                               :class="pref === 'more_senior' ? 'border-purple-500 bg-purple-50' : 'border-gray-200'">
                            <input type="radio" name="preference" value="more_senior" x-model="pref" class="mt-1">
                            <div>
                                <p class="font-medium text-sm">Más senior</p>
                                <p class="text-xs text-gray-500">Profesionales con más experiencia (puede ser más caro).</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 border-2 rounded-lg cursor-pointer transition"
                               :class="pref === 'more_economic' ? 'border-purple-500 bg-purple-50' : 'border-gray-200'">
                            <input type="radio" name="preference" value="more_economic" x-model="pref" class="mt-1">
                            <div>
                                <p class="font-medium text-sm">Más económico</p>
                                <p class="text-xs text-gray-500">Tarifa más baja, posiblemente menos seniority.</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 border-2 rounded-lg cursor-pointer transition"
                               :class="pref === 'custom' ? 'border-purple-500 bg-purple-50' : 'border-gray-200'">
                            <input type="radio" name="preference" value="custom" x-model="pref" class="mt-1">
                            <div class="flex-1">
                                <p class="font-medium text-sm">Otro requerimiento</p>
                                <textarea name="custom_input" rows="2" maxlength="1000"
                                          x-show="pref === 'custom'"
                                          :required="pref === 'custom'"
                                          placeholder="Ej: con experiencia en fintech, que hable inglés..."
                                          class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none"></textarea>
                            </div>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Presupuesto máximo mensual (opcional)
                        </label>
                        <div class="flex gap-2">
                            <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">$</span>
                            <input type="number" name="max_budget" min="0" step="0.01"
                                   placeholder="Ej: 2000"
                                   class="flex-1 rounded-r-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="flex gap-2 pt-4 border-t border-gray-100">
                        <button type="button" @click="similarOpen = false"
                                class="flex-1 rounded-md px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 rounded-md px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700">
                            Buscar perfiles
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ============================ --}}
        {{-- Modal: refund --}}
        {{-- ============================ --}}
        <div x-show="refundOpen" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
             @click.self="refundOpen = false">
            <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-xl font-medium">Solicitar devolución</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        El monto se acreditará en tu medio de pago original en 5-10 días hábiles.
                    </p>
                </div>

                <form action="{{ route('fraccional.closure.refund', $engagement) }}" method="POST" class="p-6 space-y-4">
                    @csrf

                    @if($tx)
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Monto a reembolsar</p>
                            <p class="text-2xl font-semibold">
                                {{ number_format($tx->amount, 2) }}
                                <span class="text-sm text-gray-500">{{ $tx->currency }}</span>
                            </p>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Motivo de la devolución</label>
                        <textarea name="reason" rows="4" required minlength="10" maxlength="1000"
                                  class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none"
                                  placeholder="Contanos brevemente por qué solicitás la devolución..."></textarea>
                    </div>

                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg text-xs text-amber-800">
                        <strong>Importante:</strong> esta acción es irreversible. Una vez procesado el reembolso,
                        el engagement se cierra y no podrá reabrirse.
                    </div>

                    <div class="flex gap-2 pt-4 border-t border-gray-100">
                        <button type="button" @click="refundOpen = false"
                                class="flex-1 rounded-md px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 rounded-md px-4 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                            Confirmar devolución
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection