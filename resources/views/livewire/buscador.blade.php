<div>
    <div class="relative">
        {{-- {{$loader ? 'hola': 'flase'}} --}}
        <form wire:submit.prevent="busqueda">
            <input type="text" wire:model="searchText" placeholder="tengo problemas para pedir un aumento a mi jefe" class="w-full px-6 py-4 rounded-xl border-2 border-gray-200 focus:border-[#1a0a3e] focus:outline-none text-gray-700">
            <button class="absolute right-2 top-1/2 -translate-y-1/2 px-6 py-2 bg-[#1a0a3e] text-white rounded-lg hover:bg-[#1a0a3ee8] transition-colors" style="cursor: pointer;">
               Buscar
            </button>
        </form>
        <div>
            
            <script>
                 window.addEventListener('ejecutarBusqueda', event => {
                        ejecutarBusqueda(event.detail.data, event.detail.tags);
                        console.log(event.detail);
                        
                    });
            </script>
            <script type="module">
                import { GoogleGenerativeAI } from "https://esm.run/@google/generative-ai";
    
                // Configuración
                const API_KEY = "{{ env('GEMINI_API_KEY') }}";
                const genAI = new GoogleGenerativeAI(API_KEY);
                window.ejecutarBusqueda = async function(text, tags){
                    
                    try {
                        console.log("entro");
                        const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });
                        const prompt = `
                        Tu tarea es analizar un texto y compararlo con una lista de tags existentes.
    
                        INSTRUCCIONES:
                        - Debes seleccionar ÚNICAMENTE tags que estén dentro de la lista proporcionada.
                        - No inventes nuevos tags.
                        - Devuelve solo los tags que tengan una relación semántica clara con el texto.
                        - Prioriza el significado y el contexto, no coincidencias literales.
                        - Devuelve el resultado en formato JSON válido.
                        - Si ningún tag es relevante, devuelve un array vacío.
    
                        FORMATO DE RESPUESTA (OBLIGATORIO):
                        {
                        "tags": ["tag1", "tag2"]
                        }
    
                        TEXTO:"${text}"
                        TAGS DISPONIBLES:${tags}
                        `
                        const result = await model.generateContent(prompt);
                        const response = result.response.text();
                        console.log(response);
                        
                        // 🔁 Volver a Livewire con el CV procesado
                        Livewire.dispatch('busquedaGenerada', { data: response });
                    } catch (error) {
                        console.error(error);
                        alert('Error al procesar el CV: ' + error.message);
                        Livewire.dispatch('busquedaGenerada', { data: 'Hubo un error al hacer tu busqueda.' });
                    }
                }
            </script>
                
        </div>
    </div>
    @if ($loader)
        <p class="text-xs text-gray-500 mt-3" >Generando respuesta acorde a tus necesides...</p>
    @endif
</div>