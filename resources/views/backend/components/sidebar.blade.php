<aside class="hidden md:block fixed left-0 top-0 h-full w-64 hero-section text-white p-6 overflow-y-auto z-40">
  <div class="mb-8">
    <a href="{{ route('home') }}">
      <img src="{{ asset('/images/logo-v3-recorte.png') }}" alt="logo" style=" object-fit: contain;height: 72px;">
    </a>
  </div>
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
    @if (auth()->user()->is_mentor == '1' || auth()->user()->role == 'admin')
     <a href="{{ route('agenda.index', ['id'=>auth()->id()]) }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('agenda.index') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }}  sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
      </svg>
      <span>Agenda</span>
      </a>
      <a href="{{ route('admin.payouts.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('admin.payouts.index') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }}  sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
      <span>Pagos</span>
      </a>
    @endif
    <a href="{{ route('admin.chat.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('admin.chat.index') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }} sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M8 10h8m-8 4h5m9-2a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
      <span>Mensajes</span>
    </a>
    <a href="{{ route('admin.statistics') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('admin.statistics') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }} sidebar-icon">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 17v-6m4 6V7m4 10v-3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>Mis transacciones</span>
      </a>
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
      <a href="{{ route('admin.sessions.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('admin.sessions.*') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }} sidebar-icon">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span>Gestión de sesiones</span>
      </a>
    @endif
    <a href="{{ route('logout') }}" class="flex items-center gap-3 p-2 rounded hover:bg-[#ffffff55] sidebar-icon">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1" />
      </svg>
          <span>Cerrar Sesión</span>
    </a>
  
  </nav>
</aside>

<nav class="md:hidden bg-[#1a0a3e] sticky top-0 text-white p-4 flex justify-between items-center z-30">
  <a href="{{ route('dashboard') }}">
    <img src="{{ asset('/images/logo-v3-recorte.png') }}" alt="logo" style="object-fit: contain; height: 42px;">
  </a>

  <!-- Controles agrupados a la derecha -->
  <div class="flex items-center gap-2">
    @if ( !request()->routeIs('mentors.index') )
        <div class="flex gap-2">
            <a href="{{ route('mentors.index') }}" class="flex items-center gap-2 py-2 px-2 text-center font-normal text-xs rounded-lg transition-colors cursor-pointer active-tab">
                Ir a mentores
            </a>
        </div>
    @endif
    <!-- Selector de divisa -->
    <select id="currencySelectorMobile"
      class="bg-[#261848] text-white text-xs rounded-lg border border-purple-500 px-2 py-1.5 cursor-pointer focus:outline-none focus:ring-2 focus:ring-purple-400">
      <option value="USD" {{ request()->cookie('currency', 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
      <option value="ARS" {{ request()->cookie('currency', 'USD') == 'ARS' ? 'selected' : '' }}>ARS</option>
      <option value="EUR" {{ request()->cookie('currency', 'USD') == 'EUR' ? 'selected' : '' }}>EUR</option>
    </select>

    <!-- Notificaciones -->
    <div class="relative">
      <button id="notifBtnMobile" class="relative flex items-center px-1 py-1 cursor-pointer">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span id="notifCountMobile" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1.5">0</span>
      </button>

      <!-- Dropdown notificaciones mobile -->
      <div id="notifDropdownMobile" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-lg border border-gray-200 z-50">
        <div class="p-3 border-b border-gray-100 flex items-center justify-between">
          <h3 class="text-sm font-semibold text-gray-700">Notificaciones</h3>
          <button id="clearNotifsMobile" class="text-xs text-blue-500 hover:underline">Marcar como leídas</button>
        </div>
        <div id="notifListMobile" class="max-h-64 overflow-y-auto divide-y divide-gray-100"></div>
      </div>
    </div>

    <!-- Botón hamburguesa -->
    <button id="menu-toggle" class="focus:outline-none ml-1">
      <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
  </div>
</nav>

<!-- Sidebar móvil -->
<div id="mobile-sidebar"
  class="fixed top-0 left-0 h-full w-64 bg-[#1a0a3e] text-white transform -translate-x-full transition-transform duration-300 ease-in-out z-40">
  <div class="p-4 flex justify-between items-start border-b border-[#ffffff55]">
    {{-- <h1 class="text-xl font-bold text-[#d4af6a]">Pipol</h1> --}}
    <a href="{{ route('dashboard') }}">
      <img src="{{ asset('/images/logo-v3-recorte.png') }}" alt="logo" style=" object-fit: contain;height: 72px;">
    </a>
    <button id="close-sidebar" class="focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <nav class="flex flex-col space-y-2 p-4">
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
    @if (auth()->user()->is_mentor == '1' || auth()->user()->role == 'admin')
     <a href="{{ route('agenda.index', ['id'=>auth()->id()]) }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('agenda.index') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }}  sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
      </svg>
      <span>Agenda</span>
      </a>
     <a href="{{ route('admin.payouts.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('admin.payouts.index') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }}  sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
      <span>Pagos</span>
      </a>
    @endif
    <a href="{{ route('admin.chat.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('admin.chat.index') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }} sidebar-icon">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M8 10h8m-8 4h5m9-2a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
      <span>Mensajes</span>
    </a>
    <a href="{{ route('admin.statistics') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('admin.statistics') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }} sidebar-icon">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 17v-6m4 6V7m4 10v-3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>Mis transacciones</span>
      </a>
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
      <a href="{{ route('admin.sessions.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('admin.sessions.*') ? 'bg-[#ffffff55]' : 'hover:bg-[#ffffff55]' }} sidebar-icon">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span>Gestión de sesiones</span>
      </a>
    @endif
    <div class="flex absolute bottom-2 items-center gap-3 p-2 rounded flex-col">
      <a href="{{ route('logout') }}" class="sidebar-icon flex items-center gap-3 p-2 rounded hover:bg-[#ffffff55] w-full">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1" />
        </svg>
        <span>Cerrar Sesión</span>
      </a>
    </div>
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

      const notifBtnMobile = document.getElementById("notifBtnMobile");
  const notifDropdownMobile = document.getElementById("notifDropdownMobile");
  const notifListMobile = document.getElementById("notifListMobile");
  const notifCountMobile = document.getElementById("notifCountMobile");

  notifBtnMobile?.addEventListener("click", (e) => {
    e.stopPropagation();
    notifDropdownMobile.classList.toggle("hidden");
  });

  // Cerrar dropdown al tocar fuera
  document.addEventListener("click", (e) => {
    if (!notifDropdownMobile.contains(e.target) && e.target !== notifBtnMobile) {
      notifDropdownMobile.classList.add("hidden");
    }
  });

  // Sincronizar selector mobile con el de desktop
  document.getElementById('currencySelectorMobile')?.addEventListener('change', function () {
    const selected = this.value;
    setCookie('currency', selected);
    // Sincronizar el otro selector si existe
    const desktopSelector = document.getElementById('currencySelector');
    if (desktopSelector) desktopSelector.value = selected;
    updateAllPrices(selected);
  }); 
</script>
