<?php

require_once __DIR__ . '/main.php';
require_once __DIR__ . '/mailer.php';

// Iniciar sesión para mensajes flash
iniciarSesion();

$email = limpiar_cadena($_POST['emailRecuperar'] ?? '');

// Validar campo obligatorio
if ($email == '') {
    $_SESSION['mensaje'] = ['texto' => 'Debés ingresar tu correo electrónico.', 'tipo' => 'danger'];
    header("Location: ../index.php?vista=olvideMiClave");
    exit();
}

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['mensaje'] = ['texto' => 'El correo electrónico no tiene un formato válido.', 'tipo' => 'danger'];
    header("Location: ../index.php?vista=olvideMiClave");
    exit();
}

$conexion = conexion();

// Buscar usuario con cuenta activa
$stmt = $conexion->prepare("SELECT codUsuario, estadoCuenta FROM usuarios WHERE nombreUsuario = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    $stmt->close();
    $conexion->close();
    $_SESSION['mensaje'] = [
        'texto' => 'No encontramos una cuenta activa con ese correo.',
        'tipo' => 'danger'
    ];
    header("Location: ../index.php?vista=olvideMiClave");
    exit();
}

$usuario = $res->fetch_assoc();
$stmt->close();

// Solo permitir reset para cuentas activas
if ($usuario['estadoCuenta'] !== 'Activa') {
    $conexion->close();
    $_SESSION['mensaje'] = [
        'texto' => 'No encontramos una cuenta activa con ese correo.',
        'tipo' => 'danger'
    ];
    header("Location: ../index.php?vista=olvideMiClave");
    exit();
}

// Eliminar tokens de reset anteriores para este usuario
$stmtDel = $conexion->prepare("DELETE FROM tokens_verificacion WHERE codUsuario = ? AND tipo = 'reset_password'");
$stmtDel->bind_param("i", $usuario['codUsuario']);
$stmtDel->execute();
$stmtDel->close();

// Generar token de reset (64 caracteres hex)
$token = bin2hex(random_bytes(32));
$expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));

// Guardar token en la BD
$stmtToken = $conexion->prepare("INSERT INTO tokens_verificacion (codUsuario, token, tipo, expiracion) VALUES (?, ?, 'reset_password', ?)");
$stmtToken->bind_param("iss", $usuario['codUsuario'], $token, $expiracion);
$stmtToken->execute();
$stmtToken->close();

// Enviar correo con enlace de restablecimiento
// En producción, APP_URL debe apuntar al dominio real del sitio, no a phpMyAdmin ni al puerto de la BD.
$enlaceReset = APP_URL . '/index.php?vista=resetPassword&token=' . $token;
if (!enviarCorreoResetPassword($email, $enlaceReset)) {
    $stmtDel = $conexion->prepare("DELETE FROM tokens_verificacion WHERE token = ?");
    $stmtDel->bind_param("s", $token);
    $stmtDel->execute();
    $stmtDel->close();
    $conexion->close();

    $_SESSION['mensaje'] = [
        'texto' => 'No se pudo enviar el correo. Intentá de nuevo más tarde.',
        'tipo' => 'danger'
    ];
    header("Location: ../index.php?vista=olvideMiClave");
    exit();
}

$conexion->close();

$_SESSION['mensaje'] = [
    'texto' => 'Se envió un correo para restablecer tu contraseña. Revisá tu bandeja de entrada.',
    'tipo' => 'success'
];
header("Location: ../index.php?vista=olvideMiClave");
exit();
?>
