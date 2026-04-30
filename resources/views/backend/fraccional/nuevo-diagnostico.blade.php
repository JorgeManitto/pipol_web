{{-- resources/views/components/diagnostico-wizard.blade.php --}}
{{-- O incluir en tu vista Blade donde corresponda --}}

<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .pipol-wizard { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; -webkit-font-smoothing: antialiased; }

    .page-bg { min-height: 100vh; background: linear-gradient(135deg, #faf5ff 0%, #fff 50%, #fdf2f8 100%); }

    /* Header */
    .header { padding: 24px; border-bottom: 1px solid #e5e7eb; background: rgba(255,255,255,0.8); backdrop-filter: blur(12px); position: sticky; top: 0; z-index: 10; }
    .header-inner { max-width: 640px; margin: 0 auto; }
    .header-results { max-width: 1024px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
    .logo { display: flex; align-items: center; gap: 8; }
    .logo-icon { width: 32px; height: 32px; background: linear-gradient(135deg, #9333ea, #ec4899); border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    .logo-text { font-weight: 600; background: linear-gradient(90deg, #9333ea, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

    /* Progress */
    .progress-track { width: 100%; height: 8px; background: rgba(147,51,234,0.15); border-radius: 999px; overflow: hidden; margin-top: 16px; }
    .progress-fill { height: 100%; background: linear-gradient(90deg, #9333ea, #ec4899); border-radius: 999px; transition: width 0.4s ease; }
    .progress-label { font-size: 14px; color: #6b7280; margin-top: 8px; }

    /* Card */
    .card { background: #fff; border-radius: 24px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); border: 1px solid #f3f4f6; padding: 32px 48px; }
    @media (max-width: 640px) { .card { padding: 24px 20px; } }

    /* Titles */
    .step-title { font-size: 28px; font-weight: 700; margin-bottom: 8px; color: #111827; }
    .step-desc { color: #6b7280; margin-bottom: 0; }

    /* Textarea */
    .field-label { display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px; color: #111827; }
    .field-textarea { width: 100%; min-height: 160px; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; resize: none; outline: none; font-family: inherit; box-sizing: border-box; transition: border-color 0.2s; }
    .field-textarea:focus { border-color: #9333ea; }
    .char-count { font-size: 14px; color: #6b7280; margin-top: 4px; }

    /* Option buttons */
    .options-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .options-stack { display: flex; flex-direction: column; gap: 12px; }
    .option-btn { padding: 24px; border-radius: 12px; border: 2px solid #e5e7eb; background: #fff; cursor: pointer; text-align: left; transition: all 0.2s; font-family: inherit; font-size: 14px; }
    .option-btn:hover { border-color: #c084fc; }
    .option-btn.selected { border-color: #9333ea; background: #faf5ff; }
    .option-label { font-weight: 500; }
    .option-desc { font-size: 14px; color: #6b7280; margin-top: 4px; }

    /* Dropdown */
    .dropdown-wrapper { position: relative; }
    .dropdown-trigger { width: 100%; height: 56px; padding: 0 16px; border: 1px solid #e5e7eb; border-radius: 8px; background: #fff; display: flex; align-items: center; justify-content: space-between; cursor: pointer; font-size: 14px; font-family: inherit; text-align: left; }
    .dropdown-trigger.placeholder { color: #9ca3af; }
    .dropdown-trigger.has-value { color: #111827; }
    .dropdown-menu { position: absolute; top: 100%; left: 0; right: 0; margin-top: 4px; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); z-index: 20; max-height: 240px; overflow-y: auto; }
    .dropdown-item { width: 100%; padding: 12px 16px; border: none; background: transparent; cursor: pointer; text-align: left; font-size: 14px; color: #374151; display: block; font-family: inherit; }
    .dropdown-item:hover { background: #f9fafb; }
    .dropdown-item.selected { background: #faf5ff; }

    /* Navigation */
    .nav-row { display: flex; gap: 16px; margin-top: 48px; }
    .btn { flex: 1; display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; font-family: inherit; transition: all 0.2s; }
    .btn-back { border: 1px solid #e5e7eb; background: #fff; color: #374151; }
    .btn-back:disabled { opacity: 0.5; cursor: not-allowed; }
    .btn-back:not(:disabled):hover { background: #f9fafb; }
    .btn-next { border: none; color: #fff; }
    .btn-next.enabled { background: linear-gradient(90deg, #9333ea, #ec4899); cursor: pointer; }
    .btn-next.enabled:hover { background: linear-gradient(90deg, #7e22ce, #db2777); }
    .btn-next.disabled { background: #d1d5db; opacity: 0.6; cursor: not-allowed; }
    .btn-reset { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border: 1px solid #e5e7eb; border-radius: 8px; background: #fff; cursor: pointer; font-size: 14px; font-weight: 500; color: #374151; font-family: inherit; }
    .btn-reset:hover { background: #f9fafb; }

    /* Step transition */
    .step-container { transition: opacity 0.2s ease, transform 0.2s ease; }
    .step-container.animating { opacity: 0; transform: translateY(10px); }

    /* Analyzing screen */
    .analyzing-screen { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    .analyzing-icon { width: 64px; height: 64px; margin: 0 auto 24px; border-radius: 16px; background: linear-gradient(135deg, #9333ea, #ec4899); display: flex; align-items: center; justify-content: center; animation: pulse 1.5s ease-in-out infinite; }
    .analyzing-title { font-size: 24px; font-weight: 600; color: #1f2937; margin-bottom: 8px; }
    .analyzing-desc { color: #6b7280; transition: opacity 0.3s ease; min-height: 24px; }
    .loading-track { width: 200px; height: 4px; background: #e5e7eb; border-radius: 999px; margin: 24px auto 0; overflow: hidden; }
    .loading-fill { height: 100%; background: linear-gradient(90deg, #9333ea, #ec4899); border-radius: 999px; animation: loading 2s ease-in-out infinite; }

    @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
    @keyframes loading { 0% { width: 0%; } 50% { width: 70%; } 100% { width: 100%; } }
    @keyframes pulseSmall { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }

    /* Results */
    .results-badge { display: flex; justify-content: center; margin-bottom: 32px; transition: all 0.5s ease; }
    .badge-pill { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: linear-gradient(90deg, #dcfce7, #d1fae5); color: #15803d; border-radius: 999px; border: 1px solid #bbf7d0; }
    .badge-dot { width: 8px; height: 8px; background: #22c55e; border-radius: 50%; animation: pulseSmall 2s infinite; }
    .badge-text { font-weight: 500; }

    .results-card { background: #fff; border-radius: 24px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid #f3f4f6; overflow: hidden; margin-bottom: 32px; transition: all 0.6s ease; }
    .results-header { background: linear-gradient(90deg, #9333ea, #ec4899); padding: 32px; color: #fff; }
    .results-header h1 { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
    .results-header p { color: rgba(255,255,255,0.8); }
    .results-body { padding: 32px 48px; }
    @media (max-width: 640px) { .results-body { padding: 24px 20px; } }
    .results-divider { height: 1px; background: #e5e7eb; margin: 32px 0; }

    .result-row { display: flex; gap: 16px; align-items: flex-start; }
    .result-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .result-label { font-size: 18px; font-weight: 400; color: #6b7280; margin-bottom: 4px; }
    .result-value { font-size: 22px; color: #111827; margin: 0; }
    .result-value.gradient { font-weight: 600; background: linear-gradient(90deg, #9333ea, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

    .insights-box { background: linear-gradient(135deg, #faf5ff, #fdf2f8); border-radius: 16px; padding: 32px; margin-bottom: 32px; border: 1px solid #e9d5ff; transition: all 0.6s ease; }
    .insights-title { font-size: 20px; font-weight: 600; margin-bottom: 16px; }
    .insight-item { display: flex; gap: 12px; align-items: flex-start; margin-bottom: 12px; }
    .insight-item:last-child { margin-bottom: 0; }
    .insight-dot { width: 6px; height: 6px; background: #9333ea; border-radius: 50%; margin-top: 8px; flex-shrink: 0; }
    .insight-text { color: #374151; margin: 0; line-height: 1.6; }

    .cta-section { text-align: center; transition: all 0.6s ease; }
    .btn-cta { display: inline-flex; align-items: center; gap: 8px; padding: 16px 32px; background: linear-gradient(90deg, #9333ea, #ec4899); color: #fff; border: none; border-radius: 8px; font-size: 18px; font-weight: 500; cursor: pointer; box-shadow: 0 8px 24px rgba(147,51,234,0.3); font-family: inherit; transition: all 0.2s; }
    .btn-cta:hover { background: linear-gradient(90deg, #7e22ce, #db2777); box-shadow: 0 12px 32px rgba(147,51,234,0.4); }
    .cta-sub { color: #6b7280; font-size: 14px; margin-top: 16px; }

    /* Error */
    .error-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 24px; text-align: center; margin-bottom: 32px; }
    .error-box p { color: #dc2626; margin-bottom: 12px; }
    .btn-retry { padding: 8px 24px; background: #dc2626; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-family: inherit; font-size: 14px; font-weight: 500; }
    .btn-retry:hover { background: #b91c1c; }

    /* Fade helpers */
    .fade-in { opacity: 1; transform: translateY(0) scale(1); }
    .fade-out { opacity: 0; transform: translateY(20px); }
    .fade-out-scale { opacity: 0; transform: scale(0.95); }
</style>

<div id="pipol-diagnostico" class="pipol-wizard">
    <!-- ANALYZING SCREEN -->
    <div v-if="analyzing" class="page-bg analyzing-screen">
        <div style="text-align:center">
            <div class="analyzing-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>
                    <path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/>
                </svg>
            </div>
            <h2 class="analyzing-title">Analizando tu situación...</h2>
            <p class="analyzing-desc">[[ analyzingMessage ]]</p>
            <div class="loading-track"><div class="loading-fill"></div></div>
        </div>
    </div>

    <!-- RESULTS SCREEN -->
    <div v-else-if="showResults" class="page-bg">
        <header class="header">
            <div class="header-results">
                <div class="logo">
                    <div class="logo-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>
                            <path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/>
                        </svg>
                    </div>
                    <span class="logo-text">Pipol Fraccional</span>
                </div>
                <button class="btn-reset" @click="reset">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                    Nuevo diagnóstico
                </button>
            </div>
        </header>

        <main style="padding: 48px 24px; max-width: 896px; margin: 0 auto;">
            <!-- Error -->
            <div v-if="aiError" class="error-box">
                <p>[[ aiError ]]</p>
                <button class="btn-retry" @click="retryAnalysis">Reintentar análisis</button>
            </div>

            <template v-else>
                <!-- Badge -->
                <div class="results-badge" :class="resultsVisible ? 'fade-in' : 'fade-out-scale'">
                    <div class="badge-pill">
                        <div class="badge-dot"></div>
                        <span class="badge-text">Diagnóstico completado</span>
                    </div>
                </div>

                <!-- Main results card -->
                <div class="results-card" :class="resultsVisible ? 'fade-in' : 'fade-out'" :style="{ transitionDelay: '0.2s' }">
                    <div class="results-header">
                        <h1>Tu solución está lista</h1>
                        <p>Basándonos en tu información, identificamos exactamente qué necesitás</p>
                    </div>
                    <div class="results-body">
                        <!-- Problem -->
                        <div class="result-row">
                            <div class="result-icon" style="background:#fee2e2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>
                                </svg>
                            </div>
                            <div>
                                <div class="result-label">Problema detectado</div>
                                <p class="result-value">[[ solution.problem ]]</p>
                            </div>
                        </div>
                        <div class="results-divider"></div>

                        <!-- Solution -->
                        <div class="result-row">
                            <div class="result-icon" style="background:#f3e8ff">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
                                </svg>
                            </div>
                            <div>
                                <div class="result-label">Solución recomendada</div>
                                <p class="result-value gradient">[[ solution.role ]]</p>
                            </div>
                        </div>
                        <div class="results-divider"></div>

                        <!-- Hours -->
                        <div class="result-row">
                            <div class="result-icon" style="background:#dbeafe">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                            </div>
                            <div>
                                <div class="result-label">Dedicación sugerida</div>
                                <p class="result-value">[[ solution.hours ]]</p>
                            </div>
                        </div>
                        <div class="results-divider"></div>

                        <!-- Impact -->
                        <div class="result-row">
                            <div class="result-icon" style="background:#dcfce7">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>
                                </svg>
                            </div>
                            <div>
                                <div class="result-label">Impacto esperado</div>
                                <p class="result-value">[[ solution.impact ]]</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Insights -->
                <div class="insights-box" :class="resultsVisible ? 'fade-in' : 'fade-out'" :style="{ transitionDelay: '0.4s' }">
                    <h3 class="insights-title">💡 Insights clave</h3>
                    <div v-for="(insight, i) in insights" :key="i" class="insight-item">
                        <div class="insight-dot"></div>
                        <p class="insight-text">[[ insight ]]</p>
                    </div>
                </div>

                <!-- CTA -->
                <div class="cta-section" :class="resultsVisible ? 'fade-in' : 'fade-out'" :style="{ transitionDelay: '0.6s' }">
                    <button class="btn-cta" @click="verProfesionales">
                        Ver profesionales disponibles
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </button>
                    <p class="cta-sub" v-if="solution.matchCount">[[ solution.matchCount ]]</p>
                </div>
            </template>
        </main>
    </div>

    <!-- WIZARD STEPS -->
    <div v-else class="page-bg">
        <header class="header">
            <div class="header-inner">
                <div class="logo" style="margin-bottom:16px">
                    <div class="logo-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>
                            <path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/>
                        </svg>
                    </div>
                    <span class="logo-text ms-2">Pipol Fraccional</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" :style="{ width: progressPercent + '%' }"></div>
                </div>
                <p class="progress-label">Paso [[ step ]] de [[ totalSteps ]]</p>
                <a href="{{ route('home.fraccional') }}" class="btn-outline">Volver a la página principal</a>
            </div>
        </header>

        <main style="padding: 48px 24px;">
            <div style="max-width: 640px; margin: 0 auto;">
                <div class="step-container" :class="{ animating }">
                    <div class="card">

                        <!-- STEP 1: Problema -->
                        <div v-if="step === 1" style="display:flex; flex-direction:column; gap:24px;">
                            <div>
                                <h2 class="step-title">¿Qué está pasando en tu empresa?</h2>
                                <p class="step-desc">Describí el problema o desafío que estás enfrentando. Cuanto más detalle, mejor.</p>
                            </div>
                            <div>
                                <label class="field-label">Tu problema</label>
                                <textarea
                                    v-model="formData.problem"
                                    class="field-textarea"
                                    placeholder="Ej: No tenemos claridad en nuestros procesos de contratación y estamos teniendo mucha rotación de personal..."
                                ></textarea>
                                <p class="char-count">[[ formData.problem.length ]] caracteres</p>
                            </div>
                        </div>

                        <!-- STEP 2: Tamaño -->
                        <div v-if="step === 2" style="display:flex; flex-direction:column; gap:24px;">
                            <div>
                                <h2 class="step-title">¿Cuántas personas trabajan en tu empresa?</h2>
                                <p class="step-desc">Esto nos ayuda a dimensionar la solución adecuada.</p>
                            </div>
                            <div class="options-grid">
                                <button
                                    v-for="opt in sizeOptions" :key="opt"
                                    class="option-btn" :class="{ selected: formData.size === opt }"
                                    @click="formData.size = opt"
                                ><div class="option-label">[[ opt ]]</div></button>
                            </div>
                        </div>

                        <!-- STEP 3: Industria -->
                        <div v-if="step === 3" style="display:flex; flex-direction:column; gap:24px;">
                            <div>
                                <h2 class="step-title">¿En qué industria operás?</h2>
                                <p class="step-desc">Seleccioná la que mejor describa tu empresa.</p>
                            </div>
                            <div>
                                <label class="field-label">Industria</label>
                                <div class="dropdown-wrapper" v-click-outside="() => dropdownOpen = false">
                                    <button
                                        class="dropdown-trigger"
                                        :class="formData.industry ? 'has-value' : 'placeholder'"
                                        @click="dropdownOpen = !dropdownOpen"
                                    >
                                        <span>[[ formData.industry || 'Seleccionar industria' ]]</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.5"><path d="m6 9 6 6 6-6"/></svg>
                                    </button>
                                    <div v-if="dropdownOpen" class="dropdown-menu">
                                        <button
                                            v-for="ind in industries" :key="ind"
                                            class="dropdown-item" :class="{ selected: formData.industry === ind }"
                                            @click="formData.industry = ind; dropdownOpen = false"
                                        >[[ ind ]]</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 4: Urgencia -->
                        <div v-if="step === 4" style="display:flex; flex-direction:column; gap:24px;">
                            <div>
                                <h2 class="step-title">¿Qué tan urgente es resolver esto?</h2>
                                <p class="step-desc">Esto nos ayuda a priorizar tu búsqueda.</p>
                            </div>
                            <div class="options-stack">
                                <button
                                    v-for="opt in urgencyOptions" :key="opt.label"
                                    class="option-btn" :class="{ selected: formData.urgency === opt.label }"
                                    @click="formData.urgency = opt.label"
                                >
                                    <div class="option-label">[[ opt.label ]]</div>
                                    <div class="option-desc">[[ opt.desc ]]</div>
                                </button>
                            </div>
                        </div>

                        <!-- STEP 5: Etapa -->
                        <div v-if="step === 5" style="display:flex; flex-direction:column; gap:24px;">
                            <div>
                                <h2 class="step-title">¿En qué etapa está tu negocio?</h2>
                                <p class="step-desc">Cada etapa tiene desafíos específicos.</p>
                            </div>
                            <div class="options-stack">
                                <button
                                    v-for="opt in stageOptions" :key="opt.label"
                                    class="option-btn" :class="{ selected: formData.stage === opt.label }"
                                    @click="formData.stage = opt.label"
                                >
                                    <div class="option-label">[[ opt.label ]]</div>
                                    <div class="option-desc">[[ opt.desc ]]</div>
                                </button>
                            </div>
                        </div>

                        <!-- Nav -->
                        <div class="nav-row">
                            <button class="btn btn-back" :disabled="step === 1" @click="goBack">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                                Atrás
                            </button>
                            <button class="btn btn-next" :class="canContinue ? 'enabled' : 'disabled'" :disabled="!canContinue" @click="goNext">
                                [[ step === totalSteps ? 'Analizar' : 'Continuar' ]]
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left:8px"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

{{-- ========================================= --}}
{{-- Scripts --}}
{{-- ========================================= --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.4.21/vue.global.prod.min.js"></script>

<script type="module">
    import { GoogleGenerativeAI } from "https://esm.run/@google/generative-ai";

    const API_KEY = "{{ env('GEMINI_API_KEY') }}";
    const genAI = new GoogleGenerativeAI(API_KEY);

    // Exponer la función de diagnóstico globalmente para que Vue la use
    window.ejecutarDiagnostico = async function(formData) {
        const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });

        const prompt = `Eres un consultor experto en recursos humanos y gestión empresarial de Pipol Fraccional, una empresa que ofrece profesionales fraccionales (part-time de alto nivel) en áreas como HR, Finanzas, Marketing, Tecnología, Operaciones y Legal.

Analiza los siguientes datos de un cliente potencial y genera un diagnóstico profesional.

DATOS DEL CLIENTE:
- Problema descrito: "${formData.problem}"
- Tamaño de empresa: ${formData.size}
- Industria: ${formData.industry}
- Urgencia: ${formData.urgency}
- Etapa del negocio: ${formData.stage}

ROLES FRACCIONALES DISPONIBLES (elegí el más adecuado o combiná hasta 2):
- HR Manager Fraccional
- CFO Fraccional
- CMO Fraccional
- CTO Fraccional
- COO Fraccional
- Head of Legal Fraccional
- Head of People & Culture Fraccional
- Head of Sales Fraccional

Devuelve EXCLUSIVAMENTE un JSON válido con esta estructura exacta. No uses markdown, no uses \`\`\`json, no agregues texto adicional:
{
    "problem": "Resumen del problema principal detectado en 1 oración clara (máx 15 palabras)",
    "role": "El rol fraccional recomendado (de la lista anterior)",
    "hours": "Rango de horas semanales sugeridas (ej: '8 a 12 horas semanales')",
    "impact": "Impacto esperado en 1 oración clara (máx 15 palabras)",
    "insights": [
        "Insight 1 específico al caso del cliente (1-2 oraciones)",
        "Insight 2 con dato o recomendación concreta (1-2 oraciones)",
        "Insight 3 sobre el valor del modelo fraccional para su caso (1-2 oraciones)"
    ],
    "matchCount": "Texto tipo 'Tenemos X profesionales que coinciden con tu necesidad'"
}`;

        const result = await model.generateContent(prompt);
        let response = result.response.text().trim();

        // Limpiar posibles artefactos de markdown
        response = response.replace(/```json\s*/gi, '').replace(/```\s*/gi, '').trim();

        return JSON.parse(response);
    };
</script>

<script>
    const { createApp, ref, computed } = Vue;

    const app = createApp({
        compilerOptions: {
            delimiters: ['[[', ']]'],
        },
        setup() {
            const step = ref(1);
            const totalSteps = 5;
            const animating = ref(false);
            const showResults = ref(false);
            const analyzing = ref(false);
            const resultsVisible = ref(false);
            const dropdownOpen = ref(false);
            const aiError = ref(null);
            const analyzingMessage = ref('Estamos procesando tu información...');

            const formData = ref({
                problem: '',
                size: '',
                industry: '',
                urgency: '',
                stage: '',
            });

            // Resultados dinámicos (se llenan con IA)
            const solution = ref({
                role: '',
                problem: '',
                impact: '',
                hours: '',
                matchCount: '',
            });
            const insights = ref([]);

            const sizeOptions = ['1-10 personas', '10-50 personas', '50-200 personas', 'Más de 200'];
            const industries = [
                'Tecnología', 'Salud', 'Educación', 'Finanzas', 'Retail / Comercio',
                'Manufactura', 'Construcción', 'Gastronomía', 'Logística', 'Servicios profesionales',
                'Marketing / Publicidad', 'Agro', 'Energía', 'Otra'
            ];
            const urgencyOptions = [
                { label: 'Baja', desc: 'Puedo esperar algunas semanas' },
                { label: 'Media', desc: 'Necesito comenzar en 1-2 semanas' },
                { label: 'Alta', desc: 'Es crítico, necesito ayuda ya' },
            ];
            const stageOptions = [
                { label: 'Inicio', desc: 'Estamos arrancando, definiendo producto y mercado' },
                { label: 'Crecimiento', desc: 'Tenemos tracción y estamos escalando' },
                { label: 'Consolidación', desc: 'Empresa establecida, optimizando operaciones' },
            ];

            const canContinue = computed(() => {
                switch (step.value) {
                    case 1: return formData.value.problem.trim().length > 10;
                    case 2: return formData.value.size !== '';
                    case 3: return formData.value.industry !== '';
                    case 4: return formData.value.urgency !== '';
                    case 5: return formData.value.stage !== '';
                    default: return false;
                }
            });

            const progressPercent = computed(() => (step.value / totalSteps) * 100);

            // Mensajes rotativos durante el análisis
            const analyzingMessages = [
                'Estamos procesando tu información...',
                'Analizando el contexto de tu industria...',
                'Evaluando la mejor solución fraccional...',
                'Calculando dedicación y alcance...',
                'Preparando tu diagnóstico personalizado...',
            ];

            let messageInterval = null;

            function startAnalyzingMessages() {
                let idx = 0;
                analyzingMessage.value = analyzingMessages[0];
                messageInterval = setInterval(() => {
                    idx = (idx + 1) % analyzingMessages.length;
                    analyzingMessage.value = analyzingMessages[idx];
                }, 2000);
            }

            function stopAnalyzingMessages() {
                if (messageInterval) {
                    clearInterval(messageInterval);
                    messageInterval = null;
                }
            }

            async function runDiagnostic() {
                analyzing.value = true;
                aiError.value = null;
                startAnalyzingMessages();

                try {
                    // Esperar a que la función global esté disponible (module async)
                    let attempts = 0;
                    while (!window.ejecutarDiagnostico && attempts < 20) {
                        await new Promise(r => setTimeout(r, 200));
                        attempts++;
                    }

                    if (!window.ejecutarDiagnostico) {
                        throw new Error('No se pudo cargar el módulo de IA. Recargá la página e intentá de nuevo.');
                    }

                    const result = await window.ejecutarDiagnostico(formData.value);

                    // Poblar resultados
                    solution.value = {
                        role: result.role || 'HR Manager Fraccional',
                        problem: result.problem || 'Problema no identificado',
                        impact: result.impact || 'Mejora en procesos y eficiencia',
                        hours: result.hours || '8 a 12 horas semanales',
                        matchCount: result.matchCount || '',
                    };
                    insights.value = result.insights || [];

                    // Guardar diagnóstico en DB
                    const save = await fetch('{{ route("fraccional.diagnostico.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            ...formData.value,
                            ai_role: result.role,
                            ai_problem: result.problem,
                            ai_impact: result.impact,
                            ai_hours: result.hours,
                            ai_insights: result.insights,
                            ai_match_count: result.matchCount,
                        }),
                    });
                    const saved = await save.json();
                    window._diagnosticId = saved.id;

                    stopAnalyzingMessages();
                    analyzing.value = false;
                    showResults.value = true;
                    setTimeout(() => { resultsVisible.value = true; }, 100);

                } catch (error) {
                    console.error('Error en diagnóstico IA:', error);
                    stopAnalyzingMessages();
                    analyzing.value = false;
                    showResults.value = true;
                    aiError.value = 'Error al generar el diagnóstico: ' + error.message;
                }
            }

            function goNext() {
                if (!canContinue.value) return;
                if (step.value === totalSteps) {
                    runDiagnostic();
                    return;
                }
                animating.value = true;
                setTimeout(() => {
                    step.value++;
                    animating.value = false;
                }, 200);
            }

            function goBack() {
                if (showResults.value) {
                    showResults.value = false;
                    resultsVisible.value = false;
                    aiError.value = null;
                    step.value = totalSteps;
                    return;
                }
                if (step.value === 1) return;
                animating.value = true;
                setTimeout(() => {
                    step.value--;
                    animating.value = false;
                }, 200);
            }

            function reset() {
                step.value = 1;
                showResults.value = false;
                resultsVisible.value = false;
                aiError.value = null;
                formData.value = { problem: '', size: '', industry: '', urgency: '', stage: '' };
                solution.value = { role: '', problem: '', impact: '', hours: '', matchCount: '' };
                insights.value = [];
            }

            function retryAnalysis() {
                showResults.value = false;
                aiError.value = null;
                runDiagnostic();
            }

            function verProfesionales() {
                // Despachar evento a Livewire para navegar
                if (window.Livewire) {
                    Livewire.dispatch('verProfesionales', {
                        role: solution.value.role,
                        formData: formData.value,
                    });
                }
                
                window.location.href = `{{ route("fraccional.index") }}?role=${encodeURIComponent(solution.value.role)}&diagnostic_id=${window._diagnosticId}`;
            }

            return {
                step, totalSteps, animating, showResults, analyzing, resultsVisible, dropdownOpen,
                formData, sizeOptions, industries, urgencyOptions, stageOptions,
                solution, insights, aiError, analyzingMessage,
                canContinue, progressPercent,
                goNext, goBack, reset, retryAnalysis, verProfesionales,
            };
        },
    });

    // Directiva v-click-outside
    app.directive('click-outside', {
        mounted(el, binding) {
            el.__clickOutside = (e) => {
                if (!el.contains(e.target)) binding.value();
            };
            document.addEventListener('click', el.__clickOutside);
        },
        unmounted(el) {
            document.removeEventListener('click', el.__clickOutside);
        },
    });

    app.mount('#pipol-diagnostico');
</script>