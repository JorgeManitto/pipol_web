@extends('backend.layout.app')

@section('page_title', 'Mensajes')

@section('main_content')
      <!-- Chat Container: Adjusted responsive layout and padding -->
      <div class="flex-1 flex p-2 md:p-4 lg:p-8 gap-2 md:gap-4 lg:gap-6 overflow-hidden">
        
        <!-- Chat List: Added responsive width and mobile toggle button -->
        <div 
          id="chatList"
          class="w-full md:w-80 bg-white rounded-2xl p-4 md:p-6 text-primary-dark absolute md:static inset-0 md:inset-auto z-30 md:z-auto hidden md:block"
        >
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Conversaciones</h2>
            <!-- Added close button for mobile -->
            <button 
              onclick="toggleChatList()"
              class="md:hidden p-2 hover:bg-gray-100 rounded-lg"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
          
          <div class="space-y-3">
            <!-- Chat Item Active -->
            <div class="flex items-center gap-3 p-3 rounded-xl bg-purple-600/10 border-2 border-accent-purple cursor-pointer">
              <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold">
                MC
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-sm">María Contreras</h3>
                <p class="text-xs text-gray-500 truncate">¡Perfecto! Nos vemos entonces</p>
              </div>
              <div class="text-right">
                <span class="text-xs text-gray-400">10:30</span>
                <div class="w-5 h-5 rounded-full bg-purple-600 text-white text-xs flex items-center justify-center mt-1">
                  2
                </div>
              </div>
            </div>
            
            <!-- Chat Item -->
            <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 cursor-pointer transition">
              <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-cyan-400 flex items-center justify-center text-white font-bold">
                PR
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-sm">Pedro Ramírez</h3>
                <p class="text-xs text-gray-500 truncate">Gracias por la sesión de hoy</p>
              </div>
              <div class="text-right">
                <span class="text-xs text-gray-400">Ayer</span>
              </div>
            </div>
            
            <!-- Chat Item -->
            <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 cursor-pointer transition">
              <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-red-400 flex items-center justify-center text-white font-bold">
                LG
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-sm">Laura Gómez</h3>
                <p class="text-xs text-gray-500 truncate">¿Tienes disponibilidad mañana?</p>
              </div>
              <div class="text-right">
                <span class="text-xs text-gray-400">Lun</span>
              </div>
            </div>
            
            <!-- Chat Item -->
            <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 cursor-pointer transition">
              <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-emerald-400 flex items-center justify-center text-white font-bold">
                CF
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-sm">Carlos Fernández</h3>
                <p class="text-xs text-gray-500 truncate">Me encantó la mentoría</p>
              </div>
              <div class="text-right">
                <span class="text-xs text-gray-400">Dom</span>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Chat Window: Adjusted responsive layout and mobile visibility -->
        <div class="flex-1 bg-white rounded-2xl flex flex-col text-primary-dark overflow-hidden">
          
          <!-- Chat Header: Added mobile back button and responsive layout -->
          <div class="px-4 md:px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <!-- Added back button for mobile -->
              <button 
                onclick="toggleChatList()"
                class="md:hidden p-2 hover:bg-gray-100 rounded-lg -ml-2"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
              </button>
              <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold flex-shrink-0">
                MC
              </div>
              <div>
                <h3 class="font-bold text-sm md:text-base">María Contreras</h3>
                <p class="text-xs text-green-500 flex items-center gap-1">
                  <span class="w-2 h-2 rounded-full bg-green-500"></span>
                  En línea
                </p>
              </div>
            </div>
            <div class="flex items-center gap-1 md:gap-2">
              <button class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
              </button>
              <button class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
              </button>
            </div>
          </div>
          
          <!-- Chat Messages: Adjusted responsive padding and message width -->
          <div class="flex-1 overflow-y-auto p-3 md:p-6 space-y-4">
            
            <!-- Received Message -->
            <div class="flex items-start gap-2 md:gap-3">
              <div class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                MC
              </div>
              <div class="flex flex-col gap-1 max-w-[75%] md:max-w-md">
                <div class="bg-gray-100 rounded-2xl rounded-tl-none px-3 md:px-4 py-2 md:py-3">
                  <p class="text-sm">Hola Jorge, ¿cómo estás?</p>
                </div>
                <span class="text-xs text-gray-400 px-2">10:25</span>
              </div>
            </div>
            
            <div class="flex items-start gap-2 md:gap-3">
              <div class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                MC
              </div>
              <div class="flex flex-col gap-1 max-w-[75%] md:max-w-md">
                <div class="bg-gray-100 rounded-2xl rounded-tl-none px-3 md:px-4 py-2 md:py-3">
                  <p class="text-sm">Quería confirmar nuestra sesión de mañana a las 3pm</p>
                </div>
                <span class="text-xs text-gray-400 px-2">10:26</span>
              </div>
            </div>
            
            <!-- Sent Messages -->
            <div class="flex items-start gap-2 md:gap-3 flex-row-reverse">
              <div class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-purple-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                JM
              </div>
              <div class="flex flex-col gap-1 max-w-[75%] md:max-w-md items-end">
                <div class="bg-purple-600 text-white rounded-2xl rounded-tr-none px-3 md:px-4 py-2 md:py-3">
                  <p class="text-sm">¡Hola María! Todo bien, gracias</p>
                </div>
                <span class="text-xs text-gray-400 px-2">10:28</span>
              </div>
            </div>
            
            <div class="flex items-start gap-2 md:gap-3 flex-row-reverse">
              <div class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-purple-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                JM
              </div>
              <div class="flex flex-col gap-1 max-w-[75%] md:max-w-md items-end">
                <div class="bg-purple-600 text-white rounded-2xl rounded-tr-none px-3 md:px-4 py-2 md:py-3">
                  <p class="text-sm">Sí, confirmado para mañana a las 3pm 👍</p>
                </div>
                <span class="text-xs text-gray-400 px-2">10:28</span>
              </div>
            </div>
            
            <div class="flex items-start gap-2 md:gap-3">
              <div class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                MC
              </div>
              <div class="flex flex-col gap-1 max-w-[75%] md:max-w-md">
                <div class="bg-gray-100 rounded-2xl rounded-tl-none px-3 md:px-4 py-2 md:py-3">
                  <p class="text-sm">¡Perfecto! Nos vemos entonces 😊</p>
                </div>
                <span class="text-xs text-gray-400 px-2">10:30</span>
              </div>
            </div>
            
          </div>
          
          <!-- Chat Input: Adjusted responsive padding and button sizing -->
          <div class="p-3 md:p-4 border-t border-gray-200">
            <div class="flex items-center gap-2 md:gap-3">
              <button class="p-2 hover:bg-gray-100 rounded-lg transition hidden sm:block">
                <svg class="w-5 md:w-6 h-5 md:h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                </svg>
              </button>
              <button class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 md:w-6 h-5 md:h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </button>
              <input 
                type="text" 
                placeholder="Escribe un mensaje..." 
                class="flex-1 px-3 md:px-4 py-2 md:py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple text-sm"
              />
              <button class="px-4 md:px-6 py-2 md:py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-600/90 transition font-medium text-sm">
                <span class="hidden sm:inline">Enviar</span>
                <svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
              </button>
            </div>
          </div>
          
        </div>
        
      </div>
      
        <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('-translate-x-full');
    }
    
    function toggleChatList() {
      const chatList = document.getElementById('chatList');
      chatList.classList.toggle('hidden');
    }
  </script>
       <!-- Added JavaScript for mobile interactions: sidebar toggle and chat view switching -->
  {{-- <script>
    // Sidebar toggle
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const openSidebar = document.getElementById('openSidebar');
    const closeSidebar = document.getElementById('closeSidebar');
    
    openSidebar.addEventListener('click', () => {
      sidebar.classList.remove('-translate-x-full');
      sidebarOverlay.classList.remove('hidden');
    });
    
    closeSidebar.addEventListener('click', () => {
      sidebar.classList.add('-translate-x-full');
      sidebarOverlay.classList.add('hidden');
    });
    
    sidebarOverlay.addEventListener('click', () => {
      sidebar.classList.add('-translate-x-full');
      sidebarOverlay.classList.add('hidden');
    });
    
    // Chat view switching for mobile
    const chatList = document.getElementById('chatList');
    const chatWindow = document.getElementById('chatWindow');
    const backToList = document.getElementById('backToList');
    const chatItems = document.querySelectorAll('.chat-item');
    
    chatItems.forEach(item => {
      item.addEventListener('click', () => {
        if (window.innerWidth < 768) {
          chatList.classList.add('hidden');
          chatWindow.classList.remove('hidden');
          chatWindow.classList.add('flex');
        }
      });
    });
    
    backToList.addEventListener('click', () => {
      chatList.classList.remove('hidden');
      chatWindow.classList.add('hidden');
      chatWindow.classList.remove('flex');
    });
  </script> --}}

@endsection