<?php
/**
 * Configuración de correo SMTP - PHPMailer (PLANTILLA)
 * 
 * INSTRUCCIONES:
 * 1. Copia este archivo como mailConfig.php en la misma carpeta
 *    cp php/mailConfig.example.php php/mailConfig.php
 * 
 * 2. Rellena tus credenciales SMTP de Gmail.
 * 
 * Para Gmail, necesitas una "Contraseña de aplicación":
 * 1. Activa la verificación en 2 pasos en tu cuenta de Google
 * 2. Ve a https://myaccount.google.com/apppasswords
 * 3. Genera una contraseña de aplicación para "Correo"
 * 4. Usa esa contraseña (16 caracteres) como MAIL_PASSWORD
 */

// Configuración del servidor SMTP
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_ENCRYPTION', 'tls');

// Credenciales de la cuenta de correo
define('MAIL_USERNAME', 'tu-correo@gmail.com');       // Tu correo de Gmail
define('MAIL_PASSWORD', 'xxxx xxxx xxxx xxxx');        // Contraseña de aplicación de Google

// Datos del remitente (aparecen en los correos enviados)
define('MAIL_FROM_ADDRESS', 'tu-correo@gmail.com');    // Mismo que MAIL_USERNAME
define('MAIL_FROM_NAME', 'NovaShopping');

?>
