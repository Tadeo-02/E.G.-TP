<?php 
    require_once "../main.php";

    $codPromo = limpiar_cadena($_POST['codPromo']);
    $nuevoEstado = "Denegado";
    
    $conexion = conexion();

    $denegar_promo = $conexion->prepare("UPDATE promociones SET estadoPromo = ? WHERE codPromo = ?");
    $denegar_promo->bind_param("si",$nuevoEstado,  $codPromo);
    if($denegar_promo->execute()){
        echo "Promoción denegada con éxito";}
    else{
        echo "Error al denegar la promoción";
    }

    // Cerrar la conexión
    $denegar_promo->close();
    $conexion->close();

    header("Location: /TP ENTORNOS/Page/index.php?vista=discountRequest");

?>