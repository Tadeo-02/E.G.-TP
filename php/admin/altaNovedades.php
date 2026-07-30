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
        if(isset($_SERVER['HTTP_REFERER'])) { header("Location: " . $_SERVER['HTTP_REFERER']); } else { header("Location: index.php"); }
        exit();
    }
    
    $conexion = conexion();

    //Verificar si la novedad ya existe
    $validarNombre = $conexion ->query ("SELECT textoNovedad  FROM novedades WHERE textoNovedad='$textoNovedad' "); 
    if (($validarNombre->num_rows) > 0 ) {
        $_SESSION['mensaje'] = ['texto' => 'El texto de la Novedad ya existe', 'tipo' => 'danger'];
        mysqli_close($conexion);
        if(isset($_SERVER['HTTP_REFERER'])) { header("Location: " . $_SERVER['HTTP_REFERER']); } else { header("Location: index.php"); }
        exit();
    }

    // Verificar que la fecha de inicio no sea anterior a hoy
    if($fechaDesdeNovedad < date('Y-m-d')){
        $_SESSION['mensaje'] = ['texto' => 'La fecha de inicio no puede ser anterior a hoy', 'tipo' => 'danger'];
        mysqli_close($conexion);
        if(isset($_SERVER['HTTP_REFERER'])) { header("Location: " . $_SERVER['HTTP_REFERER']); } else { header("Location: index.php"); }
        exit();
    }

    // Verificar que la fecha de fin sea posterior a la fecha de inicio
    if($fechaDesdeNovedad >= $fechaHastaNovedad){
        $_SESSION['mensaje'] = ['texto' => 'La fecha de fin debe ser posterior a la fecha de inicio', 'tipo' => 'danger'];
        mysqli_close($conexion);
        if(isset($_SERVER['HTTP_REFERER'])) { header("Location: " . $_SERVER['HTTP_REFERER']); } else { header("Location: index.php"); }
        exit();
    }



    // Guardar Local
    $guardarNovedad = $conexion ->query("INSERT INTO novedades (textoNovedad, fechaDesdeNovedad, fechaHastaNovedad, tipoCliente) VALUES ('$textoNovedad', '$fechaDesdeNovedad', '$fechaHastaNovedad', '$tipoCliente')");

    $_SESSION['mensaje'] = ['texto' => 'Novedad registrada con éxito', 'tipo' => 'success'];

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