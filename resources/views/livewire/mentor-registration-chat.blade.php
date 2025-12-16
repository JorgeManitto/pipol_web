<div class="max-w-2xl mx-4 md:mx-auto p-6 bg-gray-50 rounded-xl shadow-lg border my-12 border-gray-200" style="min-height: 100%;display: flex;flex-direction: column;justify-content: space-between;">
    <div>
        <!-- Header -->
        <div class="text-center border-b border-gray-200 pb-3 mb-3">
            <img style="display: inline-block;height: 40px;" class="mb-4" src="{{ asset('/images/logo-clea-recorte.png') }}" alt="Pipol" />
            <h2 class="text-xl text-black font-semibold titulos">Carga de Perfil</h2>
            <p class="text-sm text-gray-500">Seleccioná un método para continuar</p>
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

            @if ($loading)
                <div class="flex items-start slide-in-from-left duration-600">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center mr-3 font-bold text-sm shadow-md">
                        P
                    </div>
                    <div class="max-w-md px-5 py-3 rounded-3xl shadow-lg bg-blue-100 text-gray-800 rounded-bl-none flex items-center">
                        <div class="flex space-x-1">
                            <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce delay-100"></div>
                            <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce delay-200"></div>
                        </div>
                        <span class="ml-3 text-sm">Pensando...</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <form wire:submit.prevent="submitResponse" class="space-y-4 text-black flex flex-col justify-end" style="min-height: 100px;">
        @if ($step == 1)
            <div class="flex space-x-4">
                <button type="button" wire:click="$set('loadMethod', 'cv')" class="{{ $loadMethod == 'cv' ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-600 hover:bg-gray-700 '}} cursor-pointer transition flex-1 px-4 py-2  text-white rounded-lg shadow ">Cargar CV / LinkedIn</button>
                <button type="button" wire:click="$set('loadMethod', 'manual')" class="{{ $loadMethod == 'manual' ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-600 hover:bg-gray-700'}} cursor-pointer flex-1 px-4 py-2  text-white rounded-lg shadow  transition">Cargar datos manualmente</button>
            </div>
        @elseif ($step == 2)
            <input wire:model="name" placeholder="Nombre y apellido" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <input wire:model="birthDate" type="date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <input wire:model="country" placeholder="País" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <input wire:model="city" placeholder="Ciudad" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @error('birthDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @error('country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                

        @elseif ($step == 3)
            <div class="flex space-x-4">
                <button type="button" wire:click="$set('workingNow', 'yes')" class="{{ $workingNow == 'yes' ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-600 hover:bg-gray-700 '}} cursor-pointer flex-1 px-4 py-2 text-white rounded-lg shadow  transition">Sí</button>
                <button type="button" wire:click="$set('workingNow', 'no')" class="{{ $workingNow == 'no' ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-600 hover:bg-gray-700 '}} cursor-pointer flex-1 px-4 py-2 text-white rounded-lg shadow  transition">No</button>
            </div>
            @error('workingNow') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @elseif ($step == 4)
            @if ($workingNow == 'yes')
                <input wire:model="currentPosition" placeholder="Cargo actual" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('currentPosition') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @else
                <input wire:model="lastPosition" placeholder="Último cargo" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('lastPosition') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @endif
        @elseif ($step == 5)
            <input wire:model="yearsExperience" type="number" placeholder="Años de experiencia" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('yearsExperience') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @elseif ($step == 6)
            <div class="flex space-x-4">
                <button type="button" wire:click="$set('addCompanies', 'yes')" class="{{ $addCompanies == 'yes' ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-600 hover:bg-gray-700 '}} cursor-pointer transition flex-1 px-4 py-2 text-white rounded-lg shadow">Sí</button>
                <button type="button" wire:click="$set('addCompanies', 'no')" class="{{ $addCompanies == 'no' ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-600 hover:bg-gray-700 '}} cursor-pointer transition flex-1 px-4 py-2 text-white rounded-lg shadow">No</button>
            </div>
            @error('addCompanies') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @elseif ($step == 7)
            <input wire:model="companies" placeholder="Empresas separadas por coma" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
             @error('companies') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @elseif ($step == 8)
            <input wire:model="sectors" placeholder="Rubros / industrias" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        @elseif ($step == 9)
            <div class="flex space-x-4">
                <button type="button" wire:click="$set('hasEducation', 'yes')" class="{{ $hasEducation == 'yes' ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-600 hover:bg-gray-700 '}} cursor-pointer flex-1 px-4 py-2 text-white rounded-lg shadow  transition">Sí</button>
                <button type="button" wire:click="$set('hasEducation', 'no')" class="{{ $hasEducation == 'no' ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-600 hover:bg-gray-700 '}} cursor-pointer flex-1 px-4 py-2  text-white rounded-lg shadow transition">No</button>
            </div>
            @error('hasEducation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @elseif ($step == 10)
            <textarea wire:model="education" placeholder="Estudios y dónde los realizaste" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 h-24"></textarea>
            @error('education') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @elseif ($step == 11)
            <input wire:model="languages" placeholder="Idiomas (ej. Español, Inglés)" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        @elseif ($step == 12)
            <textarea wire:model="skills" placeholder="Habilidades (separadas por coma)" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 h-24"></textarea>
        @elseif ($step == 13)
            <textarea wire:model="bio" placeholder="Escribe tu bio profesional aquí" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 h-32"></textarea>
            @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @elseif ($step == 14)
            <textarea wire:model="availability" placeholder="Días y horarios (ej. Lunes-Viernes 9-12)" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 h-24"></textarea>
        @elseif ($step == 15)
            <div class="flex space-x-4">
                <button type="button" wire:click="$set('confirmSeniority', 'yes')" class="{{ $confirmSeniority == 'yes' ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-600 hover:bg-gray-700 '}} cursor-pointer flex-1 px-4 py-2 text-white rounded-lg shadow transition">Sí</button>
                <button type="button" wire:click="$set('confirmSeniority', 'no')" class="{{ $confirmSeniority == 'no' ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-600 hover:bg-gray-700 '}} cursor-pointer flex-1 px-4 py-2 text-white rounded-lg shadow transition">No</button>
            </div>
            @error('confirmSeniority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @elseif ($step == 16)
            <select wire:model="seniority" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option>Jefe</option>
                <option>Subgerente</option>
                <option>Director</option>
                <option>Gerente General</option>
                <option>Emprendedor</option>
            </select>
            @error('seniority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @elseif ($step == 17)
            <div class="flex space-x-4">
                @foreach ($sessionPrices as $price)
                    <button type="button" wire:click="$set('selectedPrice', {{ $price }})" class="{{ $selectedPrice == $price  ? 'bg-pink-600 hover:bg-pink-700' : 'bg-gray-600 hover:bg-gray-700 '}} cursor-pointer flex-1 px-4 py-2 text-white rounded-lg shadow  transition">${{ $price }}</button>
                @endforeach
            </div>
            @error('selectedPrice') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @elseif ($step == 18)

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


        @if ($step < 19)
            <button type="submit" wire:loading.attr="disabled" class="cursor-pointer w-full px-4 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition {{ $loading ? 'opacity-50 cursor-not-allowed' : '' }}">
                @if ($loading) Cargando... @else Enviar @endif
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
</script>