<div>
    <script type="module">
            import { GoogleGenerativeAI } from "https://esm.run/@google/generative-ai";

            // Configuración
            const API_KEY = "{{ env('GEMINI_API_KEY') }}";
            const genAI = new GoogleGenerativeAI(API_KEY);

            window.ejecutarGemini = async function(e) {
                try {
                    const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });

                    // const prompt =
                    //     "Con estos datos devuelve una biografia en español de no más de 200 palabras. " +
                    //     "Es importante que la biografia esté en primera persona, suene profesional y atractiva. " +
                    //     "Los datos son: " + JSON.stringify(e.data) +
                    //     ". Solo retorna la biografia sin ningún otro texto adicional.";
                    const prompt =
                    "Con los siguientes datos, redacta una biografía profesional en español, en primera persona, " +
                    "con un tono ejecutivo, claro y atractivo. " +
                    "La biografía debe destacar experiencia, impacto profesional, capacidad de liderazgo o aporte de valor, " +
                    "y enfoque en resultados y desarrollo de personas u organizaciones, según corresponda al perfil. " +
                    "Extensión máxima: 120 palabras. " +
                    "Datos: " + JSON.stringify(e.data) +
                    ". Devuelve únicamente el texto final, sin títulos ni explicaciones adicionales.";
                    const result = await model.generateContent(prompt);
                    const response = result.response.text();
                   

                    // 🔁 Volver a Livewire con la bio
                    Livewire.dispatch('bioGenerada', { bio: response });

                } catch (error) {
                    console.error(error);
                    alert('Error al generar la bio: ' + error.message);
                    Livewire.dispatch('bioGenerada', { bio: 'Hubo un error al generar la bio.' });
                }

            }

            window.ejecutarGeminiSeniority = async function(e) {
                try {
                    const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });

                    const prompt =
                        "Con estos datos devuelve un nivel de seniority profesional en español. " +
                        "Los datos son: " + JSON.stringify(e.data) +
                        ". Solo retorna en base a estos niveles de seniority: Jefe, Gerente , Director, CEO, Emprendedor , Director . Solo retorna el nivel de seniority sin ningún otro texto adicional.";

                    const result = await model.generateContent(prompt);
                    const response = result.response.text();
                    console.log(response);
                    

                    // 🔁 Volver a Livewire con la seniority
                    Livewire.dispatch('seniorityGenerada', { seniority: response });

                } catch (error) {
                    console.error(error);
                    alert('Error al generar el seniority: ' + error.message);
                    Livewire.dispatch('seniorityGenerada', { seniority: 'Hubo un error al generar el seniority.' });
                }

            }

            window.ejecutarGeminiAvailabilities = async function(e) {
                try {
                    const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });

                    const prompt = ' Eres un parser de disponibilidad horaria. Convierte el texto de disponibilidad en español a un JSON válido, siguiendo estrictamente estas reglas:- Los días deben mapearse a:  lunes -> monday  martes -> tuesday  miércoles -> wednesday  jueves -> thursday  viernes -> friday  sábado -> saturday  domingo -> sunday- Si se indica un rango de días (ej: lunes-viernes), debes generar  una entrada por cada día del rango.- Las horas deben devolverse en formato 24h HH:MM  ej: 16pm -> 16:00, 9am -> 09:00- Si no se especifica fecha, usar:  "start_date": null  "end_date": null- "is_recurring" debe ser true si no hay fechas específicas.- Devuelve SOLO JSON válido, sin texto adicional.Texto de entrada: "'+ e.data.availability + '"Formato de salida:[  {    "day_of_week": "monday",    "start_time": "16:00",    "end_time": "20:00",    "start_date": null,    "end_date": null,    "is_recurring": true  }] IMPORTANTE:No encierres la respuesta en ```json, ``` ni comillas.Devuelve únicamente el JSON plano.Si agregas cualquier otro carácter, la respuesta será inválida.';

                    const result = await model.generateContent(prompt);
                    const response = result.response.text();
                    console.log(response);
                    

                    // 🔁 Volver a Livewire con las disponibilidades
                    Livewire.dispatch('availabilitiesGeneradas', { availabilities: response });

                } catch (error) {
                    console.error(error);
                    alert('Error al generar las disponibilidades: ' + error.message);
                    Livewire.dispatch('availabilitiesGeneradas', { availabilities: 'Hubo un error al generar las disponibilidades.' });
                }

            }
            
            window.ejecutarCv = async function(text) {
                try {
                    const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });

                    const prompt = 'Analiza el siguiente CV y devuelve EXCLUSIVAMENTE un JSON válido. No incluyas explicaciones, texto adicional ni markdown. No uses ```json. Si un dato no está presente, usa null. No inventes información. Las claves deben llamarse EXACTAMENTE así:{"nombre_completo": string|null,"birthDate": "YYYY-MM-DD"|null,"country": string|null,"city": string|null,"workingNow": "yes"|"no"|null,"currentPosition": string|null,"lastPosition": string|null,"yearsExperience": number|null,"companies": string|null,"sectors": string|null,"education": string|null,"languages": string|null,"skills": string|null,"bio": string|null,"seniority": "Junior"|"Semi Senior"|"Senior"|"Lead"|null}REGLAS IMPORTANTES:- workingNow = "yes" si tiene un puesto actual o dice "Presente".- currentPosition = el cargo actual si existe.- lastPosition = el cargo anterior inmediato.- yearsExperience = estimar según fechas laborales (solo número).- companies = lista separada por comas.- sectors = inferir sectores profesionales principales.- education = resumir en una sola frase.- languages = lista separada por comas.- skills = solo hard skills técnicas separadas por comas.- bio = resumen profesional corto (máx 3 líneas).- seniority: Jefe, Gerente , Director, CEO, Emprendedor , Director.  CV:' + text;
                    const result = await model.generateContent(prompt);
                    const response = result.response.text();
                    // const response = '{"nombre_completo": "Jorge Oscar Manitto", "birthDate": null, "country": "Argentina", "city": "Pilar, Provincia de Buenos Aires", "workingNow": "yes", "currentPosition": "Desarrollador web", "lastPosition": "Desarrollador web", "yearsExperience": 5, "companies": "Workana, Upwork freelance, Pupila\u00ae", "sectors": "Desarrollo de software, Servicios freelance", "education": "Ingenier\u00eda en Electr\u00f3nica y Administraci\u00f3n/Administrador de redes en Universidad Nacional de Moreno (2018 - 2024)", "languages": null, "skills": "PHP, Laravel, JavaScript, Desarrollo web, Dise\u00f1o web, Dise\u00f1os adaptativos, Optimizaciones en buscadores", "bio": "Desarrollador web con m\u00e1s de 4 a\u00f1os de experiencia en PHP, Laravel y JavaScript. Especializado en crear soluciones escalables y optimizadas para mejorar la experiencia del usuario.", "seniority": "Senior"}';
                    console.log(response);
                    

                    // 🔁 Volver a Livewire con el CV procesado
                    Livewire.dispatch('cvProcesado', { cvData: response });

                } catch (error) {
                    console.error(error);
                    alert('Error al procesar el CV: ' + error.message);
                    Livewire.dispatch('cvProcesado', { cvData: 'Hubo un error al procesar el CV.' });
                }

            }

        </script>
        
</div>