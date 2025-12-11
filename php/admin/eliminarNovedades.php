<?php 
    require_once "../main.php";

    $codNovedad = limpiar_cadena($_POST['codNovedad']);
    
    $conexion = conexion();
    
    $eliminar_novedad = $conexion->prepare("DELETE FROM novedades WHERE codNovedad = ?");
    $eliminar_novedad->bind_param("s", $codNovedad);
    $eliminar_novedad->execute();
    
    // Cerrar la conexión
    $eliminar_novedad->close();
    $conexion->close();

    header("Location: ../../index.php?vista=novedadesList");
?>