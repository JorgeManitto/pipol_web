@extends('backend.layout.app')
@section('page_title', 'Profesionales - Pipol')
@section('main_content')
{{-- <div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Bienvenido al Panel de Profesionales</h2>
    <p class="text-gray-700">Desde aquí puedes gestionar tus sesiones, ver tus favoritos y actualizar tu perfil.</p>
</div> --}}
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div class="bg-white rounded-2xl shadow-sm p-8 mb-8">
          <div class="flex items-center gap-3 mb-4">
              <h1 class="text-3xl font-bold text-[#2d5a4a]">Pipol</h1>
              <svg class="w-6 h-6 text-[#d4af6a]" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
          </div>
          <p class="text-gray-600 mb-6">Bienvenido al Panel de Profesionales</p>
      
          
          <p class="text-xs text-gray-500 mt-3">Desde aquí puedes gestionar tus sesiones, ver tus favoritos y actualizar tu perfil.</p>
      </div>
  </div>
@endsection