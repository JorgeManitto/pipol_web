@extends('backend.layout.app')

@section('page_title', 'Mis Estadísticas')

@section('main_content')
<div class="container mx-auto px-4 py-8">
    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm animate-fade-in">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Tabla responsive -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
         <div class="flex-1 p-4 md:p-8 overflow-auto">
        <div class="bg-white rounded-2xl p-4 md:p-6 text-primary-dark">
          
          <!-- Table Header -->
          <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div>
              <h2 class="text-2xl font-bold mb-1">Historial de Transacciones</h2>
              <p class="text-gray-500 text-sm">Gestiona y revisa todas tus transacciones</p>
            </div>
            <div class="flex gap-2">
              {{-- <button class="px-4 py-2 bg-gray-100 text-primary-dark rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                Filtrar
              </button> --}}
              <button class="px-4 py-2 text-black rounded-lg bg-gray-100 hover:bg-accent-purple/90 transition text-sm font-medium cursor-pointer">
                Exportar
              </button>
            </div>
          </div>
          
          <!-- Table Wrapper for Responsive Scroll -->
          <div class="overflow-x-auto -mx-4 md:mx-0">
            <div class="inline-block min-w-full align-middle px-4 md:px-0">
              <table class="min-w-full">
                <thead>
                  <tr class="border-b-2 border-gray-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Sesión</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pagador</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Receptor</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gateway</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Monto</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  
                  <!-- Row 1 -->
                  @foreach ($statistics as $item)
                      
                  <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-4">
                      <span class="text-sm font-medium text-accent-purple"># {{ $item->gateway_transaction_id }}</span>
                    </td>
                    <td class="px-4 py-4">
                      <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-cyan-400 flex items-center justify-center text-white text-xs font-bold">
                          {{ substr($item->payer()->first()->name, 0, 2) }}
                        </div>
                        <span class="text-sm">{{ $item->payer()->first()->name }}</span>
                      </div>
                    </td>
                    <td class="px-4 py-4">
                      <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-accent-purple flex items-center justify-center text-white text-xs font-bold">
                          {{ substr($item->receiver()->first()->name, 0, 2) }}
                        </div>
                        <span class="text-sm">{{ $item->receiver()->first()->name }}</span>
                      </div>
                    </td>
                    <td class="px-4 py-4">
                      <span class="text-sm text-gray-600">{{ $item->gateway }}</span>
                    </td>
                    <td class="px-4 py-4">
                      <span class="text-sm font-semibold text-green-600">$ {{$item->amount}}</span>
                    </td>
                    <td class="px-4 py-4">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{$item->status }}
                      </span>
                    </td>
                    <td class="px-4 py-4">
                      <span class="text-sm text-gray-600">{{ $item->paid_at }}</span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          
          <div class="flex flex-col md:flex-row items-center justify-between mt-6 gap-4">
            <p class="text-sm text-gray-600">
                Mostrando {{ $statistics->firstItem() }} 
                a {{ $statistics->lastItem() }} 
                de {{ $statistics->total() }} transacciones
            </p>

            <div class="flex gap-2">
                {{-- Anterior --}}
                <a href="{{ $statistics->previousPageUrl() ?? '#' }}"
                  class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm
                  {{ $statistics->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">
                    Anterior
                </a>

                {{-- Páginas --}}
                @foreach ($statistics->links()->elements[0] ?? [] as $page => $url)
                    <a href="{{ $url }}"
                      class="px-3 py-2 rounded-lg text-sm transition
                      {{ $page == $statistics->currentPage()
                            ? 'bg-accent-purple text-blue-600 border border-blue-300 font-medium'
                            : 'border border-gray-300 hover:bg-gray-50' }}">
                        {{ $page }}
                    </a>
                @endforeach

                {{-- Siguiente --}}
                <a href="{{ $statistics->nextPageUrl() ?? '#' }}"
                  class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm
                  {{ $statistics->hasMorePages() ? '' : 'opacity-50 pointer-events-none' }}">
                    Siguiente
                </a>
            </div>
        </div>

          
        </div>
      </div>
    </div>
</div>

<!-- Animación de entrada para mensajes -->
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.4s ease-out;
    }
</style>
@endsection