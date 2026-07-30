<?php
    require_once "../verificarTipoUsuarioAdmin.php";
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
        $_SESSION['mensaje'] = ['texto' => 'Todos los campos obligatorios no han sido completados', 'tipo' => 'danger'];
        redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    }
    
    $conexion = conexion();

    //Verificar si el local ya existe
    $stmt = $conexion->prepare("SELECT nombreLocal FROM locales WHERE nombreLocal = ?");
    $stmt->bind_param("s", $nombreLocal);
    $stmt->execute();
    $validarNombre = $stmt->get_result();
    $stmt->close();
    if (($validarNombre->num_rows) > 0 ) {
        $_SESSION['mensaje'] = ['texto' => 'El nombre del Local ya existe', 'tipo' => 'danger'];
        mysqli_close($conexion);
        redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    }

    // Guardar Local
    $stmt = $conexion->prepare("INSERT INTO locales (nombreLocal, ubicacionLocal, rubroLocal, codUsuario, imagenLocal, estadoLocal) VALUES (?, ?, ?, ?, ?, 'Activo')");
    $stmt->bind_param("sssis", $nombreLocal, $ubicacionLocal, $rubroLocal, $codUsuario, $nombreImagen);
    $stmt->execute();
    $stmt->close();
    
    $_SESSION['mensaje'] = ['texto' => 'Local registrado con éxito', 'tipo' => 'success'];
    
    //Cerrar conexion    
    mysqli_close($conexion);

    redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    
?>