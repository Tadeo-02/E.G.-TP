<?php
/**
 * Procesa la suscripción al newsletter.
 * Recibe el email por POST (AJAX), guarda en BD con estado pendiente,
 * genera token de verificación y envía correo con enlace de confirmación.
 * Responde en JSON para ser consumido por el frontend.
 */

header('Content-Type: application/json; charset=UTF-8');


require_once __DIR__ . '/main.php';
require_once __DIR__ . '/mailer.php';
require_once __DIR__ . '/mailConfig.php';

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
$conn = conexion();


// Verificar si ya está suscrito y verificado
$stmt = $conn->prepare("SELECT id, verificado FROM suscriptores_newsletter WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $suscriptor = $resultado->fetch_assoc();
    $stmt->close();

    if ($suscriptor['verificado'] == 1) {
        // Ya verificado
        $conn->close();
        $response['success'] = true;
        $response['message'] = 'Este correo ya está suscrito al newsletter.';
        echo json_encode($response);
        exit();
    }

    // Existe pero no verificado — reenviar email de verificación
    $suscriptorId = $suscriptor['id'];

    // Eliminar tokens anteriores de newsletter para este suscriptor
    $stmtDel = $conn->prepare("DELETE FROM tokens_verificacion WHERE codUsuario = ? AND tipo = 'verificacion_newsletter'");
    $stmtDel->bind_param("i", $suscriptorId);
    $stmtDel->execute();
    $stmtDel->close();

} else {
    $stmt->close();

    // Insertar nuevo suscriptor (no verificado)
    $stmtInsert = $conn->prepare("INSERT INTO suscriptores_newsletter (email, verificado) VALUES (?, 0)");
    $stmtInsert->bind_param("s", $email);
    $stmtInsert->execute();
    $suscriptorId = $conn->insert_id;
    $stmtInsert->close();
}

// Generar token de verificación
$token = bin2hex(random_bytes(32));
$expiracion = date('Y-m-d H:i:s', strtotime('+48 hours'));

// Guardar token (usamos codUsuario para guardar el ID del suscriptor)
$stmtToken = $conn->prepare("INSERT INTO tokens_verificacion (codUsuario, token, tipo, expiracion) VALUES (?, ?, 'verificacion_newsletter', ?)");
$stmtToken->bind_param("iss", $suscriptorId, $token, $expiracion);
$stmtToken->execute();
$stmtToken->close();
$conn->close();

// Enviar correo con enlace de verificación
$enlaceVerificacion = APP_URL . '/index.php?vista=verificarNewsletter&token=' . $token;

if (enviarVerificacionNewsletter($email, $enlaceVerificacion)) {
    $response['success'] = true;
    $response['message'] = '¡Revisá tu correo! Te enviamos un enlace para confirmar tu suscripción.';
} else {
    $response['message'] = 'No se pudo enviar el correo de verificación. Intentá de nuevo más tarde.';
    http_response_code(500);
}

echo json_encode($response);
?>
