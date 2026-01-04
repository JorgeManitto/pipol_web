<!-- Sidebar principal (desktop) -->
<aside class="hidden md:block fixed left-0 top-0 h-full w-64 hero-section text-white p-6 overflow-y-auto z-40">
  <div class="mb-8">
    {{-- <h1 class="text-3xl font-bold gradient-text-hero">Pipol</h1> --}}
    <a href="{{ route('dashboard') }}">
      <img src="{{ asset('/images/logo-clea-recorte.png') }}" alt="logo" style=" object-fit: contain;height: 40px;">
    </a>
  </div>
  {{-- @dd(auth()->user()) --}}
  <nav class="mb-8 space-y-4">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('dashboard') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }} sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
      </svg>
      <span>Dashboard</span>
    </a>
    <a href="{{ route('sessions.index') }}"  class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('sessions.index') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }}  sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      <span>Mis Sesiones</span>
    </a>
    {{-- <a href="#" class="flex items-center gap-3 p-2 rounded  sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
      </svg>
      <span>Favoritos</span>
    </a> --}}
    <a href="{{ route('mentors.index') }}" class="flex items-center gap-3 p-2 rounded  {{ request()->routeIs('mentors.index') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }}  sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
      </svg>
      <span>Ir a Mentores</span>
    </a>
    <a href="{{ route('admin.chat.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('admin.chat.index') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }} sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M8 10h8m-8 4h5m9-2a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
      <span>Mensajes</span>
    </a>
    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'mentor')
     <a href="{{ route('admin.statistics') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('admin.statistics') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }} sidebar-icon">
         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                 d="M9 17v-6m4 6V7m4 10v-3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
         </svg>
         <span>Mis estadísticas</span>
       </a>
    @endif
        
    <a href="{{ route('profile.show', ['id'=>auth()->id()]) }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('profile.show') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }}  sidebar-icon">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    <span>Perfil</span>
    </a>
    @if (auth()->user()->role == 'admin')
        
      <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('admin.users.*') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }} sidebar-icon">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
          <span>Gestión de usuarios</span>
      </a>
    @endif

      
      <div class="flex absolute bottom-16 items-center gap-3 p-2 rounded flex-col">
        {{-- <div class="flex items-center cursor-pointer w-full gap-2" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" style="padding: 0.2em 0.5em;background: #261848;border-radius: 23px;">
            <img src="{{ auth()->user()->avatar ? asset('storage/avatars/'.auth()->user()->avatar) : asset('images/default-avatar.png') }}" alt="Emí" class="w-10 h-10 rounded-full border-2 border-purple-500 object-cover">
            <span class="text-white font-medium"> {{ auth()->user()->name }}</span>
        </div> --}}
        <a href="{{ route('logout') }}" class="sidebar-icon flex items-center gap-3 p-2 rounded hover:bg-[#ffffff55] w-full">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1" />
          </svg>
          <span>Cerrar Sesión</span>
        </a>
      </div>
    
  </nav>
</aside>

<!-- Navbar móvil -->
<nav class="block md:hidden bg-[#2d5a4a] sticky top-0 text-white p-4 flex justify-between items-center relative z-30">
  <h1 class="text-2xl font-bold text-[#d4af6a]">Pipol</h1>

  <!-- Botón hamburguesa -->
  <button id="menu-toggle" class="focus:outline-none">
    <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M4 6h16M4 12h16M4 18h16" />
    </svg>
  </button>
</nav>

<!-- Sidebar móvil -->
<div id="mobile-sidebar"
  class="fixed top-0 left-0 h-full w-64 bg-[#2d5a4a] text-white transform -translate-x-full transition-transform duration-300 ease-in-out z-40">
  <div class="p-4 flex justify-between items-center border-b border-[#ffffff55]">
    <h1 class="text-xl font-bold text-[#d4af6a]">Pipol</h1>
    <button id="close-sidebar" class="focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <nav class="flex flex-col space-y-2 p-4">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-2 rounded hover:bg-[#ffffff55] sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
      </svg>
      <span>Dashboard</span>
    </a>
    <a href="{{ route('mentors.index') }}" class="flex items-center gap-3 p-2 rounded bg-[#ffffff55] sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
      </svg>
      <span>Profesionales</span>
    </a>
    <a href="{{ route('sessions.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-[#ffffff55] sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      <span>Mis Sesiones</span>
    </a>
    <a href="#" class="flex items-center gap-3 p-2 rounded hover:bg-[#ffffff55] sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
      </svg>
      <span>Favoritos</span>
    </a>
        
    <a href="{{ route('profile.show', ['id'=>auth()->id()]) }}" class="flex items-center gap-3 p-2 rounded hover:bg-[#ffffff55] sidebar-icon">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span>Perfil</span>
    </a>
  </nav>
</div>

<!-- Fondo semitransparente -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30"></div>

<!-- JS puro -->
<script>
  const menuToggle = document.getElementById('menu-toggle');
  const mobileSidebar = document.getElementById('mobile-sidebar');
  const overlay = document.getElementById('overlay');
  const closeSidebar = document.getElementById('close-sidebar');
  const menuIcon = document.getElementById('menu-icon');

  // Abrir sidebar
  menuToggle.addEventListener('click', () => {
    mobileSidebar.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');
  });

  // Cerrar sidebar (botón ✖️)
  closeSidebar.addEventListener('click', () => {
    mobileSidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
  });

  // Cerrar al hacer clic fuera
  overlay.addEventListener('click', () => {
    mobileSidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
  });
</script>
