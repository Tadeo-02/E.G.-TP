<?php
    require_once "main.php";

    //todo Decidir como se selecciona el local
    // Guardar datos de los inputs
    $textoPromo = limpiar_cadena($_POST['textoPromo']);
    $fechaDesdePromo = limpiar_cadena($_POST['fechaDesdePromo']);
    $fechaHastaPromo = limpiar_cadena($_POST['fechaHastaPromo']);
    $categoriaCliente = limpiar_cadena($_POST['categoriaCliente']);
    $diasSemana = limpiar_cadena($_POST['diasSemana']);
    $estadoPromo = limpiar_cadena($_POST['estadoPromo']);

    // Verificar campos Obligatorios
    if( $textoPromo == "" || $fechaDesdePromo == "" || $fechaHastaPromo == "" || $categoriaCliente == "" || $diasSemana == "" || $estadoPromo == "" ){ 
        echo '<div class="alert alert-danger" role="alert">
                Todos los campos obligatorios no han sido completados
              </div>';
        exit();
    }
    
    if(verificarDatos("[a-zA-Z0-9$@.-]{20,100}", $textoPromo)){ //? Revisar si es necesario
        echo '<div class="alert alert-danger" role="alert">
                La descropcion de la promocion debe contener al menos 20 caracteres	
              </div>';
        exit();
    }

    if($fechaDesdePromo != $fechaHastaPromo){ //? Revisar si es necesario
        echo '<div class="alert alert-danger" role="alert">
                Las promociones no pueden comenzar y terminar el mismo día
              </div>';
        exit();
    }
    
    if($fechaDesdePromo < $fechaHastaPromo){ //? Revisar si es necesario
        echo '<div class="alert alert-danger" role="alert">
                La fecha de inicio de la prmocion no puede ser posterior a la fecha de fin de la promocion
              </div>';
        exit();
    }
    
    // Guardando datos
    $guardar_usuario=conexion();
    $guardar_usuario=$guardar_usuario->query("INSERT INTO promociones(textoPromo, fechaDesdePromo, fechaHastaPromo, categoriaCliente,diasSemana ,estadoPromo) VALUES('$textoPromo', '$fechaDesdePromo', '$fechaHastaPromo', '$categoriaCliente', '$diasSemana', '$estadoPromo')");

    header("Location: /TP ENTORNOS/Page/index.php?vista=login");




    ?>