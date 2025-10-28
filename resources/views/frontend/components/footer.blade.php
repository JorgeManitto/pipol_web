    <!-- Footer -->
    <!--  Enhanced footer with better spacing and typography -->
    <footer class="py-16 px-4 section-darker border-t" style="border-color: rgba(147, 21, 255, 0.2);">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <h3 class="text-3xl font-black gradient-text mb-6">pipol</h3>
                    <p class="text-gray-400 leading-relaxed text-lg">
                        Construimos puentes entre generaciones y democratizamos el valor de la experiencia.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6">Plataforma</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#que-es" class="hover:text-white transition-colors text-lg">Qué es Pipol</a></li>
                        <li><a href="#como-funciona" class="hover:text-white transition-colors text-lg">Cómo funciona</a></li>
                        <li><a href="#soy-mentor" class="hover:text-white transition-colors text-lg">Ser mentor</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6">Soporte</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#faq" class="hover:text-white transition-colors text-lg">Preguntas frecuentes</a></li>
                        <li><a href="#contacto" class="hover:text-white transition-colors text-lg">Contacto</a></li>
                        <li><a href="#" class="hover:text-white transition-colors text-lg">Ayuda</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6">Legal</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors text-lg">Términos y condiciones</a></li>
                        <li><a href="#" class="hover:text-white transition-colors text-lg">Política de privacidad</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t pt-10 text-center text-gray-400" style="border-color: rgba(147, 21, 255, 0.2);">
                <p class="text-lg">&copy; 2025 Pipol. Todos los derechos reservados.</p>
                <p class="mt-3 italic text-base">Cuando la experiencia se comparte, todos crecemos.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // FAQ accordion
        const faqQuestions = document.querySelectorAll('.faq-question');

        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const icon = question.querySelector('.faq-icon');

                answer.classList.toggle('hidden');
                icon.style.transform = answer.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    mobileMenu.classList.add('hidden');
                }
            });
        });
    </script>