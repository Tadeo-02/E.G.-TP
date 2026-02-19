<?php
    $hoy = date("Y-m-d");
    $estado = "Vencida";
    //Actualizar el estado de las promociones una vez vencidas
    $conexion = conexion();

    $query = "UPDATE promociones SET estadoPromo = '$estado' WHERE fechaHastaPromo < '$hoy'";
    $query2 = "UPDATE uso_promociones up JOIN promociones p ON up.codPromo = p.codPromo SET up.estado = 'Vencido' WHERE p.fechaHastaPromo < '$hoy' AND up.estado = 'Pendiente'";
    mysqli_query($conexion, $query);
    mysqli_query($conexion, $query2);

    // Cerrar la conexión
    mysqli_close($conexion);
?>