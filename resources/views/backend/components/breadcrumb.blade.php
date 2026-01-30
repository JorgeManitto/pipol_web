
<!-- Breadcrumb -->
@php
    $routeName = request()->route()->getName();
    $routeLabels = [
        'home' => 'Inicio',
        'dashboard' => 'Tablero',
        'login' => 'Iniciar sesión',
        'logout' => 'Cerrar sesión',
        'mentors.index' => 'Buscar mentores',
        'sessions.index' => 'Mis sesiones',
        'sessions.show' => 'Detalle de sesión',
        'sessions.confirm' => 'Confirmar sesión',
        'sessions.complete' => 'Completar sesión',
        'sessions.cancel' => 'Cancelar sesión',
        'sessions.review' => 'Reseña de sesión',
        'profile.edit' => 'Editar perfil',
        'profile.update' => 'Actualizar perfil',
        'profile.avatar.delete' => 'Eliminar avatar',
        'profile.show' => 'Perfil',
        'api.set-appointment' => 'Reservar cita',
        'admin.chat.index' => 'Mensajes',
    ];
@endphp
{{-- <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
    <p>
        <span class="font-bold">Tablero de Trabajo: </span>
        <a href="https://trello.com/invite/b/690126406413b1a7d3443202/ATTIa888944a607f8132bfef4a7529948afc25967C07/pipol" 
           class="underline hover:text-blue-800"
           target="_blank"
           rel="noopener noreferrer">
            Ingresa al tablero de Trello
        </a>
    </p>
</div> --}}
<nav class="text-sm text-white mb-6 flex justify-between w-full items-center">
    <div class="hidden md:block">
        <a href="#" class="hover:text-[#1a0a3e]">Dashboard</a>
        <span class="mx-2">></span>
        <span class="text-white font-medium">{{ $routeLabels[$routeName] ?? $routeName }}</span>
    </div>
    <div class="hidden md:block">
        <a href="{{ route('mentors.index') }}" class="btn-primary text-white px-4 py-2 rounded-xl text-md font-semibold inline-flex items-center justify-center gap-2 w-full sm:w-auto">Ir a mentores</a>
    </div>
    
    <div class="flex gap-4 items-center justify-end w-full md:w-auto">
        <div class="relative">
            <!-- Botón de notificaciones -->
            <button id="notifBtn" class="relative flex items-center gap-2 bg-white border rounded-full px-4 py-2 shadow-sm hover:bg-gray-100">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="text-sm font-medium text-gray-700">Notificaciones</span>
                <span id="notifCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1.5">1</span>
            </button>
    
            <!-- Dropdown de notificaciones -->
            <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 z-50">
                <div class="p-3 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700">Notificaciones</h3>
                    <button id="clearNotifs" class="text-xs text-blue-500 hover:underline">Marcar todas como leídas</button>
                </div>
                <div id="notifList" class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                    <!-- Notificaciones se agregan aquí dinámicamente -->
                </div>
            </div>
                
    
        </div>
        <div class="hidden md:flex items-center cursor-pointer w-full gap-2" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" style="padding: 0.2em 0.5em;background: #261848;border-radius: 23px;">
            <img src="{{ auth()->user()->avatar ? asset('storage/avatars/'.auth()->user()->avatar) : asset('images/default-avatar.png') }}" alt="Emí" class="w-10 h-10 rounded-full border-2 border-purple-500 object-cover">
            <span class="text-white font-medium"> {{ auth()->user()->name }}</span>
        </div>
    </div>
</nav>
<script>

    // Notificaciones que vienen desde Laravel (array de strings JSON)
    const backendNotifications = @json($notificaciones ?? []);

    // Parsear cada elemento (porque vienen como strings JSON)
    const parsedBackend = backendNotifications.map(item => JSON.parse(item));

    // Agregar un ID único y fecha si querés (para igualar estructura)
    parsedBackend.forEach((n, index) => {
        n.id = crypto.randomUUID(); // genera un id aleatorio
        n.created_at = new Date().toISOString(); // fecha actual
    });

    // Combinar ambos arrays
    const notifications = [ ...parsedBackend];
    

    // Referencias
    const notifBtn = document.getElementById("notifBtn");
    const notifDropdown = document.getElementById("notifDropdown");
    const notifList = document.getElementById("notifList");
    const notifCount = document.getElementById("notifCount");

    // Mostrar/Ocultar dropdown
    notifBtn.addEventListener("click", () => {
        notifDropdown.classList.toggle("hidden");
    });

    

    // Renderizar notificaciones
    function renderNotifications(data) {
        notifList.innerHTML = "";

        if (data.length === 0) {
            notifList.innerHTML = `<div class="p-4 text-sm text-gray-500 text-center">No tienes notificaciones</div>`;
            notifCount.classList.add("hidden");
            return;
        }

        notifCount.textContent = data.length;
        notifCount.classList.remove("hidden");

        data.forEach((n) => {
            const item = document.createElement("a");
            item.href = n.url;
            item.className =
                "block p-3 hover:bg-gray-50 transition rounded-lg";
            item.innerHTML = `
                <p class="text-sm text-gray-800">${n.mensaje}</p>
                <p class="text-xs text-gray-500 mt-1">${new Date(n.created_at).toLocaleString()}</p>
            `;
            notifList.appendChild(item);
        });
    }

    // Inicial
    renderNotifications(notifications);

    // Limpiar notificaciones
    document.getElementById("clearNotifs").addEventListener("click", () => {
        fetch("{{ route('notifications.markAsRead') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            }
        });
        notifications.length = 0;
        renderNotifications(notifications);
    });
</script>

    </div>
</nav>
