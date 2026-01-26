    <div class="modal" id="perfil-modal">
        <div class="modal-content m-auto">
            <div class="flex justify-center p-6">
                <h2 class="text-2xl font-bold text-[#2d5a4a] text-center">Perfil de Mentor</h2>
            </div>

            <div class="p-6">
                <div class="flex items-start gap-4 mb-5">
                    <img src="{{ asset('images/default-avatar.png') }}" class="w-14 h-14 rounded-full object-cover flex-shrink-0" id="avatar-modal-perfil">
                    <div class="flex-1">
                        <div class="flex items-baseline gap-2 mb-1">
                            <div>
                                <h3 class="font-semibold text-lg text-gray-900 hover:text-[#2d5a4a] transition-colors" id="nombre-modal-perfil">Nombre del Mentor</h3>
                            </div>
                            <svg class="w-4 h-4 text-[#d4af6a]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zM9 10.586l1.293 1.293a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600 mb-2" id="profesion-modal-perfil">Profesión</p>
                        <div class="flex items-center gap-1 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                            </svg>
                            <span>Español</span>
                        </div>
                       
                       
                    </div>
                </div>
                <div class="mb-2" id="bio-modal-perfil"></div>
                <div class="mb-2" >
                    <p class="text-xs text-gray-500 mb-2">Experiencia: <span class="text-sm text-gray-500" id="experiencia-modal-perfil"></span></p>
                    
                </div>
                <div class="mb-2" id="reviews-modal-perfil">
                    <p class="text-xs text-gray-500 mb-2">Reviews:</p>
                    <div class="max-h-32 overflow-y-auto p-2 border border-gray-200 rounded-lg">
                        <p class="text-sm text-gray-500">No hay reviews disponibles.</p>
                    </div>
                </div>
                <div class="mb-2" id="calificación-modal-perfil"></div>
                <div class="mb-2" id="nivel-modal-perfil"></div>
                <div class="flex items-center justify-between mt-4">
                    <div class="mb-5">
                        <p class="text-xs text-gray-500 mb-2">Especialidades:</p>
                        <div class="flex flex-wrap gap-2" id="especialidades-modal-perfil">
                            <div class="px-3 py-1 bg-[#f5f0e8] text-[#2d5a4a] text-xs rounded-full hover:bg-[#e8dfcc] transition-colors tag"></div>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-[#2d5a4a] mb-4 pt-2 text-left" id="precio-modal-perfil"></p>
                </div>
            </div>

            <div class="flex items-center gap-4 flex-col md:flex-row p-6">
                <button onclick="closePerfilModal()" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium w-full">
                    Cerrar
                </button>
                <button class="px-6 py-3 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors font-medium w-full" onclick="setSession()">Agendar sesión</button>
            </div>
            
        </div>
    </div>

    <script>
        const modalPerfil = document.getElementById('perfil-modal');
        function closePerfilModal() {
            modalPerfil.style.display = 'none';
        }
        let pivotMentor;
        let pivotCurrency;
        let pivotAvatar;

        function openPerfilModal(mentorPerfil, avatar, currency) {
            console.log(mentorPerfil);
            
            const mentor = mentorPerfil;
            pivotMentor = mentor;
            pivotCurrency = currency;
            pivotAvatar = avatar;

            modalPerfil.style.display = 'flex';
           
            document.getElementById('nombre-modal-perfil').innerText = mentor.name;
            document.getElementById('profesion-modal-perfil').innerText = mentor.profession;
            document.getElementById('precio-modal-perfil').innerText = currency;
            document.getElementById('avatar-modal-perfil').src = avatar;
            document.getElementById('bio-modal-perfil').innerText = mentor.bio || '';
            if (mentor.years_of_experience) {
                document.getElementById('experiencia-modal-perfil').innerText = mentor.years_of_experience + ' años de experiencia en ' + mentor.companies || '';
            }else{
                document.getElementById('experiencia-modal-perfil').innerText = 'No hay experiencia disponible.';
            }

            const especialidadesModalPerfil = document.getElementById('especialidades-modal-perfil');
            especialidadesModalPerfil.innerHTML = '';
            if (mentor.sectors && mentor.sectors.length > 0) {
                let specialty =  mentor.sectors.split(',')

                specialty.forEach(function(specialty) {
                    const tag = document.createElement('div');
                    tag.className = 'px-3 py-1 bg-[#f5f0e8] text-[#2d5a4a] text-xs rounded-full hover:bg-[#e8dfcc] transition-colors tag';
                    tag.innerText = specialty;
                    especialidadesModalPerfil.appendChild(tag);
                });
            } else {
                especialidadesModalPerfil.innerHTML = '<p class="text-sm text-gray-500">No hay especialidades disponibles.</p>';
            }
            // console.log(mentor);
            
        }
        function setSession() {
            modalPerfil.style.display = 'none';
            console.log(pivotMentor.id, pivotMentor.name, pivotMentor.profession, pivotCurrency, pivotAvatar, '{{ auth()->id() }}', pivotMentor.hourly_rate, pivotMentor.currency);
            
            openModal(pivotMentor.id, pivotMentor.name, pivotMentor.profession, pivotCurrency, pivotAvatar, '{{ auth()->id() }}', pivotMentor.hourly_rate, pivotMentor.currency);
        }
        

        // openModal(
        //                         '{{ $mentor->id }}',
        //                         '{{ $mentor->name }} {{ $mentor->last_name }}',
        //                         '{{ $mentor->profession }}',
        //                         '{{ $mentor->currency }} {{ number_format($mentor->hourly_rate, 2) }}',
        //                         '{{ $mentor->avatar ? asset('storage/avatars/'.$mentor->avatar) : asset('images/default-avatar.png') }}',
        //                         '{{ auth()->id() }}',
        //                         '{{ $mentor->hourly_rate }}',
        //                         '{{ $mentor->currency }}'
        //                     )"


    </script>