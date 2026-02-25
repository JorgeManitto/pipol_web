@extends('backend.layout.app')
@section('page_title', 'Profesionales - Pipol')
@section('main_content')

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
            <div class="bg-white rounded-xl shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Estadísticas</h2>
                <div class="space-y-4">
                    <div class="stat-card bg-stone-50 rounded-lg p-4 border border-stone-200">
                        <p class="text-sm text-gray-600 mb-1">Sesiones completadas</p>
                        <p class="text-3xl font-bold text-gray-900"> {{ $totalSessions ?? '0' }} </p>
                    </div>
                    <div class="stat-card bg-stone-50 rounded-lg p-4 border border-stone-200">
                        <p class="text-sm text-gray-600 mb-1">Calificación promedio</p>
                        <div class="flex items-center gap-2">
                            <p class="text-3xl font-bold text-gray-900"> {{ number_format($rating, 1) }} / 5.0 </p>
                            
                        </div>
                    </div>
                    <div class="stat-card bg-stone-50 rounded-lg p-4 border border-stone-200">
                        <p class="text-sm text-gray-600 mb-1">Años de experiencia</p>
                        <p class="text-3xl font-bold text-gray-900"> {{ $user->years_of_experience ?? '0' }} </p>
                    </div>
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
    <style >
    * {
        font-family: 'Inter', sans-serif;
    }
    
    .section-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .form-label.required::after {
        content: " *";
        color: #ef4444;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #2d5a4a;
        box-shadow: 0 0 0 3px rgba(45, 90, 74, 0.1);
    }
    
    .form-textarea {
        min-height: 100px;
        resize: vertical;
    }
    
    .image-preview-container {
        position: relative;
        display: inline-block;
    }
    
    .image-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 0.75rem;
        border: 3px solid #e5e7eb;
        transition: all 0.3s;
    }
    
    .image-preview:hover {
        border-color: #2d5a4a;
        transform: scale(1.05);
    }
    
    .image-preview.avatar {
        border-radius: 50%;
        width: 120px;
        height: 120px;
    }
    
    .file-upload-btn {
        display: inline-block;
        padding: 0.625rem 1.5rem;
        background: #2d5a4a;
        color: white;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .file-upload-btn:hover {
        background: #3d6a5a;
        transform: translateY(-1px);
    }
    
    .help-text {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.375rem;
    }
    
    .btn-primary-edit {
        background: #2d5a4a;
        color: white;
        padding: 1rem 2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary-edit:hover {
        background: #3d6a5a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 90, 74, 0.3);
    }
    
    .btn-secondary {
        background: #e5e7eb;
        color: #374151;
        padding: 1rem 2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-secondary:hover {
        background: #d1d5db;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }
    
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }
        /* Animación para el botón de IA */
    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(147, 51, 234, 0.7);
        }
        50% {
            box-shadow: 0 0 0 6px rgba(147, 51, 234, 0);
        }
    }
    
    #btnMejorarBio:hover {
        animation: pulse-glow 2s infinite;
    }
    
    /* Efecto de escritura para el textarea */
    #bio.typing {
        border-color: #9333ea;
        box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1);
    }
</style>

    {{-- <div class="">

        @include('backend.availability.availability')
    </div> --}}
@endsection