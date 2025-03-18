<?php
    $hoy = date("Y-m-d");
    $estado = "Vencida";

    $conexion = conexion();

	$promoVencida = $conexion->prepare("UPDATE promociones SET estadoPromo = ? WHERE fechaHastaPromo < ?");

    $promoVencida->bind_param("ss", $estado, $hoy);
    $promoVencida->execute();

    // Cerrar la conexión
    $promoVencida->close();
    $conexion->close();
?>