<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva notificación — Pipol</title>
</head>
<body style="margin: 0; padding: 0; background-color: #0F071A; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">

    <!-- Wrapper -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #0F071A;">
        <tr>
            <td align="center" style="padding: 40px 16px 60px;">

                <!-- Container -->
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 520px;">

                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding-bottom: 32px;">
                            <img src="{{ asset('/images/logo-clea-recorte.png') }}" alt="Pipol" height="36" style="display: inline-block; height: 36px;">
                        </td>
                    </tr>

                    <!-- Card -->
                    <tr>
                        <td style="background-color: #140A24; border: 1px solid rgba(107, 114, 128, 0.3); border-radius: 24px; padding: 36px 32px;">

                            <!-- Icon -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 24px;">
                                        <div style="width: 56px; height: 56px; background-color: rgba(139, 92, 246, 0.15); border-radius: 50%; text-align: center; line-height: 56px;">
                                            <span style="font-size: 26px; line-height: 56px;">🔔</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Heading -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 8px;">
                                        <h1 style="margin: 0; font-size: 22px; font-weight: 700; color: #FFFFFF; line-height: 1.3;">
                                            Tenés una nueva notificación
                                        </h1>
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding: 20px 0;">
                                        <div style="height: 1px; background-color: rgba(107, 114, 128, 0.3);"></div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Message block -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="background-color: #20152E; border-radius: 12px; padding: 20px;">
                                        <p style="margin: 0; font-size: 15px; color: #E5E7EB; line-height: 1.7;">
                                            {{ $mensaje }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding: 24px 0;">
                                        <div style="height: 1px; background-color: rgba(107, 114, 128, 0.3);"></div>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <!--[if mso]>
                                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ $url }}" style="height:48px;v-text-anchor:middle;width:100%;" arcsize="25%" fillcolor="#8B5CF6">
                                        <w:anchorlock/>
                                        <center style="color:#ffffff;font-family:Helvetica,Arial,sans-serif;font-size:15px;font-weight:600;">Ver más</center>
                                        </v:roundrect>
                                        <![endif]-->
                                        <!--[if !mso]><!-->
                                        <a href="{{ $url }}" target="_blank" style="display: block; width: 100%; padding: 14px 24px; background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); color: #FFFFFF; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 12px; text-align: center; box-sizing: border-box;">
                                            Ver más
                                        </a>
                                        <!--<![endif]-->
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Fallback URL -->
                    <tr>
                        <td align="center" style="padding-top: 24px; padding-bottom: 8px;">
                            <p style="margin: 0; font-size: 12px; color: #6B7280; line-height: 1.5;">
                                Si el botón no funciona, copiá y pegá este enlace en tu navegador:
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-bottom: 32px; word-break: break-all;">
                            <a href="{{ $url }}" style="font-size: 12px; color: #8B5CF6; text-decoration: underline; line-height: 1.5;">{{ $url }}</a>
                        </td>
                    </tr>

                    <!-- Footer divider -->
                    <tr>
                        <td style="padding-bottom: 24px;">
                            <div style="height: 1px; background-color: rgba(107, 114, 128, 0.2);"></div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center">
                            <p style="margin: 0 0 6px; font-size: 13px; color: #6B7280; line-height: 1.5;">
                                Saludos, el equipo de <strong style="color: #9CA3AF;">Pipol</strong>
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #4B5563; line-height: 1.5;">
                                © {{ date('Y') }} Pipol. Todos los derechos reservados.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- /Container -->

            </td>
        </tr>
    </table>
    <!-- /Wrapper -->

</body>
</html>
