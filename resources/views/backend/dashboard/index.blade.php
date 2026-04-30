{{-- DASHBOARD --}}
@extends('backend.layout.app')
@section('page_title', 'Profesionales - Pipol')
@section('main_content')

    <div>
        <!-- Fila 1: 3 cards iguales -->
        @if (!auth()->user()->is_mentor)
        <div class="flex gap-4 flex-col md:flex-row ">
            <div class="flex flex-col md:flex-row gap-6 mb-6 flex-1">
                <div class="bg-[#140A24] rounded-3xl shadow-sm p-8 border border-gray-700/50 flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <h1 class="text-xl  font-bold text-white">Pipol</h1>
                        <svg class="w-6 h-6 text-[#8B5CF6]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 mb-6">Bienvenido al Panel de Profesionales</p>
                    <p class="text-xs text-gray-500 mt-3">Desde aquí puedes gestionar tus sesiones, ver tus favoritos y actualizar tu perfil.</p>
                </div>
            </div>
            @if (auth()->user()->role === 'admin')
                <div class="flex flex-col md:flex-row gap-2 mb-2 flex-1">
                    <div class="bg-[#140A24] rounded-3xl shadow-sm p-6 flex-1 border border-gray-700/50">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 text-[#8B5CF6]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-sm uppercase font-semibold text-[#8C9BB0]">
                                Total acumulado (todos los usuarios)
                            </h3>
                        </div>
                        <p class="text-3xl font-bold text-white mt-4">
                            ${{ number_format($totalEarningsAllUsers, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-[#8C9BB0] mt-2">
                            Suma de todas las transacciones en la plataforma
                        </p>
                    </div>
                </div>
            @endif
        </div>

        @else
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

                if ($siguienteNivel) {
                    $minActual = $rangos[$nivelActual];
                    $minSiguiente = $rangos[$siguienteNivel];
                    $progreso = (($sessionsAsMentor - $minActual) / ($minSiguiente - $minActual)) * 100;
                } else {
                    $progreso = 100;
                }
            @endphp

            <!-- Fila 1: Nivel actual + Dinero ganado + Calificación promedio -->
            <div class="flex flex-col md:flex-row gap-2 mb-2">

                <!-- Widget: Nivel del mentor -->
                <div class="bg-[#140A24] rounded-3xl shadow-sm p-2 flex-1">
                    <h3 class="text-sm uppercase text-center font-semibold text-[#8C9BB0]">
                        Nivel actual
                    </h3>
                    <div class="relative flex items-center justify-center" style="width: 100px; height: 100px; margin: .3em auto;">
                        <!-- SVG Circular Progress -->
                        <svg class="absolute inset-0 -rotate-90 scale-y-[-1]" width="100" height="100" viewBox="0 0 160 160">
                            <!-- Track (fondo) -->
                            <circle cx="80" cy="80" r="70" fill="none" stroke="#20293C" stroke-width="8" />
                            <!-- Progreso -->
                            <circle cx="80" cy="80" r="70" fill="none" stroke="#3B82F6" stroke-width="8"
                                stroke-linecap="round"
                                stroke-dasharray="{{ 2 * 3.1416 * 70 }}"
                                stroke-dashoffset="{{ 2 * 3.1416 * 70 * (1 - min(100, max(0, $progreso)) / 100) }}"
                                class="transition-all duration-700"
                            />
                        </svg>
                        <!-- Nivel actual (centro) -->
                        <div class="w-16 h-16 bg-gradient-to-br from-[#C26808] to-[#8A410E] rounded-full flex items-center justify-center z-10">
                            <span class="text-xs font-semibold text-white">{{ $nivelActual }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-center">
                        <p class="text-xl font-semibold text-white">
                            Nivel {{ $nivelActual }}
                        </p>

                        @if ($siguienteNivel)
                            <p class="text-xs text-[#8C9BB0] mt-1">
                                Faltan {{ $sesionesParaSiguiente }} sesiones para <span class="text-[#3B82F6]">{{ $siguienteNivel }}</span>
                            </p>
                        @else
                            <p class="text-xs text-[#8C9BB0] mt-1">
                                🎉 ¡Ya alcanzaste el nivel HERO!
                            </p>
                        @endif

                        <div class="w-full bg-[#20293C] rounded-full h-2 mt-2">
                            <div
                                class="bg-[#3B82F6] h-2 rounded-full transition-all"
                                style="width: {{ min(100, max(0, $progreso)) }}%">
                            </div>
                        </div>
                    </div>
                </div>

                @if (auth()->user()->role === 'admin')
                <div class="flex flex-col md:flex-row gap-2 mb-2 flex-1">
                    <div class="bg-[#140A24] rounded-3xl shadow-sm p-6 flex-1 border border-gray-700/50">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 text-[#8B5CF6]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-sm uppercase font-semibold text-[#8C9BB0]">
                                Total acumulado (todos los usuarios)
                            </h3>
                        </div>
                        <p class="text-3xl font-bold text-white mt-4" id="total-hourly-rate" data-original-currency="USD" data-original-amount="{{ $totalEarningsAllUsers }}">
                            ${{ number_format($totalEarningsAllUsers, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-[#8C9BB0] mt-2">
                            Suma de todas las transacciones en la plataforma
                        </p>
                    </div>
                </div>
                @else
                <!-- Widget: Dinero ganado -->
                <div class="bg-[#140A24] rounded-3xl shadow-sm p-2   flex-1">
                    <h3 class="text-sm uppercase text-center font-semibold text-[#8C9BB0]">
                        Dinero ganado
                    </h3>

                    <div class="text-center">
                        <p class="text-2xl mt-4 font-bold text-white" id="total-hourly-rate" data-original-currency="USD" data-original-amount="{{ $totalEarnings }}">
                            ${{ number_format($totalEarnings, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-[#8C9BB0] mt-2">
                            Total acumulado
                        </p>

                        <div class="mt-4 border border-green-600/30 bg-green-600/20 p-4 rounded-xl">
                            <p class="text-2xl font-semibold text-[#34D399]" id="month-hourly-rate" data-original-currency="USD" data-original-amount="{{ $totalEarningsThisMonth }}">
                                ${{ number_format($totalEarningsThisMonth, 0, ',', '.') }}
                            </p>
                            <p class="text-xs uppercase text-[#34D399]">
                                Este mes
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                

                @php
                    $rating = $ratingReviews;
                    $fullStars = floor($rating);
                    $maxStars = 5;
                @endphp

                <!-- Widget: Calificación promedio -->
                <div class="bg-[#140A24] rounded-3xl shadow-sm p-2   flex-1">
                    <h3 class="text-sm uppercase text-center font-semibold text-[#8C9BB0]">
                        Calificación promedio
                    </h3>

                    <div class="flex flex-col items-center">
                        <div class="flex items-center gap-1 mt-2">
                            @for ($i = 1; $i <= $maxStars; $i++)
                                <svg
                                    class="w-4 h-4 {{ $i <= $fullStars ? 'text-[#FDC024]' : 'text-[#8C9BB0]' }}"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.287 3.953c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.54-1.118l1.287-3.953a1 1 0 00-.364-1.118L2.316 9.38c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.953z"/>
                                </svg>
                            @endfor
                        </div>

                        <p class="text-2xl font-normal text-white mt-2">
                            <span class="text-2xl font-semibold">{{ number_format($rating, 1) }}</span> <span class="text-[#8C9BB0]">/ 5.0</span> 
                        </p>

                        <p class="text-xs text-[#8C9BB0] mt-2 mb-2">
                            Basado en {{ $totalReviews }} {{ Str::plural('reseña', $totalReviews) }}
                        </p>

                        @php
                            $allReviews = auth()->user()->reviewsReceived;
                            $totalReviews = $allReviews->count();
                            $reviewCounts = $allReviews->groupBy('rating')->map->count();
                        @endphp

                        @foreach ($reviewsforRating as $ratingOption)
                            @php
                                $count = $reviewCounts[$ratingOption->rating] ?? 0;
                                $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
                            @endphp
                            <div class="flex gap-4 items-center mt-1 w-full">
                                <div class="flex items-center gap-1">
                                    <div class="text-xs text-[#8C9BB0]">{{ $ratingOption->rating }}</div>
                                    <svg class="w-2 h-2 text-[#8C9BB0]" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.287 3.953c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.54-1.118l1.287-3.953a1 1 0 00-.364-1.118L2.316 9.38c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.953z"/>
                                    </svg>
                                </div>
                                <div class="w-full bg-[#20293C] rounded-full h-2">
                                    <div class="bg-[#FDC024] h-2 rounded-full transition-all"
                                        style="width: {{ $percentage }}%">
                                    </div>
                                </div>
                                <div class="text-xs text-[#8C9BB0]">{{ $percentage }}%</div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Fila 2: Estadísticas (~1/3) + Sesiones realizadas (~2/3) -->
            <div class="flex flex-col md:flex-row gap-2">

                <!-- Widget: Estadísticas -->
                <div class="bg-[#140A24] rounded-3xl shadow-sm p-2   flex-1">
                    <h2 class="text-sm uppercase font-bold text-white mb-2">Estadísticas</h2>
                    <div class="space-y-4">
                        <div class="bg-[#20152E] rounded-xl p-2 border border-gray-700/50 mb-1">
                            <p class="text-xs uppercase text-[#8C9BB0] mb-1">Sesiones completadas</p>
                            <p class="text-xl  font-bold text-white"> {{ $totalSessions ?? '0' }} </p>
                        </div>
                        <div class="bg-[#20152E] rounded-xl p-2 border border-gray-700/50 mb-1">
                            <p class="text-xs uppercase text-[#8C9BB0] mb-1">Vistas de perfil</p>
                            <div class="flex items-center gap-2">
                                <p class="text-xl  font-bold text-white"> {{ $user->countViewProfile() }} </p>
                            </div>
                        </div>
                        <div class="bg-[#20152E] rounded-xl p-2 border border-gray-700/50 mb-1">
                            <p class="text-xs uppercase text-[#8C9BB0] mb-1">Años de experiencia</p>
                            <p class="text-xl  font-bold text-white"> {{ $user->years_of_experience ?? '0' }} </p>
                        </div>
                    </div>
                </div>

                <!-- Widget: Sesiones realizadas -->
                <div class="bg-[#140A24] rounded-3xl shadow-sm p-2 md:w-2/3">
                    <h3 class="text-sm font-semibold text-white mb-4">
                        Sesiones realizadas (últimos 30 días)
                    </h3>

                    <div class="relative h-36">
                        <canvas id="sessionsChart"></canvas>
                    </div>

                    <div class="flex justify-around mt-2 text-center">
                        <div>
                            <p class="text-md font-bold text-white">{{ $sessionsToday }}</p>
                            <p class="text-sm text-gray-400">Hoy</p>
                        </div>
                        <div>
                            <p class="text-md font-bold text-white">{{ $sessionsThisWeek }}</p>
                            <p class="text-sm text-gray-400">Esta semana</p>
                        </div>
                        <div>
                            <p class="text-md font-bold text-white">{{ $sessionsThisMonth }}</p>
                            <p class="text-sm text-gray-400">Este mes</p>
                        </div>
                    </div>
                </div>

            </div>

        @endif

        {{-- Si NO es mentor, mostrar solo el widget de sesiones --}}
        @if (!auth()->user()->is_mentor)
            <div class="flex flex-col md:flex-row gap-6">
                <div class="bg-[#140A24] rounded-3xl shadow-sm p-6 border border-gray-700/50 flex-1">
                    <h3 class="text-xl font-semibold text-white mb-4">
                        Sesiones realizadas (últimos 30 días)
                    </h3>

                    <div class="relative h-64">
                        <canvas id="sessionsChart"></canvas>
                    </div>

                    <div class="flex justify-around mt-6 text-center">
                        <div>
                            <p class="text-2xl font-bold text-white">{{ $sessionsToday }}</p>
                            <p class="text-sm text-gray-400">Hoy</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-white">{{ $sessionsThisWeek }}</p>
                            <p class="text-sm text-gray-400">Esta semana</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-white">{{ $sessionsThisMonth }}</p>
                            <p class="text-sm text-gray-400">Este mes</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#3B82F6',
                            pointBorderColor: '#A78BFA',
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
                                ticks: {
                                    stepSize: 1,
                                    color: '#9CA3AF'
                                },
                                grid: {
                                    color: 'rgba(107, 114, 128, 0.2)'
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: {
                                    color: '#9CA3AF',
                                    maxTicksLimit: 6
                                }
                            }
                        }
                    }
                });
            });
        </script>

    </div>

    <style>
    * {
        font-family: 'Inter', sans-serif;
    }

    .section-card {
        background: #140A24;
        border-radius: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        padding: 2rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(107, 114, 128, 0.3);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid rgba(107, 114, 128, 0.3);
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
        color: #9CA3AF;
        margin-bottom: 0.5rem;
    }

    .form-label.required::after {
        content: " *";
        color: #ef4444;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(107, 114, 128, 0.5);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s;
        background: #20152E;
        color: #ffffff;
    }

    .form-input:focus {
        outline: none;
        border-color: #8B5CF6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
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
        border: 3px solid rgba(107, 114, 128, 0.3);
        transition: all 0.3s;
    }

    .image-preview:hover {
        border-color: #8B5CF6;
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
        background: #8B5CF6;
        color: white;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .file-upload-btn:hover {
        background: #7C3AED;
        transform: translateY(-1px);
    }

    .help-text {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.375rem;
    }

    .btn-primary-edit {
        background: #8B5CF6;
        color: white;
        padding: 1rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-primary-edit:hover {
        background: #7C3AED;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }

    .btn-secondary {
        background: #20152E;
        color: #9CA3AF;
        padding: 1rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s;
        border: 1px solid rgba(107, 114, 128, 0.3);
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #2D1F42;
    }

    .alert {
        padding: 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.15);
        color: #34D399;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.15);
        color: #F87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.7);
        }
        50% {
            box-shadow: 0 0 0 6px rgba(139, 92, 246, 0);
        }
    }

    #btnMejorarBio:hover {
        animation: pulse-glow 2s infinite;
    }

    #bio.typing {
        border-color: #8B5CF6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }
    </style>

@endsection