  <!-- Navigation -->
  {{-- <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm shadow-sm z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <a href="{{ route('home') }}" class="text-2xl font-bold text-primary">Pipol</a>
        </div>
        <div class="hidden md:flex items-center gap-8">
          <a href="#que-es" class="text-dark hover:text-primary transition-colors">Qué es Pipol</a>
          <a href="#como-funciona" class="text-dark hover:text-primary transition-colors">Cómo funciona</a>
          <a href="#faq" class="text-dark hover:text-primary transition-colors">Preguntas</a>
          <a href="#contacto" class="text-dark hover:text-primary transition-colors">Contacto</a>
        </div>
        <div class="flex items-center gap-3">
          @auth
          <div id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" class="cursor-pointer bg-primary text-white rounded-full hover:bg-primary/90 transition-all font-medium flex items-center gap-2 px-4 py-2">
            <div class="relative w-8 h-8 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 border border-gray-300 ">
              <img src="{{ auth()->user()->avatar ? asset('storage/avatars/'.auth()->user()->avatar) : asset('images/default-avatar.png') }}" class="absolute w-8 h-8 text-gray-400  rounded-full object-cover">
             
            </div>
            <div class="">
              {{ auth()->user()->name }}
            </div>
          </div>

                  <!-- Dropdown menu -->
        <div id="userDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
            <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
              <div>{{ auth()->user()->name }}</div>
              <div class="font-medium truncate">{{ auth()->user()->email }}</div>
            </div>
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="avatarButton">
              <li>
                <a href="{{ route('mentors.index') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
              </li>
              <li>
                <a href="{{ route('profile.show', ['id'=> auth()->id()]) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mi perfil</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ajustes</a>
              </li>
            </ul>
            <div class="py-1">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Cerrar Sesión</a>
            </div>
        </div>
            
          @else
            <a href="{{ route('login') }}" class="hidden sm:inline-block px-4 py-2 text-primary hover:text-primary/80 transition-colors">
              Iniciar sesión
            </a>
            <a href="{{ route('login', ['is_mentor' => true]) }}" class="px-5 py-2 bg-primary text-white rounded-full hover:bg-primary/90 transition-all font-medium">
              Soy mentor
            </a>
          @endauth
          </div>
        <!-- Mobile menu button -->
        <button class="md:hidden p-2" onclick="toggleMobileMenu()">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
    
    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
      <div class="px-4 py-4 space-y-3">
        <a href="#que-es" class="block py-2 text-dark hover:text-primary">Qué es Pipol</a>
        <a href="#como-funciona" class="block py-2 text-dark hover:text-primary">Cómo funciona</a>
        <a href="#faq" class="block py-2 text-dark hover:text-primary">Preguntas</a>
        <a href="#contacto" class="block py-2 text-dark hover:text-primary">Contacto</a>
      </div>
    </div>
  </nav> --}}

  <nav class="fixed w-full z-50 backdrop-blur-md" style="background: rgba(26, 10, 62, 0.9);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-3xl font-bold gradient-text-hero">
                  {{-- <img src="{{ asset('/images/logo-v2.png') }}" alt="logo" style="height: 60px;width: 150px;"> --}}
                  Pipol
                </a>
            </div>
            <div class="hidden md:flex items-center gap-8">
              <a href="#que-es" class="nav-link text-white hover:text-gray-200">Qué es Pipol</a>
                <a href="#como-funciona" class="nav-link text-white hover:text-gray-200">Cómo funciona</a>
                <a href="#faq" class="nav-link text-white hover:text-gray-200">Preguntas</a>
                <a href="#contacto" class="nav-link text-white hover:text-gray-200">Contacto</a>
            </div>
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                
                
                <!-- User Avatar -->
                @auth
                  <div class="flex items-center gap-2 ml-4 cursor-pointer" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" style="padding: 0.2em 0.5em;background: #261848;border-radius: 23px;">
                      <img src="{{ auth()->user()->avatar ? asset('storage/avatars/'.auth()->user()->avatar) : asset('images/default-avatar.png') }}" alt="Emí" class="w-10 h-10 rounded-full border-2 border-purple-500 object-cover">
                      <span class="text-white font-medium"> {{ auth()->user()->name }}</span>
                  </div>
                  <!-- Dropdown menu -->
                  <div id="userDropdown" class="z-10 hidden bg-[#261848]/40 divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                      <div class="px-4 py-3 text-sm text-gray-200 dark:text-white">
                        <div>{{ auth()->user()->name }}</div>
                        <div class="font-medium truncate">{{ auth()->user()->email }}</div>
                      </div>
                      <ul class="py-2 text-sm text-gray-200 dark:text-gray-200" aria-labelledby="avatarButton">
                        <li>
                          <a href="{{ route('mentors.index') }}" class="block px-4 py-2  hover:bg-[#261848]/80 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                        </li>
                        <li>
                          <a href="{{ route('profile.show', ['id'=> auth()->id()]) }}" class="block px-4 py-2  hover:bg-[#261848]/80 dark:hover:bg-gray-600 dark:hover:text-white">Mi perfil</a>
                        </li>
                        <li>
                          <a href="#" class="block px-4 py-2  hover:bg-[#261848]/80 dark:hover:bg-gray-600 dark:hover:text-white">Ajustes</a>
                        </li>
                      </ul>
                      <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-200 hover:bg-[#261848]/80 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Cerrar Sesión</a>
                      </div>
                  </div>
                @else
                <a href="{{ route('login') }}" class="hidden sm:inline-block px-4 py-2 text-white hover:text-white/80 transition-colors">
                  Iniciar sesión
                </a>
                <a href="{{ route('login', ['is_mentor' => true]) }}" class="px-5 py-2 bg-[#261848] text-white rounded-full hover:bg-[#261848]/90 transition-all font-medium">
                  Soy mentor
                </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg" style="color: var(--color-accent);">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden" style="background: var(--color-dark-secondary); border-top: 1px solid rgba(147, 21, 255, 0.2);">
        <div class="px-4 pt-4 pb-6 space-y-3">
            <a href="#que-es" class="block py-2 text-gray-300 hover:text-white">Qué es Pipol</a>
            <a href="#como-funciona" class="block py-2 text-gray-300 hover:text-white">Cómo funciona</a>
            <a href="#faq" class="block py-2 text-gray-300 hover:text-white">Preguntas</a>
            <a href="#contacto" class="block py-2 text-gray-300 hover:text-white">Contacto</a>
        </div>
    </div>
  </nav>