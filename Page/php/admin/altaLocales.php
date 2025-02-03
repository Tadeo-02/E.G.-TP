<?php
    require_once "../main.php";

    $nombreLocal = limpiar_cadena($_POST['nombreLocal']);
    $ubicacionLocal = limpiar_cadena($_POST['ubicacionLocal']);
    $rubroLocal = limpiar_cadena($_POST['rubroLocal']);

    $codUsuario = 6; //todo REMAKE

    //Verificar campos obligatorios
    if ($nombreLocal == "" || $ubicacionLocal == "" || $rubroLocal == "" || $codUsuario == ""){
        echo '<div class="alert alert-danger" role="alert">
                Todos los campos obligatorios no han sido completados
              </div>';
        exit();}
    
    //Verificar si el local ya existe
    if($nombreLocal != "" && $ubicacionLocal != ""){
        $validarNombre = conexion();
        $validarUbiacion = conexion();
        $validarNombre = $validarNombre ->query ("SELECT nombreLocal  FROM locales WHERE nombreLocal='$nombreLocal' "); 
        $validarUbiacion = $validarUbiacion ->query ("SELECT ubicacionLocal  FROM locales WHERE  ubicacionLocal='$ubicacionLocal'");
        if (($validarNombre->num_rows) > 0 ) { //todo BOCA
            echo '<div class="alert al  ert-danger" role="alert">
                    El nombre del Local ya existe
                  </div>';
            exit();
        }
        $validarNombre = null;
        if(($validarUbiacion->num_rows) > 0){
            echo '<div class="alert alert-danger" role="alert">
                La ubicacion del local está ocupada
                    </div>';
            exit();
        }
        $validarUbiacion = null;

        // Guardar Local
        $guardarLocal = conexion();
        $guardarLocal = $guardarLocal ->query("INSERT INTO locales (nombreLocal, ubicacionLocal, rubroLocal, codUsuario) VALUES ('$nombreLocal', '$ubicacionLocal', '$rubroLocal', '$codUsuario')");
        //? Alerta de exito no funciona
        // if($guardarLocal->num_rows == 1){
        //     echo '<div class="alert alert-success" role="alert">
        //             El local fue registrado con éxito
        //           </div>'; 
        //     }

        //Cerrar conexion    
        $guardarLocal = null;
        }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
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