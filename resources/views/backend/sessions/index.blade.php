@extends('backend.layout.app')
@section('page_title', 'Mis Sesiones')
 
@section('main_content')
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .sidebar-link {
            transition: all 0.3s ease;
        }
        
        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #d4af6a;
        }
        
        .session-card {
            transition: all 0.3s ease;
        }
        
        .session-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        
        .tab-button {
            transition: all 0.3s ease;
        }
        
        .tab-button.active {
            background-color: #1a0a3e;
            color: white;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-confirmed {
            background-color: #1a0a3ee8;
            color: #fff;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-completed {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .calendar-mini {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.25rem;
        }
        
        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .calendar-day:hover {
            background-color: #f5f0e8;
        }
        
        .calendar-day.has-session {
            background-color: #1a0a3e;
            color: white;
            font-weight: 600;
        }
        
        .calendar-day.today {
            border: 2px solid #d4af6a;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }
        
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: white;
            border-radius: 1rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
{{-- <div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Mis Sesiones</h1>

    @if ($sessions->count())
        <table class="min-w-full bg-white shadow-sm rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Fecha</th>
                    <th class="p-3">Con</th>
                    <th class="p-3">Estado</th>
                    <th class="p-3">Precio</th>
                    <th class="p-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sessions as $session)
                    <tr class="border-t">
                        <td class="p-3">{{ optional($session->scheduled_at)->format('d/m/Y H:i') ?? 'Sin definir' }}</td>
                        <td class="p-3">
                            @if ($user->is_mentor)
                                {{ $session->mentee->name ?? '-' }}
                            @else
                                {{ $session->mentor->name ?? '-' }}
                            @endif
                        </td>
                        <td class="p-3 capitalize">
                            <span class="text-sm {{ $session->status === 'completed' ? 'text-green-600' : ($session->status === 'cancelled' ? 'text-red-600' : 'text-blue-600') }}">
                                {{ $session->status }}
                            </span>
                        </td>
                        <td class="p-3">{{ $session->currency }} {{ number_format($session->price, 2) }}</td>
                        <td class="p-3 text-right">
                            <a href="{{ route('sessions.show', $session->id) }}" class="text-blue-600 hover:underline text-sm">Ver detalle</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">{{ $sessions->links() }}</div>
    @else
        <p class="text-gray-500">No tenés sesiones registradas todavía.</p>
    @endif
</div> --}}

<!-- Header -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Mis Sesiones</h1>
            <p class="text-white">Gestiona tus sesiones programadas con mentores</p>
        </div>
        {{-- <button class="bg-[#1a0a3e] text-white px-6 py-3 rounded-lg hover:bg-[#1a0a3ee8] transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Agendar Nueva Sesión
        </button> --}}
    </div>
</div>
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm animate-fade-in">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if (request()->status)
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm animate-fade-in">
            <p class="font-medium">{{ request()->status }}</p>
        </div>
    @endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Sessions List -->
    <div class="lg:col-span-2">
        <!-- Tabs -->
        <div class="flex gap-2 mb-6 bg-white p-2 rounded-lg shadow-sm">
            <button class="tab-button active flex-1 py-2 px-4 rounded-lg font-medium" data-tab="proximas">
                Próximas ({{ $proximas_sesiones->count() }})
            </button>
            <button class="tab-button flex-1 py-2 px-4 rounded-lg font-medium text-gray-600" data-tab="pasadas">
                Pasadas ({{ $pasadas_sesiones->count() }})
            </button>
            <button class="tab-button flex-1 py-2 px-4 rounded-lg font-medium text-gray-600" data-tab="canceladas">
                Canceladas ({{ $canceladas_sesiones->count() }})
            </button>
        </div>

        <!-- Sessions Container -->
        <div id="sessions-container">
            <!-- Próximas Sessions -->
            <div class="tab-content active" data-content="proximas">
                @foreach ($proximas_sesiones as $session)
                    <!-- Session Card -->
                    <div class="session-card bg-white rounded-xl shadow-sm p-6 mb-4 border-l-4 border-blue-500">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-start gap-4">
                                @php
                                    if($user->is_mentor){
                                        $name = $session->mentee->name;
                                        $image = $session->mentee->avatar;
                                        $profession = $session->mentee->profession;
                                    }else{
                                        $name = $session->mentor->name;
                                        $image = $session->mentor->avatar;
                                        $profession = $session->mentor->profession;
                                    }
                                @endphp
                                <img src="{{ $image ? asset('storage/avatars/'.$image) : asset('images/default-avatar.png') }}" alt="{{ $name }}" class="w-16 h-16 rounded-full object-cover">
                                <div>
                                    <h3 class="font-semibold text-lg text-[#1a0a3e] mb-1">{{ $name }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ $profession }}</p>
                                    {{-- <span class="status-badge status-{{ $session->status }}">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $session->status }}
                                    </span> --}}
                                    <span class="status-badge status-{{ $session->transaction ? 'confirmed' : 'pending' }}">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        @if ($session->transaction)
                                            {{$session->transaction->status == 'paid' ? 'Pago Confirmado' : 'Pendiente de Pago'}}
                                        @else
                                            Pendiente de Pago
                                        @endif
                                    </span>

                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4 p-4 bg-[#f5f0e8] rounded-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-600">Fecha</p>
                                    <p class="font-semibold text-sm">
                                        {{ \Carbon\Carbon::parse($session->scheduled_at)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-600">Hora</p>
                                    <p class="font-semibold text-sm">
                                        {{ \Carbon\Carbon::parse($session->scheduled_at)->format('H:i') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-600">Modalidad</p>
                                    <p class="font-semibold text-sm">Online</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-600">Precio</p>
                                    <p class="font-semibold text-sm">{{ $session->mentor->currency}} {{ number_format($session->mentor->hourly_rate, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($session->status === 'pending' && auth()->user()->role == 'mentee')
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-3">
                                <p class="text-sm text-yellow-800">
                                    <strong>Esperando confirmación del mentor.</strong> Te notificaremos cuando la sesión sea confirmada.
                                </p>
                            </div>
                        @endif
                        @if ($session->status === 'confirmed')
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                                <p class="text-sm text-green-800">
                                    <strong>Sesión confirmada.</strong> ¡Prepárate para tu sesión con {{ $name }}!
                                </p>
                            </div>

                            <div class="p-3 mb-3">
                                <p class="text-sm text-blue-500">Url de la reunión: No disponible.</p>
                            </div>

                        @endif

                        <div class="flex flex-col lg:flex-row gap-3">
                            @if($session->status === 'pending' && $session->mentee->id === auth()->id())
                                <button class="flex-1 bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed" disabled>
                                    Esperando Confirmación
                                </button>
                            
                            @endif                
                            @if ($session->status === 'pending' && $session->mentor->id === auth()->id())
                                <button onclick="openConfirmModal({{ $session->id}} )" class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors">
                                    Confirmar Sesión
                                </button>
                            @endif

                            @if ($session->status === 'confirmed')
                                <button class="flex-1 bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed" disabled>
                                    Sesión Confirmada
                                </button>
                                @if ($session->mentor->id === auth()->id())
                                    
                                    <button class="flex-1 bg-[#1e40af] text-white py-2 px-4 rounded-lg cursor-pointer" onclick="generarUrlMeet()">
                                        Generar Link de Reunión
                                    </button>
                                @endif
                            @endif
                            
                            <button class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Unirse a la Sesión
                            </button>
                            @if ($session->status != 'confirmed')
                                @if ($session->mentor->id == auth()->id())
                                    <button class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors" onclick="openCancelModal('{{ $session->id }}','{{ $session->mentee->name }}', '{{ \Carbon\Carbon::parse($session->scheduled_at)->format('D, d M Y') }}', '{{ \Carbon\Carbon::parse($session->scheduled_at)->format('H:i') }} - {{ \Carbon\Carbon::parse($session->scheduled_at)->addHour()->format('H:i') }}')">
                                        Cancelar
                                    </button>
                                @else
                                    <button class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors" onclick="openCancelModal('{{ $session->id }}','{{ $session->mentor->name }}', '{{ \Carbon\Carbon::parse($session->scheduled_at)->format('D, d M Y') }}', '{{ \Carbon\Carbon::parse($session->scheduled_at)->format('H:i') }} - {{ \Carbon\Carbon::parse($session->scheduled_at)->addHour()->format('H:i') }}')">
                                        Cancelar
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach                
            </div>

            <!-- Pasadas Sessions -->
            <div class="tab-content hidden" data-content="pasadas">  
                @foreach ($pasadas_sesiones as $session)
                    <div class="session-card bg-white rounded-xl shadow-sm p-6 mb-4 border-l-4 border-yellow-500">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-start gap-4">
                                @php
                                    if($user->is_mentor){
                                        $name = $session->mentee->name;
                                        $image = $session->mentee->avatar;
                                        $profession = $session->mentee->profession;
                                    }else{
                                        $name = $session->mentor->name;
                                        $image = $session->mentor->avatar;
                                        $profession = $session->mentor->profession;
                                    }
                                @endphp
                                <img src="{{ $image ? asset('storage/avatars/'.$image) : asset('images/default-avatar.png') }}" alt="{{ $name }}" class="w-16 h-16 rounded-full object-cover">
                                <div>
                                    <h3 class="font-semibold text-lg text-[#1a0a3e] mb-1">{{ $name }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ $profession }}</p>
                                    
                                    <span class="status-badge status-{{ $session->transaction ? 'confirmed' : 'pending' }}">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        @if ($session->transaction)
                                            {{$session->transaction->status == 'paid' ? 'Pago Confirmado' : 'Pendiente de Pago'}}
                                        @else
                                            Pendiente de Pago
                                        @endif
                                    </span>

                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4 p-4 bg-[#f5f0e8] rounded-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-600">Fecha</p>
                                    <p class="font-semibold text-sm">
                                        {{ \Carbon\Carbon::parse($session->scheduled_at)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-600">Hora</p>
                                    <p class="font-semibold text-sm">
                                        {{ \Carbon\Carbon::parse($session->scheduled_at)->format('H:i') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-600">Modalidad</p>
                                    <p class="font-semibold text-sm">Online</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-600">Precio</p>
                                    <p class="font-semibold text-sm">{{ $session->mentor->currency}} {{ number_format($session->mentor->hourly_rate, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col lg:flex-row gap-3">
                            @if (!$session->review)
                            <button onclick="openReviewModal('{{ $session->id }}', '{{ $image ? asset('storage/avatars/'.$image) : asset('images/default-avatar.png') }}', '{{ $name }}')" class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors">
                                Dejar Reseña
                            </button>
                            @endif
                            <button class="px-4 py-2 border border-[#1a0a3e] text-[#1a0a3e] rounded-lg hover:bg-[#f5f0e8] transition-colors">
                                Tuve un problema con la sesión
                            </button>
                        </div>
                    </div>
                @endforeach     
            </div>

            <!-- Canceladas Sessions -->
            <div class="tab-content hidden" data-content="canceladas">
                {{-- <div class="session-card bg-white rounded-xl shadow-sm p-6 mb-4 border-l-4 border-red-500">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-start gap-4">
                            <img src="/placeholder.svg?height=60&width=60" alt="Mentor" class="w-16 h-16 rounded-full object-cover">
                            <div>
                                <h3 class="font-semibold text-lg text-[#1a0a3e] mb-1">Angeles Cascales</h3>
                                <p class="text-sm text-gray-600 mb-2">Cognitivo Conductual</p>
                                <span class="status-badge status-cancelled">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Cancelada
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4 p-4 bg-[#f5f0e8] rounded-lg">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-600">Fecha</p>
                                <p class="font-semibold text-sm">Jue, 17 Oct 2025</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-600">Hora</p>
                                <p class="font-semibold text-sm">16:00 - 17:00</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-3">
                        <p class="text-sm text-red-800">
                            <strong>Cancelada por el usuario</strong> el 15 Oct 2025. Reembolso procesado.
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors">
                            Agendar Nuevamente
                        </button>
                    </div>
                </div> --}}
                @foreach ($canceladas_sesiones as $session)
                    <div class="session-card bg-white rounded-xl shadow-sm p-6 mb-4 border-l-4 border-red-500">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-start gap-4">
                                @php
                                    if($user->is_mentor){
                                        $name = $session->mentee->name;
                                        $image = $session->mentee->avatar;
                                        $profession = $session->mentee->profession;
                                    }else{
                                        $name = $session->mentor->name;
                                        $image = $session->mentor->avatar;
                                        $profession = $session->mentor->profession;
                                    }
                                @endphp
                                <img src="{{ $image ? asset('storage/avatars/'.$image) : asset('images/default-avatar.png') }}" alt="{{ $name }}" class="w-16 h-16 rounded-full object-cover">
                                <div>
                                    <h3 class="font-semibold text-lg text-[#1a0a3e] mb-1">{{ $name }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ $profession }}</p>
                                    
                                    <span class="status-badge status-{{ $session->transaction ? 'confirmed' : 'pending' }}">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        @if ($session->transaction)
                                            {{$session->transaction->status == 'paid' ? 'Pago Confirmado' : 'Pendiente de Pago'}}
                                        @else
                                            Pendiente de Pago
                                        @endif
                                    </span>

                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4 p-4 bg-[#f5f0e8] rounded-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-600">Fecha</p>
                                    <p class="font-semibold text-sm">
                                        {{ \Carbon\Carbon::parse($session->scheduled_at)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-600">Hora</p>
                                    <p class="font-semibold text-sm">
                                        {{ \Carbon\Carbon::parse($session->scheduled_at)->format('H:i') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-600">Modalidad</p>
                                    <p class="font-semibold text-sm">Online</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-600">Precio</p>
                                    <p class="font-semibold text-sm">{{ $session->mentor->currency}} {{ number_format($session->mentor->hourly_rate, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col lg:flex-row gap-3">
                            <button class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors">
                                Dejar Reseña
                            </button>
                            <button class="px-4 py-2 border border-[#1a0a3e] text-[#1a0a3e] rounded-lg hover:bg-[#f5f0e8] transition-colors">
                                Tuve un problema con la sesión
                            </button>
                        </div>
                    </div>
                @endforeach    
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- Calendar Widget -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-lg text-[#1a0a3e]">Octubre 2025</h3>
                <div class="flex gap-2">
                    <button class="p-1 hover:bg-gray-100 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button class="p-1 hover:bg-gray-100 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="calendar-mini mb-2">
                <div class="text-center text-xs font-medium text-gray-500 py-2">D</div>
                <div class="text-center text-xs font-medium text-gray-500 py-2">L</div>
                <div class="text-center text-xs font-medium text-gray-500 py-2">M</div>
                <div class="text-center text-xs font-medium text-gray-500 py-2">M</div>
                <div class="text-center text-xs font-medium text-gray-500 py-2">J</div>
                <div class="text-center text-xs font-medium text-gray-500 py-2">V</div>
                <div class="text-center text-xs font-medium text-gray-500 py-2">S</div>
            </div>
            
            <div class="calendar-mini" id="calendar-grid">
                <!-- Calendar days will be generated by JavaScript -->
            </div>
            
            <div class="mt-4 pt-4 border-t">
                <div class="flex items-center gap-2 text-sm mb-2">
                    <div class="w-3 h-3 rounded-full bg-[#1a0a3e]"></div>
                    <span class="text-gray-600">Sesiones programadas</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <div class="w-3 h-3 rounded-full border-2 border-[#d4af6a]"></div>
                    <span class="text-gray-600">Hoy</span>
                </div>
            </div>
        </div>

        @if (auth()->user()->is_mentor)
            @include('backend.sessions.components.estadisticas')
        @endif

        <!-- Quick Actions -->
        <div class="bg-gradient-to-br from-[#1a0a3e] to-[#1a0a3ee8] rounded-xl shadow-sm p-6 text-white">
            <h3 class="font-semibold text-lg mb-2">¿Necesitas ayuda?</h3>
            <p class="text-sm text-white/80 mb-4">Nuestro equipo está disponible para asistirte con cualquier consulta.</p>
            <button class="w-full bg-white text-[#1a0a3e] py-2 px-4 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                Contactar Soporte
            </button>
        </div>
    </div>
</div>
 <!-- Reschedule Modal -->
    <div id="rescheduleModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-[#1a0a3e]">Reprogramar Sesión</h3>
                    <button onclick="closeRescheduleModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="mb-4 p-4 bg-[#f5f0e8] rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Sesión actual con</p>
                    <p class="font-semibold text-[#1a0a3e]" id="reschedule-mentor-name"></p>
                    <p class="text-sm text-gray-600 mt-2" id="reschedule-current-time"></p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nueva fecha</label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a0a3e] focus:border-transparent">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nuevo horario</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a0a3e] focus:border-transparent">
                        <option>09:00 - 10:00</option>
                        <option>10:00 - 11:00</option>
                        <option>11:00 - 12:00</option>
                        <option>14:00 - 15:00</option>
                        <option>15:00 - 16:00</option>
                        <option>16:00 - 17:00</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button onclick="closeRescheduleModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button onclick="confirmReschedule()" class="flex-1 bg-[#1a0a3e] text-white px-4 py-2 rounded-lg hover:bg-[#1a0a3ee8] transition-colors">
                        Confirmar Cambio
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Confirm Modal --}}

    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-[#1a0a3e]">Confirmar Sesión</h3>
                    <button onclick="closeConfirmModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <input type="hidden" name="session_id" id="confirm-session-id" value="">
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-800">
                        <strong>¿Estás seguro que deseas confirmar esta sesión?</strong> Una vez confirmada, no podrás reprogramarla ni cancelarla .
                    </p>
                </div>
                <div class="flex gap-3">
                    <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Volver
                    </button>
                    
                    <button type="submit" onclick="confirmSession()" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        Confirmar Sesión
                    </button>
                    
                </div>

            </div>
        </div>
    </div>
    {{-- generateMeetForm Modal --}}

    @include('backend.sessions.components.review-modal')

    <div id="generateMeetForm" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-[#1a0a3e]">Generar Link de Reunión</h3>
                    <button onclick="closeGenerateMeetForm()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <strong>Genera un link de reunión para tu sesión programada.</strong> Este link será compartido con el mentee para que pueda unirse a la sesión.
                    </p>   
                    <p class="text-sm text-red-500">
                        Se necesita haber vinculado la sesión con Google para generar el link.    
                    </p> 
                </div>
                <div class="flex gap-3">
                    <button onclick="closeGenerateMeetForm()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    
                    <button type="submit" disabled class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Generar Link
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-[#1a0a3e]">Cancelar Sesión</h3>
                    <button onclick="closeCancelModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm text-red-800 mb-1">¿Estás seguro que deseas cancelar esta sesión?</p>
                    <p class="font-semibold text-[#1a0a3e] mt-2" id="cancel-mentor-name"></p>
                    <p class="text-sm text-gray-600" id="cancel-session-time"></p>
                    <input type="hidden" name="session_id" id="cancel-session-id" value="">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo de cancelación (opcional)</label>
                    <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a0a3e] focus:border-transparent" rows="3" placeholder="Cuéntanos por qué cancelas esta sesión..."></textarea>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                    <p class="text-sm text-yellow-800">
                        <strong>Política de cancelación:</strong> Puedes cancelar hasta 24 horas antes sin cargo. Cancelaciones tardías pueden no ser reembolsables.
                    </p>
                </div>

                <div class="flex gap-3">
                    <button onclick="closeCancelModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Volver
                    </button>
                    <button onclick="confirmCancel()" class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                        Confirmar Cancelación
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabName = button.dataset.tab;
                
                // Remove active class from all buttons and contents
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.add('hidden'));
                
                // Add active class to clicked button and corresponding content
                button.classList.add('active');
                document.querySelector(`[data-content="${tabName}"]`).classList.remove('hidden');
            });
        });

        // Generate calendar
        function generateCalendar() {
            const calendarGrid = document.getElementById('calendar-grid');
            const today = 24; // October 24, 2025
            const daysInMonth = 31;
            const firstDayOfMonth = 3; // Wednesday (0 = Sunday)
            const sessionsOnDays = [21, 28, 30]; // Days with sessions (Oct 21, 28, 30)
            const upcomingSessions = [28, 30]; // Upcoming sessions (Oct 28, 30)
            
            // Add empty cells for days before the 1st
            for (let i = 0; i < firstDayOfMonth; i++) {
                const emptyDay = document.createElement('div');
                calendarGrid.appendChild(emptyDay);
            }
            
            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                dayElement.textContent = day;
                
                if (day === today) {
                    dayElement.classList.add('today');
                }
                
                if (upcomingSessions.includes(day)) {
                    dayElement.classList.add('has-session');
                }
                
                calendarGrid.appendChild(dayElement);
            }
        }

        // Modal functions
        function openRescheduleModal(mentorName, date, time) {
            document.getElementById('reschedule-mentor-name').textContent = mentorName;
            document.getElementById('reschedule-current-time').textContent = `${date} • ${time}`;
            document.getElementById('rescheduleModal').classList.add('active');
        }

        function closeRescheduleModal() {
            document.getElementById('rescheduleModal').classList.remove('active');
        }

        function confirmReschedule() {
            alert('Sesión reprogramada exitosamente');
            closeRescheduleModal();
        }

        function openCancelModal(id,mentorName, date, time) {
            document.getElementById('cancel-session-id').value = id;
            document.getElementById('cancel-mentor-name').textContent = mentorName;
            document.getElementById('cancel-session-time').textContent = `${date} • ${time}`;
            document.getElementById('cancelModal').classList.add('active');
        }

        function openConfirmModal(id) {
            document.getElementById('confirmModal').classList.add('active');
            document.getElementById('confirm-session-id').value = id;
        }

        function closeConfirmModal(){
            document.getElementById('confirmModal').classList.remove('active');

        }
        function confirmSession() {
            // alert('Sesión confirmada exitosamente.');
            fetch('{{route("sessions.confirmjson")}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: document.getElementById('confirm-session-id').value }) // Replace with actual session ID
            })
            .then(response => response.json())
            .then(data => {
                window.location.href = window.location.pathname + '?status='+ data.status;
            });

            closeConfirmModal();
        }

        function generarUrlMeet(){
            document.getElementById('generateMeetForm').classList.add('active');
        }
        function closeGenerateMeetForm(){
            document.getElementById('generateMeetForm').classList.remove('active');
        }
        function closeCancelModal() {
            document.getElementById('cancelModal').classList.remove('active');
        }

        function confirmCancel() {
            // window.location.href = '{{route("sessions.cancel")}}' + '?id=' + document.getElementById('cancel-session-id').value;
            fetch('{{route("sessions.cancel")}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: document.getElementById('cancel-session-id').value }) // Replace with actual session ID
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                window.location.reload();
            });
            // alert('Sesión cancelada. Se procesará el reembolso según nuestra política.');
            closeCancelModal();
        }

        // Close modals when clicking outside
        document.getElementById('rescheduleModal').addEventListener('click', (e) => {
            if (e.target.id === 'rescheduleModal') {
                closeRescheduleModal();
            }
        });

        document.getElementById('cancelModal').addEventListener('click', (e) => {
            if (e.target.id === 'cancelModal') {
                closeCancelModal();
            }
        });

        // Initialize calendar on page load
        generateCalendar();
    </script>
@endsection
