<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

function registrarUltimoErrorCorreo(?string $mensaje): void {
    $GLOBALS['ultimoErrorCorreo'] = $mensaje ?? '';
}

function enviarCorreoConEnlace(string $emailDestinatario, string $enlaceVerificacion, array $config): bool {
    try {
        registrarUltimoErrorCorreo(null);
		$apiKey = defined('RESEND_API_KEY') ? RESEND_API_KEY : (getenv('RESEND_API_KEY') ?: '');

		if ($apiKey === '') {
			throw new RuntimeException('RESEND_API_KEY no está configurado.');
		}

		$resend = Resend::client($apiKey);
        $remitente = defined('MAIL_FROM') ? MAIL_FROM : (getenv('MAIL_FROM') ?: '');

        if ($remitente === '') {
            throw new RuntimeException('MAIL_FROM no está configurado.');
        }

        $cuerpo = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
            <div style="background-color: #212529; padding: 20px; text-align: center;">
                <h1 style="color: #e0a800; margin: 0; font-size: 24px;">NovaShopping</h1>
            </div>
            <div style="padding: 30px;">
                <h2 style="color: #212529; margin-top: 0;">' . $config['titulo'] . '</h2>
                <p style="color: #495057; line-height: 1.6;">
                    ' . $config['descripcion'] . '
                </p>
                <div style="text-align: center; margin: 30px 0;">
                    <a href="' . htmlspecialchars($enlaceVerificacion) . '" 
                       style="background-color: ' . $config['colorBoton'] . '; color: ' . $config['colorTextoBtn'] . '; text-decoration: none; padding: 14px 30px; border-radius: 50px; font-size: 16px; font-weight: bold; display: inline-block;">
                        ' . $config['textoBoton'] . '
                    </a>
                </div>
                <p style="color: #6c757d; font-size: 13px; line-height: 1.5;">
                    Si el botón no funciona, copiá y pegá este enlace en tu navegador:<br>
                    <a href="' . htmlspecialchars($enlaceVerificacion) . '" style="color: #0d6efd; word-break: break-all;">' . htmlspecialchars($enlaceVerificacion) . '</a>
                </p>
                ' . ($config['infoExtra'] ?? '') . '
                <div style="background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 4px; padding: 15px; margin: 20px 0;">
                    <p style="color: #856404; margin: 0; font-size: 13px;">
                        <strong>⏳ Este enlace expira en ' . $config['expiracion'] . '.</strong>
                    </p>
                </div>
                <p style="color: #6c757d; font-size: 14px; margin-top: 20px;">
                    Si no realizaste esta solicitud, podés ignorar este correo.
                </p>
            </div>
            <div style="background-color: #212529; padding: 15px; text-align: center;">
                <p style="color: #e0a800; margin: 0; font-size: 12px;">NovaShopping — Todos los derechos reservados</p>
            </div>
        </div>';

        $resend->emails->send([
            'from'    => $remitente,
            'to'      => [$emailDestinatario],
            'subject' => $config['asunto'],
            'html'    => $cuerpo,
            'text'    => $config['altBody'],
        ]);

        return true;
    } catch (\Exception $e) {
        registrarUltimoErrorCorreo($e->getMessage());
        error_log("Error al enviar correo a $emailDestinatario: " . $e->getMessage());
        return false;
    }
}

function enviarCorreoVerificacion(string $emailDestinatario, string $tipoUsuario, string $enlaceVerificacion): bool {
    $infoExtra = '
                <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                    <tr>
                        <td style="padding: 8px 12px; border: 1px solid #dee2e6; background-color: #e9ecef; font-weight: bold; color: #495057;">Correo</td>
                        <td style="padding: 8px 12px; border: 1px solid #dee2e6; color: #495057;">' . htmlspecialchars($emailDestinatario) . '</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 12px; border: 1px solid #dee2e6; background-color: #e9ecef; font-weight: bold; color: #495057;">Tipo de cuenta</td>
                        <td style="padding: 8px 12px; border: 1px solid #dee2e6; color: #495057;">' . htmlspecialchars($tipoUsuario) . '</td>
                    </tr>
                </table>';

    return enviarCorreoConEnlace($emailDestinatario, $enlaceVerificacion, [
        'asunto'        => 'Verificá tu email — NovaShopping',
        'titulo'        => 'Verificá tu dirección de email',
        'descripcion'   => 'Gracias por registrarte en <strong>NovaShopping</strong>. Para activar tu cuenta, hacé clic en el siguiente botón:',
        'textoBoton'    => 'Verificar mi email',
        'colorBoton'    => '#0d6efd',
        'colorTextoBtn' => '#ffffff',
        'expiracion'    => '24 horas',
        'infoExtra'     => $infoExtra,
        'altBody'       => "Verificá tu email en NovaShopping\n\nHacé clic en este enlace para activar tu cuenta:\n$enlaceVerificacion\n\nEste enlace expira en 24 horas.\n\nCorreo: $emailDestinatario\nTipo de cuenta: $tipoUsuario",
    ]);
}

function enviarCorreoCambioEmail(string $emailNuevo, string $emailAnterior, string $enlaceVerificacion): bool {
    $infoExtra = '
                <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                    <tr>
                        <td style="padding: 8px 12px; border: 1px solid #dee2e6; background-color: #e9ecef; font-weight: bold; color: #495057;">Email anterior</td>
                        <td style="padding: 8px 12px; border: 1px solid #dee2e6; color: #495057;">' . htmlspecialchars($emailAnterior) . '</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 12px; border: 1px solid #dee2e6; background-color: #e9ecef; font-weight: bold; color: #495057;">Nuevo email</td>
                        <td style="padding: 8px 12px; border: 1px solid #dee2e6; color: #495057;">' . htmlspecialchars($emailNuevo) . '</td>
                    </tr>
                </table>';

    return enviarCorreoConEnlace($emailNuevo, $enlaceVerificacion, [
        'asunto'        => 'Confirmá tu nuevo email — NovaShopping',
        'titulo'        => 'Cambio de dirección de email',
        'descripcion'   => 'Recibimos una solicitud para cambiar el email de tu cuenta en <strong>NovaShopping</strong>. Para confirmar el cambio, hacé clic en el siguiente botón:',
        'textoBoton'    => 'Confirmar nuevo email',
        'colorBoton'    => '#0d6efd',
        'colorTextoBtn' => '#ffffff',
        'expiracion'    => '24 horas',
        'infoExtra'     => $infoExtra,
        'altBody'       => "Confirmá tu nuevo email en NovaShopping\n\nHacé clic en este enlace para confirmar el cambio:\n$enlaceVerificacion\n\nEste enlace expira en 24 horas.\n\nEmail anterior: $emailAnterior\nNuevo email: $emailNuevo",
    ]);
}

function enviarCorreoResetPassword(string $emailDestinatario, string $enlaceReset): bool {
    return enviarCorreoConEnlace($emailDestinatario, $enlaceReset, [
        'asunto'        => 'Restablecé tu contraseña — NovaShopping',
        'titulo'        => 'Restablecimiento de contraseña',
        'descripcion'   => 'Recibimos una solicitud para restablecer la contraseña de tu cuenta en <strong>NovaShopping</strong>. Hacé clic en el siguiente botón para elegir una nueva contraseña:',
        'textoBoton'    => 'Restablecer contraseña',
        'colorBoton'    => '#dc3545',
        'colorTextoBtn' => '#ffffff',
        'expiracion'    => '1 hora',
        'altBody'       => "Restablecé tu contraseña en NovaShopping\n\nHacé clic en este enlace para restablecer tu contraseña:\n$enlaceReset\n\nEste enlace expira en 1 hora.\n\nSi no solicitaste este cambio, ignorá este correo.",
    ]);
}

function enviarVerificacionNewsletter(string $emailDestinatario, string $enlaceVerificacion): bool {
    return enviarCorreoConEnlace($emailDestinatario, $enlaceVerificacion, [
        'asunto'        => 'Confirmá tu suscripción al Newsletter — NovaShopping',
        'titulo'        => 'Confirmá tu suscripción',
        'descripcion'   => 'Recibimos una solicitud para suscribir <strong>' . htmlspecialchars($emailDestinatario) . '</strong> al newsletter de <strong>NovaShopping</strong>.<br>Para confirmar y empezar a recibir noticias y ofertas especiales, hacé clic en el siguiente botón:',
        'textoBoton'    => 'Confirmar suscripción',
        'colorBoton'    => '#e0a800',
        'colorTextoBtn' => '#212529',
        'expiracion'    => '48 horas',
        'altBody'       => "Confirmá tu suscripción al Newsletter de NovaShopping\n\nHacé clic en este enlace para confirmar:\n$enlaceVerificacion\n\nEste enlace expira en 48 horas.\n\nSi no solicitaste esta suscripción, ignorá este correo.",
    ]);
}
