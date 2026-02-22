@extends('frontend.layout.app')

@section('title', 'Pipol - Mentores')  
@section('main_content')
<section class="section-darker py-32 px-4 h-screen flex items-center">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-5xl md:text-6xl font-semibold titulos text-white mb-8 leading-tight">
            Tu experiencia tiene un valor que el mundo necesita.
        </h2>
        <p class="text-md text-gray-300 mb-6 leading-relaxed">
            Compartila. Inspirá. Dejá tu huella.
        </p>
        <a href="{{ route('login', ['is_mentor'=>1]) }}" class="btn-primary text-white px-8 py-4 rounded-full text-md font-semibold inline-flex items-center justify-center gap-2 w-full sm:w-auto">
            QUIERO SER MENTOR
        </a>
    </div>
</section>
<section class="section-dark py-24 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-semibold titulos mb-4">
                Por qué ser mentor <span class="gradient-text"><img style="display: inline-block;height: 50px;" src="{{ asset('/images/logo-clea-recorte.png') }}" alt="Pipol" /></span>?
            </h2>
            <!-- Added gradient underline -->
            <div class="w-64 h-1 mx-auto bg-gradient-to-r from-purple-600 via-blue-500 to-cyan-400 rounded-full"></div>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <!-- Item 1 -->
            <div class="flex items-start gap-6">
                <div class="flex-shrink-0">
                    <svg class="w-16 h-16" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="8" y="16" width="48" height="32" rx="4" stroke="#ff006b" stroke-width="3" fill="none"></rect>
                        <rect x="20" y="24" width="24" height="16" rx="2" stroke="#ff006b" stroke-width="2" fill="none"></rect>
                        <line x1="32" y1="40" x2="32" y2="44" stroke="#ff006b" stroke-width="2"></line>
                    </svg>
                </div>
                <div>
                    <p class="text-md md:text-xl text-white leading-relaxed">
                        El mercado deja afuera lo más valioso: la experiencia.
                    </p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="flex items-start gap-6">
                <div class="flex-shrink-0">
                    <svg class="w-16 h-16" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32 12 C32 12, 20 18, 20 28 C20 38, 26 44, 32 48 C38 44, 44 38, 44 28 C44 18, 32 12, 32 12Z" stroke="#00efcf" stroke-width="3" fill="none"></path>
                        <path d="M28 28 L24 32 L32 40" stroke="#00efcf" stroke-width="2" fill="none"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-md md:text-xl text-white leading-relaxed">
                        Las nuevas generaciones enfrentan desafíos que nadie les enseñó a resolver.
                    </p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="flex items-start gap-6">
                <div class="flex-shrink-0">
                    <svg class="w-16 h-16" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 32 Q24 22, 32 22 Q40 22, 44 32" stroke="#9315ff" stroke-width="3" fill="none"></path>
                        <circle cx="26" cy="26" r="4" fill="#9315ff"></circle>
                        <circle cx="38" cy="26" r="4" fill="#9315ff"></circle>
                        <path d="M18 40 Q22 48, 32 48 Q42 48, 46 40" stroke="#9315ff" stroke-width="2" fill="none"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-md md:text-xl text-white leading-relaxed">
                        Las empresas no están formando líderes. Los líderes se forman entre líderes.
                    </p>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="flex items-start gap-6">
                <div class="flex-shrink-0">
                    <svg class="w-16 h-16" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Línea vertical -->
                        <line x1="32" y1="10" x2="32" y2="54" stroke="#ffa500" stroke-width="3" stroke-linecap="round"/>
                        
                        <!-- Curva superior del $ -->
                        <path d="M44 20
                                C44 14, 20 14, 20 26
                                C20 36, 44 30, 44 42
                                C44 50, 20 50, 20 44"
                            stroke="#ffa500"
                            stroke-width="3"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            fill="none"/>
                    </svg>
                </div>
                <div>
                    <p class="text-md md:text-xl text-white leading-relaxed">
                        Convertí tu experiencia en ingresos reales, con agenda flexible y sin inversión
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Cómo funciona -->
    <!--  Updated section background and improved visual hierarchy -->
    <section id="como-funciona" class="section-darker py-24 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-semibold titulos mb-6">
                    ¿Cómo <span class="gradient-text">funciona</span> Pipol para Mentores?
                </h2>
                <p class="text-md text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    La plataforma gestiona las reservas, el pago y las calificaciones, para que vos te enfoques en lo esencial: acompañar desde tu recorrido y tu mirada profesional.
                </p>
            </div>

            {{-- <div class="grid md:grid-cols-5 gap-8 relative">
                <!--  Added connector lines between steps -->
                <div class="hidden md:block absolute top-10 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-purple-500 to-transparent opacity-30"></div>
                
                <!-- Step 1 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        1
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Creá tu perfil profesional</h3>
                    <p class="text-gray-300 leading-relaxed text-md">
                        Contanos quien sos, tu experiencia profesional y en que temas o habilidades querés mentorear.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        2
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Pipol validará tu perfil</h3>
                    <p class="text-gray-300 leading-relaxed text-md">
                        Revisamos tu perfil para asegurarnos que tengas la experiencia necesaria y así generar confianza en la comunidad.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        3
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Definí tu disponibilidad</h3>
                    <p class="text-gray-300 leading-relaxed text-md">
                        Elegí tus días y horarios para mentorear.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        4
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Valorá tu experiencia</h3>
                    <p class="text-gray-300 leading-relaxed text-md">
                        Te ayudaremos a darle valor económico a tus mentorías.
                    </p>
                </div>

                <!-- Step 5 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        5
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Capacitate y seguí creciendo</h3>
                    <p class="text-gray-300 leading-relaxed text-md">
                        Accedé a cursos, talleres y feedback para potenciar tu impacto como mentor.
                    </p>
                </div>
            </div> --}}
            <!-- Swiper -->
            <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"
            />
            <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
            <div class="swiper steps-swiper relative">
                <div class="swiper-wrapper">

                    <!-- Step 1 -->
                    <div class="swiper-slide">
                        <div class="text-center px-6">
                            <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl">
                                1
                            </div>
                            <h3 class="text-2xl font-bold mb-4">Creá tu espacio profesional</h3>
                            <p class="text-gray-300 leading-relaxed text-md">
                                Contanos quién sos, tu recorrido y en qué podés ayudar. Este es el punto de partida para mentorear en Pipol.
                            </p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="swiper-slide">
                        <div class="text-center px-6">
                            <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl">
                                2
                            </div>
                            <h3 class="text-2xl font-bold mb-4">Pipol lo valida</h3>
                            <p class="text-gray-300 leading-relaxed text-md">
                                Revisamos tu información para asegurar experiencia real y generar confianza en la comunidad.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="swiper-slide">
                        <div class="text-center px-6">
                            <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl">
                                3
                            </div>
                            <h3 class="text-2xl font-bold mb-4">Definí tu agenda</h3>
                            <p class="text-gray-300 leading-relaxed text-md">
                                Elegí días y horarios para mentorear.
                                Vos decidís cuándo estar disponible.
                            </p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="swiper-slide">
                        <div class="text-center px-6">
                            <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl">
                                4
                            </div>
                            <h3 class="text-2xl font-bold mb-4">Poné valor a tu experiencia</h3>
                            <p class="text-gray-300 leading-relaxed text-md">
                                Te ayudamos a convertir tu conocimiento
                                en mentorías con valor económico.
                            </p>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="swiper-slide">
                        <div class="text-center px-6">
                            <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl">
                                5
                            </div>
                            <h3 class="text-2xl font-bold mb-4">Capacitate para crecer</h3>
                            <p class="text-gray-300 leading-relaxed text-md">
                                Accedé a formación, feedback y herramientas para potenciar tu impacto como mentor.
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Controles -->
                {{-- <div class="swiper-pagination mt-8"></div> --}}
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <script>
                const stepsSwiper = new Swiper('.steps-swiper', {
                    loop: false,
                    spaceBetween: 32,
                    slidesPerView: 1,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 1,
                        },
                        1024: {
                            slidesPerView: 3,
                        }
                    }
                });
            </script>


        </div>
    </section>

        <!-- FAQ con Tabs: Mentores y Mentees -->
    <section id="faq" class="section-darker py-24 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-5xl md:text-6xl font-semibold titulos mb-6">
                    Preguntas <span class="gradient-text">frecuentes</span>
                </h2>
            </div>
            <div id="content-mentores" class="tab-content space-y-6">

                <!-- FAQ Item 4 - Mentores -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all cursor-pointer">
                        <span class="text-md font-bold pr-8">¿Cómo me registro?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-md">
                            Es simple y rápido. Completás tu perfil, contás quién sos y qué experiencia tenés, elegís los temas en los que podés acompañar, fijás tu disponibilidad y listo. Una vez aprobado tu perfil, ya podés recibir reservas y comenzar a mentorear.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 1 - Mentores -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all cursor-pointer">
                        <span class="text-md font-bold pr-8">¿Tiene algún costo ser Mentor en Pipol?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-md">
                            Registrarte y estar en la plataforma no tiene costo fijo. Pipol funciona con un modelo de comisión por cada sesión que realizás, es decir, solo aportás cuando efectivamente mentoreás. Queremos que tu experiencia genere valor y que ganar sea mutuo.
                        </p>
                        <p class="text-gray-300 leading-relaxed text-md">
                            Además, en Pipol reconocemos tu crecimiento y el impacto que generás en la comunidad. A medida que alcanzás nuevos niveles como mentor, tu comisión se reduce progresivamente, premiando tu dedicación y constancia en acompañar a otros. Ver tabla de niveles y comisiones (link).
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 2 - Mentores -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all cursor-pointer">
                        <span class="text-md font-bold pr-8">¿Qué requisitos debo cumplir para ser Mentor en Pipol?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-md">
                            Para ser Mentor en Pipol necesitás:
                        </p>
                        <p class="text-gray-300 leading-relaxed text-md">
                            1) Experiencia real comprobable: Buscamos personas con trayectoria laboral sólida en cargos de liderazgo o gestión y/o emprendimientos propios con resultados reales.
                            <br>
                            2) Completar tu perfil y formación inicial 
                            <br>
                            Antes de comenzar a mentorear deberás: Completar tu perfil profesional, subir una foto profesional, definir tu disponibilidad, establecer tu valor hora y realizar el curso “Cómo ser un Mentor Pipol”
                            <br>
                            En Pipol la experiencia se demuestra y se comparte con responsabilidad. Queremos mentores preparados, reales y comprometidos.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 3 - Mentores -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all cursor-pointer">
                        <span class="text-md font-bold pr-8">¿Pueden rechazar mi registro como Mentor?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-md">
                            Si. Pipol revisa cada perfil y podrá aceptar, rechazar o solicitar información adicional.
                            <br>
                            Los principales métodos de validación son: conectar tu perfil de LinkedIn (en caso de tener uno) y cargar tu cv profesional.
                            <br>
                            Una vez finalizada la validación, Pipol te informará mediante el correo electrónico de registro
                        </p>
                    </div>
                </div>

                
                <!-- FAQ Item 4 - Mentores -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all cursor-pointer">
                        <span class="text-md font-bold pr-8">¿Cómo protege Pipol la privacidad y seguridad de los datos?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-md">
                            La información de mentores y mentees se protege con estándares modernos de seguridad.
                            <br>
                            ● Datos alojados en servidores seguros (Hostinger)
                            <br>
                            ● Videollamadas dentro de la plataforma, sin grabaciones automáticas
                            <br>
                            ● Ninguna información sensible se comparte sin consentimiento●Prohibido revelar datos identificables de terceros en sesiones
                            <br>
                            ● Derecho total del usuario a acceder y eliminar su información
                            <br>
                            Tu experiencia se comparte. Tus datos, no.
                        </p>
                    </div>
                </div>

                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all cursor-pointer">
                        <span class="text-md font-bold pr-8">¿Cuánto puedo ganar como mentor en Pipol?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-md">
                            Los ingresos en Pipol dependen principalmente de tu nivel de actividad y de cómo evoluciona tu perfil dentro de la plataforma. No existe un límite fijo: cada mentor decide cuántas sesiones ofrecer y cómo gestionar su agenda.
                            <br>
                            La cantidad de sesiones que podés generar está influenciada por distintos factores:
                            <br>
                            ✔ Disponibilidad en agenda
                            <br>
                            ✔ Nivel de mentor
                            <br>
                            ✔ Calidad de las sesiones
                            <br>
                            ✔ Especialización y claridad del perfil
                            <br>
                            ✔ Consistencia en la actividad
                            <br>
                            En Pipol, tu crecimiento no depende del azar: cuanto más valor compartís y más activa sea tu participación, mayores serán las oportunidades de generar sesiones.
                        </p>
                    </div>
                </div>


            </div>
        </div>
    </section>

@endsection