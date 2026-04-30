<?php
    require_once "../verificarTipoUsuarioAdmin.php";
    require_once "../main.php";
    
    $localModificado = limpiar_cadena($_POST['localModificado']);
    $nombreLocal = limpiar_cadena($_POST['nombreLocal']);
    $ubicacionLocal = limpiar_cadena($_POST['ubicacionLocal']);
    $rubroLocal = limpiar_cadena($_POST['rubroLocal']);

    //Verificar campos obligatorios
    if ($localModificado == "" || $nombreLocal == '' || $ubicacionLocal == '' || $rubroLocal == ''){
        $_SESSION['mensaje'] = ['texto' => 'Todos los campos obligatorios no han sido completados', 'tipo' => 'danger'];
        if(isset($_SERVER['HTTP_REFERER'])) { header("Location: " . $_SERVER['HTTP_REFERER']); } else { header("Location: index.php"); }
        exit();
    }
    
    $conexion = conexion();

    //Verificar si el local ya existe (sólo si no es el mismo local)
    $validarNombre = $conexion ->query ("SELECT nombreLocal FROM locales WHERE nombreLocal='$nombreLocal' AND codLocal != '$localModificado'"); 
    if (($validarNombre->num_rows) > 0 ) { //todo BOCA
        $_SESSION['mensaje'] = ['texto' => 'El nombre del Local ya existe', 'tipo' => 'danger'];
        mysqli_close($conexion);
        if(isset($_SERVER['HTTP_REFERER'])) { header("Location: " . $_SERVER['HTTP_REFERER']); } else { header("Location: index.php"); }
        exit();
    }

    // Guardar Local
    $guardarLocal = $conexion ->query("UPDATE locales SET nombreLocal = '$nombreLocal', ubicacionLocal = '$ubicacionLocal', rubroLocal = '$rubroLocal' WHERE codLocal = '$localModificado';");

    $_SESSION['mensaje'] = ['texto' => 'Local actualizado con éxito', 'tipo' => 'success'];

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


    