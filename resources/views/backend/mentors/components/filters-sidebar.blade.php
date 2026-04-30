<style>
    * {
        font-family: 'Inter', sans-serif;
    }
    .section-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: .5rem;
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: .5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .form-group {
        margin-bottom: .5rem;
    }
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.3rem;
    }
    .form-label.required::after {
        content: " *";
        color: #ef4444;
    }
    .form-input {
        width: 100%;
        padding: .5rem;
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
    .form-select {
        width: 100%;
        padding: .5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s;
        background-color: white;
        cursor: pointer;
        appearance: none;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2220%22%20height%3D%2220%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%236b7280%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E');
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
    }
    .form-select:focus {
        outline: none;
        border-color: #2d5a4a;
        box-shadow: 0 0 0 3px rgba(45, 90, 74, 0.1);
    }
    .btn-primary-edit {
        background: #8B5CF6;
        color: white;
        padding: 0.5em 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-primary-edit:hover {
        background: #8B5CF6e8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 90, 74, 0.3);
    }
    .btn-secondary {
        background: #e5e7eb;
        color: #374151;
        padding: 0.5em 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
    }
    .btn-secondary:hover {
        background: #d1d5db;
    }
    .help-text {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.375rem;
    }
    .filters-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0;
    }
    @media (max-width: 640px) {
        .filters-grid {
            grid-template-columns: 1fr;
        }
    }
    .btn-group {
        display: flex;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }
    .btn-group .btn-primary-edit {
        flex: 1;
        justify-content: center;
    }
    /* Toggle mobile */
    .filter-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        list-style: none;
    }
    .filter-toggle::-webkit-details-marker {
        display: none;
    }
    .toggle-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s;
    }
    details[open] .toggle-icon {
        transform: rotate(180deg);
    }
    .filter-content {
        padding-top: 0.75rem;
        border-top: 2px solid #f3f4f6;
        margin-top: 0.75rem;
    }
</style>

@php
    $rangos = [
        'BRONZE'   => 0,
        'SILVER'   => 5,
        'GOLD'     => 10,
        'PLATINUM' => 20,
        'HERO'     => 30,
    ];
@endphp

<!-- Versión Desktop -->
<div class="section-card hidden lg:block" style="max-height: 580px;">
    <form action="">
        <div class="section-title">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Buscar mentor
        </div>
        <p class="help-text" style="margin-top: -0.25rem; margin-bottom: 0.75rem;">Encuentra el mentor ideal para ti</p>

        <!-- Nombre -->
        <div class="form-group">
            <label for="q" class="form-label">Nombre</label>
            <div style="position: relative;">
                <svg style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);" class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Juan Cruz Pérez" class="form-input" style="padding-left: 2.5rem;">
            </div>
        </div>

        <!-- Filters Grid -->
        <div class="filters-grid">
            <div class="form-group">
                <label for="area" class="form-label">Área</label>
                <select name="area" id="area" class="form-select">
                    <option value="">Seleccionar</option>
                    <option value="">Tecnología</option>
                    <option value="">Negocios</option>
                </select>
            </div>

            <div class="form-group">
                <label for="stars" class="form-label">Calificación</label>
                <select name="stars" id="stars" class="form-select">
                    <option value="">Seleccionar</option>
                    <option @selected(request()->stars == "5") value="5">⭐ 5 estrellas</option>
                    <option @selected(request()->stars == "4") value="4">⭐ 4+ estrellas</option>
                </select>
            </div>

            <div class="form-group">
                <label for="lvl" class="form-label">Nivel</label>
                <select name="lvl" id="lvl" class="form-select">
                    <option value="">Seleccionar</option>
                    @foreach ($rangos as $key => $item)
                        <option value="{{ $key }}">{{ $key }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="seniority" class="form-label">Seniority</label>
                <select name="seniority" id="seniority" class="form-select">
                    <option value="">Seleccionar</option>
                    <option @selected(request()->seniority == "Jefe") value="Jefe">Jefe</option>
                    <option @selected(request()->seniority == "Gerente") value="Gerente">Gerente</option>
                    <option @selected(request()->seniority == "Director") value="Director">Director</option>
                    <option @selected(request()->seniority == "CEO") value="CEO">CEO</option>
                    <option @selected(request()->seniority == "Emprendedor") value="Emprendedor">Emprendedor</option>
                </select>
            </div>
        </div>

        <!-- Precio -->
        <div class="form-group">
            <label for="price" class="form-label">Ordenar por precio</label>
            <select name="price" id="price" class="form-select">
                <option value="asc">Menor a mayor</option>
                <option value="desc">Mayor a menor</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="btn-group">
            <button type="submit" class="btn-primary-edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Buscar
            </button>
            <a href="{{ route('mentors.index') }}" class="btn-secondary">
                Limpiar
            </a>
        </div>
    </form>
</div>

<!-- Versión Mobile -->
<div class="section-card lg:hidden">
    <form action="">
        <details class="group">
            <summary class="filter-toggle">
                <div>
                    <h2 style="font-size: 1.125rem; font-weight: 700; color: #1f2937;">Buscar mentor</h2>
                    <p class="help-text">Toca para ver filtros</p>
                </div>
                <div class="toggle-icon">
                    <svg class="w-5 h-5" style="color: #4b5563;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </summary>

            <div class="filter-content">
                <!-- Nombre -->
                <div class="form-group">
                    <label for="q-mobile" class="form-label">Nombre</label>
                    <div style="position: relative;">
                        <svg style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);" class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="q" id="q-mobile" value="{{ request('q') }}" placeholder="Juan Cruz Pérez" class="form-input" style="padding-left: 2.5rem;">
                    </div>
                </div>

                <!-- Area y Calificación -->
                <div class="filters-grid">
                    <div class="form-group">
                        <label for="area-mobile" class="form-label">Área</label>
                        <select name="area" id="area-mobile" class="form-select">
                            <option value="">Seleccionar</option>
                            <option value="">Tecnología</option>
                            <option value="">Negocios</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stars-mobile" class="form-label">Calificación</label>
                        <select name="stars" id="stars-mobile" class="form-select">
                            <option value="">Seleccionar</option>
                            <option @selected(request()->stars == "5") value="5">⭐ 5 estrellas</option>
                            <option @selected(request()->stars == "4") value="4">⭐ 4+ estrellas</option>
                        </select>
                    </div>
                </div>

                <!-- Nivel y Seniority -->
                <div class="filters-grid">
                    <div class="form-group">
                        <label for="lvl-mobile" class="form-label">Nivel</label>
                        <select name="lvl" id="lvl-mobile" class="form-select">
                            <option value="">Seleccionar</option>
                            @foreach ($rangos as $key => $item)
                                <option value="{{ $key }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="seniority-mobile" class="form-label">Seniority</label>
                        <select name="seniority" id="seniority-mobile" class="form-select">
                            <option value="">Seleccionar</option>
                            <option @selected(request()->seniority == "Jefe") value="Jefe">Jefe</option>
                            <option @selected(request()->seniority == "Gerente") value="Gerente">Gerente</option>
                            <option @selected(request()->seniority == "Director") value="Director">Director</option>
                            <option @selected(request()->seniority == "CEO") value="CEO">CEO</option>
                            <option @selected(request()->seniority == "Emprendedor") value="Emprendedor">Emprendedor</option>
                        </select>
                    </div>
                </div>

                <!-- Precio -->
                <div class="form-group">
                    <label for="price-mobile" class="form-label">Ordenar por precio</label>
                    <select name="price" id="price-mobile" class="form-select">
                        <option value="asc">Menor a mayor</option>
                        <option value="desc">Mayor a menor</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="btn-group">
                    <button type="submit" class="btn-primary-edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Buscar
                    </button>
                    <button type="reset" class="btn-secondary">
                        Limpiar
                    </button>
                </div>
            </div>
        </details>
    </form>
</div>