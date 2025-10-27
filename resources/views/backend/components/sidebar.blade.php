<!-- Sidebar principal (desktop) -->
<aside class="hidden md:block fixed left-0 top-0 h-full w-64 bg-[#2d5a4a] text-white p-6 overflow-y-auto z-40">
  <div class="mb-8">
    <h1 class="text-2xl font-bold text-[#d4af6a]">Pipol</h1>
  </div>

  <nav class="mb-8 space-y-4">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('dashboard') ? 'bg-[#3d6a5a]' : 'hover:bg-[#3d6a5a]' }} sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
      </svg>
      <span>Dashboard</span>
    </a>
    <a href="{{ route('mentors.index') }}" class="flex items-center gap-3 p-2 rounded  {{ request()->routeIs('mentors.index') ? 'bg-[#3d6a5a]' : 'hover:bg-[#3d6a5a]' }}  sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
      </svg>
      <span>Profesionales</span>
    </a>
    <a href="{{ route('sessions.index') }}"  class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('sessions.index') ? 'bg-[#3d6a5a]' : 'hover:bg-[#3d6a5a]' }}  sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      <span>Mis Sesiones</span>
    </a>
    <a href="#" class="flex items-center gap-3 p-2 rounded  sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
      </svg>
      <span>Favoritos</span>
    </a>
        
      <a href="{{ route('profile.show', ['id'=>auth()->id()]) }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('profile.show') ? 'bg-[#3d6a5a]' : 'hover:bg-[#3d6a5a]' }}  sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
      </svg>
      <span>Perfil</span>
      </a>
    
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
  <div class="p-4 flex justify-between items-center border-b border-[#3d6a5a]">
    <h1 class="text-xl font-bold text-[#d4af6a]">Pipol</h1>
    <button id="close-sidebar" class="focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <nav class="flex flex-col space-y-2 p-4">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-2 rounded hover:bg-[#3d6a5a] sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
      </svg>
      <span>Dashboard</span>
    </a>
    <a href="{{ route('mentors.index') }}" class="flex items-center gap-3 p-2 rounded bg-[#3d6a5a] sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
      </svg>
      <span>Profesionales</span>
    </a>
    <a href="{{ route('sessions.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-[#3d6a5a] sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      <span>Mis Sesiones</span>
    </a>
    <a href="#" class="flex items-center gap-3 p-2 rounded hover:bg-[#3d6a5a] sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
      </svg>
      <span>Favoritos</span>
    </a>
        
    <a href="{{ route('profile.show', ['id'=>auth()->id()]) }}" class="flex items-center gap-3 p-2 rounded hover:bg-[#3d6a5a] sidebar-icon">
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
