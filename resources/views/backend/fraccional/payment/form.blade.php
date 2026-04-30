@extends('backend.layout.fraccional')
@section('content')
@php
    $platformFeePct = (float) $contract->platform_fee_percentage;
    $fee            = round($contract->monthly_rate * $platformFeePct / 100, 2);
    $netPro         = round($contract->monthly_rate - $fee, 2);
@endphp

<main class="px-6 py-12">
    <div class="max-w-3xl mx-auto">

        <a href="{{ route('fraccional.chat.show', $contract->engagement) }}"
           class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 text-sm mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Volver al chat
        </a>

        <h1 class="text-3xl md:text-4xl mb-2 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent font-bold">
            Completar pago
        </h1>
        <p class="text-gray-600 mb-8">Los fondos quedan retenidos hasta que confirmes la entrega del servicio.</p>

        <div class="grid md:grid-cols-5 gap-6">

            {{-- Resumen --}}
            <aside class="md:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                    <h3 class="text-lg font-medium mb-4">Resumen</h3>

                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
                        <img src="{{ $contract->engagement->professional->avatar ? asset('storage/avatars/'.$contract->engagement->professional->avatar) : asset('images/default-avatar.png') }}"
                             class="w-12 h-12 rounded-xl object-cover"
                             alt="{{ $contract->engagement->professional->name }}">
                        <div>
                            <p class="font-medium">{{ $contract->engagement->professional->name }} {{ $contract->engagement->professional->last_name }}</p>
                            <p class="text-xs text-gray-500">{{ $contract->engagement->professional->currentPosition }}</p>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dedicación</span>
                            <span class="font-medium">{{ $contract->hours_per_week }} hs/sem</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Duración</span>
                            <span class="font-medium">{{ $contract->duration_months }} meses</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Honorario profesional</span>
                            <span>{{ number_format($netPro, 2) }} {{ $contract->currency }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Comisión plataforma ({{ rtrim(rtrim(number_format($platformFeePct, 2), '0'), '.') }}%)</span>
                            <span>{{ number_format($fee, 2) }} {{ $contract->currency }}</span>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-gray-100">
                            <span class="font-medium">Total</span>
                            <span class="text-xl font-semibold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                {{ number_format($contract->monthly_rate, 2) }} {{ $contract->currency }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                        <p class="text-xs text-blue-800 flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-0.5">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            Pago seguro con Stripe. Los fondos quedan retenidos y se liberan al profesional cuando confirmes la entrega.
                        </p>
                    </div>
                </div>
            </aside>

            {{-- Form --}}
            <div class="md:col-span-3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-medium mb-4">Método de pago</h3>

                    <div id="payment-element" class="mb-4"></div>

                    <div id="payment-message" class="hidden p-3 rounded-lg text-sm mb-4"></div>

                    <button id="submit-button" type="button"
                            class="w-full rounded-md px-6 py-3 text-sm font-medium text-white btn-gradient-green disabled:cursor-not-allowed">
                        <span id="button-text">Pagar {{ number_format($contract->monthly_rate, 2) }} {{ $contract->currency }}</span>
                        <span id="button-spinner" class="hidden">Procesando...</span>
                    </button>

                    <p class="text-xs text-gray-500 text-center mt-4">
                        Al pagar confirmás tu aceptación de los términos y condiciones del servicio.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://js.stripe.com/v3/"></script>
<script>
(async () => {
    const stripe = Stripe('{{ config("services.stripe.key") }}');

    const submitBtn  = document.getElementById('submit-button');
    const btnText    = document.getElementById('button-text');
    const btnSpinner = document.getElementById('button-spinner');
    const messageBox = document.getElementById('payment-message');

    function showMessage(text, type = 'error') {
        messageBox.textContent = text;
        messageBox.className = 'p-3 rounded-lg text-sm mb-4 ' + (type === 'error'
            ? 'bg-red-50 text-red-800 border border-red-200'
            : 'bg-green-50 text-green-800 border border-green-200');
    }

    function setLoading(loading) {
        submitBtn.disabled = loading;
        btnText.classList.toggle('hidden', loading);
        btnSpinner.classList.toggle('hidden', !loading);
    }

    // 1. Crear PaymentIntent
    let clientSecret;
    try {
        const res = await fetch('{{ route("fraccional.payment.intent", $contract) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        });
        if (!res.ok) throw new Error('No se pudo inicializar el pago.');
        const data = await res.json();
        clientSecret = data.clientSecret;
    } catch (e) {
        showMessage(e.message);
        submitBtn.disabled = true;
        return;
    }

    // 2. Montar Payment Element
    const elements = stripe.elements({
        clientSecret,
        appearance: {
            theme: 'stripe',
            variables: {
                colorPrimary: '#9333ea',
                borderRadius: '8px',
                fontFamily: 'system-ui, sans-serif',
            },
        },
    });
    const paymentElement = elements.create('payment', { layout: 'tabs' });
    paymentElement.mount('#payment-element');

    // 3. Submit
    submitBtn.addEventListener('click', async () => {
        setLoading(true);
        messageBox.classList.add('hidden');

        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: '{{ route("fraccional.chat.show", $contract->engagement) }}',
            },
        });

        if (error) {
            showMessage(error.message || 'Error procesando el pago.');
            setLoading(false);
        }
        // Si no hay error, Stripe redirige a return_url
    });
})();
</script>
@endsection