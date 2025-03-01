<?php
    require_once "../main.php";

    $textoNovedad = limpiar_cadena($_POST['textoNovedad']);
    $fechaDesdeNovedad = limpiar_cadena($_POST['fechaDesdeNovedad']);
    $fechaHastaNovedad = limpiar_cadena($_POST['fechaHastaNovedad']);
    $tipoUsuario = limpiar_cadena($_POST['tipoUsuario']);

    //Verificar campos obligatorios
    if ($textoNovedad == "" || $fechaDesdeNovedad == "" || $fechaHastaNovedad == "" || $tipoUsuario == ""){
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
    $guardarNovedad = $conexion ->query("INSERT INTO novedades (textoNovedad, fechaDesdeNovedad, fechaHastaNovedad, tipoUsuario) VALUES ('$textoNovedad', '$fechaDesdeNovedad', '$fechaHastaNovedad', '$tipoUsuario')");
    //? Alerta de exito no funciona
    // if($guardarLocal->num_rows == 1){
    //     echo '<div class="alert alert-success" role="alert">
    //             El local fue registrado con éxito
    //           </div>'; 
    //     }

    //Cerrar conexion    
    mysqli_close($conexion);

    header("Location: /TP ENTORNOS/Page/index.php?vista=novedadesList");
    
    
    
    ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
     // //Arma la instrucción SQL y luego la ejecuta   
    // $validarDatos = "SELECT Count(*) as canti FROM locales WHERE nombreLocal=? AND ubicacionLocal=?";
    
  
    // $resultado = mysqli_query($link, $validarDatos) or die(mysqli_error($link));
    // $cantLocales = mysqli_fetch_assoc($resultado);
    // $stmt = mysqli_prepare($link, $validarDatos);
    // mysqli_stmt_bind_param($stmt, "ss", $nombreLocal, $ubicacionLocal);
    // mysqli_stmt_execute($stmt);
    // mysqli_stmt_bind_result($stmt, $vCantLocales);
    // mysqli_stmt_fetch($stmt);
    // mysqli_stmt_close($stmt);

    // if ($cantLocales['canti'] != 0) {
    //     echo ("El local ya existe<br>");

    // } 
    // else {
    //     $link = $guardar_usuario->query("INSERT INTO locales (nombreLocal, ubicacionLocal, rubroLocal, codUsuario) VALUES ('$nombreLocal', '$ubicacionLocal', '$rubroLocal', '$codUsuario')");
    //     echo ("El local fue registrado con éxito. <br>");

    //     // Liberar conjunto de resultados
    //     mysqli_free_result($vResultado);
    // }
    // // Cerrar la conexion
    // mysqli_close($guardar_usuario);