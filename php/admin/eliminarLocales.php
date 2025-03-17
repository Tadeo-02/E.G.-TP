
<?php 
    require_once "../main.php";

    $codLocal = limpiar_cadena($_POST['codLocal']);  

    $conexion = conexion();
    $eliminar_promocion = $conexion->prepare("UPDATE promociones SET estadoPromo = 'Desactivada' WHERE codLocal = ?");
    $eliminar_promocion->bind_param("i", $codLocal);
    $eliminar_promocion->execute();

    $eliminar_local = $conexion->prepare("UPDATE locales SET estadoLocal = 0 WHERE codLocal = ?");
    $eliminar_local->bind_param("i", $codLocal);

// Ejecutar la consulta y verificar si tuvo éxito
if ($eliminar_local->execute()) {
    echo '<div class="alert alert-success" role="alert">
            Local eliminado con éxito
          </div>';
    
    // Redirigir después de la actualización
    header("Location: /TP ENTORNOS/index.php?vista=localsList");
    exit; // Detener ejecución después de la redirección
} else {
    echo '<div class="alert alert-danger" role="alert">
            Error al eliminar el local.
          </div>';
}
    // Cerrar la conexión
    mysqli_close($conexion);

    header("Location: /TP ENTORNOS/index.php?vista=localsList");

?>