<?php
/**
 * Actualización de perfil del cliente
 * 
 * Acciones soportadas:
 * - cambiarEmail: Cambia email con re-verificación por correo
 * - cambiarClave: Cambia contraseña (requiere clave actual)
 */
require_once __DIR__ . '/../main.php';
require_once __DIR__ . '/../mailer.php';
require_once __DIR__ . '/../mailConfig.php';

// Iniciar sesión
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name("UNR");
    session_start();
}

// Verificar que sea un cliente logueado
if (!isset($_SESSION['codUsuario']) || $_SESSION['codUsuario'] == "" || $_SESSION['tipoUsuario'] !== 'Cliente') {
    header("Location: ../../index.php?vista=login");
    exit();
}

$accion = isset($_POST['accion']) ? $_POST['accion'] : '';

// =============================================
// ACCIÓN: Cambiar Nombre y Apellido
// =============================================
if ($accion === 'cambiarNombreApellido') {
    $nombrePersona = limpiar_cadena($_POST['nombrePersona'] ?? '');
    $apellidoPersona = limpiar_cadena($_POST['apellidoPersona'] ?? '');

    // Validar campos obligatorios
    if ($nombrePersona == '' || $apellidoPersona == '') {
        $_SESSION['perfil_mensaje'] = ['texto' => 'El nombre y apellido son obligatorios.', 'tipo' => 'danger'];
        header("Location: ../../index.php?vista=miPerfil");
        exit();
    }

    $conexion = conexion();

    $stmtUpdate = $conexion->prepare("UPDATE usuarios SET nombrePersona = ?, apellidoPersona = ? WHERE codUsuario = ?");
    $stmtUpdate->bind_param("ssi", $nombrePersona, $apellidoPersona, $_SESSION['codUsuario']);
    $stmtUpdate->execute();
    $stmtUpdate->close();
    $conexion->close();

    $_SESSION['perfil_mensaje'] = ['texto' => '¡Nombre y apellido actualizados exitosamente!', 'tipo' => 'success'];
    header("Location: ../../index.php?vista=miPerfil");
    exit();
}

// =============================================
// ACCIÓN: Cambiar Email
// =============================================
if ($accion === 'cambiarEmail') {
    $emailNuevo = limpiar_cadena($_POST['emailNuevo'] ?? '');
    $claveConfirm = $_POST['claveConfirmEmail'] ?? '';

    // Validar campos obligatorios
    if ($emailNuevo == '' || $claveConfirm == '') {
        $_SESSION['perfil_mensaje'] = ['texto' => 'Todos los campos son obligatorios.', 'tipo' => 'danger'];
        header("Location: ../../index.php?vista=miPerfil");
        exit();
    }

    // Validar formato de email
    if (!filter_var($emailNuevo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['perfil_mensaje'] = ['texto' => 'El nuevo email no tiene un formato válido.', 'tipo' => 'danger'];
        header("Location: ../../index.php?vista=miPerfil");
        exit();
    }

    $conexion = conexion();

    // Verificar contraseña actual
    $stmt = $conexion->prepare("SELECT claveUsuario, nombreUsuario FROM usuarios WHERE codUsuario = ?");
    $stmt->bind_param("i", $_SESSION['codUsuario']);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();

    if (!$user || !password_verify($claveConfirm, $user['claveUsuario'])) {
        $conexion->close();
        $_SESSION['perfil_mensaje'] = ['texto' => 'La contraseña ingresada es incorrecta.', 'tipo' => 'danger'];
        header("Location: ../../index.php?vista=miPerfil");
        exit();
    }

    // Verificar que el nuevo email no sea igual al actual
    if ($emailNuevo === $user['nombreUsuario']) {
        $conexion->close();
        $_SESSION['perfil_mensaje'] = ['texto' => 'El nuevo email es igual al actual.', 'tipo' => 'warning'];
        header("Location: ../../index.php?vista=miPerfil");
        exit();
    }

    // Verificar que el nuevo email no esté en uso por una cuenta activa
    $stmtCheck = $conexion->prepare("SELECT codUsuario, estadoCuenta FROM usuarios WHERE nombreUsuario = ?");
    $stmtCheck->bind_param("s", $emailNuevo);
    $stmtCheck->execute();
    $resCheck = $stmtCheck->get_result();
    if ($resCheck->num_rows > 0) {
        $cuentaExistente = $resCheck->fetch_assoc();
        if ($cuentaExistente['estadoCuenta'] !== 'Baja') {
            $stmtCheck->close();
            $conexion->close();
            $_SESSION['perfil_mensaje'] = ['texto' => 'El email ingresado ya está registrado por otro usuario.', 'tipo' => 'danger'];
            header("Location: ../../index.php?vista=miPerfil");
            exit();
        }
    }
    $stmtCheck->close();

    // Generar token de verificación para el cambio de email
    $token = bin2hex(random_bytes(32));
    $expiracion = date('Y-m-d H:i:s', strtotime('+24 hours'));

    // Guardar token con tipo 'cambio_email' y el nuevo email en la tabla tokens_verificacion
    $stmtToken = $conexion->prepare("INSERT INTO tokens_verificacion (codUsuario, token, tipo, expiracion, datosExtra) VALUES (?, ?, 'cambio_email', ?, ?)");
    $stmtToken->bind_param("isss", $_SESSION['codUsuario'], $token, $expiracion, $emailNuevo);
    $stmtToken->execute();
    $stmtToken->close();
    $conexion->close();

    // Enviar correo de verificación al nuevo email
    $enlaceVerificacion = APP_URL . '/index.php?vista=verificarEmail&token=' . $token . '&tipo=cambio_email';
    enviarCorreoCambioEmail($emailNuevo, $user['nombreUsuario'], $enlaceVerificacion);

    $_SESSION['perfil_mensaje'] = [
        'texto' => 'Se envió un correo de verificación a ' . htmlspecialchars($emailNuevo) . '. Revisá tu bandeja de entrada para confirmar el cambio.',
        'tipo' => 'success'
    ];
    header("Location: ../../index.php?vista=miPerfil");
    exit();
}

// =============================================
// ACCIÓN: Cambiar Contraseña
// =============================================
if ($accion === 'cambiarClave') {
    $claveActual = $_POST['claveActual'] ?? '';
    $claveNueva1 = limpiar_cadena($_POST['claveNueva1'] ?? '');
    $claveNueva2 = limpiar_cadena($_POST['claveNueva2'] ?? '');

    // Validar campos obligatorios
    if ($claveActual == '' || $claveNueva1 == '' || $claveNueva2 == '') {
        $_SESSION['perfil_mensaje'] = ['texto' => 'Todos los campos son obligatorios.', 'tipo' => 'danger'];
        header("Location: ../../index.php?vista=miPerfil");
        exit();
    }

    // Validar formato de nueva clave
    if (verificarDatos("[a-zA-Z0-9\$@.-]{7,100}", $claveNueva1)) {
        $_SESSION['perfil_mensaje'] = ['texto' => 'La nueva contraseña debe tener al menos 7 caracteres.', 'tipo' => 'danger'];
        header("Location: ../../index.php?vista=miPerfil");
        exit();
    }

    // Verificar que las nuevas claves coincidan
    if ($claveNueva1 !== $claveNueva2) {
        $_SESSION['perfil_mensaje'] = ['texto' => 'Las nuevas contraseñas no coinciden.', 'tipo' => 'danger'];
        header("Location: ../../index.php?vista=miPerfil");
        exit();
    }

    $conexion = conexion();

    // Verificar contraseña actual
    $stmt = $conexion->prepare("SELECT claveUsuario FROM usuarios WHERE codUsuario = ?");
    $stmt->bind_param("i", $_SESSION['codUsuario']);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();

    if (!$user || !password_verify($claveActual, $user['claveUsuario'])) {
        $conexion->close();
        $_SESSION['perfil_mensaje'] = ['texto' => 'La contraseña actual es incorrecta.', 'tipo' => 'danger'];
        header("Location: ../../index.php?vista=miPerfil");
        exit();
    }

    // Encriptar nueva contraseña
    $claveHash = password_hash($claveNueva1, PASSWORD_BCRYPT, ["cost" => 10]);

    // Actualizar en BD
    $stmtUpdate = $conexion->prepare("UPDATE usuarios SET claveUsuario = ? WHERE codUsuario = ?");
    $stmtUpdate->bind_param("si", $claveHash, $_SESSION['codUsuario']);
    $stmtUpdate->execute();
    $stmtUpdate->close();
    $conexion->close();

    $_SESSION['perfil_mensaje'] = ['texto' => '¡Contraseña actualizada exitosamente!', 'tipo' => 'success'];
    header("Location: ../../index.php?vista=miPerfil");
    exit();
}

// =============================================
// ACCIÓN: Dar de baja la cuenta
// =============================================
if ($accion === 'darDeBaja') {
    $claveBaja = $_POST['claveBaja'] ?? '';

    // Validar campo obligatorio
    if ($claveBaja == '') {
        $_SESSION['perfil_mensaje'] = ['texto' => 'Debés ingresar tu contraseña para confirmar la baja.', 'tipo' => 'danger'];
        header("Location: ../../index.php?vista=miPerfil");
        exit();
    }

    $conexion = conexion();

    // Verificar contraseña actual
    $stmt = $conexion->prepare("SELECT claveUsuario FROM usuarios WHERE codUsuario = ?");
    $stmt->bind_param("i", $_SESSION['codUsuario']);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();

    if (!$user || !password_verify($claveBaja, $user['claveUsuario'])) {
        $conexion->close();
        $_SESSION['perfil_mensaje'] = ['texto' => 'La contraseña ingresada es incorrecta.', 'tipo' => 'danger'];
        header("Location: ../../index.php?vista=miPerfil");
        exit();
    }

    // Cambiar estado de la cuenta a 'Baja'
    $stmtUpdate = $conexion->prepare("UPDATE usuarios SET estadoCuenta = 'Baja' WHERE codUsuario = ?");
    $stmtUpdate->bind_param("i", $_SESSION['codUsuario']);
    $stmtUpdate->execute();
    $stmtUpdate->close();
    $conexion->close();

    // Destruir sesión y redirigir al login
    session_unset();
    session_destroy();

    // Reiniciar sesión para mostrar mensaje flash
    session_name("UNR");
    session_start();
    $_SESSION['mensaje'] = [
        'texto' => 'Tu cuenta ha sido dada de baja exitosamente.',
        'tipo' => 'info'
    ];
    header("Location: ../../index.php?vista=login");
    exit();
}

// Acción no reconocida
$_SESSION['perfil_mensaje'] = ['texto' => 'Acción no válida.', 'tipo' => 'danger'];
header("Location: ../../index.php?vista=miPerfil");
exit();
?>
