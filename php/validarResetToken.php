<?php

require_once __DIR__ . '/main.php';

function validarResetToken(string $token): array {
    if (empty($token) || strlen($token) !== 64) {
        return ['valido' => false, 'mensaje' => 'Enlace de restablecimiento inválido.'];
    }

    $conexion = conexion();
    $stmt = $conexion->prepare("SELECT tv.codUsuario, tv.expiracion, u.nombreUsuario 
                                FROM tokens_verificacion tv 
                                INNER JOIN usuarios u ON tv.codUsuario = u.codUsuario 
                                WHERE tv.token = ? AND tv.tipo = 'reset_password'");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        $stmt->close();
        $conexion->close();
        return ['valido' => false, 'mensaje' => 'El enlace de restablecimiento no es válido o ya fue utilizado.'];
    }

    $fila = $res->fetch_assoc();
    $stmt->close();

    if (strtotime($fila['expiracion']) < time()) {
        // Eliminar token expirado
        $stmtDel = $conexion->prepare("DELETE FROM tokens_verificacion WHERE token = ?");
        $stmtDel->bind_param("s", $token);
        $stmtDel->execute();
        $stmtDel->close();
        $conexion->close();
        return ['valido' => false, 'mensaje' => 'El enlace de restablecimiento ha expirado. Solicitá uno nuevo.'];
    }

    $conexion->close();
    return ['valido' => true, 'nombreUsuario' => $fila['nombreUsuario']];
}
