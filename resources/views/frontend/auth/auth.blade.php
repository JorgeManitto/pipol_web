<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}
    <title>@yield('page_title') </title>
     {{-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            
        @endif --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
            theme: {
                extend: {
                colors: {
                    primary: '#2D5F5D',
                    secondary: '#E8D5C4',
                    accent: '#D4A574',
                    dark: '#1A1A1A',
                    light: '#F5F5F0',
                },
                fontFamily: {
                    sans: ['Inter', 'system-ui', 'sans-serif'],
                    display: ['Georgia', 'serif'],
                }
                }
            }
            }
        </script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
            
            html {
            scroll-behavior: smooth;
            }
            
            .hero-gradient {
            background: linear-gradient(135deg, #2D5F5D 0%, #1A4644 100%);
            }
            
            .text-balance {
            text-wrap: balance;
            }
        </style>
    @livewireStyles
</head>
<body>
    <livewire:auth-tabs class="mt-8" />
</body>
</html>