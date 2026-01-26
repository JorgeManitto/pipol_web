    <div class="modal" id="review-modal">
        <div class="modal-content m-auto">
            <div class="flex justify-center p-6">
                <h2 class="text-2xl font-bold text-[#2d5a4a] text-center">Deja tu Review</h2>
            </div>
            <div class="p-6 border-t border-b border-gray-200">
                <div class="flex items-center mb-4">
                    <img src="" alt="Avatar" class="w-16 h-16 rounded-full mr-4" id="avatar-modal-review">
                    <div>
                        <h3 class="text-xl font-semibold text-[#2d5a4a]" id="name-modal-review"></h3>
                        
                    </div>
                </div>
                <input type="hidden" name="session_id" id="session_id_review" value="">
                <div class="mb-2">
                    <label for="comment">Deja tu comentario(opcional)</label>
                    <textarea id="comment" class="w-full border border-gray-300 rounded-lg p-2 mt-1" rows="3" placeholder="Escribe tu comentario aquí..."></textarea>
                </div>
                <div class="mb-2">
                    <label for="rating">Deja tus estrellas</label>
                    <select id="rating" class="w-full border border-gray-300 rounded-lg p-2 mt-1">
                        <option value="1">1 estrella</option>
                        <option value="2">2 estrellas</option>
                        <option value="3">3 estrellas</option>
                        <option value="4">4 estrellas</option>
                        <option value="5">5 estrellas</option>
                    </select>
                </div>

            </div>
            
            <div class="flex items-center gap-4 flex-col md:flex-row p-6">
                <button onclick="closeReviewModal()" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium w-full">
                    Cerrar
                </button>
                <button class="px-6 py-3 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors font-medium w-full" onclick="setReview()">Enviar</button>
            </div>
            
        </div>
    </div>

    <script>
        function openReviewModal(sessionId, avatarUrl, name) {
            document.getElementById('session_id_review').value = sessionId;
            document.getElementById('avatar-modal-review').src = avatarUrl;
            document.getElementById('name-modal-review').textContent = name;
            document.getElementById('review-modal').style.display = 'block';
        }
        function closeReviewModal() {
            document.getElementById('review-modal').style.display = 'none';
        }
        function setReview() {
            const sessionId = document.getElementById('session_id_review').value;
            const comment = document.getElementById('comment').value;
            const rating = document.getElementById('rating').value;

            fetch("{{ route('sessions.review') }}", {
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
                closeReviewModal();
            })
            .catch(error => {
                alert(error.message);
            });
        }

    </script>