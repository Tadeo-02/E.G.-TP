<?php 
    require_once "../main.php";

    $codLocal = limpiar_cadena($_POST['codLocal']);  

    $conexion = conexion();
    
    $eliminar_local = $conexion->prepare("DELETE FROM locales WHERE codLocal = ?");
    $eliminar_local->bind_param("i", $codLocal);
    if($eliminar_local->execute()){
        echo '<div class="alert alert-success" role="alert">
            Local eliminado con exito
            </div>';
    }else{
        echo '<div class="alert alert-danger" role="alert">
            Error al eliminar el local
            </div>';
            $conexion->close();
    }

    // Cerrar la conexión
    $eliminar_local->close();
    $conexion->close();

    header("Location: index.php?vista=localsList");

?>