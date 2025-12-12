<?php 
    require_once "../main.php";

    // Now expect primary key codUsoPromociones
    $codUso = limpiar_cadena($_POST['codUsoPromociones']);
    $estado = "Aprobada";

    $conexion = conexion();

    // Obtener el codCliente asociado para actualizar la categoría luego
    $stmtGet = $conexion->prepare("SELECT codCliente FROM uso_promociones WHERE codUsoPromociones = ? LIMIT 1");
    $stmtGet->bind_param("i", $codUso);
    $stmtGet->execute();
    $res = $stmtGet->get_result();
    $row = $res->fetch_assoc();
    $codCliente = $row['codCliente'] ?? null;
    $stmtGet->close();

    $aprobar_promo = $conexion->prepare("UPDATE uso_promociones SET estado = ? WHERE codUsoPromociones = ? LIMIT 1");
    $aprobar_promo->bind_param("si", $estado, $codUso);
    $aprobar_promo->execute();

    // Cerrar la conexión
    $aprobar_promo->close();
    $conexion->close();

    if (isset($_SERVER['HTTP_REFERER'])) {
        // Redireccionar al usuario a la página anterior
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // En caso de que no haya página anterior, redirigir a una página predeterminada
        header("Location: index.php");
        exit();
    }
?>