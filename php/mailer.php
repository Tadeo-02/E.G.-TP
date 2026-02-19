<?php
/**
 * Módulo de envío de correos - PHPMailer
 * 
 * Funciones reutilizables para enviar correos electrónicos
 * desde distintas partes de la aplicación.
 */

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/mailConfig.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Crea y configura una instancia de PHPMailer con las credenciales SMTP.
 * 
 * @return PHPMailer instancia configurada
 */
function crearMailer(): PHPMailer {
    $mail = new PHPMailer(true);

    // Configuración del servidor
    $mail->isSMTP();
    $mail->Host       = MAIL_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = MAIL_USERNAME;
    $mail->Password   = MAIL_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = MAIL_PORT;

    // Configuración del remitente
    $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
    $mail->CharSet = 'UTF-8';

    return $mail;
}

/**
 * Función genérica para enviar correos con enlace de verificación.
 * Reutilizada por enviarCorreoVerificacion() y enviarVerificacionNewsletter().
 * 
 * @param string $emailDestinatario correo del destinatario
 * @param string $enlaceVerificacion URL completa con el token
 * @param array  $config configuración del correo:
 *   - 'asunto'       : asunto del email
 *   - 'titulo'       : título h2 del cuerpo
 *   - 'descripcion'  : párrafo descriptivo
 *   - 'textoBoton'   : texto del botón CTA
 *   - 'colorBoton'   : color de fondo del botón (hex)
 *   - 'colorTextoBtn': color del texto del botón (hex)
 *   - 'expiracion'   : texto de expiración (ej: "24 horas")
 *   - 'infoExtra'    : HTML adicional entre botón y aviso (opcional)
 *   - 'altBody'      : texto plano alternativo
 * @return bool true si se envió correctamente
 */
function enviarCorreoConEnlace(string $emailDestinatario, string $enlaceVerificacion, array $config): bool {
    try {
        $mail = crearMailer();
        $mail->addAddress($emailDestinatario);
        $mail->isHTML(true);

        $mail->Subject = $config['asunto'];
        $mail->Body    = '
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
        $mail->AltBody = $config['altBody'];

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error al enviar correo de verificación a $emailDestinatario: " . $e->getMessage());
        return false;
    }
}

/**
 * Envía un correo con enlace de verificación de email (registro de cuenta).
 */
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

/**
 * Envía un correo con enlace de verificación para suscripción al newsletter.
 */
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
?>