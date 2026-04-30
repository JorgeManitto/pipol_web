<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pipol - Términos y Condiciones</title>
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

        .policy-section h4 {
            color: #D1D5DB;
            font-size: 0.9375rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            margin-top: 1.25rem;
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

        .policy-section ol {
            list-style: none;
            padding-left: 0;
            margin: 0.75rem 0;
            counter-reset: step-counter;
        }

        .policy-section ol li {
            position: relative;
            padding-left: 2rem;
            margin-bottom: 0.5rem;
            counter-increment: step-counter;
        }

        .policy-section ol li::before {
            content: counter(step-counter);
            position: absolute;
            left: 0;
            top: 0;
            width: 1.375rem;
            height: 1.375rem;
            border-radius: 50%;
            background: rgba(139, 92, 246, 0.15);
            border: 1px solid rgba(139, 92, 246, 0.3);
            color: #8B5CF6;
            font-size: 0.7rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            text-align: center;
            padding-top: 1px;
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

        .policy-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .highlight-box {
            background: #1A1029;
            border: 1px solid rgba(107, 114, 128, 0.3);
            border-radius: 0.75rem;
            padding: 1rem;
            margin: 0.75rem 0;
        }

        .highlight-box p {
            margin-bottom: 0.25rem;
        }

        .highlight-box p:last-child {
            margin-bottom: 0;
        }

        .warning-box {
            background: rgba(245, 158, 11, 0.08);
            border: 1px solid rgba(245, 158, 11, 0.25);
            border-radius: 0.75rem;
            padding: 1rem;
            margin: 0.75rem 0;
        }

        .warning-box p {
            color: #FBBF24;
        }

        .danger-box {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.25);
            border-radius: 0.75rem;
            padding: 1rem;
            margin: 0.75rem 0;
        }

        .danger-box p {
            color: #F87171;
        }

        .toc-link {
            display: block;
            padding: 0.375rem 0;
            color: #9CA3AF;
            font-size: 0.8125rem;
            text-decoration: none;
            transition: color 0.15s;
        }

        .toc-link:hover {
            color: #8B5CF6;
        }

        .toc-link span {
            color: #8B5CF6;
            font-weight: 600;
            margin-right: 0.5rem;
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
                            <span class="text-white">Términos y Condiciones de</span>
                            <a href="{{ route('home') }}" class="gradient-text"><img style="display: inline-block;height: 32px;" src="{{ asset('/images/logo-clea-recorte.png') }}" alt="Pipol" /></a>
                        </h1>

                        <p class="text-md font-normal text-auth-tabs leading-relaxed max-w-xl pb-0">
                            Conocé las reglas que rigen el uso de nuestra plataforma, los derechos y obligaciones de cada parte.
                        </p>
                    </div>

                    <!-- Card -->
                    <div class="relative">
                        <div class="bg-[#140A24] backdrop-blur-sm rounded-3xl p-5 md:py-8 md:px-10 border border-gray-700/50 policy-section">

                            <!-- Encabezado -->
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-full bg-purple-900/40 border border-purple-700/50 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <polyline points="10 9 9 9 8 9"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white mb-0">Términos y Condiciones Generales</h2>
                                    <p class="text-auth-tabs text-xs mb-0">Pipol — Pitt Enterprise LLC</p>
                                </div>
                            </div>

                            <hr class="section-divider my-5">

                            <!-- Índice -->
                            <div class="highlight-box">
                                <p class="text-white font-semibold text-sm mb-3" style="color: #fff;">Índice</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                                    <a href="#sec-1" class="toc-link"><span>01</span> Identificación del Operador</a>
                                    <a href="#sec-2" class="toc-link"><span>02</span> Aceptación</a>
                                    <a href="#sec-3" class="toc-link"><span>03</span> Naturaleza del Servicio</a>
                                    <a href="#sec-4" class="toc-link"><span>04</span> Servicios Provistos</a>
                                    <a href="#sec-5" class="toc-link"><span>05</span> Registro de Usuarios</a>
                                    <a href="#sec-6" class="toc-link"><span>06</span> Requisitos para ser Mentor</a>
                                    <a href="#sec-7" class="toc-link"><span>07</span> Obligaciones de los Usuarios</a>
                                    <a href="#sec-8" class="toc-link"><span>08</span> Relación entre Usuarios</a>
                                    <a href="#sec-9" class="toc-link"><span>09</span> Limitación de Responsabilidad</a>
                                    <a href="#sec-10" class="toc-link"><span>10</span> Modificaciones</a>
                                    <a href="#sec-11" class="toc-link"><span>11</span> Ley Aplicable y Jurisdicción</a>
                                    <a href="#sec-pagos" class="toc-link"><span>12</span> Pagos, Escrow y Cancelaciones</a>
                                    <a href="#sec-mentores" class="toc-link"><span>13</span> Política de Mentores</a>
                                    <a href="#sec-comunidad" class="toc-link"><span>14</span> Comunidad Segura</a>
                                    <a href="#sec-reputacion" class="toc-link"><span>15</span> Reputación y Calificaciones</a>
                                    <a href="#sec-business" class="toc-link"><span>16</span> Pipol for Business (Fractional)</a>
                                </div>
                            </div>

                            <hr class="section-divider my-5">

                            {{-- ============================================ --}}
                            {{-- TÉRMINOS Y CONDICIONES GENERALES             --}}
                            {{-- ============================================ --}}

                            <!-- 1 -->
                            <h3 id="sec-1">1. Identificación del Operador</h3>
                            <p>La plataforma digital denominada "Pipol" es operada por PITT ENTERPRISE LLC, sociedad de responsabilidad limitada constituida conforme a las leyes de los Estados Unidos de América, en adelante "Pipol".</p>
                            <p>Estos Términos y Condiciones regulan el acceso, navegación y uso de la plataforma Pipol, incluyendo su sitio web, aplicaciones, sistemas y servicios asociados (en adelante, la "Plataforma").</p>

                            <hr class="section-divider my-5">

                            <!-- 2 -->
                            <h3 id="sec-2">2. Aceptación</h3>
                            <p>El acceso o uso de la Plataforma implica la aceptación plena y sin reservas de los presentes Términos y Condiciones, así como de las políticas complementarias publicadas por Pipol.</p>

                            <hr class="section-divider my-5">

                            <!-- 3 -->
                            <h3 id="sec-3">3. Naturaleza del Servicio – Rol de Pipol</h3>
                            <p>Pipol es exclusivamente una plataforma tecnológica de intermediación que facilita el contacto entre personas que desean recibir mentorías ("Mentees") y personas que ofrecen servicios de mentoría de forma independiente ("Mentores").</p>

                            <div class="highlight-box">
                                <p class="text-white font-medium text-sm" style="color: #D1D5DB;">Pipol:</p>
                                <ul>
                                    <li>No presta servicios de mentoría.</li>
                                    <li>No garantiza resultados, contenidos ni efectos de las sesiones.</li>
                                    <li>No controla, dirige ni supervisa la actividad profesional de los Mentores.</li>
                                    <li>No mantiene relación laboral, societaria ni de representación con los Mentores.</li>
                                </ul>
                            </div>

                            <p>Cada Mentor actúa en forma autónoma e independiente, siendo el único y exclusivo responsable de los servicios que ofrece.</p>
                            <p>Pipol actúa exclusivamente como una plataforma tecnológica que facilita el contacto entre Mentores y Mentees. Pipol no participa en la relación que se genera entre los usuarios ni forma parte de los acuerdos alcanzados entre ellos.</p>

                            <hr class="section-divider my-5">

                            <!-- 4 -->
                            <h3 id="sec-4">4. Servicios Provistos por Pipol</h3>
                            <p>Pipol pone a disposición de los usuarios:</p>
                            <ul>
                                <li>Infraestructura digital para creación y gestión de perfiles.</li>
                                <li>Publicación de servicios.</li>
                                <li>Agenda, reservas y comunicación interna.</li>
                                <li>Sistema de pagos en custodia (escrow).</li>
                                <li>Sistema de calificaciones y reputación.</li>
                                <li>Soporte técnico de la Plataforma.</li>
                            </ul>

                            <hr class="section-divider my-5">

                            <!-- 5 -->
                            <h3 id="sec-5">5. Registro de Usuarios</h3>
                            <p>Para utilizar la Plataforma, el usuario deberá crear una cuenta, proporcionando información verdadera, completa y actualizada.</p>
                            <p>El usuario es responsable de mantener la confidencialidad de sus credenciales y de toda actividad realizada desde su cuenta.</p>

                            <hr class="section-divider my-5">

                            <!-- 6 -->
                            <h3 id="sec-6">6. Requisitos para ser Mentor</h3>
                            <p>Para registrarse y operar como Mentor dentro de la Plataforma, el usuario deberá cumplir, sin excepción, con los siguientes requisitos:</p>

                            <h4>6.1. Edad y capacidad legal</h4>
                            <p>Ser mayor de dieciocho (18) años y contar con plena capacidad legal para contratar.</p>

                            <h4>6.2. Experiencia profesional</h4>
                            <p>Acreditar experiencia profesional comprobable en al menos uno de los siguientes ámbitos:</p>
                            <ul>
                                <li>Cargos de jefatura, subgerencia, gerencia, dirección o gerencia general.</li>
                                <li>Rol de CEO, fundador, cofundador, entrepreneur o emprendedor con trayectoria verificable.</li>
                            </ul>

                            <h4>6.3. Información veraz</h4>
                            <p>Proporcionar información personal y profesional verdadera, completa, actualizada y verificable, asumiendo plena responsabilidad por la exactitud de los datos suministrados.</p>

                            <h4>6.4. Validación de identidad</h4>
                            <p>Someterse obligatoriamente al proceso de validación de identidad y perfil definido por Pipol, el cual podrá incluir, entre otros mecanismos:</p>
                            <ul>
                                <li>Envío de fotografía tipo selfie en tiempo real.</li>
                                <li>Presentación de documento oficial de identidad vigente.</li>
                                <li>Verificaciones manuales o automatizadas.</li>
                            </ul>

                            <h4>6.5. Proceso de revisión</h4>
                            <p>Al registrarse, el Mentor acepta expresamente el proceso de revisión y validación, entendiendo que Pipol podrá:</p>
                            <ul>
                                <li>Aprobar o rechazar solicitudes de registro como Mentor.</li>
                                <li>Solicitar documentación adicional.</li>
                                <li>Suspender o cancelar perfiles ante inconsistencias, falsedad de información o incumplimiento de estos Términos.</li>
                            </ul>

                            <div class="warning-box">
                                <p class="text-sm">El incumplimiento de cualquiera de estos requisitos habilitará a Pipol a denegar el registro, suspender temporalmente o eliminar definitivamente la cuenta, sin derecho a indemnización alguna.</p>
                            </div>

                            <hr class="section-divider my-5">

                            <!-- 7 -->
                            <h3 id="sec-7">7. Obligaciones de los Usuarios</h3>

                            <h4>7.1. Mentores</h4>
                            <p>Los Mentores se obligan a:</p>
                            <ul>
                                <li>Prestar los servicios en fecha y horario acordados.</li>
                                <li>Mantener conducta ética, profesional y respetuosa.</li>
                                <li>Cumplir con lo ofrecido en su perfil.</li>
                                <li>No solicitar ni aceptar pagos fuera de Pipol.</li>
                                <li>Cumplir con las políticas complementarias de Pipol.</li>
                            </ul>

                            <h4>7.2. Mentees</h4>
                            <p>Los Mentees se obligan a:</p>
                            <ul>
                                <li>Asistir a las sesiones reservadas.</li>
                                <li>Cancelar o reprogramar conforme a las políticas vigentes.</li>
                                <li>Mantener trato respetuoso.</li>
                            </ul>

                            <h4>7.3. Pagos fuera de la Plataforma</h4>
                            <div class="danger-box">
                                <p class="text-sm">Los usuarios se comprometen a no solicitar, ofrecer ni realizar pagos por servicios acordados a través de la Plataforma fuera del sistema de pagos de Pipol. Cualquier intento de eludir el sistema de pagos podrá dar lugar a la suspensión o cancelación de la cuenta correspondiente.</p>
                            </div>

                            <hr class="section-divider my-5">

                            <!-- 8 -->
                            <h3 id="sec-8">8. Relación entre Usuarios</h3>
                            <p>Las mentorías y cualquier interacción entre Mentores y Mentees se realizan directamente entre ellos.</p>
                            <p>Pipol no será responsable por disputas, desacuerdos, daños o perjuicios que puedan surgir entre usuarios como consecuencia de dichas interacciones.</p>
                            <p>Los usuarios reconocen y aceptan que cualquier decisión profesional, educativa o personal adoptada a partir de una mentoría es de exclusiva responsabilidad del propio usuario.</p>

                            <hr class="section-divider my-5">

                            <!-- 9 -->
                            <h3 id="sec-9">9. Limitación de Responsabilidad</h3>
                            <p>Pipol no será responsable por:</p>
                            <ul>
                                <li>Contenido, calidad o resultados de los servicios prestados por los Mentores.</li>
                                <li>Decisiones tomadas por los usuarios.</li>
                                <li>Daños directos o indirectos derivados de las mentorías.</li>
                                <li>Conductas individuales de Mentores o Mentees.</li>
                            </ul>
                            <p>Las opiniones, recomendaciones o consejos proporcionados por los Mentores reflejan exclusivamente su experiencia personal o profesional. Pipol no valida ni garantiza la exactitud, utilidad o resultados de dichas recomendaciones.</p>

                            <hr class="section-divider my-5">

                            <!-- 10 -->
                            <h3 id="sec-10">10. Modificaciones</h3>
                            <p>Pipol se reserva el derecho de modificar los presentes Términos y Condiciones en cualquier momento.</p>
                            <p>El uso continuado de la Plataforma implicará aceptación de las modificaciones.</p>

                            <hr class="section-divider my-5">

                            <!-- 11 -->
                            <h3 id="sec-11">11. Ley Aplicable y Jurisdicción</h3>
                            <p>Para usuarios en Argentina, estos Términos se regirán por el Código Civil y Comercial de la Nación, sometiéndose a los tribunales ordinarios de la Ciudad Autónoma de Buenos Aires.</p>
                            <p>Para usuarios en Chile, se regirán por la legislación vigente de la República de Chile, sometiéndose a los tribunales ordinarios de Santiago.</p>

                            <hr class="section-divider my-5">

                            {{-- ============================================ --}}
                            {{-- POLÍTICA DE PAGOS, ESCROW Y CANCELACIONES    --}}
                            {{-- ============================================ --}}

                            <div class="flex items-center gap-3 mt-8 mb-2">
                                <div class="w-10 h-10 rounded-full bg-purple-900/40 border border-purple-700/50 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                        <line x1="1" y1="10" x2="23" y2="10"/>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-white mb-0" id="sec-pagos">Política de Pagos, Escrow y Cancelaciones</h2>
                            </div>

                            <hr class="section-divider my-5">

                            <h3>1. Sistema de Pagos</h3>
                            <p>Todos los pagos se procesan mediante Stripe u otro proveedor autorizado.</p>
                            <p>Pipol utiliza un sistema de pago en custodia (escrow) a través de Stripe Connect:</p>
                            <ol>
                                <li>El Mentee paga al reservar.</li>
                                <li>El dinero queda retenido.</li>
                                <li>Finalizada la sesión, Mentor y Mentee confirman su realización.</li>
                                <li>Pipol libera el dinero a la cuenta Stripe del Mentor, descontando su comisión.</li>
                            </ol>
                            <p>Pipol podrá retener fondos ante disputas.</p>

                            <hr class="section-divider my-5">

                            <h3>2. Cancelaciones</h3>

                            <h4>Cancelación sin penalidad</h4>
                            <div class="highlight-box">
                                <p class="text-sm" style="color: #34D399;">Con 24 horas o más de anticipación: sin cargo.</p>
                            </div>

                            <h4>Cancelación tardía</h4>
                            <div class="warning-box">
                                <p class="text-sm">Menos de 24 horas de anticipación:</p>
                                <ul style="margin-top: 0.5rem;">
                                    <li style="color: #FBBF24;">El Mentee puede perder el pago total.</li>
                                    <li style="color: #FBBF24;">El Mentor puede ser penalizado reputacionalmente.</li>
                                </ul>
                            </div>
                            <p>Pipol podrá permitir reprogramaciones según antecedentes.</p>

                            <hr class="section-divider my-5">

                            <h3>3. No-Show</h3>

                            <h4>No-Show del Mentor</h4>
                            <p>Se considera no-show si no se presenta o abandona injustificadamente la sesión antes del tiempo de finalización.</p>
                            <p>Consecuencias:</p>
                            <ul>
                                <li>Reembolso íntegro al Mentee.</li>
                                <li>Calificación automática de 1 estrella.</li>
                                <li>Registro interno.</li>
                            </ul>
                            <div class="danger-box">
                                <p class="text-sm">Con 3 no-shows: suspensión automática y revisión para baja definitiva.</p>
                            </div>

                            <h4>No-Show del Mentee</h4>
                            <p>Si el Mentee no asiste sin previo aviso:</p>
                            <ul>
                                <li>El Mentor puede cobrar la sesión.</li>
                                <li>Pipol puede restringir la cuenta.</li>
                            </ul>

                            <hr class="section-divider my-5">

                            <h3>4. Disputas</h3>
                            <p>Pipol podrá:</p>
                            <ul>
                                <li>Solicitar evidencia.</li>
                                <li>Retener fondos.</li>
                                <li>Decidir reembolso, liberación o sanción interna.</li>
                            </ul>
                            <p>Las decisiones operativas de Pipol serán finales dentro de la plataforma.</p>

                            <hr class="section-divider my-5">

                            {{-- ============================================ --}}
                            {{-- POLÍTICA DE MENTORES                         --}}
                            {{-- ============================================ --}}

                            <div class="flex items-center gap-3 mt-8 mb-2">
                                <div class="w-10 h-10 rounded-full bg-purple-900/40 border border-purple-700/50 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-white mb-0" id="sec-mentores">Política de Mentores</h2>
                            </div>

                            <hr class="section-divider my-5">

                            <h3>1. Rol del Mentor</h3>
                            <p>El Mentor es un prestador independiente y no mantiene relación laboral con Pipol.</p>
                            <p>Es responsable de:</p>
                            <ul>
                                <li>Sus declaraciones.</li>
                                <li>Sus recomendaciones.</li>
                                <li>Cumplimiento legal y fiscal.</li>
                            </ul>

                            <hr class="section-divider my-5">

                            <h3>2. Estándares Mínimos</h3>
                            <p>Todo Mentor debe:</p>
                            <ul>
                                <li>Brindar información verdadera.</li>
                                <li>Cumplir horarios.</li>
                                <li>Mantener trato respetuoso.</li>
                                <li>Ofrecer servicios alineados a su perfil.</li>
                                <li>Mantener confidencialidad.</li>
                            </ul>

                            <hr class="section-divider my-5">

                            <h3>3. Prohibiciones</h3>
                            <div class="danger-box">
                                <ul style="margin: 0;">
                                    <li style="color: #F87171;">Cobrar fuera de Pipol.</li>
                                    <li style="color: #F87171;">Mentir sobre experiencia.</li>
                                    <li style="color: #F87171;">Abandonar sesiones.</li>
                                    <li style="color: #F87171;">Ofrecer servicios ilegales.</li>
                                    <li style="color: #F87171;">Acosar, discriminar o manipular.</li>
                                </ul>
                            </div>

                            <hr class="section-divider my-5">

                            <h3>4. Medidas Disciplinarias</h3>
                            <p>Pipol podrá aplicar:</p>
                            <ul>
                                <li>Advertencias.</li>
                                <li>Suspensión temporal.</li>
                                <li>Reducción de visibilidad.</li>
                                <li>Eliminación definitiva.</li>
                                <li>Bloqueo de fondos ante investigaciones.</li>
                            </ul>

                            <hr class="section-divider my-5">

                            {{-- ============================================ --}}
                            {{-- POLÍTICA DE COMUNIDAD SEGURA                 --}}
                            {{-- ============================================ --}}

                            <div class="flex items-center gap-3 mt-8 mb-2">
                                <div class="w-10 h-10 rounded-full bg-purple-900/40 border border-purple-700/50 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-white mb-0" id="sec-comunidad">Política de Comunidad Segura, Acoso y Discriminación</h2>
                            </div>

                            <hr class="section-divider my-5">

                            <h3>1. Principio General</h3>
                            <p>Pipol es un espacio seguro, inclusivo y libre de discriminación.</p>
                            <p>Está prohibida toda conducta de:</p>
                            <ul>
                                <li>Acoso.</li>
                                <li>Abuso.</li>
                                <li>Violencia.</li>
                                <li>Exposición sexual.</li>
                                <li>Lenguaje ofensivo.</li>
                                <li>Discriminación de cualquier tipo.</li>
                            </ul>

                            <hr class="section-divider my-5">

                            <h3>2. Denuncias</h3>
                            <p>Cualquier usuario puede denunciar desde el chat o soporte.</p>
                            <p>Deberá aportar evidencia:</p>
                            <ul>
                                <li>Capturas de pantalla.</li>
                                <li>Mensajes.</li>
                                <li>Audios.</li>
                                <li>Grabaciones.</li>
                            </ul>

                            <hr class="section-divider my-5">

                            <h3>3. Medidas Posibles</h3>
                            <ul>
                                <li>Suspensión preventiva inmediata.</li>
                                <li>Investigación interna.</li>
                                <li>Cancelación definitiva.</li>
                                <li>Retención o devolución de fondos.</li>
                                <li>Comunicación a autoridades si correspondiera.</li>
                            </ul>
                            <p>Pipol, aunque no controla los contenidos, sí es responsable de preservar un entorno seguro.</p>

                            <hr class="section-divider my-5">

                            {{-- ============================================ --}}
                            {{-- POLÍTICA DE REPUTACIÓN Y CALIFICACIONES      --}}
                            {{-- ============================================ --}}

                            <div class="flex items-center gap-3 mt-8 mb-2">
                                <div class="w-10 h-10 rounded-full bg-purple-900/40 border border-purple-700/50 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-white mb-0" id="sec-reputacion">Política de Reputación y Calificaciones</h2>
                            </div>

                            <hr class="section-divider my-5">

                            <h3>1. Sistema de Reputación</h3>
                            <p>Luego de cada sesión, el Mentee deberá:</p>
                            <ul>
                                <li>Calificar al Mentor.</li>
                                <li>Dejar comentarios públicos.</li>
                            </ul>

                            <hr class="section-divider my-5">

                            <h3>2. Uso de la Reputación</h3>
                            <p>Las calificaciones impactan en:</p>
                            <ul>
                                <li>Visibilidad dentro de la Plataforma.</li>
                                <li>Niveles del Mentor.</li>
                                <li>Permanencia en la Plataforma.</li>
                            </ul>

                            <hr class="section-divider my-5">

                            <h3>3. Manipulación</h3>
                            <p>Está prohibido:</p>
                            <div class="danger-box">
                                <ul style="margin: 0;">
                                    <li style="color: #F87171;">Comprar reseñas.</li>
                                    <li style="color: #F87171;">Presionar usuarios.</li>
                                    <li style="color: #F87171;">Crear cuentas falsas.</li>
                                </ul>
                            </div>
                            <p>Pipol podrá eliminar valoraciones fraudulentas y sancionar cuentas.</p>

                            <hr class="section-divider my-5">

                            {{-- ============================================ --}}
                            {{-- PIPOL FOR BUSINESS (FRACTIONAL)              --}}
                            {{-- ============================================ --}}

                            <div class="flex items-center gap-3 mt-8 mb-2">
                                <div class="w-10 h-10 rounded-full bg-purple-900/40 border border-purple-700/50 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                                        <line x1="3" y1="6" x2="21" y2="6"/>
                                        <path d="M16 10a4 4 0 0 1-8 0"/>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-white mb-0" id="sec-business">Cláusulas — Pipol for Business (Fractional)</h2>
                            </div>

                            <hr class="section-divider my-5">

                            <h3>1. Naturaleza del Vínculo – No Relación Laboral</h3>
                            <p>Las partes reconocen expresamente que el Profesional presta sus servicios en carácter de trabajador independiente, sin que exista relación laboral alguna con la Empresa ni con Pipol.</p>
                            <p>En ningún caso se entenderá que el presente acuerdo genera una relación de dependencia, sociedad, asociación, mandato, agencia o vínculo laboral de ningún tipo entre las partes.</p>

                            <hr class="section-divider my-5">

                            <h3>2. Rol de Pipol como Intermediario</h3>
                            <p>Pipol actúa exclusivamente como plataforma de intermediación, facilitando el contacto entre la Empresa y el Profesional, gestionando el marco contractual, la coordinación del servicio y los pagos correspondientes.</p>
                            <p>Pipol no dirige, supervisa ni controla la ejecución técnica de los servicios prestados por el Profesional, los cuales son realizados bajo su exclusiva responsabilidad.</p>

                            <hr class="section-divider my-5">

                            <h3>3. Autonomía Técnica y Ausencia de Subordinación</h3>
                            <p>El Profesional ejecutará los servicios con plena autonomía técnica y organizativa, sin estar sujeto a órdenes jerárquicas, instrucciones operativas diarias ni control horario por parte de la Empresa ni de Pipol.</p>
                            <p>La Empresa podrá definir objetivos, prioridades y resultados esperados, sin que ello implique subordinación laboral.</p>

                            <hr class="section-divider my-5">

                            <h3>4. Dedicación Estimada – No Jornada Laboral</h3>
                            <p>La dedicación indicada en el presente acuerdo constituye una estimación de tiempo necesaria para la correcta prestación del servicio y no configura jornada laboral, horario fijo ni disponibilidad exclusiva.</p>
                            <p>El Profesional organizará libremente su tiempo de trabajo, conforme a los objetivos y entregables acordados.</p>

                            <hr class="section-divider my-5">

                            <h3>5. No Exclusividad</h3>
                            <p>El Profesional declara y la Empresa acepta que no existe exclusividad, pudiendo el Profesional prestar servicios a otros clientes de manera simultánea, siempre que ello no afecte el cumplimiento de las obligaciones asumidas en el presente acuerdo.</p>

                            <hr class="section-divider my-5">

                            <h3>6. Honorarios – Naturaleza No Salarial</h3>
                            <p>Los importes abonados al Profesional constituyen honorarios por servicios profesionales, no revisten carácter salarial ni generan derechos laborales, previsionales, indemnizatorios ni de seguridad social.</p>
                            <p>El Profesional será el único responsable del cumplimiento de sus obligaciones fiscales, previsionales y tributarias.</p>

                            <hr class="section-divider my-5">

                            <h3>7. Duración Limitada y Renovaciones Expresas</h3>
                            <p>El presente acuerdo tendrá una duración determinada, según lo indicado en el Anexo de Servicio, y no se considerará de carácter indefinido.</p>
                            <p>Toda renovación deberá realizarse de manera expresa y por escrito, sin que la continuidad en la prestación implique prórroga automática.</p>

                            <hr class="section-divider my-5">

                            <h3>8. Reemplazo y Continuidad del Servicio</h3>
                            <p>En caso de indisponibilidad del Profesional, falta de adecuación al servicio o decisión de cualquiera de las partes de dar por finalizado el acuerdo, Pipol podrá proponer un profesional alternativo, sin que ello implique obligación de aceptación por parte de la Empresa.</p>

                            <hr class="section-divider my-5">

                            <h3>9. Limitación de Responsabilidad de Pipol</h3>
                            <p>Pipol no será responsable por los resultados técnicos, operativos o comerciales derivados de los servicios prestados por el Profesional.</p>
                            <p>La responsabilidad de Pipol se limita a su rol de intermediación, gestión del marco contractual y administración de pagos, conforme a lo establecido en el presente acuerdo.</p>

                            <hr class="section-divider my-5">

                            <h3>10. Ausencia de Integración Organizacional</h3>
                            <p>El Profesional no forma parte de la estructura organizativa de la Empresa, no ocupa cargo alguno dentro de su organigrama, ni representa a la Empresa frente a terceros, salvo autorización expresa y específica.</p>

                            <hr class="section-divider my-5">

                            <h3>11. Terminación Anticipada</h3>
                            <p>Cualquiera de las partes podrá dar por finalizado el presente acuerdo, sin expresión de causa, mediante notificación escrita con un preaviso razonable, sin que ello genere derecho a indemnización laboral alguna.</p>

                            <hr class="section-divider my-5">

                            <h3>12. Reconocimiento Expreso de las Partes</h3>
                            <p>Las partes declaran haber comprendido plenamente la naturaleza del presente acuerdo, reconociendo que el mismo no persigue la sustitución permanente de un puesto laboral, sino la cobertura temporal o fraccional de una necesidad específica del negocio.</p>

                            <hr class="section-divider my-5">

                            <h3>13. Jurisdicción y Ley Aplicable</h3>
                            <p>El presente acuerdo se regirá por las leyes de la República Argentina, en particular por las disposiciones del Código Civil y Comercial de la Nación y la normativa aplicable.</p>
                            <p>Para cualquier controversia derivada de la interpretación, ejecución o cumplimiento del presente acuerdo, las partes se someten a la jurisdicción de los tribunales ordinarios con competencia en la Ciudad Autónoma de Buenos Aires, renunciando a cualquier otro fuero o jurisdicción que pudiera corresponder.</p>

                            <hr class="section-divider my-5">

                            <!-- Footer -->
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
