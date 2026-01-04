<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title')</title>
    @vite(['resources/css/app.css'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>
<body class="bg-gray-50">
    <main class="flex items-center hero-section" style="height: 100vh;">
        <div class="container mx-auto px-4 py-8">
            <div class="mb-8 text-center">
                <a href="{{ route('dashboard') }}" class="mb-8 pb-6">
                    <img src="{{ asset('/images/logo-clea-recorte.png') }}" alt="logo" style=" object-fit: contain;height: 120px;margin: 0 auto;" />
                </a>
                {{-- <h1 class="text-3xl font-bold text-white">Bienvenido A Pipol</h1> --}}
                <p class="text-white mt-8">Seleccione una opción para continuar.</p>
            </div>
            <div class="space-x-4 text-center flex flex-col items-center justify-center">
                <a href="{{ route('linkedin.set.as.mentor') }}" class="block flex-1 text-center mx-auto py-3 px-6 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors font-medium mb-6">Convertirse en Mentor</a>
                <a href="{{ route('dashboard') }}" class="block flex-1 text-center mx-auto py-3 px-6 bg-[#c2c2c2] text-black rounded-lg hover:bg-[#3d6a5a] transition-colors font-medium">Seguir como usuario</a>
            </div>
        </div>
 </main>
</body>
</html>
