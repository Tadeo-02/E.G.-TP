<?php 
    require_once "../main.php";

    $codNovedad = limpiar_cadena($_POST['codNovedad']);
    

    // Verificar campos Obligatorios
    
    $conexion = conexion();
    
    $eliminar_novedad = $conexion->prepare("DELETE FROM novedades WHERE codNovedad = ?");
    $eliminar_novedad->bind_param("s", $codNovedad);
    if($eliminar_novedad->execute()){
        echo '<div class="alert alert-success" role="alert">
            Novedad eliminada con exito
            </div>';
    }else{
        echo '<div class="alert alert-danger" role="alert">
            Error al eliminar la novedad
            </div>';
            $conexion->close();
    }
   
   
    

    // Cerrar la conexión
    $eliminar_novedad->close();
    $conexion->close();

    header("Location: /TP ENTORNOS/index.php?vista=novedadesList");

?>