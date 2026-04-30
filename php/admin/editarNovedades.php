<?php
    require_once "../verificarTipoUsuarioAdmin.php";
    require_once "../main.php";
    
    $novedadModificada = limpiar_cadena($_POST['novedadModificada']);
    $textoNovedad = limpiar_cadena($_POST['textoNovedad']);
    $fechaDesdeNovedad = limpiar_cadena($_POST['fechaDesdeNovedad']);
    $fechaHastaNovedad = limpiar_cadena($_POST['fechaHastaNovedad']);
    $tipoCliente = limpiar_cadena($_POST['tipoCliente']);

    //Verificar campos obligatorios
    if ($novedadModificada  == "" || $textoNovedad == "" || $fechaDesdeNovedad == "" || $fechaHastaNovedad == "" || $tipoCliente == ""){
        $_SESSION['mensaje'] = ['texto' => 'Todos los campos obligatorios no han sido completados', 'tipo' => 'danger'];
        if(isset($_SERVER['HTTP_REFERER'])) { header("Location: " . $_SERVER['HTTP_REFERER']); } else { header("Location: index.php"); }
        exit();
    }
    
    $conexion = conexion();

    // Verificar si la fecha de inicio es menor a la fecha de fin
    if($fechaDesdeNovedad == $fechaHastaNovedad){ //? Revisar si es necesario
        $_SESSION['mensaje'] = ['texto' => 'Las novedades no pueden comenzar y terminar el mismo día', 'tipo' => 'danger'];
        mysqli_close($conexion);
        if(isset($_SERVER['HTTP_REFERER'])) { header("Location: " . $_SERVER['HTTP_REFERER']); } else { header("Location: index.php"); }
        exit();
    }
    
    if($fechaDesdeNovedad > $fechaHastaNovedad){ //? Revisar si es necesario
        $_SESSION['mensaje'] = ['texto' => 'La fecha de inicio de la novedad no puede ser posterior a la fecha de fin', 'tipo' => 'danger'];
        mysqli_close($conexion);
        if(isset($_SERVER['HTTP_REFERER'])) { header("Location: " . $_SERVER['HTTP_REFERER']); } else { header("Location: index.php"); }
        exit();
    }

    // Guardar Local
    $guardarNovedad = $conexion ->query("UPDATE novedades SET textoNovedad = '$textoNovedad', fechaDesdeNovedad = '$fechaDesdeNovedad', fechaHastaNovedad = '$fechaHastaNovedad', tipoCliente = '$tipoCliente' WHERE codNovedad = '$novedadModificada';");

    $_SESSION['mensaje'] = ['texto' => 'Novedad actualizada con éxito', 'tipo' => 'success'];

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

    