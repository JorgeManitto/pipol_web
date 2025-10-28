
<!-- Breadcrumb -->
@php
    $routeName = request()->route()->getName();
    $routeLabels = [

    ]
@endphp
<div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
    <p>
        <span class="font-bold">Tablero de Trabajo: </span>
        <a href="https://trello.com/invite/b/690126406413b1a7d3443202/ATTIa888944a607f8132bfef4a7529948afc25967C07/pipol" 
           class="underline hover:text-blue-800"
           target="_blank"
           rel="noopener noreferrer">
            Ingresa al tablero de Trello
        </a>
    </p>
</div>
<nav class="text-sm text-gray-600 mb-6">
    <a href="#" class="hover:text-[#2d5a4a]">Dashboard</a>
    <span class="mx-2">></span>
    <span class="text-[#2d5a4a] font-medium">{{  $routeName }}</span>
</nav>
