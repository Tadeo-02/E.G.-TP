<?php
    require_once "../main.php";

    $nombreLocal = limpiar_cadena($_POST['nombreLocal']);
    $ubicacionLocal = limpiar_cadena($_POST['ubicacionLocal']);
    $rubroLocal = limpiar_cadena($_POST['rubroLocal']);
    $codUsuario = limpiar_cadena($_POST['codUsuario']);
    
    $nombreImagen = $_FILES['imagenLocal']['name']; // lo que guardamos en la DB es el nombre de la imagen, ya que despues para mostrarlas leemos la ruta donde se guardan las imagenes
    $tempname = $_FILES['imagenLocal']['tmp_name']; //esto lo que haces es verificar que el tipo de archivo sea correcto, es algo integrado de php
    $carpeta = 'locales/' . $nombreImagen; //guardo donde voy a guardar la imagen que está subiendo el administrador desde su pc

    move_uploaded_file($tempname, $carpeta); //esto lo que hace es mover la imagen a la carpeta que le indiqué, donde vamos a guardar todas las imagenes de locales

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
    $guardarLocal = $conexion ->query("INSERT INTO locales (nombreLocal, ubicacionLocal, rubroLocal, codUsuario, imagenLocal, estadoLocal) VALUES ('$nombreLocal', '$ubicacionLocal', '$rubroLocal', '$codUsuario', '$nombreImagen', 'Activo')");
    
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