<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
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
    <main class="md:ml-64 p-2 md:p-8">
        
        @include('backend.components.breadcrumb')
        @yield('main_content')
    </main>
    @livewireScripts
</body>
</html>