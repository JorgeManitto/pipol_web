<div class="max-w-2xl mx-4 md:mx-auto p-6 bg-gray-50 rounded-xl shadow-lg border my-12 border-gray-200" style="min-height: 100%;display: flex;flex-direction: column;justify-content: space-between;">
    
    <div>
        <!-- Header -->
        <div class="text-center border-b border-gray-200 pb-3 mb-3">
            <img style="display: inline-block;height: 40px;" class="mb-4" src="{{ asset('/images/logo-clea-recorte.png') }}" alt="Pipol" />
            <h2 class="text-xl text-black font-semibold titulos">Carga de Perfil</h2>
            <p class="text-sm text-gray-500">Continua con tu perfil</p>
        </div>

        <style>
            .slide-in-from-left {
            animation: slideInFromLeft 0.6s ease-out forwards;
            opacity: 0;
            transform: translateX(-100%);
            }

            .slide-in-from-right {
            animation: slideInFromRight 0.6s ease-out forwards;
            opacity: 0;
            transform: translateX(100%);
            }

            @keyframes slideInFromLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
            }

            @keyframes slideInFromRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
            }
        </style>
        
        <div id="chat" class="h-96 overflow-y-auto overflow-x-hidden mb-6 space-y-6 px-4 py-4 bg-white rounded-lg shadow-inner">
            @foreach ($messages as $index => $message)
                <div 
                    wire:key="message-{{ $loop->index }}"
                    class="{{ $message['type'] === 'bot' ? 'flex items-start slide-in-from-left' : 'flex items-end justify-end slide-in-from-right' }}"
                    class="duration-600"
                >
                    @if ($message['type'] === 'bot')
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center mr-3 font-bold text-sm shadow-md">
                            P
                        </div>
                    @endif

                    <div class="max-w-md px-5 py-3 rounded-3xl shadow-lg {{ 
                        $message['type'] === 'bot' 
                            ? 'bg-blue-100 text-gray-800 rounded-bl-none' 
                            : 'bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-br-none' 
                    }}">
                        <p class="text-sm leading-relaxed ">
                            {{ $message['content'] }}
                        </p>
                    </div>

                    @if ($message['type'] === 'user')
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-600 text-white flex items-center justify-center ml-3 font-bold text-sm shadow-md">
                            Tú
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <form wire:submit.prevent="submitResponse"  class="space-y-4 text-black flex flex-col justify-end" style="min-height: 100px;">

        @if ($step == 1)
            <select wire:model="seniority" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option>Jefe</option>
                <option>Gerente</option>
                <option>Director</option>
                <option>CEO</option>
                <option>Emprendedor</option>
                <option>Director</option>
            </select>
            @error('seniority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @elseif ($step == 2)
            <div class="flex space-x-4">
                @foreach ($sessionPrices as $price)
                    <button type="button" onclick="submitForm()" wire:click="$set('selectedPrice', {{ $price }})" class="{{ $selectedPrice == $price  ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-600 hover:bg-gray-700 '}} cursor-pointer flex-1 px-4 py-2 text-white rounded-lg shadow  transition">${{ $price }}</button>
                @endforeach
            </div>
            @error('selectedPrice') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @elseif ($step == 3)

            <!-- INPUTS OCULTOS -->
            <input
                id="selfieInput"
                wire:model="selfie"
                type="file"
                accept="image/*"
                class="hidden"
            >

            <input
                id="documentInput"
                wire:model="documentPhoto"
                type="file"
                accept="image/*"
                class="hidden"
            >

            <!-- TARJETAS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- TARJETA SELFIE -->
                <div
                    onclick="document.getElementById('selfieInput').click()"
                    class="cursor-pointer border-2 border-dashed rounded-xl p-6 text-center
                        hover:border-blue-500 hover:bg-blue-50 transition"
                >
                    <div class="text-4xl mb-2">🤳</div>
                    <p class="font-semibold">Subir selfie</p>
                    <p class="text-sm text-gray-500">Foto de tu rostro</p>

                    @if ($selfie)
                        <p class="mt-2 text-green-600 text-sm">✔ Archivo seleccionado</p>
                    @endif
                </div>

                <!-- TARJETA DOCUMENTO -->
                <div
                    onclick="document.getElementById('documentInput').click()"
                    class="cursor-pointer border-2 border-dashed rounded-xl p-6 text-center
                        hover:border-blue-500 hover:bg-blue-50 transition"
                >
                    <div class="text-4xl mb-2">🪪</div>
                    <p class="font-semibold">Subir documento</p>
                    <p class="text-sm text-gray-500">DNI / Pasaporte</p>

                    @if ($documentPhoto)
                        <p class="mt-2 text-green-600 text-sm">✔ Archivo seleccionado</p>
                    @endif
                </div>

            </div>

            <!-- ERRORES -->
            @error('selfie')
                <span class="text-red-500 text-sm block mt-2">{{ $message }}</span>
            @enderror

            @error('documentPhoto')
                <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
            @enderror

        @endif


        @if ($step < 4)
            <button type="submit" @disabled($buttonDisabled) wire:loading.attr="disabled" class="cursor-pointer w-full px-4 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition {{ $buttonDisabled ? 'opacity-50 cursor-not-allowed' : '' }}" id="btn-enviar">
                @if ($loading) Cargando... @else Siguiente @endif
            </button>
        @endif
        @if ($step > 1 && $step < 19)
            <button
                type="button"
                wire:click="goBack"
                class="w-full px-4 py-2 mb-2 border border-gray-300 text-gray-700 rounded-lg
                    hover:bg-gray-100 transition cursor-pointer"
            >
                ← Volver atrás
            </button>
        @endif

    </form>
</div>

<script>
    let chat = document.getElementById('chat');
    window.addEventListener('scrollToBottom', event => {
        if (chat) {
            setTimeout(() => {
                chat.scrollTop = chat.scrollHeight;
                
            }, 200);
        }
    });

    function submitForm() {
        const btnEnviar = document.getElementById('btn-enviar');
        btnEnviar.disabled = false;
        btnEnviar.click();
    }
</script>
