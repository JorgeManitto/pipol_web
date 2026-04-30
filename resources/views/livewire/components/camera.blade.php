{{-- ============================================================
     MODAL DE CÁMARA (colocar fuera del form, antes del cierre del div principal)
     ============================================================ --}}
<div id="cameraModal" class="fixed inset-0 z-50 hidden" style="position:fixed;">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="CameraModal.close()"></div>

    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-4" style="z-index:51;">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg relative overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between px-5 py-3 border-b border-gray-200">
                <h3 id="cameraModalTitle" class="text-base font-semibold text-gray-800">Capturar Foto</h3>
                <button onclick="CameraModal.close()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Camera View -->
            <div class="relative bg-black" style="min-height: 300px;">
                <video id="cameraStream" autoplay playsinline
                    class="w-full object-cover" style="min-height: 300px; display:none;"></video>

                <canvas id="cameraCanvas" class="hidden"></canvas>

                <img id="capturedPreview" class="w-full object-cover hidden" style="min-height: 300px;" alt="Foto capturada">

                <!-- Loading -->
                <div id="cameraLoading" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-900 text-white">
                    <svg class="animate-spin w-8 h-8 mb-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <p class="text-sm">Iniciando cámara...</p>
                </div>

                <!-- Error -->
                <div id="cameraError" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-900 text-white hidden px-6 text-center">
                    <svg class="w-10 h-10 mb-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p id="cameraErrorMsg" class="text-sm mb-3">No se pudo acceder a la cámara</p>
                    <button onclick="CameraModal.startCamera()" class="px-4 py-2 bg-white text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-100 transition">
                        Reintentar
                    </button>
                </div>

                <!-- Guías visuales -->
                <div id="cameraGuide" class="absolute inset-0 pointer-events-none hidden">
                    <div id="selfieGuide" class="absolute inset-0 flex items-center justify-center hidden">
                        <div class="w-44 h-56 border-2 border-dashed border-white/60 rounded-full"></div>
                    </div>
                    <div id="documentGuide" class="absolute inset-0 flex items-center justify-center hidden">
                        <div class="w-64 h-40 border-2 border-dashed border-white/60 rounded-lg"></div>
                    </div>
                </div>
            </div>

            <!-- Controles -->
            <div class="px-5 py-4 bg-gray-50">
                <!-- Captura -->
                <div id="captureControls" class="flex items-center justify-center gap-4 hidden">
                    <button onclick="CameraModal.switchCamera()" class="w-11 h-11 rounded-full bg-white shadow-md flex items-center justify-center text-gray-600 hover:text-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                    <button onclick="CameraModal.capture()" class="w-14 h-14 rounded-full bg-white border-4 border-gray-300 shadow-lg hover:border-blue-400 transition active:scale-95 flex items-center justify-center">
                        <div class="w-10 h-10 rounded-full bg-red-500 hover:bg-red-600 transition"></div>
                    </button>
                    <div class="w-11 h-11"></div>
                </div>

                <!-- Confirmación -->
                <div id="confirmControls" class="hidden flex items-center justify-center gap-3">
                    <button onclick="CameraModal.retake()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Repetir
                    </button>
                    <button onclick="CameraModal.confirm()" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Usar Foto
                    </button>
                </div>

                <!-- Uploading indicator -->
                <div id="uploadingControls" class="hidden flex items-center justify-center gap-2 text-gray-600">
                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span class="text-sm">Subiendo imagen...</span>
                </div>

                <p id="cameraTip" class="text-xs text-center text-gray-500 mt-3">
                    Asegurate de tener buena iluminación
                </p>
            </div>
        </div>
    </div>
</div>
<script>
const CameraModal = {
    stream: null,
    currentTarget: null,       // 'selfie' | 'document'
    currentFacingMode: 'user',
    capturedBlob: null,

    // ---- Abrir ----
    async open(target) {
        this.currentTarget = target;
        this.capturedBlob = null;

        const title = document.getElementById('cameraModalTitle');
        const tip   = document.getElementById('cameraTip');

        if (target === 'selfie') {
            this.currentFacingMode = 'user';
            title.textContent = 'Tomar Selfie';
            tip.textContent   = 'Sostené tu documento de identidad junto a tu rostro';
        } else {
            this.currentFacingMode = 'environment';
            title.textContent = 'Fotografiar Documento';
            tip.textContent   = 'Colocá el documento sobre una superficie plana con buena luz';
        }

        document.getElementById('cameraModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        this.showState('loading');
        await this.startCamera();
    },

    // ---- Cerrar ----
    close() {
        this.stopCamera();
        document.getElementById('cameraModal').classList.add('hidden');
        document.body.style.overflow = '';
        this.capturedBlob = null;
    },

    // ---- Iniciar cámara ----
    async startCamera() {
        this.stopCamera();

        try {
            this.stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: this.currentFacingMode },
                    width:  { ideal: 1280 },
                    height: { ideal: 960 },
                },
                audio: false,
            });

            const video = document.getElementById('cameraStream');
            video.srcObject = this.stream;
            video.onloadedmetadata = () => {
                video.play();
                this.showState('streaming');
                this.showGuide();
            };
        } catch (err) {
            console.error('Camera error:', err);
            let msg = 'No se pudo acceder a la cámara.';
            if (err.name === 'NotAllowedError')  msg = 'Permiso de cámara denegado. Habilitalo en la configuración del navegador.';
            if (err.name === 'NotFoundError')     msg = 'No se encontró ninguna cámara en este dispositivo.';
            if (err.name === 'NotReadableError')  msg = 'La cámara está siendo usada por otra aplicación.';
            document.getElementById('cameraErrorMsg').textContent = msg;
            this.showState('error');
        }
    },

    // ---- Detener ----
    stopCamera() {
        if (this.stream) {
            this.stream.getTracks().forEach(t => t.stop());
            this.stream = null;
        }
        const v = document.getElementById('cameraStream');
        if (v) v.srcObject = null;
    },

    // ---- Cambiar frontal/trasera ----
    async switchCamera() {
        this.currentFacingMode = this.currentFacingMode === 'user' ? 'environment' : 'user';
        this.showState('loading');
        await this.startCamera();
    },

    // ---- Capturar ----
    capture() {
        const video  = document.getElementById('cameraStream');
        const canvas = document.getElementById('cameraCanvas');

        canvas.width  = video.videoWidth;
        canvas.height = video.videoHeight;

        const ctx = canvas.getContext('2d');
        if (this.currentFacingMode === 'user') {
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
        }
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob((blob) => {
            this.capturedBlob = blob;
            document.getElementById('capturedPreview').src = URL.createObjectURL(blob);
            this.showState('captured');
        }, 'image/jpeg', 0.92);
    },

    // ---- Repetir ----
    retake() {
        this.capturedBlob = null;
        this.showState('streaming');
        this.showGuide();
    },

    // ---- Confirmar y subir a Livewire ----
    confirm() {
        if (!this.capturedBlob) return;

        this.showState('uploading');

        const fileName = this.currentTarget === 'selfie'
            ? 'selfie_capture.jpg'
            : 'document_capture.jpg';

        const file = new File([this.capturedBlob], fileName, { type: 'image/jpeg' });

        // Determinar qué propiedad Livewire actualizar
        const wireProperty = this.currentTarget === 'selfie' ? 'selfie' : 'documentPhoto';

        // Subir vía Livewire upload nativo
        // @this es la referencia al componente Livewire actual
        @this.upload(wireProperty, file,
            // Success
            (uploadedFilename) => {
                console.log(`${wireProperty} uploaded:`, uploadedFilename);
                this.close();
            },
            // Error
            () => {
                alert('Error al subir la imagen. Por favor intentá de nuevo.');
                this.showState('captured');
            },
            // Progress (opcional)
            (event) => {
                console.log(`Upload progress: ${event.detail.progress}%`);
            }
        );
    },

    // ---- Guías visuales ----
    showGuide() {
        document.getElementById('cameraGuide').classList.remove('hidden');
        document.getElementById('selfieGuide').classList.toggle('hidden', this.currentTarget !== 'selfie');
        document.getElementById('documentGuide').classList.toggle('hidden', this.currentTarget !== 'document');
    },

    hideGuide() {
        document.getElementById('cameraGuide').classList.add('hidden');
    },

    // ---- Control de estados ----
    showState(state) {
        const video       = document.getElementById('cameraStream');
        const preview     = document.getElementById('capturedPreview');
        const loading     = document.getElementById('cameraLoading');
        const error       = document.getElementById('cameraError');
        const captureCtrls  = document.getElementById('captureControls');
        const confirmCtrls  = document.getElementById('confirmControls');
        const uploadCtrls   = document.getElementById('uploadingControls');

        // Ocultar todo
        video.style.display = 'none';
        preview.classList.add('hidden');
        loading.classList.add('hidden');
        error.classList.add('hidden');
        captureCtrls.classList.add('hidden');
        confirmCtrls.classList.add('hidden');
        uploadCtrls.classList.add('hidden');
        this.hideGuide();

        switch (state) {
            case 'loading':
                loading.classList.remove('hidden');
                break;
            case 'streaming':
                video.style.display = 'block';
                captureCtrls.classList.remove('hidden');
                break;
            case 'captured':
                preview.classList.remove('hidden');
                confirmCtrls.classList.remove('hidden');
                break;
            case 'uploading':
                preview.classList.remove('hidden');
                uploadCtrls.classList.remove('hidden');
                break;
            case 'error':
                error.classList.remove('hidden');
                break;
        }
    },
};
</script>