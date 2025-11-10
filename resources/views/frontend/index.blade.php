@extends('frontend.layout.app')

@section('title', 'Pipol - Conectando experiencia con talento')  
@section('main_content')
    

    <!-- Hero Section -->
    <section class="hero-section relative pt-32 pb-4 px-4 overflow-hidden  flex items-center">
        <!-- Network dots pattern con animación -->
        
        <div class="max-w-7xl mx-auto relative z-10 w-full">
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
    <p>
        <span class="font-bold">Google meet: </span>
        <a href="https://meet.google.com/bxf-ytfs-etf" 
           class="underline hover:text-blue-800"
           target="_blank"
           rel="noopener noreferrer">
            Unirse a la llamada
        </a>
    </p>
</div>
            <div class="flex flex-col md:flex-row justify-between gap-12 items-center">
                <!-- Left Column - Text Content -->
                <div>
                    <!-- Tagline with lightbulb icon -->
                    <div class="flex items-center gap-2 mb-8">
                        <div class="w-6 h-6 rounded-full bg-yellow-400 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/>
                            </svg>
                        </div>
                        <p class="text-gray-300 text-lg">El conocimiento se aprende. La experiencia se vive.</p>
                    </div>

                    <!-- Main Heading -->
                    <h1 class="text-5xl md:text-5xl lg:text-5xl font-black mb-6 leading-tight">
                    <span class="text-white">Rompemos el monopolio de la experiencia.</span>
                    </h1>

                    <!-- Description -->
                    <p class="text-md text-gray-300 mb-10 leading-relaxed" >
                        Conectamos a personas que ya vivieron con quienes recién empiezan, para que la experiencia no se pierda: se comparta. Porque nadie llega solo. Todos tuvimos un mentor.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#registro" class="btn-primary text-white px-8 py-4 rounded-full text-lg font-semibold inline-flex items-center justify-center gap-2 w-full sm:w-auto">
                            Encontrá tu mentor
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="#soy-mentor" class="btn-secondary px-8 py-4 rounded-full text-lg font-semibold inline-flex items-center justify-center gap-2 w-full sm:w-auto">
                            Quiero ser mentor
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Right Column - Illustration -->
                <div class="relative  w-10/12">
                    <div>
                        <video src="{{ asset('/images/illustrator.mp4') }}" autoplay muted loop style="border-radius: 90px;"></video>
                    </div>
                </div>
            </div>
        </div>
    </section>
  <!-- Hero Section -->
  {{-- <section id="home" class="hero-gradient pt-24 pb-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="grid lg:grid-cols-2 gap-12 items-center min-h-[600px]">
        <div class="text-white space-y-8">
          <div class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm">
            ✨ La experiencia es el conocimiento más valioso
          </div>
          <h1 class="text-4xl sm:text-5xl lg:text-5xl font-bold leading-tight text-balance">
            <span class="text-[#d4af6a]">Pipol:</span> Construir un puente entre generaciones y democratizar el valor de la experiencia.
          </h1>
          <p class="text-xl text-white/90 leading-relaxed">
            Conectamos a profesionales con experiencia real con quienes están empezando su camino. Porque los mejores líderes tuvieron grandes mentores.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 pt-4">
            <a href="#registro" class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary rounded-full font-semibold hover:bg-secondary transition-all text-lg shadow-lg">
              Encontrá tu mentor
              <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
              </svg>
            </a>
            <a href="#soy-mentor" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white rounded-full font-semibold hover:bg-white hover:text-primary transition-all text-lg">
              Quiero ser mentor
            </a>
          </div>
        </div>
        <div class="hidden lg:block">
          <div class="relative">
            <div class="absolute inset-0 bg-accent/20 rounded-3xl blur-3xl"></div>
            <img src="https://images.ctfassets.net/k0lk9kiuza3o/5FPiCcAZSijYVv5qoT1ZpO/82156da1075a50b8a81db9f482498f5f/6.png?q=85&fm=webp" 
                 alt="Mentores y aprendices colaborando" 
                 class="relative rounded-3xl shadow-2xl w-full">
          </div>
        </div>
      </div>
    </div>
  </section> --}}

 <!-- Qué es Pipol -->
    <!--  Updated section background to match hero style -->
    <section id="que-es" class="section-dark py-24 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-black mb-6">
                    ¿Qué es <span class="gradient-text">Pipol</span>?
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    En Pipol creemos que la experiencia es el conocimiento más valioso que existe —y que solo tiene sentido cuando se comparte.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="card p-10 rounded-3xl">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-8">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Conectamos generaciones</h3>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Creamos un espacio donde las personas pueden desarrollarse a través de la experiencia de otros, aprendiendo de historias reales, no de teorías vacías.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="card p-10 rounded-3xl">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-8">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Damos valor a la experiencia</h3>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Quienes hoy quedan fuera del mercado laboral por edad, contexto o cambio de etapa, encuentran aquí un lugar para compartir su experiencia y seguir aportando valor.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="card p-10 rounded-3xl">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-8">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Visibilidad real</h3>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Damos visibilidad a profesionales que no son influencers ni tienen miles de seguidores, pero que tienen muchísimo por enseñar.
                    </p>
                </div>
            </div>
        </div>
    </section>
    

    <!-- Cómo funciona -->
    <!--  Updated section background and improved visual hierarchy -->
    <section id="como-funciona" class="section-darker py-24 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-black mb-6">
                    ¿Cómo <span class="gradient-text">funciona</span>?
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    Tres pasos simples para comenzar tu camino de crecimiento profesional
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-16 relative">
                <!--  Added connector lines between steps -->
                <div class="hidden md:block absolute top-10 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-purple-500 to-transparent opacity-30"></div>
                
                <!-- Step 1 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        1
                    </div>
                    <h3 class="text-3xl font-bold mb-4">Registrate</h3>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Creá tu perfil y contanos qué estás buscando: orientación profesional, cambio de carrera, o desarrollar una idea.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        2
                    </div>
                    <h3 class="text-3xl font-bold mb-4">Encontrá tu mentor</h3>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Explorá perfiles de profesionales con experiencia real en tu área de interés y elegí quien mejor se adapte a tus necesidades.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        3
                    </div>
                    <h3 class="text-3xl font-bold mb-4">Crecé con propósito</h3>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Conectá con tu mentor, aprendé de su experiencia y definí tu camino profesional con claridad y confianza.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Soy Mentor CTA -->
    <!--  Enhanced CTA section with better visual hierarchy -->
    <section id="soy-mentor" class="section-dark py-24 px-4">
        <div class="max-w-5xl mx-auto">
            <div class="gradient-border rounded-3xl p-16 text-center">
                <h2 class="text-5xl md:text-6xl font-black mb-8">
                    ¿Tenés experiencia para <span class="gradient-text">compartir</span>?
                </h2>
                <p class="text-xl text-gray-300 mb-10 leading-relaxed max-w-3xl mx-auto">
                    Si sentís que tu experiencia puede ayudar a otros a crecer, este es tu lugar. No necesitás ser influencer ni tener miles de seguidores. Solo necesitas ganas de compartir lo que aprendiste.
                </p>
                <a href="#registro-mentor" class="btn-primary inline-flex items-center gap-2 text-white px-10 py-5 rounded-full text-xl font-bold">
                    Quiero ser mentor
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- FAQ con Tabs: Mentores y Mentees -->
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
                        class="tab-btn px-8 py-3 rounded-lg font-bold text-lg transition-all duration-300 active-tab"
                        id="tab-mentores">
                        Mentores
                    </button>
                    <button 
                        onclick="switchTab('mentees')" 
                        class="tab-btn px-8 py-3 rounded-lg font-bold text-lg transition-all duration-300"
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
                        <p class="text-gray-300 leading-relaxed text-lg">
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
                        <p class="text-gray-300 leading-relaxed text-lg">
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
                        <p class="text-gray-300 leading-relaxed text-lg">
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
                        <p class="text-gray-300 leading-relaxed text-lg">
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
                        <p class="text-gray-300 leading-relaxed text-lg">
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
                        <p class="text-gray-300 leading-relaxed text-lg">
                            Cada perfil de mentor incluye su experiencia, áreas de expertise, y enfoque de mentoría. Podés leer sobre su trayectoria y elegir a quien mejor se alinee con tus objetivos y necesidades profesionales.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- JavaScript para Tabs y Acordeón -->
<script>
    // Cambiar pestaña + reinicializar acordeones
    function switchTab(tab) {
        const mentoresContent = document.getElementById('content-mentores');
        const menteesContent = document.getElementById('content-mentees');
        const mentoresTab = document.getElementById('tab-mentores');
        const menteesTab = document.getElementById('tab-mentees');

        if (tab === 'mentores') {
            mentoresContent.classList.remove('hidden');
            menteesContent.classList.add('hidden');
            mentoresTab.classList.add('active-tab');
            menteesTab.classList.remove('active-tab');
        } else {
            menteesContent.classList.remove('hidden');
            mentoresContent.classList.add('hidden');
            menteesTab.classList.add('active-tab');
            mentoresTab.classList.remove('active-tab');
        }

        // REINICIAR acordeones en la pestaña activa
        initAccordions();
    }

    // Función para inicializar TODOS los acordeones visibles
    function initAccordions() {
        // Remover eventos anteriores para evitar duplicados
        document.querySelectorAll('.faq-question').forEach(btn => {
            btn.replaceWith(btn.cloneNode(true)); // Clona para eliminar listeners
        });

        // Volver a asignar eventos a los nuevos botones
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', () => {
                const answer = button.nextElementSibling;
                const icon = button.querySelector('.faq-icon');

                answer.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
    }

    // Inicializar al cargar la página
    document.addEventListener('DOMContentLoaded', () => {
        initAccordions();
    });
</script>

<!-- Estilos adicionales para tabs activos -->
<style>

</style>

    <!-- Contact -->
    <!--  Enhanced contact section with improved layout -->
    <section id="contacto" class="section-dark py-24 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-black mb-6">
                    {{-- ¿Tenés alguna <span class="gradient-text">pregunta</span>? --}}
                    ¿Necesitas <span class="gradient-text">contactarnos</span>?
                </h2>
                <p class="text-xl text-gray-300">
                    Estamos aquí para ayudarte. Escribinos y te responderemos a la brevedad.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="card p-10 rounded-3xl">
                    <form class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold mb-3 text-gray-300">Nombre</label>
                            <input type="text" class="w-full px-5 py-4 rounded-xl focus:outline-none focus:ring-2 transition-all text-lg" style="background: var(--color-dark); border: 1px solid rgba(147, 21, 255, 0.3); color: white;" placeholder="Tu nombre">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-3 text-gray-300">Email</label>
                            <input type="email" class="w-full px-5 py-4 rounded-xl focus:outline-none focus:ring-2 transition-all text-lg" style="background: var(--color-dark); border: 1px solid rgba(147, 21, 255, 0.3); color: white;" placeholder="tu@email.com">
                        </div>
                        <div>
                            <label for="motivo" class="block text-sm font-semibold mb-3 text-gray-300">Motivo</label>
                            <select name="motivo" id="motivo" class="w-full px-5 py-4 rounded-xl focus:outline-none focus:ring-2 transition-all text-lg" style="background: var(--color-dark); border: 1px solid rgba(147, 21, 255, 0.3); color: white;">
                                <option value="">Sugerencia</option>
                                <option value="">Feedback</option>
                                <option value="">Reclamo</option>
                                <option value="">Consulta</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-3 text-gray-300">Mensaje</label>
                            <textarea rows="5" class="w-full px-5 py-4 rounded-xl focus:outline-none focus:ring-2 transition-all text-lg" style="background: var(--color-dark); border: 1px solid rgba(147, 21, 255, 0.3); color: white;" placeholder="¿En qué podemos ayudarte?"></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full text-white px-6 py-4 rounded-xl font-bold text-lg">
                            Enviar mensaje
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="space-y-6">
                    {{-- <div class="card p-8 rounded-3xl flex items-start gap-6">
                        <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl mb-2">Email</h3>
                            <p class="text-gray-300 text-lg">contacto@pipol.com</p>
                        </div>
                    </div> --}}

                    <div class="card p-8 rounded-3xl flex items-start gap-6">
                        <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl mb-2">Ubicación</h3>
                            <p class="text-gray-300 text-lg">Buenos Aires, Argentina</p>
                        </div>
                    </div>

                    <div class="card p-8 rounded-3xl">
                        <h3 class="font-bold text-xl mb-6">Seguinos en redes</h3>
                        <div class="flex gap-4">
                            <a href="#" class="w-14 h-14 gradient-bg rounded-xl flex items-center justify-center hover:opacity-80 transition-opacity">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-14 h-14 gradient-bg rounded-xl flex items-center justify-center hover:opacity-80 transition-opacity">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-14 h-14 gradient-bg rounded-xl flex items-center justify-center hover:opacity-80 transition-opacity">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-14 h-14 gradient-bg rounded-xl flex items-center justify-center hover:opacity-80 transition-opacity">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.421.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
