<?php
require_once "../main.php";

// Iniciar sesión con el mismo nombre usado en la aplicación
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name("UNR");
    session_start();
}

$tipoMensaje = limpiar_cadena($_POST['tipoMensaje'] ?? '');

switch($tipoMensaje) {
    case 'nivelInsuficiente':
        $_SESSION['mensaje'] = 'Usted no puede acceder a esta promoción porque su nivel de usuario es menor al solicitado';
        break;
    case 'fueraPeriodo':
        $_SESSION['mensaje'] = 'Por favor, vuelva a intentarlo cuando el periodo de la promoción haya iniciado';
        break;
    default:
        $_SESSION['mensaje'] = 'Acción no válida';
}

$redirect = $_SERVER['HTTP_REFERER'] ?? '../../index.php?vista=promocionesList';
header('Location: ' . $redirect);
exit();
?>