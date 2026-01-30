<div class="relative bg-white p-6 rounded-2xl shadow-lg mb-6 hidden lg:block border border-gray-100" style="max-height: 650px;">
     @php
        $rangos = [
            'BRONZE'   => 0,
            'SILVER'   => 5,
            'GOLD'     => 10,
            'PLATINUM' => 20,
            'HERO'     => 30,
        ];
        // dd(request()->all());
    @endphp 
    <form action="">
        <!-- Header -->
        <div class="mb-6 pb-4 border-b border-gray-100">
            <h2 class="text-2xl font-semibold text-gray-800">Buscar mentor</h2>
            <p class="text-sm text-gray-500 mt-1">Encuentra el mentor ideal para ti</p>
        </div>

        <!-- Search Input -->
        <div class="mb-5">
            <label for="q" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" value="{{ request('q')}}" placeholder="Juan Cruz Pérez" class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#1a0a3e] focus:ring-2 focus:ring-[#1a0a3e]/20 focus:outline-none text-gray-700 transition-all">
            </div>
        </div>

        <!-- Filters Grid -->
        <div class="grid grid-cols-2 gap-4 mb-5">
            <!-- Area -->
            <div>
                <label for="area" class="block text-sm font-medium text-gray-700 mb-2">Área</label>
                <select name="area" id="area" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#1a0a3e] focus:ring-2 focus:ring-[#1a0a3e]/20 focus:outline-none text-gray-700 bg-white cursor-pointer transition-all appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2220%22%20height%3D%2220%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%236b7280%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_1rem_center]">
                    <option value="">Seleccionar</option>
                    <option value="">Tecnología</option>
                    <option value="">Negocios</option>
                </select>
            </div>

            <!-- Calificación -->
            <div>
                <label for="stars" class="block text-sm font-medium text-gray-700 mb-2">Calificación</label>
                <select name="stars" id="stars" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#1a0a3e] focus:ring-2 focus:ring-[#1a0a3e]/20 focus:outline-none text-gray-700 bg-white cursor-pointer transition-all appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2220%22%20height%3D%2220%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%236b7280%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_1rem_center]">
                    <option value="">Seleccionar</option>
                    {{-- <option value="5">⭐ 5 estrellas</option>
                    <option value="4">⭐ 4+ estrellas</option> --}}
                    <option @selected(request()->stars == "5" ) value="5">⭐ 5 estrellas</option>
                    <option @selected(request()->stars == "4" ) value="4"> ⭐ 4+ estrellas</option>
                </select>
            </div>

            <!-- Nivel -->
            <div>
                <label for="lvl" class="block text-sm font-medium text-gray-700 mb-2">Nivel</label>
                <select name="lvl" id="lvl" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#1a0a3e] focus:ring-2 focus:ring-[#1a0a3e]/20 focus:outline-none text-gray-700 bg-white cursor-pointer transition-all appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2220%22%20height%3D%2220%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%236b7280%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_1rem_center]">
                    <option value="">Seleccionar</option>
                    @foreach ($rangos as $key => $item)
                        <option value="{{ $key }}">{{ $key }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Seniority -->
            <div>
                <label for="seniority" class="block text-sm font-medium text-gray-700 mb-2">Seniority</label>
                <select name="seniority" id="seniority" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#1a0a3e] focus:ring-2 focus:ring-[#1a0a3e]/20 focus:outline-none text-gray-700 bg-white cursor-pointer transition-all appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2220%22%20height%3D%2220%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%236b7280%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_1rem_center]">
                    <option value="">Seleccionar</option>
                    <option @selected(request()->seniority == "Jefe" ) value="Jefe">Jefe</option>
                    <option @selected(request()->seniority == "Gerente" ) value="Gerente">Gerente</option>
                    <option @selected(request()->seniority == "Director" ) value="Director">Director</option>
                    <option @selected(request()->seniority == "CEO" ) value="CEO">CEO</option>
                    <option @selected(request()->seniority == "Emprendedor" ) value="Emprendedor">Emprendedor</option>
                    <option @selected(request()->seniority == "Director" ) value="Director">Director</option>
                </select>
            </div>
        </div>

        <!-- Price Sort -->
        <div class="mb-6">
            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Ordenar por precio</label>
            <select name="price" id="price" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#1a0a3e] focus:ring-2 focus:ring-[#1a0a3e]/20 focus:outline-none text-gray-700 bg-white cursor-pointer transition-all appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2220%22%20height%3D%2220%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%236b7280%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_1rem_center]">
                <option value="asc">Menor a mayor</option>
                <option value="desc">Mayor a menor</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button type="submit" class="flex-1 px-6 py-3 bg-[#1a0a3e] text-white font-medium rounded-xl hover:bg-[#1a0a3ee8] active:scale-[0.98] transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Buscar
            </button>
            <a href="{{ route('mentors.index') }}" type="reset" class="px-4 py-3 border border-gray-200 text-gray-600 font-medium rounded-xl hover:bg-gray-50 active:scale-[0.98] transition-all">
                Limpiar
            </a>
        </div>
    </form>
</div>
<!-- Versión Mobile (visible solo en pantallas pequeñas) -->
<div class="bg-white p-4 rounded-xl shadow-lg mb-4 lg:hidden border border-gray-100">
    <form action="">
        <!-- Header con toggle -->
        <details class="group">
            <summary class="flex items-center justify-between cursor-pointer list-none mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Buscar mentor</h2>
                    <p class="text-xs text-gray-500">Toca para ver filtros</p>
                </div>
                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center group-open:rotate-180 transition-transform">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </summary>

            <div class="space-y-4 pt-2 border-t border-gray-100">
                <!-- Search Input -->
                <div>
                    <label for="q-mobile" class="block text-sm font-medium text-gray-700 mb-1.5">Nombre</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="q" id="q-mobile" value="{{ request('q')}}" placeholder="Juan Cruz Pérez" class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 focus:border-[#1a0a3e] focus:ring-2 focus:ring-[#1a0a3e]/20 focus:outline-none text-sm text-gray-700 transition-all">
                    </div>
                </div>

                <!-- Area y Calificación -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="area-mobile" class="block text-sm font-medium text-gray-700 mb-1.5">Área</label>
                        <select name="area" id="area-mobile" class="w-full px-3 py-2.5 rounded-lg border border-gray-200 focus:border-[#1a0a3e] focus:ring-2 focus:ring-[#1a0a3e]/20 focus:outline-none text-sm text-gray-700 bg-white cursor-pointer transition-all appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%236b7280%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_0.75rem_center]">
                            <option value="">Seleccionar</option>
                            <option value="">Tecnología</option>
                            <option value="">Negocios</option>
                        </select>
                    </div>
                    <div>
                        <label for="stars-mobile" class="block text-sm font-medium text-gray-700 mb-1.5">Calificación</label>
                        <select name="stars" id="stars-mobile" class="w-full px-3 py-2.5 rounded-lg border border-gray-200 focus:border-[#1a0a3e] focus:ring-2 focus:ring-[#1a0a3e]/20 focus:outline-none text-sm text-gray-700 bg-white cursor-pointer transition-all appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%236b7280%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_0.75rem_center]">
                            <option value="">Seleccionar</option>
                            <option @selected(request()->stars == "5" ) value="5">⭐ 5 estrellas</option>
                            <option @selected(request()->stars == "4" ) value="4">⭐ 4+ estrellas</option>
                        </select>
                    </div>
                </div>

                <!-- Nivel y Seniority -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                       
                        <label for="lvl-mobile" class="block text-sm font-medium text-gray-700 mb-1.5">Nivel</label>
                        <select name="lvl" id="lvl-mobile" class="w-full px-3 py-2.5 rounded-lg border border-gray-200 focus:border-[#1a0a3e] focus:ring-2 focus:ring-[#1a0a3e]/20 focus:outline-none text-sm text-gray-700 bg-white cursor-pointer transition-all appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%236b7280%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_0.75rem_center]">
                            @foreach ($rangos as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="seniority-mobile" class="block text-sm font-medium text-gray-700 mb-1.5">Seniority</label>
                        <select name="seniority" id="seniority-mobile" class="w-full px-3 py-2.5 rounded-lg border border-gray-200 focus:border-[#1a0a3e] focus:ring-2 focus:ring-[#1a0a3e]/20 focus:outline-none text-sm text-gray-700 bg-white cursor-pointer transition-all appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%236b7280%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_0.75rem_center]">
                            <option value="">Seleccionar</option>
                            <option @selected(request()->seniority == "Jefe" ) value="Jefe">Jefe</option>
                            <option @selected(request()->seniority == "Gerente" ) value="Gerente">Gerente</option>
                            <option @selected(request()->seniority == "Director" ) value="Director">Director</option>
                            <option @selected(request()->seniority == "CEO" ) value="CEO">CEO</option>
                            <option @selected(request()->seniority == "Emprendedor" ) value="Emprendedor">Emprendedor</option>
                            <option @selected(request()->seniority == "Director" ) value="Director">Director</option>
                        </select>
                    </div>
                </div>

                <!-- Precio -->
                <div>
                    <label for="price-mobile" class="block text-sm font-medium text-gray-700 mb-1.5">Ordenar por precio</label>
                    <select name="price" id="price-mobile" class="w-full px-3 py-2.5 rounded-lg border border-gray-200 focus:border-[#1a0a3e] focus:ring-2 focus:ring-[#1a0a3e]/20 focus:outline-none text-sm text-gray-700 bg-white cursor-pointer transition-all appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%236b7280%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_0.75rem_center]">
                        <option value="asc">Menor a mayor</option>
                        <option value="desc">Mayor a menor</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-[#1a0a3e] text-white text-sm font-medium rounded-lg hover:bg-[#1a0a3ee8] active:scale-[0.98] transition-all shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Buscar
                    </button>
                    <button type="reset" class="px-4 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 active:scale-[0.98] transition-all">
                        Limpiar
                    </button>
                </div>
            </div>
        </details>
    </form>
</div>