<?php
    require_once "../verificarTipoUsuarioAdmin.php";
    require_once "../main.php";

    $textoNovedad = limpiar_cadena($_POST['textoNovedad']);
    $fechaDesdeNovedad = limpiar_cadena($_POST['fechaDesdeNovedad']);
    $fechaHastaNovedad = limpiar_cadena($_POST['fechaHastaNovedad']);
    $tipoCliente = limpiar_cadena($_POST['tipoCliente']);

    //Verificar campos obligatorios
    if ($textoNovedad == "" || $fechaDesdeNovedad == "" || $fechaHastaNovedad == "" || $tipoCliente == ""){
        $_SESSION['mensaje'] = ['texto' => 'Todos los campos obligatorios no han sido completados', 'tipo' => 'danger'];
        redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    }
    
    $conexion = conexion();

    //Verificar si la novedad ya existe
    $stmt = $conexion->prepare("SELECT textoNovedad FROM novedades WHERE textoNovedad = ?");
    $stmt->bind_param("s", $textoNovedad);
    $stmt->execute();
    $validarNombre = $stmt->get_result();
    $stmt->close();
    if (($validarNombre->num_rows) > 0 ) {
        $_SESSION['mensaje'] = ['texto' => 'El texto de la Novedad ya existe', 'tipo' => 'danger'];
        mysqli_close($conexion);
        redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    }

    // Verificar que la fecha de inicio no sea anterior a hoy
    if($fechaDesdeNovedad < date('Y-m-d')){
        $_SESSION['mensaje'] = ['texto' => 'La fecha de inicio no puede ser anterior a hoy', 'tipo' => 'danger'];
        mysqli_close($conexion);
        redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    }

    // Verificar que la fecha de fin sea posterior a la fecha de inicio
    if($fechaDesdeNovedad >= $fechaHastaNovedad){
        $_SESSION['mensaje'] = ['texto' => 'La fecha de fin debe ser posterior a la fecha de inicio', 'tipo' => 'danger'];
        mysqli_close($conexion);
        redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    }



    // Guardar Novedad
    $stmt = $conexion->prepare("INSERT INTO novedades (textoNovedad, fechaDesdeNovedad, fechaHastaNovedad, tipoCliente) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $textoNovedad, $fechaDesdeNovedad, $fechaHastaNovedad, $tipoCliente);
    $stmt->execute();
    $stmt->close();

    $_SESSION['mensaje'] = ['texto' => 'Novedad registrada con éxito', 'tipo' => 'success'];

    //Cerrar conexion    
    mysqli_close($conexion);

    redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    
?>