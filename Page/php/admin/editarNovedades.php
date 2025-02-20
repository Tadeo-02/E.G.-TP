<?php
    require_once "../main.php";
    
    $novedadModificada = limpiar_cadena($_POST['novedadModificada']);
    $textoNovedad = limpiar_cadena($_POST['textoNovedad']);
    $fechaDesdeNovedad = limpiar_cadena($_POST['fechaDesdeNovedad']);
    $fechaHastaNovedad = limpiar_cadena($_POST['fechaHastaNovedad']);
    $tipoUsuario = limpiar_cadena($_POST['tipoUsuario']);

    //Verificar campos obligatorios
    if ($novedadModificada  == "" || $textoNovedad == "" || $fechaDesdeNovedad == "" || $fechaHastaNovedad == "" || $tipoUsuario == ""){
        echo '<div class="alert alert-danger" role="alert">
                Todos los campos obligatorios no han sido completados
              </div>';
        exit();
    }
    
    $conexion = conexion();

    //Verificar si la novedad ya existe
    $validarNombre = $conexion ->query ("SELECT textoNovedad  FROM novedades WHERE textoNovedad='$textoNovedad' "); 
    if (($validarNombre->num_rows) > 0 ) {
        echo '<div class="alert al  ert-danger" role="alert">
                El nombre del Local ya existe
                </div>';
        exit();
    }

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
    $guardarNovedad = $conexion ->query("UPDATE novedades SET textoNovedad = '$textoNovedad', fechaDesdeNovedad = '$fechaDesdeNovedad', fechaHastaNovedad = '$fechaHastaNovedad', tipoUsuario = '$tipoUsuario' WHERE codNovedad = '$novedadModificada';");

    //? Alerta de exito no funciona
    // if($guardarLocal->num_rows == 1){
    //     echo '<div class="alert alert-success" role="alert">
    //             El local fue modificado con éxito
    //           </div>'; 
    //     }

    //Cerrar conexion    
    mysqli_close($conexion);

    header("Location: /TP ENTORNOS/Page/index.php?vista=novedadesManage");


    