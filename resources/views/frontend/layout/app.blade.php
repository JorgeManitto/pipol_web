<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}
    <title>@yield('page_title') </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
     @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @else
            
        @endif
        
        {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
        <script src="https://unpkg.com/flowbite@2.5.1/dist/flowbite.min.js"></script> 
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
        <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        :root {
            --color-primary: #9315ff;
            --color-secondary: #4b61fd;
            --color-accent: #00efcf;
            --color-dark: #0a0a1f;
            --color-dark-secondary: #1a1a3e;
            --color-pink: #ff006b;
        }

        body {
            background-color: var(--color-dark);
            color: #ffffff;
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 50%, var(--color-accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-text-hero {
            background: linear-gradient(90deg, #ff006b 0%, var(--color-primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-bg {
            background: #211832;
        }

        .gradient-bg-pink {
            background: linear-gradient(90deg, #ff006b 0%, var(--color-primary) 100%);
        }

        .gradient-border {
            position: relative;
            background: var(--color-dark-secondary);
            border: 2px solid transparent;
            background-clip: padding-box;
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary), var(--color-accent));
            border-radius: inherit;
            z-index: -1;
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

        .card {
            background: var(--color-dark-secondary);
            border: 1px solid rgba(147, 21, 255, 0.2);
            transition: all 0.3s ease;
        }

        .card:hover {
            border-color: var(--color-primary);
            box-shadow: 0 8px 30px rgba(147, 21, 255, 0.3);
            transform: translateY(-5px);
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-accent));
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .hero-section {
            background: linear-gradient(180deg, #1a0a3e 0%, var(--color-dark) 100%);
            position: relative;
        }

        .network-dots {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            opacity: 0.3;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .network-dots {
                width: 100%;
                opacity: 0.2;
            }
        }
    </style>
    @livewireStyles
</head>
<body>
    @include('frontend.components.header')
    @yield('main_content')
    @include('frontend.components.footer')
    @livewireScripts
</body>
</html>