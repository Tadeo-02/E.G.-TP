<?php
require_once "../main.php";

// Ensure session is started for flash messages
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name("UNR");
    session_start();
}

// Guardar datos de los inputs
 $codCliente = limpiar_cadena($_POST['codUsuario'] ?? '');
 $codPromo = limpiar_cadena($_POST['codPromo'] ?? '');
 $hoy = date("Y-m-d");

// Verificar que el cliente no haya solicitado la misma promoción antes (pendiente o aprobada)
$conexion = conexion();
$stmtVerif = $conexion->prepare("SELECT * FROM uso_promociones WHERE codCliente = ? AND codPromo = ? AND estado IN ('Pendiente', 'Aprobada')");
$stmtVerif->bind_param("ss", $codCliente, $codPromo);
$stmtVerif->execute();
$verificar_solicitud = $stmtVerif->get_result();
$stmtVerif->close();

if (mysqli_num_rows($verificar_solicitud) > 0) {
    $_SESSION['mensaje'] = 'Ya has solicitado esta promoción anteriormente';
    redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
}

// Verificar campos Obligatorios
if( $codCliente == "" || $codPromo == "" ){ 
    mysqli_close($conexion);
    $_SESSION['mensaje'] = 'Todos los campos obligatorios no han sido completados';
    redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
}
// Guardando datos (se permite solicitar en cualquier día; validación de uso se aplica al utilizar)
$stmtInsert = $conexion->prepare("INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estado) VALUES (?, ?, ?, 'Pendiente')");
$stmtInsert->bind_param("sss", $codCliente, $codPromo, $hoy);
$guardar_promo = $stmtInsert->execute();
$stmtInsert->close();

if ($guardar_promo) {
    $_SESSION['mensaje'] = 'Solicitud registrada con exito';
} else {
    $_SESSION['mensaje'] = 'Error al registrar la solicitud: ' . mysqli_error($conexion);
}

//Cerrar conexion    
mysqli_close($conexion);

redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
