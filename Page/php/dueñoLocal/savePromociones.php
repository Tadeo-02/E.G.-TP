<?php
    require_once "../main.php";

    // Guardar datos de los inputs
    $codLocal = limpiar_cadena($_POST['codLocal']);
    $textoPromo = limpiar_cadena($_POST['textoPromo']);
    $fechaDesdePromo = limpiar_cadena($_POST['fechaDesdePromo']);
    $fechaHastaPromo = limpiar_cadena($_POST['fechaHastaPromo']);
    $categoriaCliente = limpiar_cadena($_POST['categoriaCliente']);
    $diasSemana = limpiar_cadena($_POST['diasSemana']);

    // Verificar campos Obligatorios
    if( $codLocal == "" || $textoPromo == "" || $fechaDesdePromo == "" || $fechaHastaPromo == "" || $categoriaCliente == "" || $diasSemana == ""){ 
        echo '<div class="alert alert-danger" role="alert">
                Todos los campos obligatorios no han sido completados
              </div>';
        exit();
    }
    
    // if(verificarDatos("[a-zA-Z0-9$@.-]{1,100}", $textoPromo)){ //? Revisar si es necesario
    //     echo '<div class="alert alert-danger" role="alert">
    //             La descripcion de la promocion debe contener al menos 20 caracteres	
    //           </div>';
    //     exit();
    // }

    if($fechaDesdePromo == $fechaHastaPromo){ //? Revisar si es necesario
        echo '<div class="alert alert-danger" role="alert">
                Las promociones no pueden comenzar y terminar el mismo día
              </div>';
        exit();
    }
    
    if($fechaDesdePromo > $fechaHastaPromo){ //? Revisar si es necesario
        echo '<div class="alert alert-danger" role="alert">
                La fecha de inicio de la prmocion no puede ser posterior a la fecha de fin de la promocion
              </div>';
        exit();
    }
    
    // Guardando datos
    $guardar_usuario=conexion();
    $guardar_usuario=$guardar_usuario->query("INSERT INTO promociones(textoPromo, fechaDesdePromo, fechaHastaPromo, categoriaCliente,diasSemana, estadoPromo, codLocal) VALUES ('$textoPromo', '$fechaDesdePromo', '$fechaHastaPromo', '$categoriaCliente', '$diasSemana', 'Pendiente', $codLocal)");

    echo '<div class="alert alert-success" role="alert">
            Solicitud registrada con exito
        </div>';

    header("Location: /TP ENTORNOS/Page/index.php?vista=cargaPromociones");

    ?>