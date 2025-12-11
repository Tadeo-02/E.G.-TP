<?php
    require_once "../main.php";

    // Guardar datos de los inputs
    $codLocal = limpiar_cadena($_POST['codLocal']);
    $textoPromo = limpiar_cadena($_POST['textoPromo']);
    $fechaDesdePromo = limpiar_cadena($_POST['fechaDesdePromo']);
    $fechaHastaPromo = limpiar_cadena($_POST['fechaHastaPromo']);
    $categoriaCliente = limpiar_cadena($_POST['categoriaCliente']);
    $diasSemana = $_POST['diasSemana'];

    // Verificar campos Obligatorios
    if( $codLocal == "" || $textoPromo == "" || $fechaDesdePromo == "" || $fechaHastaPromo == "" || $categoriaCliente == "" || $diasSemana == ""){ 
        echo '<div class="alert alert-danger" role="alert">
                Todos los campos obligatorios no han sido completados
              </div>';
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
        echo '<div class="alert alert-danger" role="alert">
                Las promociones no pueden comenzar y terminar el mismo día
              </div>';
        exit();
    }
    
    if($fechaDesdePromo > $fechaHastaPromo){ 
        echo '<div class="alert alert-danger" role="alert">
                La fecha de inicio de la prmocion no puede ser posterior a la fecha de fin de la promocion
              </div>';
        exit();
    }
    
    // Guardando datos
    $guardar_usuario=conexion();
    $guardar_usuario=$guardar_usuario->query("INSERT INTO promociones(textoPromo, fechaDesdePromo, fechaHastaPromo, categoriaCliente,diasSemana, estadoPromo, codLocal) VALUES ('$textoPromo', '$fechaDesdePromo', '$fechaHastaPromo', '$categoriaCliente', '$diasSemanaJSON', 'Pendiente', $codLocal)");

    // Guardar mensaje en sesión para mostrarlo después de la redirección
    $_SESSION['mensaje'] = 'Solicitud registrada con éxito';

    //Cerrar conexion    
    $guardar_promocion = null;

    // Redireccionar a la lista de promociones
    header("Location: ../../index.php?vista=promocionesList");
    exit();

    ?>