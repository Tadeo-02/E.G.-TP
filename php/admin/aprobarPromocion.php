<?php 
    require_once "../main.php";

    $codPromo = limpiar_cadena($_POST['codPromo']);
    $nuevoEstado = "Activa";
        
    $conexion = conexion();
    
    $aprobar_promo = $conexion->prepare("UPDATE promociones SET estadoPromo = ? WHERE codPromo = ?");
    $aprobar_promo->bind_param("si",$nuevoEstado,  $codPromo);
    
    if($aprobar_promo->execute()){
        $_SESSION['mensaje'] = 'Promoción aprobada con éxito';
    } else{
        $_SESSION['mensaje'] = 'Error al aprobar la promoción';
    }

    // Cerrar la conexión
    $aprobar_promo->close();
    $conexion->close();

    // Redireccionar a la lista de promociones
    header("Location: ../../index.php?vista=promocionesList");
    exit();
    
?>