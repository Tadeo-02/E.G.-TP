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
        echo '<div class="alert alert-danger" role="alert">
                Todos los campos obligatorios no han sido completados
              </div>';
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
        echo '<div class="alert alert-danger" role="alert">
            La solicitud no está disponible este día de la semana
        </div>';
        exit();
    }

    $guardar_promo=$guardar_promo->query("INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estado) VALUES ('$codCliente', '$codPromo', '$hoy', 'Pendiente')");

    echo '<div class="alert alert-success" role="alert">
            Solicitud registrada con exito
        </div>';

    //Cerrar conexion    
    $guardar_promo = null;

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




































