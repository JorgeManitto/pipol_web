<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            color: white;
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
            color: white;
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
        </style>
        @livewireStyles
</head>
<body class="bg-gray-50">

    @include('backend.components.sidebar')
    <!-- Main Content -->
    <main class="md:ml-64 p-2 md:p-8 hero-section h-min-screen min-h-screen">
        
        @include('backend.components.breadcrumb')
        @yield('main_content')
    </main>
    @livewireScripts
</body>
</html>