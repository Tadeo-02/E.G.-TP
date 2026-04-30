<?php 
    session_name("UNR");
    session_start();

    if (!isset($_SESSION['codUsuario']) || $_SESSION['codUsuario'] == "" || ($_SESSION['tipoUsuario'] !== 'Administrador' && $_SESSION['tipoUsuario'] !== 'Dueño')) {
        header("Location: /index.php?vista=login");
        exit();
    }

    require_once "../main.php";

    $codLocal = limpiar_cadena($_POST['codLocal']);  

    $conexion = conexion();

    if ($_SESSION['tipoUsuario'] === 'Dueño') {
        $check_owner = $conexion->prepare("SELECT codUsuario FROM locales WHERE codLocal = ?");
        $check_owner->bind_param("i", $codLocal);
        $check_owner->execute();
        $result = $check_owner->get_result();
        $local_data = $result->fetch_assoc();
        $check_owner->close();

        if (!$local_data || (string)$local_data['codUsuario'] !== (string)$_SESSION['codUsuario']) {
            $_SESSION['mensaje'] = ['texto' => 'No tienes permisos para eliminar este local.', 'tipo' => 'danger'];
            $conexion->close();
            header("Location: ../../index.php?vista=localsList");
            exit();
        }
    }
    
    $eliminar_local = $conexion->prepare("DELETE FROM locales WHERE codLocal = ?");
    $eliminar_local->bind_param("i", $codLocal);
try {
    if ($eliminar_local->execute()) {
        $_SESSION['mensaje'] = ['texto' => 'Local eliminado con éxito', 'tipo' => 'success'];
    } else {
        $_SESSION['mensaje'] = ['texto' => 'Error al eliminar el local. Intente de nuevo.', 'tipo' => 'danger'];
    }
} catch (mysqli_sql_exception $e) {
    // 1451 is the MySQL error code for "Cannot delete or update a parent row: a foreign key constraint fails"
    if ($e->getCode() == 1451) {
        $_SESSION['mensaje'] = ['texto' => 'No se puede eliminar el local porque tiene promociones.', 'tipo' => 'danger'];
    } else {
        $_SESSION['mensaje'] = ['texto' => 'Ocurrió un error en la base de datos.', 'tipo' => 'danger'];
    }
}    
    // Cerrar la conexión
    $eliminar_local->close();
    $conexion->close();

    // $_SESSION['mensaje'] = ['texto' => 'Local eliminado con éxito', 'tipo' => 'success'];

    header("Location: ../../index.php?vista=localsList");
?>