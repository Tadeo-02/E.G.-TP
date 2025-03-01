<?php
    require_once "../main.php";
    
    $localModificado = limpiar_cadena($_POST['localModificado']);
    $nombreLocal = limpiar_cadena($_POST['nombreLocal']);
    $ubicacionLocal = limpiar_cadena($_POST['ubicacionLocal']);
    $rubroLocal = limpiar_cadena($_POST['rubroLocal']);

    //Verificar campos obligatorios
    if ($localModificado == "" || $nombreLocal == '' || $ubicacionLocal == '' || $rubroLocal == ''){
        echo '<div class="alert alert-danger" role="alert">
                Todos los campos obligatorios no han sido completados
              </div>';
        exit();
    }
    
    $conexion = conexion();

    //Verificar si el local ya existe
    $validarNombre = $conexion ->query ("SELECT nombreLocal  FROM locales WHERE nombreLocal='$nombreLocal' "); 
    if (($validarNombre->num_rows) > 0 ) { //todo BOCA
        echo '<div class="alert al  ert-danger" role="alert">
                El nombre del Local ya existe
                </div>';
        exit();
    }

    $validarUbiacion = $conexion ->query ("SELECT ubicacionLocal FROM locales WHERE  ubicacionLocal='$ubicacionLocal'");
    if(($validarUbiacion->num_rows) > 0){
        echo '<div class="alert alert-danger" role="alert">
            La ubicacion del local está ocupada
                </div>';
        exit();
    }

    // Guardar Local
    $guardarLocal = $conexion ->query("UPDATE locales SET nombreLocal = '$nombreLocal', ubicacionLocal = '$ubicacionLocal', rubroLocal = '$rubroLocal' WHERE codLocal = '$localModificado';");
    
    //? Alerta de exito no funciona
    // if($guardarLocal->num_rows == 1){
    //     echo '<div class="alert alert-success" role="alert">
    //             El local fue modificado con éxito
    //           </div>'; 
    //     }

    //Cerrar conexion    
    mysqli_close($conexion);

    header("Location: /TP ENTORNOS/Page/index.php?vista=localsList");


    