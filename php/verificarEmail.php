<?php
/**
 * Verificación de email mediante token
 * 
 * Se accede vía: index.php?vista=verificarEmail&token=xxx
 * Este archivo se incluye desde la vista verificarEmail.php
 */
require_once __DIR__ . '/main.php';

function verificarTokenEmail(string $token): array {
    if (empty($token) || strlen($token) !== 64) {
        return ['exito' => false, 'mensaje' => 'Token inválido.'];
    }

    $conn = conexion();
    
    // Buscar token válido y no expirado
    $stmt = $conn->prepare("SELECT tv.codUsuario, tv.expiracion, u.estadoCuenta, u.nombreUsuario 
                            FROM tokens_verificacion tv 
                            INNER JOIN usuarios u ON tv.codUsuario = u.codUsuario 
                            WHERE tv.token = ? AND tv.tipo = 'verificacion_email'");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        $stmt->close();
        $conn->close();
        return ['exito' => false, 'mensaje' => 'El enlace de verificación no es válido o ya fue utilizado.'];
    }

    $fila = $resultado->fetch_assoc();
    $stmt->close();

    // Verificar expiración
    if (strtotime($fila['expiracion']) < time()) {
        // Eliminar token expirado
        $stmtDel = $conn->prepare("DELETE FROM tokens_verificacion WHERE token = ?");
        $stmtDel->bind_param("s", $token);
        $stmtDel->execute();
        $stmtDel->close();
        $conn->close();
        return ['exito' => false, 'mensaje' => 'El enlace de verificación ha expirado. Por favor, registrate nuevamente.'];
    }

    // Ya verificado?
    if ($fila['estadoCuenta'] === 'Activa') {
        $stmtDel = $conn->prepare("DELETE FROM tokens_verificacion WHERE token = ?");
        $stmtDel->bind_param("s", $token);
        $stmtDel->execute();
        $stmtDel->close();
        $conn->close();
        return ['exito' => true, 'mensaje' => 'Tu cuenta ya está verificada. Podés iniciar sesión.'];
    }

    // Activar cuenta (solo Clientes se activan directo; Dueños pasan a Pendiente de aprobación)
    if ($fila['estadoCuenta'] === 'PendienteVerificacion') {
        // Determinar el nuevo estado según tipo de usuario
        $stmtTipo = $conn->prepare("SELECT tipoUsuario FROM usuarios WHERE codUsuario = ?");
        $stmtTipo->bind_param("i", $fila['codUsuario']);
        $stmtTipo->execute();
        $resTipo = $stmtTipo->get_result()->fetch_assoc();
        $stmtTipo->close();

        if ($resTipo['tipoUsuario'] === 'Dueño') {
            $nuevoEstado = 'Pendiente'; // Pendiente de aprobación admin
        } else {
            $nuevoEstado = 'Activa';
        }

        $stmtUpdate = $conn->prepare("UPDATE usuarios SET estadoCuenta = ? WHERE codUsuario = ?");
        $stmtUpdate->bind_param("si", $nuevoEstado, $fila['codUsuario']);
        $stmtUpdate->execute();
        $stmtUpdate->close();
    }

    // Eliminar token usado
    $stmtDel = $conn->prepare("DELETE FROM tokens_verificacion WHERE token = ?");
    $stmtDel->bind_param("s", $token);
    $stmtDel->execute();
    $stmtDel->close();
    
    $conn->close();

    if (isset($nuevoEstado) && $nuevoEstado === 'Pendiente') {
        return ['exito' => true, 'mensaje' => '¡Email verificado! Tu cuenta de Dueño está pendiente de aprobación por un administrador.'];
    }

    return ['exito' => true, 'mensaje' => '¡Tu email ha sido verificado exitosamente! Ya podés iniciar sesión.'];
}