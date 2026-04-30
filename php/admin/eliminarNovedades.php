<?php 
    require_once "../verificarTipoUsuarioAdmin.php";
    require_once "../main.php";

    $codNovedad = limpiar_cadena($_POST['codNovedad']);
    
    $conexion = conexion();
    
    $eliminar_novedad = $conexion->prepare("DELETE FROM novedades WHERE codNovedad = ?");
    $eliminar_novedad->bind_param("s", $codNovedad);
    try {
        if ($eliminar_novedad->execute()) {
            $_SESSION['mensaje'] = ['texto' => 'Novedad eliminada con éxito', 'tipo' => 'success'];
        } else {
            $_SESSION['mensaje'] = ['texto' => 'Error al eliminar la novedad. Intente de nuevo.', 'tipo' => 'danger'];
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1451) {
            $_SESSION['mensaje'] = ['texto' => 'No se puede eliminar la novedad porque tiene registros asociados.', 'tipo' => 'danger'];
        } else {
            $_SESSION['mensaje'] = ['texto' => 'Ocurrió un error en la base de datos.', 'tipo' => 'danger'];
        }
    }
    
    // Cerrar la conexión
    $eliminar_novedad->close();
    $conexion->close();

    header("Location: ../../index.php?vista=novedadesList");
?>