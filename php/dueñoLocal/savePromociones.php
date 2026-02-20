<?php
    require_once "../verificarTipoUsuarioDueño.php";
    require_once "../main.php";
    
    // Iniciar sesión con el mismo nombre usado en la aplicación
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_name("UNR");
        session_start();
    }

    // Guardar datos de los inputs
    $codLocal = limpiar_cadena($_POST['codLocal']);
    $textoPromo = limpiar_cadena($_POST['textoPromo']);
    $fechaDesdePromo = limpiar_cadena($_POST['fechaDesdePromo']);
    $fechaHastaPromo = limpiar_cadena($_POST['fechaHastaPromo']);
    $categoriaCliente = limpiar_cadena($_POST['categoriaCliente']);
    $diasSemana = $_POST['diasSemana'];

    // Verificar campos Obligatorios
    if( $codLocal == "" || $textoPromo == "" || $fechaDesdePromo == "" || $fechaHastaPromo == "" || $categoriaCliente == "" || $diasSemana == ""){ 
        $_SESSION['mensaje'] = 'Todos los campos obligatorios no han sido completados';
        header('Location: ../../index.php?vista=cargaPromociones');
        exit();
    }
    if (isset($_POST['diasSemana'])) {
        $diasSemanaArray = $_POST['diasSemana']; // Captura los días como array
    } else {
        $diasSemanaArray = []; // Si no se selecciona nada, queda vacío
    }

    $diasSemanaJSON = json_encode($diasSemanaArray);
    // Verificacion de fecha
    if($fechaDesdePromo == $fechaHastaPromo){ 
        $_SESSION['mensaje'] = 'Las promociones no pueden comenzar y terminar el mismo día';
        header('Location: ../../index.php?vista=cargaPromociones');
        exit();
    }
    if($fechaDesdePromo > $fechaHastaPromo){ 
        $_SESSION['mensaje'] = 'La fecha de inicio de la promoción no puede ser posterior a la fecha de fin de la promoción';
        header('Location: ../../index.php?vista=cargaPromociones');
        exit();
    }
    
    // Guardando datos
    $guardar_usuario = conexion();
    $query = "INSERT INTO promociones(textoPromo, fechaDesdePromo, fechaHastaPromo, categoriaCliente, diasSemana, estadoPromo, codLocal) VALUES ('$textoPromo', '$fechaDesdePromo', '$fechaHastaPromo', '$categoriaCliente', '$diasSemanaJSON', 'Pendiente', $codLocal)";
    $guardar_promocion = mysqli_query($guardar_usuario, $query);

    // Guardar mensaje en sesión para mostrarlo después de la redirección
    $_SESSION['mensaje'] = 'Solicitud registrada con éxito';

    //Cerrar conexion    
    mysqli_close($guardar_usuario);

    // Redireccionar a la lista de promociones
    header("Location: ../../index.php?vista=promocionesList");
    exit();

    ?>