@extends('frontend.layout.app')

@section('title', 'Pipol - Mentores')  
@section('main_content')
<section class="section-darker py-32 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-5xl md:text-7xl font-black text-white mb-8 leading-tight">
            Tu experiencia tiene un valor que el mundo necesita.
        </h2>
        <p class="text-2xl md:text-3xl text-white mb-12 leading-relaxed">
            Compartila. Inspirá. Dejá tu huella.
        </p>
        <a href="#soy-mentor" class="btn-primary inline-flex items-center gap-3 text-white px-12 py-6 rounded-full text-2xl font-black uppercase tracking-wide">
            QUIERO SER MENTOR
        </a>
    </div>
</section>
<section class="section-dark py-24 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black mb-4">
                Por qué ser mentor <span class="gradient-text">Pipol</span>?
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
                    <p class="text-xl md:text-2xl text-white leading-relaxed">
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
                    <p class="text-xl md:text-2xl text-white leading-relaxed">
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
                    <p class="text-xl md:text-2xl text-white leading-relaxed">
                        Las capacitaciones de liderazgo no generan impacto real, sólo pérdida de tiempo.
                    </p>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="flex items-start gap-6">
                <div class="flex-shrink-0">
                    <svg class="w-16 h-16" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32 12 L38 24 L52 26 L42 36 L44 50 L32 44 L20 50 L22 36 L12 26 L26 24 Z" stroke="#ffa500" stroke-width="3" fill="none"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xl md:text-2xl text-white leading-relaxed">
                        Los mejores líderes se forman de grandes grandes mentores
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
                <h2 class="text-5xl md:text-6xl font-black mb-6">
                    ¿Cómo <span class="gradient-text">funciona</span> Pipol para Mentores?
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    La plataforma gestiona las reservas, el pago y las calificaciones, para que vos te enfoques en lo esencial: acompañar desde tu recorrido y tu mirada profesional.
                </p>
            </div>

            <div class="grid md:grid-cols-5 gap-8 relative">
                <!--  Added connector lines between steps -->
                <div class="hidden md:block absolute top-10 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-purple-500 to-transparent opacity-30"></div>
                
                <!-- Step 1 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        1
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Creá tu perfil profesional</h3>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Contanos quien sos, tu experiencia profesional y en que temas o habilidades querés mentorear.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        2
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Pipol validará tu perfil</h3>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Revisamos tu perfil para asegurarnos que tengas la experiencia necesaria y así generar confianza en la comunidad.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        3
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Definí tu disponibilidad</h3>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Elegí tus días y horarios para mentorear.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        4
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Valorá tu experiencia</h3>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Te ayudaremos a darle valor económico a tus mentorías.
                    </p>
                </div>

                <!-- Step 5 -->
                <div class="text-center relative">
                    <div class="w-24 h-24 gradient-bg rounded-full flex items-center justify-center mx-auto mb-8 text-4xl font-black text-white shadow-2xl relative z-10">
                        5
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Capacitate y seguí creciendo</h3>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Accedé a cursos, talleres y feedback para potenciar tu impacto como mentor.
                    </p>
                </div>
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
                        <div id="content-mentores" class="tab-content space-y-6">
                <!-- FAQ Item 1 - Mentores -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all">
                        <span class="text-xl font-bold pr-8">¿Tiene algún costo ser Mentor en Pipol?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-lg">
                            Registrarte y estar en la plataforma no tiene costo fijo. Pipol funciona con un modelo de comisión por cada sesión que realizás, es decir, solo aportás cuando efectivamente mentoreás. Queremos que tu experiencia genere valor y que ganar sea mutuo.
                        </p>
                        <p class="text-gray-300 leading-relaxed text-lg">
                            Además, en Pipol reconocemos tu crecimiento y el impacto que generás en la comunidad. A medida que alcanzás nuevos niveles como mentor, tu comisión se reduce progresivamente, premiando tu dedicación y constancia en acompañar a otros. Ver tabla de niveles y comisiones (link).
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 2 - Mentores -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all">
                        <span class="text-xl font-bold pr-8">¿Qué requisitos debo cumplir para ser Mentor en Pipol?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-lg">
                            Para ser Mentor en Pipol necesitás:
                        </p>
                        <p class="text-gray-300 leading-relaxed text-lg">
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
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all">
                        <span class="text-xl font-bold pr-8">¿Pueden rechazar mi registro como Mentor?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-lg">
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
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all">
                        <span class="text-xl font-bold pr-8">¿Cómo me registro?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-lg">
                            Es simple y rápido. Completás tu perfil, contás quién sos y qué experiencia tenés, elegís los temas en los que podés acompañar, fijás tu disponibilidad y listo. Una vez aprobado tu perfil, ya podés recibir reservas y comenzar a mentorear.
                        </p>
                    </div>
                </div>
                <!-- FAQ Item 4 - Mentores -->
                <div class="card rounded-2xl overflow-hidden">
                    <button class="faq-question w-full text-left p-8 flex justify-between items-center hover:bg-opacity-80 transition-all">
                        <span class="text-xl font-bold pr-8">¿Cómo protege Pipol la privacidad y seguridad de los datos?</span>
                        <svg class="faq-icon w-6 h-6 flex-shrink-0 transition-transform" style="color: var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-8 pb-8">
                        <p class="text-gray-300 leading-relaxed text-lg">
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


            </div>
        </div>
    </section>

@endsection