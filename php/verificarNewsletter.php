<?php
/**
 * Verificación de suscripción al newsletter mediante token
 * 
 * Se accede vía: index.php?vista=verificarNewsletter&token=xxx
 */
require_once __DIR__ . '/main.php';

function verificarTokenNewsletter(string $token): array {
    if (empty($token) || strlen($token) !== 64) {
        return ['exito' => false, 'mensaje' => 'Token inválido.'];
    }

    $conn = conexion();
    
    // Buscar token válido de newsletter
    $stmt = $conn->prepare("SELECT tv.codUsuario, tv.expiracion 
                            FROM tokens_verificacion tv 
                            WHERE tv.token = ? AND tv.tipo = 'verificacion_newsletter'");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        $stmt->close();
        $conn->close();
        return ['exito' => false, 'mensaje' => 'El enlace de confirmación no es válido o ya fue utilizado.'];
    }

    $fila = $resultado->fetch_assoc();
    $stmt->close();

    // Verificar expiración
    if (strtotime($fila['expiracion']) < time()) {
        $stmtDel = $conn->prepare("DELETE FROM tokens_verificacion WHERE token = ?");
        $stmtDel->bind_param("s", $token);
        $stmtDel->execute();
        $stmtDel->close();
        $conn->close();
        return ['exito' => false, 'mensaje' => 'El enlace de confirmación ha expirado. Por favor, suscribite nuevamente.'];
    }

    $suscriptorId = $fila['codUsuario']; // En este contexto es el ID del suscriptor

    // Verificar que el suscriptor existe
    $stmtSub = $conn->prepare("SELECT email, verificado FROM suscriptores_newsletter WHERE id = ?");
    $stmtSub->bind_param("i", $suscriptorId);
    $stmtSub->execute();
    $resSub = $stmtSub->get_result();

    if ($resSub->num_rows === 0) {
        $stmtSub->close();
        // Limpiar token huérfano
        $stmtDel = $conn->prepare("DELETE FROM tokens_verificacion WHERE token = ?");
        $stmtDel->bind_param("s", $token);
        $stmtDel->execute();
        $stmtDel->close();
        $conn->close();
        return ['exito' => false, 'mensaje' => 'No se encontró la suscripción asociada.'];
    }

    $suscriptor = $resSub->fetch_assoc();
    $stmtSub->close();

    if ($suscriptor['verificado'] == 1) {
        // Ya verificado, limpiar token
        $stmtDel = $conn->prepare("DELETE FROM tokens_verificacion WHERE token = ?");
        $stmtDel->bind_param("s", $token);
        $stmtDel->execute();
        $stmtDel->close();
        $conn->close();
        return ['exito' => true, 'mensaje' => 'Tu suscripción al newsletter ya estaba confirmada.'];
    }

    // Activar suscripción
    $stmtUpdate = $conn->prepare("UPDATE suscriptores_newsletter SET verificado = 1 WHERE id = ?");
    $stmtUpdate->bind_param("i", $suscriptorId);
    $stmtUpdate->execute();
    $stmtUpdate->close();

    // Eliminar token usado
    $stmtDel = $conn->prepare("DELETE FROM tokens_verificacion WHERE token = ?");
    $stmtDel->bind_param("s", $token);
    $stmtDel->execute();
    $stmtDel->close();

    $conn->close();

    return ['exito' => true, 'mensaje' => '¡Suscripción confirmada! Ya vas a recibir nuestras novedades y ofertas.'];
}