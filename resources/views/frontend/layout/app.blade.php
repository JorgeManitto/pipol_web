<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}
    <title>@yield('page_title') </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* @font-face {
            font-family: "TT Firs Neue";
            src: url("/tt_firs_neue/TT Firs Neue Trial Regular.ttf") format("truetype");
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: "TT Firs Neue";
            src: url("/tt_firs_neue/TT Firs Neue Trial Bold.ttf") format("truetype");
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: "TT Firs Neue";
            src: url("/tt-firs/TT Firs Neue Trial Italic.ttf") format("truetype");
            font-weight: 400;
            font-style: italic;
        } */
    </style>
    
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
<body style="position: relative;">
    
    @include('frontend.components.header')
    <div class="absolute top-0  -z-10  bg-[#000000] bg-[radial-gradient(#ffffff33_1px,#00091d_1px)] bg-[size:20px_20px]" style="height: 100%;width: 100%;display: none;" id="bg-1"></div>
    <div class="absolute inset-0 -z-10 w-full items-center px-5 py-24 [background:radial-gradient(125%_125%_at_50%_10%,#000_40%,#63e_100%)]" style="display: none;" id="bg-2"></div>
    <div class="absolute h-full -z-10 bottom-0 left-0 right-0 top-0 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:14px_24px] [mask-image:radial-gradient(ellipse_80%_90%_at_50%_0%,#000_70%,transparent_110%)]" style="" id="bg-3"></div>
    <div class="absolute inset-0  -z-10 h-full w-full bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:92px_92px]" style="display: none;" id="bg-4"></div>
    <div class="absolute top-0 h-full -z-10  bg-neutral-950 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(120,119,198,0.3),rgba(255,255,255,0))]" style="display: none;width: 100%;" id="bg-5"></div>
    @yield('main_content')
    @include('frontend.components.footer')
    @livewireScripts
    <script>
        const fondos = ["bg-1", "bg-2", "bg-3", "bg-4", "bg-5"];
        let index = 0;

        document.getElementById("toggle-bg").addEventListener("click", () => {
            // Ocultar todos
            fondos.forEach(id => {
                document.getElementById(id).style.display = "none";
            });

            // Mostrar el siguiente
            document.getElementById(fondos[index]).style.display = "block";

            // Avanzar al próximo
            index = (index + 1) % fondos.length;
        });
    </script>
</body>
</html>