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
        }
    </style>
 <script>
    const { createApp, ref, reactive, watch, nextTick } = Vue;

    createApp({
        components: {
            'chat-form': {
                template: `
                <div class="w-full max-w-lg shadow-xl rounded-xl p-5 flex flex-col h-[700px] template mx-2 md:mx-0">

                    <!-- Header -->
                    <div class="text-center border-b border-gray-200 pb-3 mb-3">
                        <img style="display: inline-block;height: 40px;" class="mb-4" src="{{ asset('/images/logo-clea-recorte.png') }}" alt="Pipol" />
                        <h2 class="text-xl text-black font-semibold titulos">Carga de Perfil</h2>
                        <p class="text-sm text-gray-500">Seleccioná un método para continuar</p>
                    </div>

                    <!-- Chat -->
                    <div class="flex-1 overflow-y-auto space-y-4 p-2" ref="chatBox">
                        <div v-for="msg in messages" :class="msg.from === 'bot' ? 'text-left' : 'text-right'">

                            <span :class="msg.from === 'bot'
                                ? 'inline-block bg-gray-200 text-gray-800 px-3 py-2 rounded-xl whitespace-pre-line'
                                : 'inline-block bg-blue-600 text-white px-3 py-2 rounded-xl whitespace-pre-line'">
                                @{{ msg.text }}
                            </span>

                            <!-- Opciones -->
                            <div v-if="msg.type === 'profile-options'" class="mt-3 space-y-2">
                                <button @click="selectType('A')" class="w-full btn bg-[#0e76a8] text-white py-2 rounded-lg cursor-pointer">A) Conectar LinkedIn</button>
                                <button @click="selectType('B')" class="w-full btn-primary text-white py-2 rounded-lg cursor-pointer">B) Subir CV</button>
                                <button @click="selectType('C')" class="w-full btn bg-gray-600 text-white py-2 rounded-lg cursor-pointer">C) Completar Manualmente</button>
                            </div>

                            <!-- LinkedIn -->
                            <div v-if="msg.type === 'linkedin-button'" class="mt-3">
                                <button class="bg-[#0e76a8] text-white px-4 py-2 rounded-lg w-full">
                                    Conectar con LinkedIn
                                </button>
                            </div>

                            <!-- CV -->
                            <div v-if="msg.type === 'cv-upload'" class="mt-3">
                                <input type="file" @change="uploadCV($event)" accept=".pdf,.doc,.docx"
                                    class="block w-full border p-2 rounded-lg border-gray-200 text-black">
                            </div>

                            <!-- Seniority -->
                            <div v-if="msg.type === 'seniority-options'" class="mt-4 space-y-2">
                                <button v-for="opt in seniorityOptions"
                                        @click="selectSeniority(opt.value)"
                                        class="w-full text-left px-4 py-3 rounded-lg border border-gray-300 hover:bg-gray-600 transition bg-white text-black cursor-pointer">
                                    @{{ opt.label }}
                                </button>
                            </div>

                            <!-- Precio -->
                            <div v-if="msg.type === 'price-options'" class="mt-4 space-y-2">
                                <p class="text-sm text-gray-600 mb-2">Precios sugeridos para <strong>@{{ selectedSeniorityLabel }}</strong> (USD):</p>

                                <button v-for="price in priceOptions"
                                        @click="selectPrice(price)"
                                        class="w-full px-4 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition cursor-pointer">
                                    @{{ '$' + price }}
                                </button>
                            </div>

                            <!-- Elección Bio -->
                            <div v-if="msg.type === 'bio-generation-choice'" class="mt-4 space-y-3">
                                <button @click="chooseBioMode('auto')"
                                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
                                    Generar Bio por IA
                                </button>
                                <button @click="chooseBioMode('manual')"
                                    class="w-full bg-gray-700 text-white py-3 rounded-lg hover:bg-gray-800 transition">
                                    Hacerlo Manualmente
                                </button>
                            </div>

                            <!-- Documento -->
                            <div v-if="msg.type === 'identity-document'" class="mt-3">
                                <input type="file" accept="image/*"
                                    @change="handleDocumentUpload"
                                    class="block w-full border p-2 rounded-lg border-gray-200 text-black">
                            </div>

                            <!-- Selfie -->
                            <div v-if="msg.type === 'identity-selfie'" class="mt-3">
                                <input type="file" accept="image/*" capture="user"
                                    @change="handleSelfieUpload"
                                    class="block w-full border p-2 rounded-lg border-gray-200 text-black">
                            </div>

                            <!-- Checklist final -->
                            <div v-if="msg.type === 'final-checklist'" class="mt-3">
                                <span class="inline-block bg-gray-200 text-gray-800 px-3 py-2 rounded-xl whitespace-pre-line">
                                    @{{ msg.text }}
                                </span>
                            </div>
                            <!-- Activar cuenta -->
                            <div v-if="msg.type === 'activate-account'" class="mt-3">
                                <button @click="activateAccount"
                                    class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition cursor-pointer">
                                    Activar mi cuenta de mentor
                                </button>
                            </div>


                        </div>
                    </div>

                    <!-- Input -->
                    <div v-if="showInput" class="mt-4 flex">
                        <input v-model="input" @keyup.enter="sendMessage"
                            id="messageInput"
                            class="flex-1 border border-gray-200 text-black rounded-l-xl px-3 py-2 focus:outline-none"
                            placeholder="Escribe tu respuesta...">
                        <button @click="sendMessage"
                                class="btn-primary text-white px-8 py-4 rounded-r-xl text-md font-semibold">
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
                        { from: "bot", text: "¿Cómo querés continuar?", type: "profile-options" }
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
                    ];

                    /* ------------ SENIORITY ------------ */
                    const seniorityOptions = [
                        { label: "Jefe", value: "jefe" },
                        { label: "Gerente", value: "gerente" },
                        { label: "Director", value: "director" },
                        { label: "Gerente general", value: "gerente_general" },
                        { label: "Entrepreneur", value: "entrepreneur" }
                    ];

                    const pricesBySeniority = {
                        jefe: [20, 23, 26],
                        gerente: [26, 29, 32],
                        director: [30, 40, 50],
                        gerente_general: [50, 60, 70],
                        entrepreneur: [50, 60, 70]
                    };

                    const selectedSeniority = ref(null);
                    const selectedSeniorityLabel = ref("");
                    const priceOptions = ref([]);

                    /* ------------ BIO ------------ */
                    const bioMode = ref(null);
                    const bioStep = ref(0);

                    const manualBioData = reactive({
                        bio_corta: ""
                    });

                    const manualBioQuestions = [
                        { key: "bio_corta", text: "📝 Escribí una bio corta:" }
                    ];

                    /* ------------ VALIDACIÓN IDENTIDAD ------------ */
                    const identityData = reactive({
                        documento: null,
                        selfie: null
                    });

                    const startIdentityValidation = () => {
                        messages.value.push({
                            from: "bot",
                            text: "Ahora vamos a validar tu identidad 🔐"
                        });

                        setTimeout(() => {
                            messages.value.push({
                                from: "bot",
                                text: "📄 Subí una foto de tu documento",
                                type: "identity-document"
                            });
                            scrollToBottom();
                        }, 1200);
                        scrollToBottom();
                    };

                    const handleDocumentUpload = (e) => {
                        const file = e.target.files[0];
                        if (!file) return;

                        identityData.documento = file;

                        messages.value.push({ from: "user", text: `Documento subido ✔️ (${file.name})` });
                        messages.value.push({ from: "bot", text: "⏳ Procesando documento..." });

                        setTimeout(() => {
                            messages.value.push({
                                from: "bot",
                                text: "🤳 Ahora subí una selfie",
                                type: "identity-selfie"
                            });
                            scrollToBottom();
                        }, 1500);
                        scrollToBottom();
                    };

                    const handleSelfieUpload = (e) => {
                        const file = e.target.files[0];
                        if (!file) return;

                        identityData.selfie = file;

                        messages.value.push({ from: "user", text: `Selfie subida ✔️ (${file.name})` });
                        messages.value.push({ from: "bot", text: "⏳ Procesando tu identidad..." });

                        setTimeout(() => {
                            // Mensaje: Archivos enviados
                            messages.value.push({
                                from: "bot",
                                text: "✔️ Archivos enviados correctamente."
                            });

                            scrollToBottom();

                            // Checklist final
                            // messages.value.push({
                            //     from: "bot",
                            //     text: `Checklist final:
                            //             - Perfil ✓
                            //             - Foto ✓
                            //             - Bio ✓
                            //             - Áreas ✓
                            //             - Precio ✓
                            //             - Agenda ✓
                            //             - Identidad ✓`,
                            //     type: "final-checklist"
                            // });

                            scrollToBottom();

                            // Botón de Activar cuenta
                            messages.value.push({
                                from: "bot",
                                text: "Cuando estés listo, activá tu cuenta:",
                                type: "activate-account"
                            });

                            scrollToBottom();

                            console.log("DATOS FINALES COMPLETOS:", {
                                ...manualData,
                                ...manualBioData,
                                ...identityData
                            });
                        }, 1500);

                        scrollToBottom();
                    };

                    /* ------------ FLUJO PRINCIPAL ------------ */
                    const selectType = (t) => {
                        mode.value = t;
                        messages.value.push({ from: "user", text: t });
                        scrollToBottom();

                        if (t === "A") {
                            messages.value.push({ from: "bot", text: "Perfecto ✔️", type: "linkedin-button" });
                        } else if (t === "B") {
                            messages.value.push({ from: "bot", text: "Subí tu CV:", type: "cv-upload" });
                        } else {
                            startManualFlow();
                        }
                    };

                    const uploadCV = async (e) => {
                        const file = e.target.files[0];
                        if (!file) return;

                        messages.value.push({ from: "user", text: file.name });

                        const formData = new FormData();
                        formData.append("cv", file);
                        formData.append("_token", "{{ csrf_token() }}");

                        const res = await fetch("/procesar-cv", { method: "POST", body: formData });
                        const data = await res.json();

                        messages.value.push({ from: "bot", text: `Listo ✔️\n${JSON.stringify(data, null, 2)}` });

                        askSeniority();
                        scrollToBottom();
                    };

                    const startManualFlow = () => {
                        step.value = 0;
                        showInput.value = true;

                        messages.value.push({ from: "bot", text: "Perfecto ✔️ Vamos a completar tus datos." });
                        messages.value.push({ from: "bot", text: manualQuestions[0].text });
                        
                    };

                    const sendMessage = () => {
                        if (!input.value) return;

                        messages.value.push({ from: "user", text: input.value });

                        if (bioMode.value === "manual") return handleManualBioAnswer();
                        if (mode.value === "C") return handleManualAnswer();

                        input.value = "";
                        scrollToBottom();
                    };

                    const handleManualAnswer = () => {
                        const q = manualQuestions[step.value];
                        manualData[q.key] = input.value;

                        step.value++;
                        scrollToBottom();
                        if (step.value < manualQuestions.length) {
                            messages.value.push({ from: "bot", text: manualQuestions[step.value].text });
                        } else {
                            askSeniority();
                        }

                        input.value = "";
                    };

                    const askSeniority = () => {
                        showInput.value = false;

                        messages.value.push({
                            from: "bot",
                            text: "¿Qué seniority sugerís?",
                            type: "seniority-options"
                        });
                    };

                    const selectSeniority = (value) => {
                        const label = seniorityOptions.find(o => o.value === value).label;

                        selectedSeniority.value = value;
                        selectedSeniorityLabel.value = label;
                        manualData.seniority = label;

                        messages.value.push({ from: "user", text: label });

                        priceOptions.value = pricesBySeniority[value];

                        messages.value.push({
                            from: "bot",
                            text: "Elegí uno de los precios sugeridos:",
                            type: "price-options"
                        });
                        scrollToBottom();
                    };

                    const selectPrice = (price) => {
                        manualData.precio = price;

                        messages.value.push({ from: "user", text: `$${price}` });

                        scrollToBottom();
                        askBioGeneration();
                    };

                    const askBioGeneration = () => {
                        messages.value.push({
                            from: "bot",
                            text: "¿Querés generar tu Bio automáticamente o escribirla manualmente?",
                            type: "bio-generation-choice"
                        });
                    };

                    const chooseBioMode = (choice) => {
                        bioMode.value = choice;

                        if (choice === "auto") {
                            messages.value.push({ from: "user", text: "Generar Bio con IA" });
                            messages.value.push({ from: "bot", text: "⏳ Generando tu Bio..." });

                            setTimeout(() => {
                                messages.value.push({ from: "bot", text: "✨ Bio generada: [bio generada]" });

                                setTimeout(() => startIdentityValidation(), 1200);
                            }, 1500);
                            scrollToBottom();
                        }

                        if (choice === "manual") {
                            messages.value.push({ from: "user", text: "Hacerlo manualmente" });
                            startManualBioFlow();
                        }
                    };

                    const startManualBioFlow = () => {
                        showInput.value = true;
                        bioStep.value = 0;

                        messages.value.push({
                            from: "bot",
                            text: manualBioQuestions[0].text
                        });
                        scrollToBottom();
                    };

                    const handleManualBioAnswer = () => {
                        const q = manualBioQuestions[bioStep.value];
                        manualBioData[q.key] = input.value;

                        bioStep.value++;

                        if (bioStep.value < manualBioQuestions.length) {
                            messages.value.push({
                                from: "bot",
                                text: manualBioQuestions[bioStep.value].text
                            });
                        } else {
                            showInput.value = false;
                            messages.value.push({ from: "bot", text: "Bio completada ✔️" });
                            scrollToBottom();
                            setTimeout(() => startIdentityValidation(), 1500);
                        }

                        input.value = "";
                    };
                    const activateAccount = () => {
                        messages.value.push({
                            from: "user",
                            text: "Activar mi cuenta de mentor"
                        });

                        messages.value.push({
                            from: "bot",
                            text: "¡Ya casi estamos!\nTu perfil está siendo revisado por el equipo de Pipol y será validado dentro de las próximas 3 horas.\nTe enviaremos un correo cuando esté listo."
                        });

                        scrollToBottom();
                    };


                    return {
                        input,
                        messages,
                        showInput,
                        chatBox,
                        sendMessage,
                        selectType,
                        uploadCV,
                        seniorityOptions,
                        selectedSeniorityLabel,
                        priceOptions,
                        selectSeniority,
                        selectPrice,
                        chooseBioMode,
                        handleDocumentUpload,
                        handleSelfieUpload,
                        activateAccount
                    };
                }

            }
        }
    }).mount("#app");
</script>


@endsection