<?php 
    require_once "../verificarTipoUsuarioAdmin.php";
    require_once "../main.php";

    $codLocal = limpiar_cadena($_POST['codLocal']);  

    $conexion = conexion();
    
    $eliminar_local = $conexion->prepare("DELETE FROM locales WHERE codLocal = ?");
    $eliminar_local->bind_param("i", $codLocal);
    $eliminar_local->execute();
    
    // Cerrar la conexión
    $eliminar_local->close();
    $conexion->close();

    $_SESSION['mensaje'] = ['texto' => 'Local eliminado con éxito', 'tipo' => 'success'];

    header("Location: ../../index.php?vista=localsList");
?>