<div class="modal" id="perfil-modal">
        <div class="modal-content m-auto">
            <div class="flex justify-center p-2">
                <h2 class="text-2xl font-bold text-[#1a0a3e] text-center">Perfil de Mentor</h2>
            </div>

            <div class="px-6 py-2">
                <div class="flex items-start gap-4 mb-5">
                    <img src="{{ asset('images/default-avatar.png') }}" class="w-14 h-14 md:w-32 md:h-32 rounded-full object-fill flex-shrink-0" id="avatar-modal-perfil">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-semibold text-md text-gray-900 hover:text-[#1a0a3ee8] transition-colors" id="nombre-modal-perfil">Nombre del Mentor</h3>
                            
                            {{-- Badge de rango (se llena dinámicamente) --}}
                            <span 
                                id="rango-badge-modal-perfil"
                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                style="display: none;"
                            >
                                <span id="rango-icon-modal-perfil"></span>
                                <span id="rango-nombre-modal-perfil"></span>
                            </span>
                        </div>
                        
                        <p class="text-xs text-gray-600 mb-1" id="profesion-modal-perfil">Educación</p>
                        <div class="flex items-center gap-1 text-xs text-gray-500">
                            <span id="modal-languages">Español</span>
                        </div>
                        @auth
                            <a id="sendMessage" class="inline-block mt-2 px-4 py-2 border border-[#1a0a3e] text-[#1a0a3e] bg-transparent rounded-lg hover:bg-[#1a0a3ee8] hover:text-white transition-colors font-medium text-xs cursor-pointer">Enviar mensaje</a>
                        @else
                            <a href="{{ route('dashboard') }}" disabled id="sendMessage" class="inline-block mt-2 px-4 py-2 border border-[#1a0a3e] text-[#1a0a3e] bg-transparent rounded-lg hover:bg-[#1a0a3ee8] hover:text-white transition-colors font-medium text-xs cursor-pointer">Enviar mensaje</a>
                        @endauth
                    </div>
                </div>

                <div class="mb-2">
                    <p class="text-gray-700 text-xs" id="bio-modal-perfil"></p>
                </div>

                <div class="mb-2">
                    <p class="text-xs text-gray-500 mb-2">Modalidad de atención</p>
                    <div class="flex items-center gap-2 text-xs text-gray-700">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>Online</span>
                    </div>
                </div>
               
                <div class="mb-2">
                    <p class="text-xs text-gray-500">Experiencia: <span class="text-xs text-gray-700" id="experiencia-modal-perfil"></span></p>
                    <a id="linkedin_url-modal-perfil" target="_blank" class="text-blue-500 text-xs hover:underline">Linkedin</a>
                </div>

                {{-- Reviews section --}}
                <div class="mb-2" id="reviews-modal-perfil">
                    <p class="text-xs text-gray-500 mb-2">Reviews:</p>
                    <div class="max-h-48 overflow-y-auto space-y-3 p-2 border border-gray-200 rounded-lg" id="reviews-list-modal-perfil">
                        <p class="text-xs text-gray-500">No hay reviews disponibles.</p>
                    </div>
                </div>

                <div class="mb-2" id="calificación-modal-perfil"></div>
                <div class="mb-2" id="nivel-modal-perfil"></div>

                <div class="flex items-center justify-between mt-4">
                    <div class="mb-5">
                        {{-- <p class="text-xs text-gray-500 mb-2">Especialidades:</p>
                        <div class="flex flex-wrap gap-1" id="especialidades-modal-perfil">
                        </div> --}}
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Valor hora</p>
                        <p class="text-2xl font-semibold text-[#1a0a3e] mb-4 text-left" id="precio-modal-perfil"></p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4 flex-col md:flex-row p-6">
                <button onclick="closePerfilModal()" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium w-full text-sm">
                    Cerrar
                </button>
                @auth
                    <button class="px-6 py-3 bg-[#1a0a3e] text-white rounded-lg hover:bg-[#1a0a3ee8] transition-colors font-medium w-full text-sm" onclick="setSession()">Agendar sesión</button>
                @else
                 <a href="{{ route('dashboard') }}" class="px-6 text-center py-3 bg-[#1a0a3e] text-white rounded-lg hover:bg-[#1a0a3ee8] transition-colors font-medium w-full text-sm">Agendar sesión</a>
                @endauth
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
        let pivotAvailabilities;
        const sendMessage = document.getElementById('sendMessage');

        let pivotConfirmedSessions; 

        /**
         * Genera el HTML de estrellas para un rating dado (1-5)
         */
        function renderStars(rating, maxStars = 5) {
            let html = '';
            for (let i = 1; i <= maxStars; i++) {
                const colorClass = i <= Math.floor(rating) ? 'text-yellow-400' : 'text-gray-300';
                html += `<svg class="w-3 h-3 ${colorClass}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.287 3.953c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.54-1.118l1.287-3.953a1 1 0 00-.364-1.118L2.316 9.38c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.953z"/>
                </svg>`;
            }
            return html;
        }

        /**
         * Renderiza la lista de reviews en el modal
         */
        function renderReviews(reviews) {
            const container = document.getElementById('reviews-list-modal-perfil');
            container.innerHTML = '';

            if (!reviews || reviews.length === 0) {
                container.innerHTML = '<p class="text-xs text-gray-500">No hay reviews disponibles.</p>';
                return;
            }

            reviews.forEach(review => {
                const reviewEl = document.createElement('div');
                reviewEl.className = 'pb-3 border-b border-gray-100 last:border-0 last:pb-0';
                reviewEl.innerHTML = `
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center gap-0.5">
                            ${renderStars(review.rating)}
                            <span class="text-xs text-gray-700 font-semibold ml-1">${review.rating}/5</span>
                        </div>
                        <span class="text-xs text-gray-400">${review.created_at}</span>
                    </div>
                    ${review.comment ? `<p class="text-xs text-gray-700">${review.comment}</p>` : ''}
                `;
                container.appendChild(reviewEl);
            });
        }

        function openPerfilModal(mentorPerfil, avatar, currency, availabilities = [], confirmedSessions = [], linkedin_url, rango = null, reviews = []) { 
            const mentor = mentorPerfil;
            countViewProfile(mentor.id);
            
            sendMessage.href = '/new-conversation/' + mentor.id;
            pivotMentor = mentor;
            pivotLinkedin_url = linkedin_url;
            pivotCurrency = currency;
            pivotAvatar = avatar;
            pivotAvailabilities = availabilities;
            pivotConfirmedSessions = confirmedSessions;

            modalPerfil.style.display = 'flex';
        
            document.getElementById('nombre-modal-perfil').innerText = mentor.name;
            document.getElementById('profesion-modal-perfil').innerText = mentor.education;
            document.getElementById('modal-languages').innerText = mentor.languages;
            
            document.getElementById('precio-modal-perfil').innerText = currency;
            document.getElementById('avatar-modal-perfil').src = avatar;
            document.getElementById('bio-modal-perfil').innerText = mentor.bio || '';
            document.getElementById('linkedin_url-modal-perfil').innerText = mentor.linkedin_url || '';
            document.getElementById('linkedin_url-modal-perfil').href = mentor.linkedin_url || '';
            if (mentor.years_of_experience) {
                document.getElementById('experiencia-modal-perfil').innerText = mentor.years_of_experience + ' años de experiencia en ' + mentor.companies || '';
            } else {
                document.getElementById('experiencia-modal-perfil').innerText = 'No hay experiencia disponible.';
            }

            // Renderizar badge de rango
            const rangoBadge = document.getElementById('rango-badge-modal-perfil');
            const rangoIcon = document.getElementById('rango-icon-modal-perfil');
            const rangoNombre = document.getElementById('rango-nombre-modal-perfil');

            if (rango && rango.nombre) {
                rangoIcon.textContent = rango.icon;
                rangoNombre.textContent = rango.nombre;
                rangoBadge.style.display = 'inline-flex';
                rangoBadge.style.backgroundColor = rango.bg;
                rangoBadge.style.color = rango.color;
                rangoBadge.style.border = `1px solid ${rango.color}20`;
            } else {
                rangoBadge.style.display = 'none';
            }

            // Renderizar reviews
            renderReviews(reviews);

            // Renderizar especialidades como tags
            const especialidadesContainer = document.getElementById('especialidades-modal-perfil');
            especialidadesContainer.innerHTML = '';
            if (mentor.skills && mentor.skills.length > 0) {
                mentor.skills.forEach(skill => {
                    const tag = document.createElement('a');
                    tag.className = 'px-2 py-1 bg-[#f5f0e8] text-[#1a0a3e] text-xs rounded-full hover:bg-[#1a0a3ee8] hover:text-white transition-colors tag cursor-pointer';
                    tag.textContent = skill.name;
                    tag.href = '?skill=' + skill.id;
                    especialidadesContainer.appendChild(tag);
                });
            }
        }
    
        function setSession() {
            modalPerfil.style.display = 'none';
            
            openModal(
                pivotMentor.id, 
                pivotMentor.name, 
                pivotMentor.education, 
                pivotCurrency, 
                pivotAvatar, 
                '{{ auth()->id() }}', 
                pivotMentor.hourly_rate, 
                pivotMentor.currency,
                pivotAvailabilities,
                pivotConfirmedSessions
            );
        }
        function countViewProfile(mentorId) {
            fetch('{{ route("mentors.countViewProfile") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ mentor_id: mentorId })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
            })
            .catch(error => {
                console.error('Error al contar la vista del perfil:', error);
            });
        }
    </script>