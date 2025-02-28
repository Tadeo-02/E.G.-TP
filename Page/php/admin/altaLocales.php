<?php
    require_once "../main.php";

    $nombreLocal = limpiar_cadena($_POST['nombreLocal']);
    $ubicacionLocal = limpiar_cadena($_POST['ubicacionLocal']);
    $rubroLocal = limpiar_cadena($_POST['rubroLocal']);
    $codUsuario = limpiar_cadena($_POST['codUsuario']);
    
    $nombreImagen = $_FILES['imagenLocal']['name']; // lo que guardamos en la DB es el nombre de la imagen, ya que despues para mostrarlas leemos la ruta donde se guardan las imagenes
    $tempname = $_FILES['imagenLocal']['tmp_name']; //esto lo que haces es verificar que el tipo de archivo sea correcto, es algo integrado de php
    $carpeta = 'locales/' . $nombreImagen; //gurado donde voy a guardar la imagen que está subiendo el administrador desde su pc

    if(move_uploaded_file($tempname, $carpeta)){ //esto lo que hace es mover la imagen a la carpeta que le indiqué, donde vamos a guardar todas las imagenes de locales
        echo "Imagen subida con éxito"; //este echo no es necesario
    }

    //Verificar campos obligatorios
    if ($nombreLocal == "" || $ubicacionLocal == "" || $rubroLocal == "" || $codUsuario == ""){
        echo '<div class="alert alert-danger" role="alert">
                Todos los campos obligatorios no han sido completados
              </div>';
        exit();
    }
    
    $conexion = conexion();

    //Verificar si el local ya existe
    $validarNombre = $conexion ->query ("SELECT nombreLocal  FROM locales WHERE nombreLocal='$nombreLocal' "); 
    if (($validarNombre->num_rows) > 0 ) {
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
    $guardarLocal = $conexion ->query("INSERT INTO locales (nombreLocal, ubicacionLocal, rubroLocal, codUsuario, imagenLocal) VALUES ('$nombreLocal', '$ubicacionLocal', '$rubroLocal', '$codUsuario', '$nombreImagen')");
    
    if(move_uploaded_file($tempname, $carpeta)){
        echo "Imagen subida con éxito";
    }else{
        echo "Error al subir la imagen";
    }
    
    //? Alerta de exito no funciona
    // if($guardarLocal->num_rows == 1){
    //     echo '<div class="alert alert-success" role="alert">
    //             El local fue registrado con éxito
    //           </div>'; 
    //     }

    //Cerrar conexion    
    mysqli_close($conexion);

    header("Location: /TP ENTORNOS/Page/index.php?vista=cargaLocales");
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
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