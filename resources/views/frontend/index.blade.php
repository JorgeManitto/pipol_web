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
                    <h1 class="text-5xl md:text-5xl lg:text-6xl font-semibold mb-6 leading-tight">
                    <span class="text-white titulos">Rompemos el monopolio de la experiencia.</span>
                    </h1>

                    <!-- Description -->
                    <p class="text-md text-gray-300 mb-2 leading-relaxed">
                        Conectamos a personas que ya vivieron con quienes recién empiezan, para que la experiencia no se pierda: se comparta. Porque nadie llega solo. Todos tuvimos un mentor.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-6 md:mt-12 justify-center z-20">
                        <a href="{{ route('mentors.index') }}" class="btn-primary text-white px-8 py-4 rounded-full text-md font-semibold inline-flex items-center justify-center gap-2 w-full sm:w-auto">
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
            </div>
        </div>
    </section>
      
    <!-- Qué es Pipol -->
    <section id="que-es" class="section-dark py-24 px-4">
        <div class="max-w-7xl mx-auto ">
            <div class="text-center mb-4 md:mb-20">
                <h2 class="text-5xl md:text-5xl lg:text-6xl mb-6 titulos font-semibold">
                    ¿Qué es <img style="display: inline-block;height: 120px;" src="{{ asset('/images/logo-clean.png') }}" />?
                </h2>
                <p class="text-md text-gray-300 mb-2 leading-relaxed">
                    En Pipol creemos que la experiencia es el conocimiento más valioso que existe —y que solo tiene sentido cuando se comparte.
                </p>
            </div>

            <div class="hidden md:grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="card p-4 rounded-3xl">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-2" style=" background: linear-gradient(to bottom right, #a855f7, #ec4899, #f97316);">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Conectamos generaciones</h3>
                    <p class="text-gray-300 leading-relaxed text-md">
                        Creamos un espacio donde las personas pueden desarrollarse a través de la experiencia de otros, aprendiendo de historias reales, no de teorías vacías.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="card p-4 rounded-3xl">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-2" style=" background: linear-gradient(to bottom right, #a855f7, #ec4899, #f97316);">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Damos valor a la experiencia</h3>
                    <p class="text-gray-300 leading-relaxed text-md">
                        Quienes hoy quedan fuera del mercado laboral por edad, contexto o cambio de etapa, encuentran aquí un lugar para compartir su experiencia y seguir aportando valor.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="card p-4 rounded-3xl">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-2" style=" background: linear-gradient(to bottom right, #a855f7, #ec4899, #f97316);">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Visibilidad real</h3>
                    <p class="text-gray-300 leading-relaxed text-md">
                        Damos visibilidad a profesionales que no son influencers ni tienen miles de seguidores, pero que tienen muchísimo por enseñar.
                    </p>
                </div>
            </div>
        </div>
        <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"
        />
        <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
        <div class="md:hidden">
            <div class="swiper max-w-7xl mx-auto pt-8 ">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide pt-6 flex">
                        <div class="card items-center p-2 rounded-3xl h-full flex flex-col" style="height: 390px;">
                            <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-8" style=" background: linear-gradient(to bottom right, #a855f7, #ec4899, #f97316);">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-4">Conectamos generaciones</h3>
                            <p class="text-gray-300 leading-relaxed text-md text-center">
                                Creamos un espacio donde las personas pueden desarrollarse a través de la experiencia de otros, aprendiendo de historias reales, no de teorías vacías.
                            </p>
                        </div>
                    </div>
                    <div class="swiper-slide pt-6 flex">
                        <div class="card items-center p-2 rounded-3xl h-full flex flex-col" style="height: 390px;">
                            <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-8" style=" background: linear-gradient(to bottom right, #a855f7, #ec4899, #f97316);">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-4">Damos valor a la experiencia</h3>
                            <p class="text-gray-300 leading-relaxed text-md text-center">
                                Quienes hoy quedan fuera del mercado laboral por edad, contexto o cambio de etapa, encuentran aquí un lugar para compartir su experiencia y seguir aportando valor.
                            </p>
                        </div>
                    </div>
                    <div class="swiper-slide pt-6 flex">
                        <div class="card items-center p-2 rounded-3xl h-full flex flex-col" style="height: 390px;">
                            <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mb-8" style=" background: linear-gradient(to bottom right, #a855f7, #ec4899, #f97316);">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-4">Visibilidad real</h3>
                            <p class="text-gray-300 leading-relaxed text-md text-center">
                                Damos visibilidad a profesionales que no son influencers ni tienen miles de seguidores, pero que tienen muchísimo por enseñar.
                            </p>
                        </div>
                    </div>
                    
                    </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>
    
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev" style="height: 22px;left: -10px;"></div>
                <div class="swiper-button-next" style="height: 22px;right: -10px;"></div>
    
            </div>
        </div>
        <script>
            const swiper = new Swiper('.swiper', {
                // Optional parameters
                direction: 'horizontal',
                loop: true,
                    // autoplay: {
                    //     delay: 2500,
                    //     disableOnInteraction: false,
                    // },
                slidesPerView: 1,
                spaceBetween: 20,
                // centeredSlides: true,

                // If we need pagination
                pagination: {
                    el: '.swiper-pagination',
                },

                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },

                // And if we need scrollbar
                scrollbar: {
                    el: '.swiper-scrollbar',
                },
            });
        </script>
    </section>

    <!-- Cómo funciona -->
    <section id="como-funciona" class="section-darker py-24 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl titulos font-semibold mb-6">
                    ¿Cómo <span class="gradient-text">funciona</span>?
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    Tres pasos simples para comenzar tu camino de crecimiento profesional
                </p>
            </div>

            <div class="hidden md:grid md:grid-cols-3 gap-16 relative">
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
            <!-- Mobile Swiper -->
            <div class="block md:hidden px-6">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">

                        <!-- Slide 1 -->
                        <div class="swiper-slide text-center">
                            <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-6 text-4xl font-black text-white shadow-2xl">
                                1
                            </div>
                            <h3 class="text-2xl font-bold mb-3">Registrate</h3>
                            <p class="text-gray-300 leading-relaxed text-md">
                                Creá tu perfil y contanos qué estás buscando: orientación profesional, cambio de carrera, o desarrollar una idea.
                            </p>
                        </div>

                        <!-- Slide 2 -->
                        <div class="swiper-slide text-center">
                            <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-6 text-4xl font-black text-white shadow-2xl">
                                2
                            </div>
                            <h3 class="text-2xl font-bold mb-3">Encontrá tu mentor</h3>
                            <p class="text-gray-300 leading-relaxed text-md">
                                Explorá perfiles de profesionales con experiencia real en tu área de interés y elegí quien mejor se adapte a tus necesidades.
                            </p>
                        </div>

                        <!-- Slide 3 -->
                        <div class="swiper-slide text-center">
                            <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-6 text-4xl font-black text-white shadow-2xl">
                                3
                            </div>
                            <h3 class="text-2xl font-bold mb-3">Crecé con propósito</h3>
                            <p class="text-gray-300 leading-relaxed text-md">
                                Conectá con tu mentor, aprendé de su experiencia y definí tu camino profesional con claridad y confianza.
                            </p>
                        </div>

                    </div>

                    <div class="my-swiper-pagination mt-6 flex justify-center"></div>
                    {{-- <div class="my-swiper-button-prev" style="height: 22px;left: -10px;"></div> --}}
                    {{-- <div class="my-swiper-button-next" style="height: 22px;right: -10px;"></div> --}}
                </div>
            </div>
            <script>
            var newswiper = new Swiper('.mySwiper', {
                // Optional parameters
                direction: 'horizontal',
                loop: true,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                slidesPerView: 1,
                spaceBetween: 20,
                // centeredSlides: true,

                // If we need pagination
                pagination: {
                    el: '.my-swiper-pagination',
                },

                // Navigation arrows
                navigation: {
                    nextEl: '.my-swiper-button-next',
                    prevEl: '.my-swiper-button-prev',
                },

                // And if we need scrollbar
                scrollbar: {
                    el: '.swiper-scrollbar',
                },
            });
        </script>

        </div>
    </section>

    <!-- FAQ con Tabs: Mentores y Mentees -->
    <section id="faq" class="section-darker py-24 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-5xl md:text-6xl titulos font-semibold mb-6">
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
                        <span class="text-md font-bold pr-8">¿Qué es Pipol exactamente?</span>
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
                        <span class="text-md font-bold pr-8">¿Cómo puedo convertirme en mentor?</span>
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
                        <span class="text-md font-bold pr-8">¿Tiene algún costo usar Pipol?</span>
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
                        <span class="text-md font-bold pr-8">¿Cómo encuentro el mentor ideal para mí?</span>
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
                        <span class="text-md font-bold pr-8">¿Qué tipo de mentores puedo encontrar?</span>
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
                        <span class="text-md font-bold pr-8">¿Cómo sé qué mentor es el adecuado para mí?</span>
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
@endsection
