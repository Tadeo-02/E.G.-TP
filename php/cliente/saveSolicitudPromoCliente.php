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
    // Guardando datos
    $guardar_promo=conexion();
    $consulta_promo = "SELECT * FROM promociones WHERE codPromo = '$codPromo'";
    $datos = mysqli_query($guardar_promo, $consulta_promo);

    $fila = mysqli_fetch_assoc($datos);

    $diasSemanaLimpios = preg_replace('/[^0-9,]/', '', $fila['diasSemana']); // Eliminar caracteres no deseados
    $diasSemanaPermitidos = explode(',', $diasSemanaLimpios); // Convertir a array

    if (!in_array($arrayDiasSemana[$diaDeLaSemana], $diasSemanaPermitidos)) {
        // Usar mensaje en sesión y redirigir (evita output antes de header)
        $_SESSION['mensaje'] = 'La solicitud no está disponible este día de la semana';
        $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        header('Location: ' . $redirect);
        exit();
    }

    $guardar_promo=$guardar_promo->query("INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estado) VALUES ('$codCliente', '$codPromo', '$hoy', 'Pendiente')");

    $_SESSION['mensaje'] = 'Solicitud registrada con exito';

    //Cerrar conexion    
    $guardar_promo = null;

    $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header('Location: ' . $redirect);
    exit();
    
    ?>




































