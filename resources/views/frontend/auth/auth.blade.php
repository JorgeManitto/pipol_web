<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}
    <title>Pipol - Ingreso</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
            
            html {
            scroll-behavior: smooth;
            }
            
            /* .hero-gradient {
            background: linear-gradient(135deg, #2D5F5D 0%, #1A4644 100%);
            } */
            
            .text-balance {
            text-wrap: balance;
            }
        </style>
    @livewireStyles
</head>
<body style="background: #0F071A;">
    <livewire:auth-tabs class="mt-8" />
</body>
</html>