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
$query_verificar = "SELECT * FROM uso_promociones WHERE codCliente = '$codCliente' AND codPromo = '$codPromo' AND estado IN ('Pendiente', 'Aprobada')";
$verificar_solicitud = mysqli_query($conexion, $query_verificar);

if (mysqli_num_rows($verificar_solicitud) > 0) {
    // mysqli_close($conexion);
    $_SESSION['mensaje'] = 'Ya has solicitado esta promoción anteriormente';
    $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header('Location: ' . $redirect);
    exit();
}

// Verificar campos Obligatorios
if( $codCliente == "" || $codPromo == "" ){ 
    mysqli_close($conexion);
    $_SESSION['mensaje'] = 'Todos los campos obligatorios no han sido completados';
    $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header('Location: ' . $redirect);
    exit();
}
// Guardando datos (se permite solicitar en cualquier día; validación de uso se aplica al utilizar)
$query_insert = "INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estado) VALUES ('$codCliente', '$codPromo', '$hoy', 'Pendiente')";
$guardar_promo = mysqli_query($conexion, $query_insert);

if ($guardar_promo) {
    $_SESSION['mensaje'] = 'Solicitud registrada con exito';
} else {
    $_SESSION['mensaje'] = 'Error al registrar la solicitud: ' . mysqli_error($conexion);
}

//Cerrar conexion    
mysqli_close($conexion);

$redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header('Location: ' . $redirect);
exit();

?>




































