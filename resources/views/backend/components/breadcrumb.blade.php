<!-- Breadcrumb -->
@php
    $routeName = request()->route()->getName();
    $routeLabels = [

    ]
@endphp
<nav class="text-sm text-gray-600 mb-6">
    <a href="#" class="hover:text-[#2d5a4a]">Dashboard</a>
    <span class="mx-2">></span>
    <span class="text-[#2d5a4a] font-medium">{{  $routeName }}</span>
</nav>