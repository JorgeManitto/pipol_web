@php
    // mode: 'create' (empresa primera vez), 'counter' (profesional contra-propone), 'revise' (empresa modifica contra-propuesta)
    $config = match($mode) {
        'create' => [
            'open_var'    => 'open',
            'action'      => route('fraccional.contract.store', $engagement),
            'title'       => 'Términos del contrato',
            'subtitle'    => 'El profesional podrá firmar o enviar una contra-propuesta.',
            'submit'      => 'Enviar propuesta',
            'show_note'   => false,
        ],
        'counter' => [
            'open_var'    => 'counterOpen',
            'action'      => route('fraccional.contract.counter', $contract),
            'title'       => 'Enviar contra-propuesta',
            'subtitle'    => 'Modificá los términos que querés ajustar. La empresa los revisará.',
            'submit'      => 'Enviar contra-propuesta',
            'show_note'   => true,
        ],
        'revise' => [
            'open_var'    => 'reviseOpen',
            'action'      => route('fraccional.contract.revise', $contract),
            'title'       => 'Modificar propuesta',
            'subtitle'    => 'Estás creando una nueva versión. El profesional deberá revisarla.',
            'submit'      => 'Enviar nueva versión',
            'show_note'   => true,
        ],
    };
    $values = $contract ?? null;
@endphp

<div x-show="{{ $config['open_var'] }}" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 overflow-y-auto"
     @click.self="{{ $config['open_var'] }} = false">
    <div class="bg-white rounded-2xl shadow-xl max-w-xl w-full my-8">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-xl font-medium">{{ $config['title'] }}</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $config['subtitle'] }}</p>
        </div>

        <form action="{{ $config['action'] }}" method="POST" class="p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Objetivos</label>
                <textarea name="objectives" rows="3" required
                          class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none"
                          placeholder="¿Qué se espera lograr?">{{ old('objectives', $values?->objectives) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Responsabilidades</label>
                <textarea name="responsibilities" rows="3" required
                          class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none"
                          placeholder="Tareas y entregables concretos...">{{ old('responsibilities', $values?->responsibilities) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alcance (opcional)</label>
                <textarea name="scope" rows="2"
                          class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none"
                          placeholder="Qué entra y qué queda afuera...">{{ old('scope', $values?->scope) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Horas/semana</label>
                    <input type="number" name="hours_per_week" min="1" max="40" required
                           value="{{ old('hours_per_week', $values?->hours_per_week) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none"
                           placeholder="10">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duración (meses)</label>
                    <input type="number" name="duration_months" min="1" max="24" required
                           value="{{ old('duration_months', $values?->duration_months) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none"
                           placeholder="3">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Honorario mensual</label>
                    <input type="number" step="0.01" name="monthly_rate" min="1" required
                           value="{{ old('monthly_rate', $values?->monthly_rate ?? $engagement->professional->hourly_rate) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none"
                           placeholder="2500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Moneda</label>
                    <select name="currency" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none">
                        @foreach(['USD','ARS','EUR'] as $c)
                            <option value="{{ $c }}" @selected(old('currency', $values?->currency ?? 'USD') === $c)>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de inicio</label>
                <input type="date" name="start_date" min="{{ now()->toDateString() }}"
                       value="{{ old('start_date', $values?->start_date?->toDateString()) }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none">
            </div>

            @if($config['show_note'])
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nota / motivo del cambio
                        @if($mode === 'counter')<span class="text-red-500">*</span>@endif
                    </label>
                    <textarea name="counter_proposal_note" rows="3"
                              {{ $mode === 'counter' ? 'required minlength=10' : '' }}
                              maxlength="1000"
                              class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none"
                              placeholder="Explicá qué cambiaste y por qué."></textarea>
                </div>
            @endif

            <div class="flex gap-2 pt-4 border-t border-gray-100">
                <button type="button" @click="{{ $config['open_var'] }} = false"
                        class="flex-1 rounded-md px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50 transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="flex-1 rounded-md px-4 py-2.5 text-sm font-medium text-white btn-gradient-green transition">
                    {{ $config['submit'] }}
                </button>
            </div>
        </form>
    </div>
</div>