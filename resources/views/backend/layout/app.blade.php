<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title')</title>
    @vite(['resources/css/app.css'])

    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #9315ff;
            --color-secondary: #4b61fd;
            --color-accent: #00efcf;
            --color-dark: #0a0a1f;
            --color-dark-secondary: #1a1a3e;
            --color-pink: #ff006b;
        }
        .hero-section {
            background: linear-gradient(180deg, #1a0a3e 0%, var(--color-dark) 100%);
        }
        .gradient-text-hero {
            background: linear-gradient(90deg, #ff006b 0%, var(--color-primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-primary {
            background: linear-gradient(90deg, #ff006b 0%, var(--color-primary) 100%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(255, 0, 107, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(255, 0, 107, 0.5);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            /* color: white; */
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .sidebar-icon {
            transition: all 0.3s ease;
        }
        
        .sidebar-icon:hover {
            transform: translateX(4px);
        }
        
        .filter-checkbox:checked + label {
            background-color: #2d5a4a;
            /* color: white; */
        }
        
        .professional-card {
            transition: all 0.3s ease;
        }
        
        .professional-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        
        .tag {
            transition: all 0.2s ease;
        }
        
        .tag:hover {
            transform: scale(1.05);
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
        /* Estilos para el calendario de sesiones */
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
            font-size: 0.875rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            position: relative;
        }

        .calendar-day:hover {
            background-color: #f3f4f6;
        }

        .calendar-day.today {
            border: 2px solid #d4af6a;
            font-weight: 600;
            color: #d4af6a;
        }

        .calendar-day.has-session {
            background-color: #1a0a3e;
            color: white;
            font-weight: 600;
        }

        .calendar-day.has-session:hover {
            background-color: #2a1a4e;
            transform: scale(1.05);
        }

        .calendar-day.has-session.today {
            background-color: #d4af6a;
            color: #1a0a3e;
            border: 2px solid #1a0a3e;
        }

        /* Estilos para tabs */
        .tab-button {
            transition: all 0.2s ease;
        }

        .tab-button.active {
            background-color: #1a0a3e;
            color: white;
        }

        /* Estilos para status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-confirmed {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Animaciones */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        /* Estilos para modales */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal.active {
            display: flex;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .calendar-day {
                font-size: 0.75rem;
            }
        }

        /* Tooltip para días con sesiones */
        .calendar-day[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #1f2937;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            white-space: nowrap;
            margin-bottom: 0.25rem;
            z-index: 10;
        }

        .calendar-day[title]:hover::before {
            content: '';
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 4px solid transparent;
            border-top-color: #1f2937;
            z-index: 10;
        }
        </style>
        @livewireStyles
         <script src="https://unpkg.com/flowbite@2.5.1/dist/flowbite.min.js"></script> 
</head>
<body class="bg-gray-50">

    @if (!request()->routeIs('mentors.index'))
        @include('backend.components.sidebar')
    @else
        @include('backend.components.nav-bar-mobile')
    @endif
    <!-- Main Content -->
    <main class="{{ !request()->routeIs('mentors.index') ? 'md:ml-64' : '' }} p-2 md:p-8 hero-section h-min-screen min-h-screen">
        @include('backend.components.breadcrumb')
        @yield('main_content')
    </main>
   
    @livewireScripts
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log(Echo);
            
            Echo.private('App.Models.User.' + {{ auth()->id() }})
                .notification((notification) => {
                    console.log('🔔', notification);
                    notifications.unshift(notification); // agrega al inicio
                    renderNotifications(notifications);
                 });
        });
    </script>
</body>
</html>