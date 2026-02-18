<?php
/**
 * Módulo de envío de correos - PHPMailer
 * 
 * Funciones reutilizables para enviar correos electrónicos
 * desde distintas partes de la aplicación.
 */

require_once __DIR__ . '/../vendor/autoload.php';
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
 * Envía un correo de confirmación de suscripción al newsletter.
 * 
 * @param string $emailDestinatario correo del suscriptor
 * @return bool true si se envió correctamente
 */
function enviarConfirmacionNewsletter(string $emailDestinatario): bool {
    try {
        $mail = crearMailer();
        $mail->addAddress($emailDestinatario);
        $mail->isHTML(true);

        $mail->Subject = '¡Bienvenido al Newsletter de NovaShopping!';
        $mail->Body    = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
            <div style="background-color: #212529; padding: 20px; text-align: center;">
                <h1 style="color: #e0a800; margin: 0; font-size: 24px;">NovaShopping</h1>
            </div>
            <div style="padding: 30px;">
                <h2 style="color: #212529; margin-top: 0;">¡Gracias por suscribirte!</h2>
                <p style="color: #495057; line-height: 1.6;">
                    Tu suscripción al newsletter de <strong>NovaShopping</strong> ha sido registrada exitosamente.
                </p>
                <p style="color: #495057; line-height: 1.6;">
                    A partir de ahora recibirás las últimas noticias, ofertas especiales y novedades de nuestro centro comercial directamente en tu bandeja de entrada.
                </p>
                <div style="background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 4px; padding: 15px; margin: 20px 0;">
                    <p style="color: #856404; margin: 0;">
                        <strong>📧 Correo registrado:</strong> ' . htmlspecialchars($emailDestinatario) . '
                    </p>
                </div>
                <p style="color: #6c757d; font-size: 14px; margin-top: 20px;">
                    Si no solicitaste esta suscripción, puedes ignorar este correo.
                </p>
            </div>
            <div style="background-color: #212529; padding: 15px; text-align: center;">
                <p style="color: #e0a800; margin: 0; font-size: 12px;">NovaShopping — Todos los derechos reservados</p>
            </div>
        </div>';
        $mail->AltBody = "¡Gracias por suscribirte al newsletter de NovaShopping!\n\nTu correo ($emailDestinatario) ha sido registrado exitosamente.\nRecibirás noticias y ofertas especiales.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error al enviar correo de newsletter a $emailDestinatario: " . $e->getMessage());
        return false;
    }
}

/**
 * Envía un correo de confirmación de registro de usuario.
 * 
 * @param string $emailDestinatario correo del nuevo usuario
 * @param string $tipoUsuario tipo de cuenta (Cliente / Dueño)
 * @return bool true si se envió correctamente
 */
function enviarConfirmacionRegistro(string $emailDestinatario, string $tipoUsuario = 'Cliente'): bool {
    try {
        $mail = crearMailer();
        $mail->addAddress($emailDestinatario);
        $mail->isHTML(true);

        $estadoMsg = '';
        if ($tipoUsuario === 'Dueño') {
            $estadoMsg = '<div style="background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 4px; padding: 15px; margin: 20px 0;">
                <p style="color: #856404; margin: 0;">
                    <strong>⏳ Cuenta de Dueño de Local:</strong> Tu cuenta está pendiente de aprobación por un administrador. Te notificaremos cuando sea activada.
                </p>
            </div>';
        } else {
            $estadoMsg = '<div style="background-color: #d4edda; border: 1px solid #28a745; border-radius: 4px; padding: 15px; margin: 20px 0;">
                <p style="color: #155724; margin: 0;">
                    <strong>✅ Cuenta activa:</strong> Ya puedes iniciar sesión y empezar a disfrutar de las promociones.
                </p>
            </div>';
        }

        $mail->Subject = 'Confirmación de Registro — NovaShopping';
        $mail->Body    = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
            <div style="background-color: #212529; padding: 20px; text-align: center;">
                <h1 style="color: #e0a800; margin: 0; font-size: 24px;">NovaShopping</h1>
            </div>
            <div style="padding: 30px;">
                <h2 style="color: #212529; margin-top: 0;">¡Registro exitoso!</h2>
                <p style="color: #495057; line-height: 1.6;">
                    Tu cuenta en <strong>NovaShopping</strong> ha sido creada correctamente.
                </p>
                <table style="width: 100%; border-collapse: collapse; margin: 15px 0;">
                    <tr>
                        <td style="padding: 8px 12px; border: 1px solid #dee2e6; background-color: #e9ecef; font-weight: bold; color: #495057;">Correo</td>
                        <td style="padding: 8px 12px; border: 1px solid #dee2e6; color: #495057;">' . htmlspecialchars($emailDestinatario) . '</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 12px; border: 1px solid #dee2e6; background-color: #e9ecef; font-weight: bold; color: #495057;">Tipo de cuenta</td>
                        <td style="padding: 8px 12px; border: 1px solid #dee2e6; color: #495057;">' . htmlspecialchars($tipoUsuario) . '</td>
                    </tr>
                </table>
                ' . $estadoMsg . '
                <p style="color: #495057; line-height: 1.6;">
                    Si no creaste esta cuenta, por favor ignora este correo o contáctanos.
                </p>
            </div>
            <div style="background-color: #212529; padding: 15px; text-align: center;">
                <p style="color: #e0a800; margin: 0; font-size: 12px;">NovaShopping — Todos los derechos reservados</p>
            </div>
        </div>';
        $mail->AltBody = "¡Registro exitoso en NovaShopping!\n\nCorreo: $emailDestinatario\nTipo de cuenta: $tipoUsuario\n\n" .
            ($tipoUsuario === 'Dueño' 
                ? "Tu cuenta está pendiente de aprobación por un administrador." 
                : "Tu cuenta ya está activa. Puedes iniciar sesión.");

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error al enviar correo de registro a $emailDestinatario: " . $e->getMessage());
        return false;
    }
}

?>
