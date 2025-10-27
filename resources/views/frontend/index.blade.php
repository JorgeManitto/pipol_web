@extends('frontend.layout.app')

@section('title', 'Pipol - Conectando experiencia con talento')  
@section('main_content')
  <!-- Hero Section -->
  <section id="home" class="hero-gradient pt-24 pb-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="grid lg:grid-cols-2 gap-12 items-center min-h-[600px]">
        <div class="text-white space-y-8">
          <div class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm">
            ✨ La experiencia es el conocimiento más valioso
          </div>
          <h1 class="text-4xl sm:text-5xl lg:text-5xl font-bold leading-tight text-balance">
            <span class="text-[#d4af6a]">Pipol:</span> Construir un puente entre generaciones y democratizar el valor de la experiencia.
            {{-- La experiencia es el conocimiento más valioso --}}
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
  </section>

  <!-- Qué es Pipol -->
  <section id="que-es" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6 text-balance">
          ¿Qué es Pipol?
        </h2>
        <p class="text-xl text-gray-600 leading-relaxed">
          Somos una plataforma que democratiza el valor de la experiencia, creando un espacio donde el conocimiento real se comparte y todos crecemos juntos.
        </p>
      </div>

      <div class="grid md:grid-cols-3 gap-8 mb-16">
        <div class="bg-secondary/30 rounded-2xl p-8 hover:shadow-lg transition-shadow">
          <div class="w-14 h-14 bg-primary rounded-xl flex items-center justify-center mb-6">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-3">Conectamos generaciones</h3>
          <p class="text-gray-600 leading-relaxed">
            Construimos puentes entre quienes tienen experiencia valiosa y quienes están comenzando su camino profesional.
          </p>
        </div>

        <div class="bg-secondary/30 rounded-2xl p-8 hover:shadow-lg transition-shadow">
          <div class="w-14 h-14 bg-primary rounded-xl flex items-center justify-center mb-6">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-3">Experiencia real</h3>
          <p class="text-gray-600 leading-relaxed">
            No teorías vacías. Aquí se comparten historias reales, aprendizajes vividos y conocimiento que solo da la experiencia.
          </p>
        </div>

        <div class="bg-secondary/30 rounded-2xl p-8 hover:shadow-lg transition-shadow">
          <div class="w-14 h-14 bg-primary rounded-xl flex items-center justify-center mb-6">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-3">Valor compartido</h3>
          <p class="text-gray-600 leading-relaxed">
            Damos visibilidad a profesionales que tienen mucho por enseñar, más allá de seguidores o influencia digital.
          </p>
        </div>
      </div>

      <div class="bg-primary/5 rounded-3xl p-8 md:p-12">
        <div class="grid md:grid-cols-2 gap-8 items-center">
          <div>
            <h3 class="text-2xl font-bold mb-4">Nuestra misión</h3>
            <p class="text-gray-700 leading-relaxed mb-4">
              Creemos que quienes hoy quedan fuera del mercado laboral —por edad, contexto o cambio de etapa— tienen un tesoro invaluable: su experiencia.
            </p>
            <p class="text-gray-700 leading-relaxed">
              En Pipol, esas personas encuentran un lugar para compartir su conocimiento y seguir aportando valor, mientras ayudan a otros a crecer con propósito.
            </p>
          </div>
          <div class="bg-white rounded-2xl p-8 shadow-lg">
            <blockquote class="text-lg italic text-gray-700 mb-4">
              "Cuando la experiencia se comparte, todos crecemos."
            </blockquote>
            <p class="text-primary font-semibold">— Filosofía Pipol</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Cómo funciona -->
  <section id="como-funciona" class="py-20 px-4 sm:px-6 lg:px-8 bg-light">
    <div class="max-w-7xl mx-auto">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6 text-balance">
          ¿Cómo funciona?
        </h2>
        <p class="text-xl text-gray-600 leading-relaxed">
          Conectar con tu mentor ideal es simple. Tres pasos para comenzar tu camino de crecimiento profesional.
        </p>
      </div>

      <div class="grid md:grid-cols-3 gap-8 relative">
        <!-- Connecting lines for desktop -->
        <div class="hidden md:block absolute top-24 left-0 right-0 h-1 bg-accent/30" style="width: 66%; margin-left: 16.5%;"></div>
        
        <div class="relative">
          <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow relative z-10">
            <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mb-6 mx-auto">
              1
            </div>
            <h3 class="text-xl font-bold mb-3 text-center">Creá tu perfil</h3>
            <p class="text-gray-600 leading-relaxed text-center">
              Contanos sobre tus objetivos, intereses y qué tipo de experiencia estás buscando para tu desarrollo profesional.
            </p>
          </div>
        </div>

        <div class="relative">
          <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow relative z-10">
            <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mb-6 mx-auto">
              2
            </div>
            <h3 class="text-xl font-bold mb-3 text-center">Encontrá tu mentor</h3>
            <p class="text-gray-600 leading-relaxed text-center">
              Explorá perfiles de profesionales con experiencia real en tu área de interés y elegí quien mejor se adapte a tus necesidades.
            </p>
          </div>
        </div>

        <div class="relative">
          <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow relative z-10">
            <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mb-6 mx-auto">
              3
            </div>
            <h3 class="text-xl font-bold mb-3 text-center">Crecé con propósito</h3>
            <p class="text-gray-600 leading-relaxed text-center">
              Comenzá tu proceso de mentoría, aprendé de historias reales y definí tu camino con la guía de quien ya lo recorrió.
            </p>
          </div>
        </div>
      </div>

      <div class="mt-16 text-center">
        <a href="#registro" class="inline-flex items-center px-8 py-4 bg-primary text-white rounded-full font-semibold hover:bg-primary/90 transition-all text-lg shadow-lg">
          Comenzar ahora
          <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!-- CTA Section - Soy Mentor -->
  <section id="soy-mentor" class="py-20 px-4 sm:px-6 lg:px-8 bg-primary text-white">
    <div class="max-w-5xl mx-auto text-center">
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6 text-balance">
        ¿Tenés experiencia para compartir?
      </h2>
      <p class="text-xl text-white/90 leading-relaxed mb-8 max-w-3xl mx-auto">
        No necesitás miles de seguidores para ser un gran mentor. Si tenés experiencia real, historias vividas y ganas de ayudar a otros a crecer, este es tu lugar.
      </p>
      <div class="grid sm:grid-cols-3 gap-6 mb-10 max-w-3xl mx-auto">
        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
          <div class="text-3xl font-bold mb-2">+</div>
          <p class="text-sm">Compartí tu conocimiento</p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
          <div class="text-3xl font-bold mb-2">+</div>
          <p class="text-sm">Seguí aportando valor</p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
          <div class="text-3xl font-bold mb-2">+</div>
          <p class="text-sm">Impactá vidas</p>
        </div>
      </div>
      <a href="#registro-mentor" class="inline-flex items-center px-8 py-4 bg-white text-primary rounded-full font-semibold hover:bg-secondary transition-all text-lg shadow-lg">
        Registrate como mentor
        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
        </svg>
      </a>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
    <div class="max-w-4xl mx-auto">
      <div class="text-center mb-16">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6">
          Preguntas frecuentes
        </h2>
        <p class="text-xl text-gray-600">
          Todo lo que necesitás saber sobre Pipol
        </p>
      </div>

      <div class="space-y-4">
        <div class="bg-light rounded-xl overflow-hidden">
          <button onclick="toggleFaq(1)" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-secondary/20 transition-colors">
            <span class="font-semibold text-lg">¿Qué es exactamente Pipol?</span>
            <svg class="w-6 h-6 transform transition-transform" id="faq-icon-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          <div id="faq-content-1" class="hidden px-6 pb-5">
            <p class="text-gray-600 leading-relaxed">
              Pipol es una plataforma que conecta a profesionales con experiencia real con personas que están comenzando o desarrollando su carrera. Creemos que la experiencia es el conocimiento más valioso, y creamos un espacio donde se puede compartir de manera significativa.
            </p>
          </div>
        </div>

        <div class="bg-light rounded-xl overflow-hidden">
          <button onclick="toggleFaq(2)" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-secondary/20 transition-colors">
            <span class="font-semibold text-lg">¿Quién puede ser mentor en Pipol?</span>
            <svg class="w-6 h-6 transform transition-transform" id="faq-icon-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          <div id="faq-content-2" class="hidden px-6 pb-5">
            <p class="text-gray-600 leading-relaxed">
              Cualquier profesional con experiencia real en su campo puede ser mentor. No necesitás ser influencer ni tener miles de seguidores. Si tenés conocimientos vividos, historias para compartir y ganas de ayudar a otros a crecer, sos bienvenido en Pipol.
            </p>
          </div>
        </div>

        <div class="bg-light rounded-xl overflow-hidden">
          <button onclick="toggleFaq(3)" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-secondary/20 transition-colors">
            <span class="font-semibold text-lg">¿Cómo funciona el proceso de mentoría?</span>
            <svg class="w-6 h-6 transform transition-transform" id="faq-icon-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          <div id="faq-content-3" class="hidden px-6 pb-5">
            <p class="text-gray-600 leading-relaxed">
              Una vez que te registrás, podés explorar perfiles de mentores según tu área de interés. Cuando encontrás el mentor ideal, podés conectar con él o ella para comenzar tu proceso de mentoría personalizado, donde recibirás guía basada en experiencia real.
            </p>
          </div>
        </div>

        <div class="bg-light rounded-xl overflow-hidden">
          <button onclick="toggleFaq(4)" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-secondary/20 transition-colors">
            <span class="font-semibold text-lg">¿Tiene algún costo usar Pipol?</span>
            <svg class="w-6 h-6 transform transition-transform" id="faq-icon-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          <div id="faq-content-4" class="hidden px-6 pb-5">
            <p class="text-gray-600 leading-relaxed">
              Estamos trabajando en diferentes modelos para hacer la plataforma accesible para todos. Nuestro objetivo es democratizar el acceso a la experiencia, por lo que estamos diseñando opciones que se adapten a diferentes necesidades y posibilidades.
            </p>
          </div>
        </div>

        <div class="bg-light rounded-xl overflow-hidden">
          <button onclick="toggleFaq(5)" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-secondary/20 transition-colors">
            <span class="font-semibold text-lg">¿Qué áreas profesionales cubre Pipol?</span>
            <svg class="w-6 h-6 transform transition-transform" id="faq-icon-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          <div id="faq-content-5" class="hidden px-6 pb-5">
            <p class="text-gray-600 leading-relaxed">
              Pipol está abierto a profesionales de todas las áreas: tecnología, negocios, diseño, marketing, educación, salud, y más. Creemos que cada industria tiene profesionales con experiencia valiosa para compartir.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contacto" class="py-20 px-4 sm:px-6 lg:px-8 bg-light">
    <div class="max-w-5xl mx-auto">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
          <h2 class="text-3xl sm:text-4xl font-bold mb-6">
            ¿Tenés alguna pregunta?
          </h2>
          <p class="text-xl text-gray-600 leading-relaxed mb-8">
            Estamos aquí para ayudarte. Escribinos y te responderemos a la brevedad.
          </p>
          <div class="space-y-4">
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
              </div>
              <div>
                <h3 class="font-semibold mb-1">Email</h3>
                <p class="text-gray-600">contacto@pipol.com</p>
              </div>
            </div>
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
              </div>
              <div>
                <h3 class="font-semibold mb-1">Ubicación</h3>
                <p class="text-gray-600">Buenos Aires, Argentina</p>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">
          <form class="space-y-5">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
              <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" placeholder="Tu nombre">
            </div>
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
              <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" placeholder="tu@email.com">
            </div>
            <div>
              <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Mensaje</label>
              <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all resize-none" placeholder="Contanos en qué podemos ayudarte..."></textarea>
            </div>
            <button type="submit" class="w-full px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-all">
              Enviar mensaje
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
@endsection
