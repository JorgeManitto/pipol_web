@extends('frontend.layout.app')

@section('title', 'Pipol - Preguntas Frecuentes')  
@section('main_content')
    <section id="faq" class="section-darker py-24 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-5xl md:text-6xl font-black mb-6">
                    Preguntas <span class="gradient-text">frecuentes</span>
                </h2>
            </div>

            <!-- Tabs -->
            <div class="flex justify-center mb-10">
                <div class="inline-flex bg-gray-800 rounded-xl p-1 shadow-lg">
                    <button 
                        onclick="switchTab('mentores')" 
                        class="tab-btn px-8 py-3 rounded-lg font-bold text-md transition-all duration-300 active-tab"
                        id="tab-mentores">
                        Mentores
                    </button>
                    <button 
                        onclick="switchTab('mentees')" 
                        class="tab-btn px-8 py-3 rounded-lg font-bold text-md transition-all duration-300"
                        id="tab-mentees">
                        Mentees
                    </button>
                </div>
            </div>

            <!-- Contenido de Tabs -->
            <div id="content-mentores" class="tab-content space-y-6">
                <!-- FAQ Item 1 - Mentores -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all">
                        <span class="text-xl font-bold pr-8">¿Qué es Pipol exactamente?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-md">
                            Pipol es una plataforma que conecta a profesionales con experiencia con personas que están comenzando o buscando orientación en su carrera. Creemos que la experiencia real es el mejor maestro, y facilitamos ese intercambio de conocimiento.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 2 - Mentores -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all">
                        <span class="text-xl font-bold pr-8">¿Cómo puedo convertirme en mentor?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-md">
                            Simplemente registrate como mentor, completá tu perfil con tu experiencia profesional y áreas de expertise. No necesitás ser famoso ni tener miles de seguidores, solo ganas de compartir tu conocimiento y ayudar a otros a crecer.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 3 - Mentores -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all">
                        <span class="text-xl font-bold pr-8">¿Tiene algún costo usar Pipol?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-md">
                            Registrarte y explorar mentores es completamente gratuito. Los mentores pueden establecer sus propias tarifas por sesiones de mentoría, asegurando que su experiencia sea valorada justamente.
                        </p>
                    </div>
                </div>
            </div>

            <div id="content-mentees" class="tab-content space-y-6 hidden">
                <!-- FAQ Item 1 - Mentees -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all">
                        <span class="text-xl font-bold pr-8">¿Cómo encuentro el mentor ideal para mí?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-md">
                            Filtrá por industria, experiencia o enfoque de mentoría. Revisá perfiles detallados con trayectoria, reseñas y estilo de enseñanza. Podés reservar una sesión introductoria para ver si hay conexión.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 2 - Mentees -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all">
                        <span class="text-xl font-bold pr-8">¿Qué tipo de mentores puedo encontrar?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-md">
                            En Pipol encontrarás profesionales de diversas industrias y con diferentes trayectorias. Desde emprendedores hasta ejecutivos, freelancers y especialistas técnicos. Todos comparten el deseo de ayudar a otros con su experiencia real.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 3 - Mentees -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all">
                        <span class="text-xl font-bold pr-8">¿Cómo sé qué mentor es el adecuado para mí?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-md">
                            Cada perfil de mentor incluye su experiencia, áreas de expertise, y enfoque de mentoría. Podés leer sobre su trayectoria y elegir a quien mejor se alinee con tus objetivos y necesidades profesionales.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection