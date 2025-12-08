@extends('frontend.layout.app')
@section('title', 'Pipol - Chat de Carga de Perfil')  
@section('main_content')
<!-- Vue + Tailwind -->
<script src="https://unpkg.com/vue@3.4.15/dist/vue.global.prod.js"></script>
    <div id="app" class="flex justify-center py-10">
        <chat-form></chat-form>
    </div>
    <style>
        .template{
            border-color: var(--color-primary);
            box-shadow: 0 8px 30px rgba(147, 21, 255, 0.3);
            border: 1px solid #9315ff;
            background: rgba(255, 255, 255, 0.8);
        }
        .btn:hover {
            transform: translateY(-2px);
            /* box-shadow: 0 6px 30px rgba(255, 0, 107, 0.5); */
        }
    </style>
    <script>
        const { createApp, ref, reactive, watch, nextTick } = Vue;

        createApp({
            components: {
                'chat-form': {
                    template: `
                    <div class="w-full max-w-lg shadow-xl rounded-xl p-5 flex flex-col h-[700px] template" >

                        <!-- Header -->
                        <div class="text-center border-b border-gray-200 pb-3 mb-3">
                            <img style="display: inline-block;height: 40px;" class="mb-4" src="{{ asset('/images/logo-clea-recorte.png') }}" alt="Pipol" />
                            <h2 class="text-xl text-black font-semibold titulos">Carga de Perfil</h2>
                            <p class="text-sm text-gray-500">Seleccioná un método para continuar</p>
                        </div>

                        <!-- Chat Messages -->
                        <div 
                            class="flex-1 overflow-y-auto space-y-4 p-2" 
                            ref="chatBox"
                        >
                            <div 
                                v-for="msg in messages" 
                                :class="msg.from === 'bot' ? 'text-left' : 'text-right'"
                            >
                                <span 
                                    :class="msg.from === 'bot'
                                        ? 'inline-block bg-gray-200 text-gray-800 px-3 py-2 rounded-xl whitespace-pre-line'
                                        : 'inline-block bg-blue-600 text-white px-3 py-2 rounded-xl whitespace-pre-line'"
                                >
                                    @{{ msg.text }}
                                </span>

                                <!-- Botones tipo -->
                                <div v-if="msg.type === 'profile-options'" class="mt-3 space-y-2">
                                    <button @click="selectType('A')" class="w-full btn bg-[#0e76a8] text-white py-2 rounded-lg cursor-pointer">A) Conectar LinkedIn</button>
                                    <button @click="selectType('B')" class="w-full btn-primary text-white py-2 rounded-lg cursor-pointer">B) Subir CV</button>
                                    <button @click="selectType('C')" class="w-full btn bg-gray-600 text-white py-2 rounded-lg cursor-pointer">C) Completar Manualmente</button>
                                </div>

                                <!-- Botón LinkedIn -->
                                <div v-if="msg.type === 'linkedin-button'" class="mt-3">
                                    <button class="bg-[#0e76a8] text-white px-4 py-2 rounded-lg w-full">
                                        Conectar con LinkedIn
                                    </button>
                                </div>

                                <!-- Input de CV -->
                                <div v-if="msg.type === 'cv-upload'" class="mt-3">
                                    <input 
                                        type="file" 
                                        @change="uploadCV($event)" 
                                        accept=".pdf,.doc,.docx"
                                        class="block w-full border p-2 rounded-lg border-gray-200 text-black"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Input normal -->
                        <div v-if="showInput" class="mt-4 flex">
                            <input 
                                v-model="input"
                                @keyup.enter="sendMessage" 
                                id="messageInput"
                                class="flex-1 border border-gray-200 text-black rounded-l-xl px-3 py-2 focus:outline-none"
                                placeholder="Escribe tu respuesta..."
                            >
                            <button 
                                @click="sendMessage"
                                class="btn-primary text-white px-8 py-4 rounded-r-xl text-md font-semibold inline-flex items-center justify-center gap-2 w-full sm:w-auto"
                            >
                                Enviar
                            </button>
                        </div>
                    </div>
                    `,
                    setup() {
                        const input = ref("");
                        const showInput = ref(false);

                        const chatBox = ref(null);

                        const messages = ref([
                            { from: "bot", text: "Hola 👋 Vamos a cargar tu perfil." },
                            { 
                                from: "bot", 
                                text: "¿Cómo querés continuar?", 
                                type: "profile-options" 
                            }
                        ]);

                        const scrollToBottom = () => {
                            nextTick(() => {
                                if (chatBox.value) {
                                    chatBox.value.scrollTop = chatBox.value.scrollHeight;
                                    document.getElementById("messageInput")?.focus();
                                }
                            });
                        };

                        const step = ref(0);
                        const mode = ref(null);

                        const manualData = reactive({
                            nombre: "",
                            cargo: "",
                            experiencia: "",
                            empresas: "",
                            sectores: "",
                            estudios: "",
                            idiomas: "",
                            habilidades: "",
                            logros: "",
                            seniority: "",
                            precio: ""
                        });

                        const manualQuestions = [
                            { key: "nombre", text: "Nombre y apellido:" },
                            { key: "cargo", text: "Cargo actual o último:" },
                            { key: "experiencia", text: "Años de experiencia:" },
                            { key: "empresas", text: "Empresas donde trabajaste:" },
                            { key: "sectores", text: "Sectores:" },
                            { key: "estudios", text: "Estudios y certificaciones:" },
                            { key: "idiomas", text: "Idiomas:" },
                            { key: "habilidades", text: "Habilidades duras y blandas:" },
                            { key: "logros", text: "Logros profesionales:" },
                            { key: "seniority", text: "¿Qué seniority sugerís (jefe, gerente, director, gerente general, entrepreneur)?" },
                        ];


                        /* -----------------------------------
                        SELECCIÓN DE MÉTODO
                        ----------------------------------- */
                        const selectType = (t) => {
                            mode.value = t;

                            messages.value.push({ from: "user", text: t });
                            scrollToBottom();

                            if (t === "A") {
                                messages.value.push({
                                    from: "bot",
                                    text: "Perfecto ✔️\nHacé clic en el botón para conectar con LinkedIn:",
                                    type: "linkedin-button"
                                });
                                scrollToBottom();
                                showInput.value = false;
                            }

                            if (t === "B") {
                                messages.value.push({
                                    from: "bot",
                                    text: "Subí tu CV (PDF o Word):",
                                    type: "cv-upload"
                                });
                                scrollToBottom();
                                showInput.value = false;
                            }

                            if (t === "C") {
                                startManualFlow();
                            }
                        };


                        /* -----------------------------------
                        SUBIDA DE CV
                        ----------------------------------- */
                        const uploadCV = async (e) => {
                            const file = e.target.files[0];
                            if (!file) return;

                            messages.value.push({ from: "user", text: `Archivo seleccionado: ${file.name}` });
                            scrollToBottom();

                            const formData = new FormData();
                            formData.append("cv", file);
                            formData.append("_token", "{{ csrf_token() }}");

                            const res = await fetch("/procesar-cv", {
                                method: "POST",
                                body: formData
                            });

                            const data = await res.json();

                            messages.value.push({
                                from: "bot",
                                text: `Listo ✔️\nEstos son los datos procesados del CV:\n${JSON.stringify(data, null, 2)}`
                            });
                            scrollToBottom();
                        };


                        /* -----------------------------------
                        FLUJO MANUAL
                        ----------------------------------- */
                        const startManualFlow = () => {
                            step.value = 0;
                            showInput.value = true;

                            messages.value.push({
                                from: "bot",
                                text: "Perfecto ✔️ Vamos a completar tus datos manualmente."
                            });

                            messages.value.push({
                                from: "bot",
                                text: manualQuestions[0].text
                            });

                            scrollToBottom();
                        };

                        const sendMessage = () => {
                            if (!input.value.trim()) return;

                            messages.value.push({ from: "user", text: input.value });
                            scrollToBottom();

                            if (mode.value === "C") handleManualAnswer();

                            input.value = "";
                        };

                        const handleManualAnswer = () => {
                            const q = manualQuestions[step.value];
                            manualData[q.key] = input.value;

                            step.value++;

                            if (step.value < manualQuestions.length) {
                                messages.value.push({
                                    from: "bot",
                                    text: manualQuestions[step.value].text
                                });
                                scrollToBottom();
                            } else {
                                askPriceSelection();
                            }
                        };

                        /* -----------------------------------
                        PRECIO FINAL
                        ----------------------------------- */
                        const askPriceSelection = () => {
                            showInput.value = false;

                            messages.value.push({
                                from: "bot",
                                text:
                                    `Seleccioná un precio sugerido (USD):

                                    1) Jefes: 20 – 23 – 26
                                    2) Gerentes: 26 – 29 – 32
                                    3) Directores: 30 – 40 – 50
                                    4) Gerente general: 50 – 60 –70

                                    Selecciona un número.`,
                            });

                            scrollToBottom();

                            showInput.value = true;
                        };

                        // Cuando el usuario escribe el precio final
                        watch(input, (val) => {
                            if (mode.value === "C" && step.value === manualQuestions.length) {
                                if (!val.trim()) return;

                                messages.value.push({ from: "user", text: val });
                                scrollToBottom();

                                manualData.precio = val;

                                // 🔥 LOG FINAL DE LOS DATOS DEL USUARIO
                                console.log("DATOS COMPLETOS DEL USUARIO:", JSON.parse(JSON.stringify(manualData)));

                                messages.value.push({
                                    from: "bot",
                                    text: "¡Perfecto! Ya cargamos todos tus datos ✔️"
                                });

                                scrollToBottom();
                                showInput.value = false;
                            }
                        });


                        return {
                            input,
                            messages,
                            showInput,
                            chatBox,
                            sendMessage,
                            selectType,
                            uploadCV    
                        };
                    }
                }
            }
        }).mount("#app");
    </script>

@endsection