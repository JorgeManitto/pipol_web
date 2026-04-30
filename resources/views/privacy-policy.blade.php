<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pipol - Política de Privacidad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        html {
            scroll-behavior: smooth;
        }

        .text-balance {
            text-wrap: balance;
        }

        .policy-section h3 {
            color: #fff;
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            margin-top: 2rem;
        }

        .policy-section p,
        .policy-section li {
            color: #9CA3AF;
            font-size: 0.875rem;
            line-height: 1.75;
        }

        .policy-section ul {
            list-style: none;
            padding-left: 0;
            margin: 0.75rem 0;
        }

        .policy-section ul li {
            position: relative;
            padding-left: 1.25rem;
            margin-bottom: 0.375rem;
        }

        .policy-section ul li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0.625rem;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #8B5CF6;
        }

        .policy-section a {
            color: #8B5CF6;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .policy-section a:hover {
            color: #A78BFA;
        }

        .section-divider {
            border-color: rgba(107, 114, 128, 0.2);
        }
    </style>
    @livewireStyles
</head>
<body style="background: #0F071A;">
    <div>
        <div class="min-h-dvh relative pt-4 pb-20 px-4 bg-[#0F071A]">
            <div class="max-w-3xl mx-auto">
                <div class="grid lg:grid-cols-1 gap-4 items-center">

                    <!-- Branding -->
                    <div class="text-white space-y-4">
                        <div class="flex items-start flex-col gap-2 mb-0">
                            <a href="{{ route('home') }}" class="flex items-center py-2 rounded-full text-sm text-auth-tabs">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 18l-6-6 6-6" />
                                </svg>
                                Volver al sitio principal
                            </a>
                        </div>

                        <h1 class="text-2xl font-black leading-tight mb-0">
                            <span class="text-white">Política de Privacidad de</span>
                            <a href="{{ route('home') }}" class="gradient-text"><img style="display: inline-block;height: 32px;" src="{{ asset('/images/logo-clea-recorte.png') }}" alt="Pipol" /></a>
                        </h1>

                        <p class="text-md font-normal text-auth-tabs leading-relaxed max-w-xl pb-0">
                            Conocé cómo recopilamos, utilizamos y protegemos tus datos personales.
                        </p>
                    </div>

                    <!-- Card -->
                    <div class="relative">
                        <div class="bg-[#140A24] backdrop-blur-sm rounded-3xl p-5 md:py-8 md:px-10 border border-gray-700/50 policy-section">

                            <!-- Encabezado -->
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-full bg-purple-900/40 border border-purple-700/50 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white mb-0">Política de Privacidad</h2>
                                    <p class="text-auth-tabs text-xs mb-0">Pipol — Pitt Enterprise LLC</p>
                                </div>
                            </div>

                            <hr class="section-divider my-5">

                            <!-- 1. Identidad del Responsable -->
                            <h3>1. Identidad del Responsable</h3>
                            <p>
                                Pitt Enterprise LLC, sociedad constituida conforme a las leyes de los Estados Unidos de América, que opera comercialmente bajo el nombre Pipol, es responsable del tratamiento de los datos personales recopilados a través del sitio web <a href="https://www.somospipol.com.ar" target="_blank">www.somospipol.com.ar</a> (en adelante, la "Plataforma").
                            </p>
                            <p>
                                La presente Política de Privacidad describe cómo se recopilan, utilizan, almacenan y protegen los datos personales de los usuarios de la Plataforma.
                            </p>
                            <p>
                                Al registrarse o utilizar los servicios, el Usuario acepta de manera libre, expresa e informada esta Política y presta su consentimiento conforme a la Ley N° 25.326 de Protección de Datos Personales de la República Argentina y normativa complementaria aplicable.
                            </p>

                            <hr class="section-divider my-5">

                            <!-- 2. Datos Personales Recopilados -->
                            <h3>2. Datos Personales Recopilados</h3>
                            <p>Pipol podrá recopilar las siguientes categorías de datos personales:</p>
                            <ul>
                                <li>Nombre y apellido</li>
                                <li>Correo electrónico</li>
                                <li>Información profesional (CV, experiencia, especialidad, perfil público)</li>
                                <li>Datos de facturación</li>
                                <li>Información de pago (procesada por proveedores externos como Stripe u otros procesadores)</li>
                                <li>Historial de sesiones y actividad dentro de la Plataforma</li>
                                <li>Comunicaciones realizadas dentro del sistema</li>
                                <li>Datos técnicos (IP, dispositivo, navegación, cookies)</li>
                            </ul>
                            <p>El suministro de los datos es voluntario, pero necesario para la correcta prestación del servicio.</p>
                            <p>El Usuario declara que la información proporcionada es veraz y actualizada.</p>

                            <hr class="section-divider my-5">

                            <!-- 3. Finalidades del Tratamiento -->
                            <h3>3. Finalidades del Tratamiento</h3>
                            <p>Los datos personales serán tratados con las siguientes finalidades:</p>
                            <ul>
                                <li>Crear y administrar cuentas de usuario.</li>
                                <li>Permitir la conexión entre mentores y mentees.</li>
                                <li>Gestionar sesiones, agenda y evaluaciones.</li>
                                <li>Procesar pagos y liquidar comisiones.</li>
                                <li>Enviar comunicaciones operativas (confirmaciones, recordatorios, soporte).</li>
                                <li>Enviar comunicaciones informativas o promocionales (cuando el Usuario lo autorice).</li>
                                <li>Mejorar funcionalidades, seguridad y experiencia de uso.</li>
                                <li>Cumplir obligaciones legales, fiscales o regulatorias.</li>
                            </ul>
                            <p>Pipol no utilizará los datos para finalidades distintas a las aquí detalladas.</p>

                            <hr class="section-divider my-5">

                            <!-- 4. Base Legal del Tratamiento -->
                            <h3>4. Base Legal del Tratamiento</h3>
                            <p>El tratamiento de los datos se fundamenta en:</p>
                            <ul>
                                <li>El consentimiento del Usuario.</li>
                                <li>La necesidad de prestar los servicios solicitados a través de la Plataforma.</li>
                                <li>El cumplimiento de obligaciones legales.</li>
                                <li>El interés legítimo de Pipol en garantizar la seguridad, integridad y mejora del servicio.</li>
                            </ul>

                            <hr class="section-divider my-5">

                            <!-- 5. Conservación de Datos -->
                            <h3>5. Conservación de Datos</h3>
                            <p>
                                Pipol conservará los datos personales del Usuario mientras mantenga una cuenta activa o continúe utilizando los servicios de la Plataforma, y mientras los datos resulten necesarios para las finalidades descritas en esta Política.
                            </p>
                            <p>
                                El Usuario podrá solicitar en cualquier momento la eliminación de su cuenta mediante las herramientas disponibles en la Plataforma o enviando una solicitud a: <a href="mailto:privacidad@somospipol.com.ar">privacidad@somospipol.com.ar</a>
                            </p>
                            <p>Una vez solicitada la eliminación:</p>
                            <ul>
                                <li>El perfil público dejará de ser visible.</li>
                                <li>Los datos personales serán eliminados o anonimizados en un plazo razonable.</li>
                            </ul>
                            <p>No obstante, podrán conservarse ciertos datos mínimos cuando resulte necesario para:</p>
                            <ul>
                                <li>Cumplir obligaciones legales o fiscales.</li>
                                <li>Gestionar pagos, comisiones o disputas.</li>
                                <li>Prevenir fraude o abuso del sistema.</li>
                                <li>Proteger la integridad histórica de la Plataforma (por ejemplo, registros de sesiones ya realizadas).</li>
                            </ul>
                            <p>En tales casos, los datos serán bloqueados y utilizados únicamente para los fines legales correspondientes durante los plazos exigidos por la normativa aplicable.</p>

                            <hr class="section-divider my-5">

                            <!-- 6. Compartición de Datos -->
                            <h3>6. Compartición de Datos</h3>
                            <p>Pipol podrá compartir datos personales únicamente en los siguientes casos:</p>
                            <ul>
                                <li>Con proveedores tecnológicos necesarios para operar la Plataforma (hosting, procesamiento de pagos, correo electrónico, analítica, etc.).</li>
                                <li>Con afiliadas o vinculadas de Pitt Enterprise LLC.</li>
                                <li>Cuando sea requerido por autoridad competente o por ley.</li>
                                <li>Para proteger derechos legales o prevenir actividades ilícitas.</li>
                            </ul>
                            <p>Pipol no vende ni alquila datos personales a terceros.</p>
                            <p>Cuando los datos sean transferidos internacionalmente, se adoptarán medidas contractuales razonables para garantizar su adecuada protección.</p>

                            <hr class="section-divider my-5">

                            <!-- 7. Seguridad de la Información -->
                            <h3>7. Seguridad de la Información</h3>
                            <p>
                                Pipol implementa medidas técnicas y organizativas razonables para proteger los datos personales contra acceso no autorizado, pérdida, alteración o divulgación indebida.
                            </p>
                            <p>Sin embargo, el Usuario reconoce que ningún sistema digital es absolutamente invulnerable.</p>
                            <p>Se recomienda:</p>
                            <ul>
                                <li>Utilizar contraseñas seguras.</li>
                                <li>No compartir credenciales.</li>
                                <li>Cerrar sesión en dispositivos compartidos.</li>
                            </ul>

                            <hr class="section-divider my-5">

                            <!-- 8. Derechos del Usuario -->
                            <h3>8. Derechos del Usuario</h3>
                            <p>Conforme a la Ley 25.326, el Usuario tiene derecho a:</p>
                            <ul>
                                <li>Acceder a sus datos personales.</li>
                                <li>Solicitar su rectificación o actualización.</li>
                                <li>Solicitar su supresión.</li>
                                <li>Revocar su consentimiento.</li>
                            </ul>
                            <p>El derecho de acceso podrá ejercerse con intervalos no inferiores a seis (6) meses, salvo interés legítimo acreditado.</p>
                            <p>Las solicitudes deberán enviarse a: <a href="mailto:privacidad@somospipol.com.ar">privacidad@somospipol.com.ar</a></p>

                            <hr class="section-divider my-5">

                            <!-- 9. Autoridad de Control -->
                            <h3>9. Autoridad de Control</h3>
                            <p>
                                La AGENCIA DE ACCESO A LA INFORMACIÓN PÚBLICA (AAIP), órgano de control de la Ley N° 25.326, atiende denuncias y reclamos relacionados con protección de datos personales.
                            </p>
                            <div class="mt-3 p-4 rounded-xl bg-[#1A1029] border border-gray-700/30">
                                <p class="text-auth-tabs text-sm mb-1">Av. Pte. Julio A. Roca 710, Piso 2° — Ciudad de Buenos Aires</p>
                                <p class="text-auth-tabs text-sm mb-1">
                                    <a href="https://www.argentina.gob.ar/aaip" target="_blank">www.argentina.gob.ar/aaip</a>
                                </p>
                                <p class="text-auth-tabs text-sm mb-1">
                                    <a href="mailto:datospersonales@aaip.gob.ar">datospersonales@aaip.gob.ar</a>
                                </p>
                                <p class="text-auth-tabs text-sm mb-0">Tel. +54 11 2821-0047</p>
                            </div>

                            <hr class="section-divider my-5">

                            <!-- 10. Enlaces a Terceros -->
                            <h3>10. Enlaces a Terceros</h3>
                            <p>
                                La Plataforma puede contener enlaces a sitios externos. Pipol no es responsable por el contenido ni las políticas de privacidad de dichos sitios.
                            </p>
                            <p>El acceso a los mismos es bajo exclusiva responsabilidad del Usuario.</p>

                            <hr class="section-divider my-5">

                            <!-- 11. Comunicaciones Electrónicas -->
                            <h3>11. Comunicaciones Electrónicas</h3>
                            <p>Pipol podrá enviar:</p>
                            <ul>
                                <li>Comunicaciones operativas necesarias para el funcionamiento del servicio.</li>
                                <li>Comunicaciones promocionales o informativas, de las cuales el Usuario podrá desuscribirse en cualquier momento.</li>
                            </ul>

                            <hr class="section-divider my-5">

                            <!-- 12. Modificaciones -->
                            <h3>12. Modificaciones</h3>
                            <p>Pipol podrá modificar esta Política de Privacidad en cualquier momento.</p>
                            <p>Las modificaciones serán publicadas en la Plataforma indicando la fecha de actualización.</p>
                            <p>El uso continuado de la Plataforma implica la aceptación de las modificaciones.</p>

                            <hr class="section-divider my-5">

                            <div class="text-center">
                                <p class="text-auth-tabs text-xs">Última actualización: Marzo 2026</p>
                                <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-[#8B5CF6] hover:underline text-sm mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M15 18l-6-6 6-6" />
                                    </svg>
                                    Volver al inicio
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
