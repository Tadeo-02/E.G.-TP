<?php 
    require_once "../main.php";

    $codPromo = limpiar_cadena($_POST['codPromo']);
    $nuevoEstado = "Activa";
        
    $conexion = conexion();
    
    $aprobar_promo = $conexion->prepare("UPDATE promociones SET estadoPromo = ? WHERE codPromo = ?");
    $aprobar_promo->bind_param("si",$nuevoEstado,  $codPromo);
    if($aprobar_promo->execute()){
        echo "Promoción aprobada con éxito";}
    else{
        echo "Error al aprobar la promoción";
    }

    // Cerrar la conexión
    $aprobar_promo->close();
    $conexion->close();

    header("Location: /TP ENTORNOS/Page/index.php?vista=discountRequest");

?>