@extends('frontend.layout.app')

@section('title', 'Pipol - Conectando experiencia con talento')  
@section('main_content')
    

    
    
    <section class=" relative px-4 overflow- flex ">

        <div class="max-w-7xl mx-auto relative z-10 w-full">
                {{-- <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
                        <p>
                            <span class="font-bold">Google meet: </span>
                            <a href="https://meet.google.com/bxf-ytfs-etf" 
                            class="underline hover:text-blue-800"
                            target="_blank"
                            rel="noopener noreferrer">
                                Unirse a la llamada
                            </a>
                        </p>
                    </div> --}}
            <div class="flex flex-col md:flex-row justify-between gap-12 items-center">
                <!-- Left Column - Text Content -->
                <style>
                    .main-section {
                        max-width: 100%;
                        margin: auto;
                        padding-top: 24px; 
                    }
                    @media (min-width: 768px) {
                        .main-section {
                            max-width: 70%;
                            text-align: center;
                            padding-top: 0; 
                        }
                    }
                </style>
                <div  class="main-section md:h-screen flex flex-col md:justify-center">
                    <!-- Tagline with lightbulb icon -->
                    <div class="flex items-center gap-2 mb-4 justify-center">
                        <div class="w-6 h-6 rounded-full bg-yellow-400 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/>
                            </svg>
                        </div>
                        <p class="text-gray-300 text-md">El conocimiento se aprende. La experiencia se vive.</p>
                    </div>

                    <!-- Main Heading -->
                    <h1 class="text-5xl md:text-5xl lg:text-6xl font-black mb-6 leading-tight">
                    <span class="text-white">Rompemos el monopolio de la experiencia.</span>
                    </h1>

                    <!-- Description -->
                    <p class="text-md text-gray-300 mb-2 leading-relaxed">
                        Conectamos a personas que ya vivieron con quienes recién empiezan, para que la experiencia no se pierda: se comparta. Porque nadie llega solo. Todos tuvimos un mentor.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-6 md:mt-12 justify-center z-20">
                        <a href="{{ route('login') }}" class="btn-primary text-white px-8 py-4 rounded-full text-md font-semibold inline-flex items-center justify-center gap-2 w-full sm:w-auto">
                            Encontrá tu mentor
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="{{ route('login', ['is_mentor'=>1]) }}" class="btn-secondary px-8 py-4 rounded-full text-md font-semibold inline-flex items-center justify-center gap-2 w-full sm:w-auto">
                            Quiero ser mentor
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Right Column - Illustration -->
                {{-- <div class="relative  w-10/12">
                    <div>
                        <video src="{{ asset('/images/illustrator.mp4') }}" autoplay muted loop style="border-radius: 90px;"></video>
                    </div>
                </div> --}}
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
            <a href="#registro" class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary rounded-full font-semibold hover:bg-secondary transition-all text-md shadow-lg">
              Encontrá tu mentor
              <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
              </svg>
            </a>
            <a href="#soy-mentor" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white rounded-full font-semibold hover:bg-white hover:text-primary transition-all text-md">
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
                <h2 class="text-5xl md:text-5xl lg:text-6xl  font-black mb-6">
                    ¿Qué es <span class="gradient-text">Pipol</span>?
                </h2>
                <p class="text-md text-gray-300 mb-2 leading-relaxed">
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
                    <p class="text-gray-300 leading-relaxed text-md">
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
                    <p class="text-gray-300 leading-relaxed text-md">
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
                    <p class="text-gray-300 leading-relaxed text-md">
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
                    <p class="text-gray-300 leading-relaxed text-md">
                        Creá tu perfil y contanos qué estás buscando: orientación profesional, cambio de carrera, o desarrollar una idea.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        2
                    </div>
                    <h3 class="text-3xl font-bold mb-4">Encontrá tu mentor</h3>
                    <p class="text-gray-300 leading-relaxed text-md">
                        Explorá perfiles de profesionales con experiencia real en tu área de interés y elegí quien mejor se adapte a tus necesidades.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        3
                    </div>
                    <h3 class="text-3xl font-bold mb-4">Crecé con propósito</h3>
                    <p class="text-gray-300 leading-relaxed text-md">
                        Conectá con tu mentor, aprendé de su experiencia y definí tu camino profesional con claridad y confianza.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Soy Mentor CTA -->
    <!--  Enhanced CTA section with better visual hierarchy -->
    {{-- <section id="soy-mentor" class="section-dark py-24 px-4">
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
    </section> --}}

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



@endsection
