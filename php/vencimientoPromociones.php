<?php
    $hoy = date("Y-m-d");
    $estado = "Vencida";
    $vencido = "Vencido";
    $pendiente = "Pendiente";
    //Actualizar el estado de las promociones una vez vencidas
    $conexion = conexion();

    $stmt = $conexion->prepare("UPDATE promociones SET estadoPromo = ? WHERE fechaHastaPromo < ?");
    $stmt->bind_param("ss", $estado, $hoy);
    $stmt->execute();
    $stmt->close();

    $stmt2 = $conexion->prepare("UPDATE uso_promociones up JOIN promociones p ON up.codPromo = p.codPromo SET up.estado = ? WHERE p.fechaHastaPromo < ? AND up.estado = ?");
    $stmt2->bind_param("sss", $vencido, $hoy, $pendiente);
    $stmt2->execute();
    $stmt2->close();

    // Cerrar la conexión
    mysqli_close($conexion);
?>