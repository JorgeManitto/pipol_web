@php
    $canSignAsPro     = $isProfessional && !$contract?->professional_signed_at && !$contract?->isProposedByProfessional();
    $canCounterAsPro  = $isProfessional && $contract && !$contract->isFullySigned() && !$contract->isProposedByProfessional();
    $canSignAsCompany = $isCompany && $contract && !$contract->company_signed_at && $contract->professional_signed_at;
    $canReviseAsCompany = $isCompany && $contract && !$contract->isFullySigned() && $contract->isProposedByProfessional();
@endphp

@if(!$contract)
    {{-- ====================================== --}}
    {{-- Sin contrato --}}
    {{-- ====================================== --}}
    @if($isCompany)
        {{-- Empresa: puede proponer --}}
        <div class="p-6" x-data="{ open: false }">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-purple-50 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <h3 class="text-lg font-medium mb-2">Definí los términos</h3>
            <p class="text-sm text-gray-600 mb-4">
                Una vez que tengan claridad sobre objetivos y alcance, proponé los términos formales del contrato. El profesional podrá firmar o enviar una contra-propuesta.
            </p>
            <button @click="open = true"
                    class="w-full rounded-md px-4 py-2.5 text-sm font-medium text-white btn-gradient-green transition">
                Proponer términos
            </button>

            @include('backend.fraccional.chat.partials._contract-form-modal', [
                'engagement' => $engagement,
                'contract'   => null,
                'mode'       => 'create',
            ])
        </div>
    @else
        {{-- Profesional: solo espera --}}
        <div class="p-6 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gray-100 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <h3 class="text-base font-medium mb-2">Esperando propuesta</h3>
            <p class="text-sm text-gray-600">
                La empresa enviará los términos del contrato cuando hayan acordado los objetivos. Vas a poder firmar o proponer cambios.
            </p>
        </div>
    @endif

@else
    {{-- ====================================== --}}
    {{-- Contrato existe --}}
    {{-- ====================================== --}}
    <div class="p-6">

        {{-- Header con versión --}}
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <h3 class="text-lg font-medium">Términos</h3>
                @if($contract->version > 1)
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-purple-100 text-purple-700">
                        v{{ $contract->version }}
                    </span>
                @endif
            </div>
            @include('backend.fraccional.partials._status-badge', ['status' => $contract->status])
        </div>

        {{-- Quien propuso esta versión --}}
        @if($contract->last_proposed_by)
            <div class="mb-4 p-3 bg-gray-50 rounded-lg text-xs">
                <p class="text-gray-600">
                    @if($contract->isProposedByCompany())
                        🏢 Propuesto por la empresa {{ $contract->last_proposed_at?->diffForHumans() }}
                    @else
                        💼 Contra-propuesta del profesional {{ $contract->last_proposed_at?->diffForHumans() }}
                    @endif
                </p>
                @if($contract->counter_proposal_note)
                    <p class="text-gray-700 mt-2 italic">"{{ $contract->counter_proposal_note }}"</p>
                @endif
            </div>
        @endif

        {{-- Términos --}}
        <div class="space-y-3 text-sm">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide">Objetivos</p>
                <p class="text-gray-800 mt-1">{{ $contract->objectives }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide">Responsabilidades</p>
                <p class="text-gray-800 mt-1">{{ $contract->responsibilities }}</p>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3 border-t border-gray-100">
                <div>
                    <p class="text-xs text-gray-500">Dedicación</p>
                    <p class="font-medium">{{ $contract->hours_per_week }} hs/sem</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Duración</p>
                    <p class="font-medium">{{ $contract->duration_months }} meses</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-500">Honorario mensual</p>
                    <p class="text-2xl font-semibold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        {{ number_format($contract->monthly_rate, 2) }} {{ $contract->currency }}
                    </p>
                </div>
            </div>

            {{-- Historial de versiones --}}
            @if($contract->version > 1 && !empty($contract->proposal_history))
                <div x-data="{ open: false }" class="pt-3 border-t border-gray-100">
                    <button @click="open = !open"
                            class="text-xs text-purple-600 hover:text-purple-700 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :class="open ? 'rotate-90' : ''" class="transition">
                            <polyline points="9 18 15 12 9 6"/>
                        </svg>
                        Ver historial de versiones ({{ count($contract->proposal_history) }})
                    </button>

                    <div x-show="open" x-cloak class="mt-3 space-y-2">
                        @foreach(array_reverse($contract->proposal_history) as $hist)
                            <div class="p-3 bg-gray-50 rounded-lg text-xs">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium">v{{ $hist['version'] }}</span>
                                    <span class="text-gray-500">
                                        {{ \Carbon\Carbon::parse($hist['proposed_at'])->format('d/m H:i') }}
                                    </span>
                                </div>
                                <p class="text-gray-600">
                                    {{ $hist['hours_per_week'] }} hs/sem ·
                                    {{ $hist['duration_months'] }} meses ·
                                    {{ number_format($hist['monthly_rate'], 2) }} {{ $hist['currency'] }}
                                </p>
                                @if(!empty($hist['counter_note']))
                                    <p class="text-gray-500 italic mt-1">"{{ $hist['counter_note'] }}"</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Firmas --}}
            <div class="pt-3 border-t border-gray-100 space-y-2">
                <div class="flex items-center gap-2 text-xs">
                    @if($contract->professional_signed_at)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        <span class="text-green-700">Profesional firmó</span>
                    @else
                        <div class="w-4 h-4 rounded-full border-2 border-gray-300"></div>
                        <span class="text-gray-500">Profesional pendiente</span>
                    @endif
                </div>
                <div class="flex items-center gap-2 text-xs">
                    @if($contract->company_signed_at)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        <span class="text-green-700">Empresa firmó y aceptó T&C</span>
                    @else
                        <div class="w-4 h-4 rounded-full border-2 border-gray-300"></div>
                        <span class="text-gray-500">Empresa pendiente</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- ============================ --}}
        {{-- Acciones según rol y estado --}}
        {{-- ============================ --}}
        <div class="mt-6 space-y-2" x-data="{ counterOpen: false, reviseOpen: false }">

            {{-- PROFESIONAL: firmar (si la última propuesta fue de la empresa) --}}
            @if($canSignAsPro)
                @if(!auth()->user()->stripe_connect_id)
                    <a href="{{ route('fraccional.stripe.connect') }}"
                       class="block w-full text-center rounded-md px-4 py-2.5 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 transition">
                        Conectar Stripe para firmar
                    </a>
                @else
                    <form action="{{ route('fraccional.contract.sign.pro', $contract) }}" method="POST"
                          onsubmit="return confirm('¿Aceptás los términos y firmás el contrato?')">
                        @csrf
                        <button type="submit"
                                class="w-full rounded-md px-4 py-2.5 text-sm font-medium text-white btn-gradient transition">
                            ✍ Firmar contrato
                        </button>
                    </form>
                @endif
            @endif

            {{-- PROFESIONAL: contra-proponer --}}
            @if($canCounterAsPro)
                <button @click="counterOpen = true"
                        class="w-full rounded-md px-4 py-2.5 text-sm font-medium text-purple-700 bg-purple-50 border border-purple-200 hover:bg-purple-100 transition">
                    🔄 Enviar contra-propuesta
                </button>

                @include('backend.fraccional.chat.partials._contract-form-modal', [
                    'engagement' => $engagement,
                    'contract'   => $contract,
                    'mode'       => 'counter',
                ])
            @endif

            {{-- PROFESIONAL: ya envió contra-propuesta, espera respuesta --}}
            @if($isProfessional && $contract->isProposedByProfessional() && !$contract->isFullySigned())
                <p class="text-xs text-center text-gray-600 p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                    Enviaste una contra-propuesta. Esperando respuesta de la empresa.
                </p>
            @endif

            {{-- EMPRESA: revisar contra-propuesta del profesional --}}
            @if($canReviseAsCompany)
                <div class="p-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-800 mb-2">
                    El profesional envió una contra-propuesta. Podés aceptarla firmando, o ajustarla y enviar una nueva versión.
                </div>

                <form action="{{ route('fraccional.contract.sign.company', $contract) }}" method="POST"
                      x-data="{ accepted: false }">
                    @csrf
                    <label class="flex items-start gap-2 mb-3 cursor-pointer">
                        <input type="checkbox" name="terms_accepted" value="1" x-model="accepted"
                               class="mt-0.5 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="text-xs text-gray-700">
                            Acepto los <a href="" target="_blank" class="text-purple-600 underline">términos y condiciones</a>
                            y los términos propuestos por el profesional.
                        </span>
                    </label>
                    <button type="submit" :disabled="!accepted"
                            :class="accepted ? 'btn-gradient' : 'bg-gray-300 cursor-not-allowed'"
                            class="w-full rounded-md px-4 py-2.5 text-sm font-medium text-white transition">
                        ✍ Aceptar contra-propuesta y firmar
                    </button>
                </form>

                <button @click="reviseOpen = true"
                        class="w-full rounded-md px-4 py-2.5 text-sm font-medium text-purple-700 bg-purple-50 border border-purple-200 hover:bg-purple-100 transition">
                    📝 Modificar y enviar nueva versión
                </button>

                @include('backend.fraccional.chat.partials._contract-form-modal', [
                    'engagement' => $engagement,
                    'contract'   => $contract,
                    'mode'       => 'revise',
                ])
            @endif

            {{-- EMPRESA: ya propuso, espera al profesional --}}
            @if($isCompany && $contract->isProposedByCompany() && !$contract->professional_signed_at)
                <p class="text-xs text-center text-gray-500 p-3 bg-gray-50 rounded-lg">
                    Esperando que el profesional firme o envíe contra-propuesta.
                </p>
            @endif

            {{-- EMPRESA: firmar después de que el profesional firmó (caso normal) --}}
            @if($canSignAsCompany && !$contract->isProposedByProfessional())
                <form action="{{ route('fraccional.contract.sign.company', $contract) }}" method="POST"
                      x-data="{ accepted: false }">
                    @csrf
                    <label class="flex items-start gap-2 mb-3 cursor-pointer">
                        <input type="checkbox" name="terms_accepted" value="1" x-model="accepted"
                               class="mt-0.5 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="text-xs text-gray-700">
                            Acepto los <a href="" target="_blank" class="text-purple-600 underline">términos y condiciones</a>
                            del servicio Pipol Fraccional.
                        </span>
                    </label>
                    <button type="submit" :disabled="!accepted"
                            :class="accepted ? 'btn-gradient' : 'bg-gray-300 cursor-not-allowed'"
                            class="w-full rounded-md px-4 py-2.5 text-sm font-medium text-white transition">
                        Firmar y proceder al pago
                    </button>
                </form>
            @endif

            {{-- CTA pago --}}
            @if($isCompany && $contract->isFullySigned() && $engagement->status === 'confirmed')
                <a href="{{ route('fraccional.payment.form', $contract) }}"
                   class="block w-full text-center rounded-md px-4 py-2.5 text-sm font-medium text-white btn-gradient-green transition">
                    Pagar y activar servicio
                </a>
            @endif

            @if($isProfessional && $engagement->status === 'confirmed')
                <p class="text-xs text-center text-gray-600 p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                    Todo listo. Esperando el pago de la empresa.
                </p>
            @endif

            {{-- Liberar fondos --}}
            @if($isCompany && $engagement->status === 'active')
                <form action="{{ route('fraccional.payment.release', $engagement) }}" method="POST"
                      onsubmit="return confirm('¿Confirmás que el servicio fue entregado satisfactoriamente?')">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-md px-4 py-2 text-sm font-medium text-white btn-gradient-green transition">
                        Marcar como completado
                    </button>
                </form>
            @endif

            @if($engagement->status === 'completed' && !$engagement->closed_at)
                <a href="{{ route('fraccional.closure.show', $engagement) }}"
                   class="block w-full text-center rounded-md px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition">
                    Decidir próximos pasos
                </a>
            @endif
        </div>
    </div>
@endif