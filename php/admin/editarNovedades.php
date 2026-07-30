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
        redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    }
    
    $conexion = conexion();

    // Verificar si la fecha de inicio es menor a la fecha de fin
    if($fechaDesdeNovedad == $fechaHastaNovedad){ //? Revisar si es necesario
        $_SESSION['mensaje'] = ['texto' => 'Las novedades no pueden comenzar y terminar el mismo día', 'tipo' => 'danger'];
        mysqli_close($conexion);
        redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    }
    
    if($fechaDesdeNovedad > $fechaHastaNovedad){ //? Revisar si es necesario
        $_SESSION['mensaje'] = ['texto' => 'La fecha de inicio de la novedad no puede ser posterior a la fecha de fin', 'tipo' => 'danger'];
        mysqli_close($conexion);
        redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    }

    // Guardar Novedad
    $stmt = $conexion->prepare("UPDATE novedades SET textoNovedad = ?, fechaDesdeNovedad = ?, fechaHastaNovedad = ?, tipoCliente = ? WHERE codNovedad = ?");
    $stmt->bind_param("ssssi", $textoNovedad, $fechaDesdeNovedad, $fechaHastaNovedad, $tipoCliente, $novedadModificada);
    $stmt->execute();
    $stmt->close();

    $_SESSION['mensaje'] = ['texto' => 'Novedad actualizada con éxito', 'tipo' => 'success'];

    //Cerrar conexion    
    mysqli_close($conexion);

    redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
?>

    