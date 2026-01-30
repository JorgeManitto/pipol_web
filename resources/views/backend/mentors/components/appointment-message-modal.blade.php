<div class="modal" id="appointmentMessage">
        <div class="modal-content">
            <div class="flex justify-center p-6">
                <h2 class="text-2xl font-bold text-[#1a0a3e] text-center">Notificación de pipol</h2>
            </div>
            <div id="content-payment">
                <div class="p-6">
                    <div id="message"></div>
                    <div class="my-4">
                        <h3 class="text-lg font-semibold text-[#1a0a3e] mb-4">Realiza tu pago para asegurar tu mentoría</h3>
                    </div>
                    <script src="https://js.stripe.com/v3/"></script>
                    <form id="payment-form">
                        <div class="mb-6">
                            <div id="card-element"></div>
                        </div>
                        
                        <button id="submit" class="px-6 py-3 bg-[#1a0a3e] text-white rounded-lg hover:bg-[#1a0a3ee8] transition-colors font-medium w-full">Pagar</button>
                    </form>
    
                </div>
                <div class="flex items-center gap-4 flex-col md:flex-row p-6">
                    <button onclick="closeMessageModal()" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium w-full">
                        Cerrar
                    </button>
                    <a href="{{ route('sessions.index') }}" class="px-6 py-3 bg-[#1a0a3e] text-white rounded-lg hover:bg-[#1a0a3ee8] transition-colors font-medium w-full">Ir a mis Sesiones </a>
                </div>
            </div>
            <div id="container-loader" style="display: none;">
                <div class="flex justify-center p-6">
                    <div style="width: 150px;height: 150px;">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 150">
                            <path fill="none" stroke="#1A0A3E" stroke-width="15" stroke-linecap="round" stroke-dasharray="300 385" stroke-dashoffset="0" d="M275 75c0 31-27 50-50 50-58 0-92-100-150-100-28 0-50 22-50 50s23 50 50 50c58 0 92-100 150-100 24 0 50 19 50 50Z">
                                <animate attributeName="stroke-dashoffset" calcMode="spline" dur="2" values="685;-685" keySplines="0 0 1 1" repeatCount="indefinite"></animate>
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div style="display: none;" id="response-message">
                <div class="flex justify-start p-6">
                    <h2 class="text-2xl font-bold text-[#000000] text-center" id="response-message-text"></h2>
                </div>
                <div class="flex items-center gap-4 flex-col md:flex-row p-6">
                    <button onclick="closeMessageModal()" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium w-full">
                        Cerrar
                    </button>
                    <a href="{{ route('sessions.index') }}" class="px-6 py-3 bg-[#1a0a3e] text-white rounded-lg hover:bg-[#1a0a3ee8] transition-colors font-medium w-full">Ir a mis Sesiones </a>
                </div>
            </div>
        </div>
    </div>