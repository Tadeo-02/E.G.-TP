<?php
/**
 * Procesa la suscripción al newsletter.
 * Recibe el email por POST (AJAX) y envía un correo de confirmación.
 * Responde en JSON para ser consumido por el frontend.
 */

header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/mailer.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método no permitido.';
    http_response_code(405);
    echo json_encode($response);
    exit();
}

$email = isset($_POST['emailNewsletter']) ? trim($_POST['emailNewsletter']) : '';

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Por favor, ingresa un correo electrónico válido.';
    http_response_code(400);
    echo json_encode($response);
    exit();
}

// Enviar correo de confirmación de suscripción
if (enviarConfirmacionNewsletter($email)) {
    $response['success'] = true;
    $response['message'] = '¡Suscripción exitosa! Revisa tu bandeja de entrada.';
} else {
    $response['message'] = 'No se pudo enviar el correo de confirmación. Intenta de nuevo más tarde.';
    http_response_code(500);
}

echo json_encode($response);
?>
