<?php
/**
 * Procesar restablecimiento de contraseña
 * 
 * Recibe el token y la nueva contraseña, valida todo
 * y actualiza la contraseña del usuario.
 */
require_once __DIR__ . '/main.php';

// Iniciar sesión para mensajes flash
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name("UNR");
    session_start();
}

$token = $_POST['token'] ?? '';
$claveNueva1 = limpiar_cadena($_POST['claveNueva1'] ?? '');
$claveNueva2 = limpiar_cadena($_POST['claveNueva2'] ?? '');

// Validar campos obligatorios
if ($token == '' || $claveNueva1 == '' || $claveNueva2 == '') {
    $_SESSION['mensaje'] = ['texto' => 'Todos los campos son obligatorios.', 'tipo' => 'danger'];
    header("Location: ../index.php?vista=resetPassword&token=" . urlencode($token));
    exit();
}

// Validar token
if (strlen($token) !== 64) {
    $_SESSION['mensaje'] = ['texto' => 'Token inválido.', 'tipo' => 'danger'];
    header("Location: ../index.php?vista=login");
    exit();
}

// Validar formato de nueva clave
if (verificarDatos("[a-zA-Z0-9\$@.-]{7,100}", $claveNueva1)) {
    $_SESSION['mensaje'] = ['texto' => 'La contraseña debe tener al menos 7 caracteres.', 'tipo' => 'danger'];
    header("Location: ../index.php?vista=resetPassword&token=" . urlencode($token));
    exit();
}

// Verificar que las claves coincidan
if ($claveNueva1 !== $claveNueva2) {
    $_SESSION['mensaje'] = ['texto' => 'Las contraseñas no coinciden.', 'tipo' => 'danger'];
    header("Location: ../index.php?vista=resetPassword&token=" . urlencode($token));
    exit();
}

$conexion = conexion();

// Buscar token válido
$stmt = $conexion->prepare("SELECT tv.codUsuario, tv.expiracion 
                            FROM tokens_verificacion tv 
                            WHERE tv.token = ? AND tv.tipo = 'reset_password'");
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    $stmt->close();
    $conexion->close();
    $_SESSION['mensaje'] = ['texto' => 'El enlace de restablecimiento no es válido o ya fue utilizado.', 'tipo' => 'danger'];
    header("Location: ../index.php?vista=olvideMiClave");
    exit();
}

$fila = $res->fetch_assoc();
$stmt->close();

// Verificar expiración
if (strtotime($fila['expiracion']) < time()) {
    $stmtDel = $conexion->prepare("DELETE FROM tokens_verificacion WHERE token = ?");
    $stmtDel->bind_param("s", $token);
    $stmtDel->execute();
    $stmtDel->close();
    $conexion->close();
    $_SESSION['mensaje'] = ['texto' => 'El enlace de restablecimiento ha expirado. Solicitá uno nuevo.', 'tipo' => 'danger'];
    header("Location: ../index.php?vista=olvideMiClave");
    exit();
}

// Encriptar nueva contraseña y actualizar
$claveHash = password_hash($claveNueva1, PASSWORD_BCRYPT, ["cost" => 10]);

$stmtUpdate = $conexion->prepare("UPDATE usuarios SET claveUsuario = ? WHERE codUsuario = ?");
$stmtUpdate->bind_param("si", $claveHash, $fila['codUsuario']);
$stmtUpdate->execute();
$stmtUpdate->close();

// Eliminar token usado
$stmtDel = $conexion->prepare("DELETE FROM tokens_verificacion WHERE token = ?");
$stmtDel->bind_param("s", $token);
$stmtDel->execute();
$stmtDel->close();

// Eliminar también cualquier otro token de reset pendiente para este usuario
$stmtDelAll = $conexion->prepare("DELETE FROM tokens_verificacion WHERE codUsuario = ? AND tipo = 'reset_password'");
$stmtDelAll->bind_param("i", $fila['codUsuario']);
$stmtDelAll->execute();
$stmtDelAll->close();

$conexion->close();

$_SESSION['mensaje'] = [
    'texto' => '¡Contraseña restablecida exitosamente! Ya podés iniciar sesión con tu nueva contraseña.',
    'tipo' => 'success'
];
header("Location: ../index.php?vista=login");
exit();
?>
