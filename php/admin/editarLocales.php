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
        redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    }
    
    $conexion = conexion();

    //Verificar si el local ya existe (sólo si no es el mismo local)
    $stmt = $conexion->prepare("SELECT nombreLocal FROM locales WHERE nombreLocal = ? AND codLocal != ?");
    $stmt->bind_param("si", $nombreLocal, $localModificado);
    $stmt->execute();
    $validarNombre = $stmt->get_result();
    $stmt->close();
    if (($validarNombre->num_rows) > 0 ) { //todo BOCA
        $_SESSION['mensaje'] = ['texto' => 'El nombre del Local ya existe', 'tipo' => 'danger'];
        mysqli_close($conexion);
        redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
    }

    // Guardar Local
    $stmt = $conexion->prepare("UPDATE locales SET nombreLocal = ?, ubicacionLocal = ?, rubroLocal = ? WHERE codLocal = ?");
    $stmt->bind_param("sssi", $nombreLocal, $ubicacionLocal, $rubroLocal, $localModificado);
    $stmt->execute();
    $stmt->close();

    $_SESSION['mensaje'] = ['texto' => 'Local actualizado con éxito', 'tipo' => 'success'];

    //Cerrar conexion    
    mysqli_close($conexion);

    redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');


    