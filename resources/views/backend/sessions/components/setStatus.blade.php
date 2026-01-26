    <div class="modal" id="status-modal">
        <div class="modal-content m-auto">
            <div class="flex justify-center p-6">
                <h2 class="text-2xl font-bold text-[#2d5a4a] text-center">Deja tu status</h2>
            </div>
            <div class="p-6 border-t border-b border-gray-200">
                <div class="flex items-center mb-4">
                    <img src="" alt="Avatar" class="w-16 h-16 rounded-full mr-4" id="avatar-modal-status">
                    <div>
                        <h3 class="text-xl font-semibold text-[#2d5a4a]" id="name-modal-status"></h3>
                        
                    </div>
                </div>
                <input type="hidden" name="session_id" id="session_id" value="">
            </div>
            
            <div class="flex items-center gap-4 flex-col md:flex-row p-6">
                <button onclick="closeStatusModal()" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium w-full">
                    Cerrar
                </button>
                <button class="px-6 py-3 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors font-medium w-full" onclick="setStatus()">Enviar</button>
            </div>
            
        </div>
    </div>

    <script>
        function openStatusModal(sessionId, avatarUrl, name) {
            document.getElementById('session_id_status').value = sessionId;
            document.getElementById('avatar-modal-status').src = avatarUrl;
            document.getElementById('name-modal-status').textContent = name;
            document.getElementById('status-modal').style.display = 'block';
        }
        function closeStatusModal() {
            document.getElementById('status-modal').style.display = 'none';
        }
        function setstatus() {
            const sessionId = document.getElementById('session_id_status').value;
            const comment = document.getElementById('comment').value;
            const rating = document.getElementById('rating').value;

            fetch("{{ route('sessions.status') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    comment: comment,
                    rating: rating
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => { throw new Error(data.status || 'Error al enviar la reseña.'); });
                }
                return response.json();
            })
            .then(data => {
                alert('Reseña enviada con éxito.');
                closestatusModal();
            })
            .catch(error => {
                alert(error.message);
            });
        }

    </script>