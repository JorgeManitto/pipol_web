<div>
    <script type="module">
            import { GoogleGenerativeAI } from "https://esm.run/@google/generative-ai";

            // Configuración
            const API_KEY = "{{ env('GEMINI_API_KEY') }}";
            const genAI = new GoogleGenerativeAI(API_KEY);

            // window.ejecutarGemini = async function(e) {
            //     try {
            //         const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });

            //         const prompt =
            //             "Con estos datos devuelve una biografia en español de no más de 200 palabras. " +
            //             "Es importante que la biografia esté en primera persona, suene profesional y atractiva para posibles clientes que busquen un mentor en la plataforma. " +
            //             "Los datos son: " + JSON.stringify(e.data) +
            //             ". Solo retorna la biografia sin ningún otro texto adicional.";

            //         const result = await model.generateContent(prompt);
            //         const response = result.response;

            //         console.log(response.text());

            //     } catch (error) {
            //         console.error(error);
            //     } finally {
                    
            //     }

            // }
            window.ejecutarGemini = async function(e) {
                try {
                    const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });

                    const prompt =
                        "Con estos datos devuelve una biografia en español de no más de 200 palabras. " +
                        "Es importante que la biografia esté en primera persona, suene profesional y atractiva. " +
                        "Los datos son: " + JSON.stringify(e.data) +
                        ". Solo retorna la biografia sin ningún otro texto adicional.";

                    const result = await model.generateContent(prompt);
                    const response = result.response.text();

                    // 🔁 Volver a Livewire con la bio
                    Livewire.dispatch('bioGenerada', { bio: response });

                } catch (error) {
                    console.error(error);
                    Livewire.dispatch('bioGenerada', { bio: 'Hubo un error al generar la bio.' });
                }

            }

        </script>
        
</div>