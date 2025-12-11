<?php
    require_once "../main.php";
    
    $novedadModificada = limpiar_cadena($_POST['novedadModificada']);
    $textoNovedad = limpiar_cadena($_POST['textoNovedad']);
    $fechaDesdeNovedad = limpiar_cadena($_POST['fechaDesdeNovedad']);
    $fechaHastaNovedad = limpiar_cadena($_POST['fechaHastaNovedad']);
    $tipoCliente = limpiar_cadena($_POST['tipoCliente']);

    //Verificar campos obligatorios
    if ($novedadModificada  == "" || $textoNovedad == "" || $fechaDesdeNovedad == "" || $fechaHastaNovedad == "" || $tipoCliente == ""){
        echo '<div class="alert alert-danger" role="alert">
                Todos los campos obligatorios no han sido completados
              </div>';
        exit();
    }
    
    $conexion = conexion();

    // Verificar si la fecha de inicio es menor a la fecha de fin
    if($fechaDesdeNovedad == $fechaHastaNovedad){ //? Revisar si es necesario
        echo '<div class="alert alert-danger" role="alert">
                Las promociones no pueden comenzar y terminar el mismo día
              </div>';
        exit();
    }
    
    if($fechaDesdeNovedad > $fechaHastaNovedad){ //? Revisar si es necesario
        echo '<div class="alert alert-danger" role="alert">
                La fecha de inicio de la prmocion no puede ser posterior a la fecha de fin de la promocion
              </div>';
        exit();
    }

    // Guardar Local
    $guardarNovedad = $conexion ->query("UPDATE novedades SET textoNovedad = '$textoNovedad', fechaDesdeNovedad = '$fechaDesdeNovedad', fechaHastaNovedad = '$fechaHastaNovedad', tipoCliente = '$tipoCliente' WHERE codNovedad = '$novedadModificada';");

    //Cerrar conexion    
    mysqli_close($conexion);

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

    