@extends('backend.layout.app')
@section('page_title', 'Profesionales - Pipol')
@section('main_content')
{{-- <div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Bienvenido al Panel de Profesionales</h2>
    <p class="text-gray-700">Desde aquí puedes gestionar tus sesiones, ver tus favoritos y actualizar tu perfil.</p>
</div> --}}
  {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-sm p-8 mb-8">
          <div class="flex items-center gap-3 mb-4">
              <h1 class="text-3xl font-bold text-[#1a0a3e]">Pipol</h1>
              <svg class="w-6 h-6 text-[#d4af6a]" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
          </div>
          <p class="text-gray-600 mb-6">Bienvenido al Panel de Profesionales</p>
      
          
          <p class="text-xs text-gray-500 mt-3">Desde aquí puedes gestionar tus sesiones, ver tus favoritos y actualizar tu perfil.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
            <p class="text-sm text-gray-500">Sesiones realizadas</p>
            <h2 class="text-3xl font-bold text-[#1a0a3e] mt-2">128</h2>

            <div class="mt-4 space-y-1 text-sm text-gray-600">
                <p>📅 Hoy: <span class="font-semibold">3</span></p>
                <p>📆 Semana: <span class="font-semibold">18</span></p>
                <p>🗓️ Mes: <span class="font-semibold">62</span></p>
                <p>📈 Año: <span class="font-semibold">128</span></p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <p class="text-sm text-gray-500">Dinero ganado</p>
            <h2 class="text-3xl font-bold text-[#1a0a3e] mt-2">$2.450</h2>

            <p class="text-sm text-gray-600 mt-4">
                Este mes: <span class="font-semibold text-green-600">$620</span>
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
            <p class="text-sm text-gray-500 mb-2">Calificación</p>

            <div class="flex items-center gap-2">
                <div class="flex text-yellow-400">
                    ★ ★ ★ ★ ☆
                </div>
                <span class="text-sm text-gray-600">(4.6)</span>
            </div>

            <p class="text-xs text-gray-500 mt-3">
                Basado en 54 reseñas
            </p>
        </div>
        <div class="bg-gradient-to-br from-[#1a0a3e] to-[#3b7a63] text-white rounded-2xl shadow-sm p-6">
            <p class="text-sm opacity-80">Nivel del mentor</p>

            <h2 class="text-2xl font-bold mt-2">Mentor Pro</h2>

            <div class="mt-4 text-sm opacity-90">
                <p>✔ +100 sesiones</p>
                <p>✔ Calificación ≥ 4.5</p>
            </div>
        </div>




  </div> --}}

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Widget de Bienvenida (el que ya tenías) -->
        @if (!auth()->user()->is_mentor)
            <div class="bg-white rounded-2xl shadow-sm p-8 mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <h1 class="text-3xl font-bold text-[#1a0a3e]">Pipol</h1>
                    <svg class="w-6 h-6 text-[#d4af6a]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-gray-600 mb-6">Bienvenido al Panel de Profesionales</p>
                <p class="text-xs text-gray-500 mt-3">Desde aquí puedes gestionar tus sesiones, ver tus favoritos y actualizar tu perfil.</p>
            </div>

            @else
            <!-- Widget: Nivel del mentor -->
            @php
                $rangos = [
                    'BRONZE' => 0,
                    'SILVER' => 5,
                    'GOLD' => 10,
                    'PLATINUM' => 20,
                    'HERO' => 30,
                ];

                $nivelActual = 'BRONZE';
                $siguienteNivel = null;
                $sesionesParaSiguiente = 0;

                $niveles = array_keys($rangos);

                foreach ($rangos as $nivel => $minimo) {
                    if ($sessionsAsMentor >= $minimo) {
                        $nivelActual = $nivel;
                    }
                }

                $indiceActual = array_search($nivelActual, $niveles);

                if (isset($niveles[$indiceActual + 1])) {
                    $siguienteNivel = $niveles[$indiceActual + 1];
                    $sesionesParaSiguiente = $rangos[$siguienteNivel] - $sessionsAsMentor;
                }

                // Progreso de la barra
                if ($siguienteNivel) {
                    $minActual = $rangos[$nivelActual];
                    $minSiguiente = $rangos[$siguienteNivel];
                    $progreso = (($sessionsAsMentor - $minActual) / ($minSiguiente - $minActual)) * 100;
                } else {
                    $progreso = 100;
                }
            @endphp
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="text-2xl text-center font-semibold text-[#1a0a3e] mb-4">
                    Nivel actual
                </h3>
                <div class="w-12 h-12 mx-auto bg-gradient-to-br from-[#d4af6a] to-[#1a0a3e] rounded-full flex items-center justify-center mb-4">
                    <span style="font-size: 11px;" class="font-semibold text-white">{{ $nivelActual }}</span>
                </div> 

                <div class="flex flex-col items-center">
                    <p class="text-xl font-semibold text-gray-800">
                        Nivel {{ $nivelActual }}
                    </p>

                    @if ($siguienteNivel)
                        <p class="text-sm text-gray-500 mt-2">
                            Faltan {{ $sesionesParaSiguiente }} sesiones para {{ $siguienteNivel }}
                        </p>
                    @else
                        <p class="text-sm text-gray-500 mt-2">
                            🎉 ¡Ya alcanzaste el nivel HERO!
                        </p>
                    @endif

                    <div class="w-full bg-gray-200 rounded-full h-3 mt-4">
                        <div
                            class="bg-[#d4af6a] h-3 rounded-full transition-all"
                            style="width: {{ min(100, max(0, $progreso)) }}%">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget: Dinero ganado -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="text-2xl text-center font-semibold text-[#1a0a3e] mb-4">
                    Dinero ganado
                </h3>
    
                <div class="text-center">
                    <p class="text-4xl font-bold text-[#1a0a3e]">
                        ${{ number_format($totalEarnings, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        Total acumulado
                    </p>
    
                    <div class="mt-4">
                        <p class="text-2xl font-semibold text-green-600">
                            ${{ number_format($totalEarningsThisMonth, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Este mes
                        </p>
                    </div>
                </div>
            </div>
            @php
                $rating = $ratingReviews; // ej: 4.9
                $fullStars = floor($rating);
                $maxStars = 5;
            @endphp
    
            <!-- Widget: Calificación promedio -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="text-2xl text-center font-semibold text-[#1a0a3e] mb-4">
                    Calificación promedio
                </h3>
    
                <div class="flex flex-col items-center">
                    <div class="flex items-center gap-1 mb-2">
                        @for ($i = 1; $i <= $maxStars; $i++)
                            <svg
                                class="w-8 h-8 {{ $i <= $fullStars ? 'text-yellow-400' : 'text-gray-300' }}"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.287 3.953c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.54-1.118l1.287-3.953a1 1 0 00-.364-1.118L2.316 9.38c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.953z"/>
                            </svg>
                        @endfor
                    </div>
    
                    <p class="text-2xl font-bold text-gray-800">
                        {{ number_format($rating, 1) }} / 5.0
                    </p>
    
                    <p class="text-sm text-gray-500 mt-1">
                        Basado en {{ $totalReviews }} {{ Str::plural('reseña', $totalReviews) }}
                    </p>
                </div>
            </div>
        @endif



        
        <!-- Widget: Sesiones realizadas -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-xl font-semibold text-[#1a0a3e] mb-4">
                Sesiones realizadas (últimos 30 días)
            </h3>

            <div class="relative h-64">
                <canvas id="sessionsChart"></canvas>
            </div>

            <div class="flex justify-around mt-6 text-center">
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $sessionsToday }}</p>
                    <p class="text-sm text-gray-500">Hoy</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $sessionsThisWeek }}</p>
                    <p class="text-sm text-gray-500">Esta semana</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $sessionsThisMonth }}</p>
                    <p class="text-sm text-gray-500">Este mes</p>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('sessionsChart').getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($labels),
                        datasets: [{
                            data: @json($data),
                            borderColor: '#1a0a3e',
                            backgroundColor: 'rgba(26,10,62,0.08)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#d4af6a',
                            pointBorderColor: '#1a0a3e',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            });
        </script>

    </div>
@endsection