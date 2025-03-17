<?php
   require_once "../main.php";

    // Guardar datos de los inputs
    $codCliente = limpiar_cadena($_POST['codUsuario']);
    $codPromo = limpiar_cadena($_POST['codPromo']);
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
        $_SESSION['mensaje'] = "Error al registrar la solicitud";
        
    } else{
        // Guardando datos
        $guardar_promo=conexion();
        $consulta_promo = "SELECT * FROM promociones WHERE codPromo = '$codPromo'";
        $datos = mysqli_query($guardar_promo, $consulta_promo);

        $fila = mysqli_fetch_assoc($datos);

        $diasSemanaPermitidos = explode(',', $fila['diasSemana']); // Convertir cadena a array

        if (!in_array($arrayDiasSemana[$diaDeLaSemana], $diasSemanaPermitidos)) {
            $_SESSION['mensaje'] = "La solicitud no está disponible este día de la semana";

        } else{
            $guardar_promo=$guardar_promo->query("INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estado) VALUES ('$codCliente', '$codPromo', '$hoy', 'Pendiente')");

            $_SESSION['mensaje'] = "Solicitud registrada con éxito";
            //Cerrar conexion    
            $guardar_promo = null;
        }
    }

    if (isset($_SERVER['HTTP_REFERER'])) {
        // Redireccionar al usuario a la página anterior
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // En caso de que no haya página anterior, redirigir a una página predeterminada
        header("Location: index.php");
        exit();    
    }


    ?>




































