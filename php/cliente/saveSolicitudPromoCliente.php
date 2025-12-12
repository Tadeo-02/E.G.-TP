<?php
require_once "../main.php";

// Ensure session is started for flash messages
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Guardar datos de los inputs
 $codCliente = limpiar_cadena($_POST['codUsuario'] ?? '');
 $codPromo = limpiar_cadena($_POST['codPromo'] ?? '');
 $hoy = date("Y-m-d");
 $diaDeLaSemana = date("l", strtotime($hoy));

    $arrayDiasSemana = [
    'Monday' => "1",
    'Tuesday' => "2",
    'Wednesday' => "3",
    'Thursday' => "4",
    'Friday' => "5",
    'Saturday' => "6",
    'Sunday' => "7", 
    ];

    // Verificar campos Obligatorios
    if( $codCliente == "" || $codPromo == "" ){ 
        $_SESSION['mensaje'] = 'Todos los campos obligatorios no han sido completados';
        $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        header('Location: ' . $redirect);
        exit();
    }
    // Guardando datos (se permite solicitar en cualquier día; validación de uso se aplica al utilizar)
    $guardar_promo = conexion();
    $guardar_promo = $guardar_promo->query("INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estado) VALUES ('$codCliente', '$codPromo', '$hoy', 'Pendiente')");

    $_SESSION['mensaje'] = 'Solicitud registrada con exito';

    //Cerrar conexion    
    $guardar_promo = null;

    $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header('Location: ' . $redirect);
    exit();
    
    ?>




































