<?php 
    require_once "../main.php";

    $codCliente = limpiar_cadena($_POST['codCliente']);
    $codPromo = limpiar_cadena($_POST['codPromo']);
    $estado = "Rechazado";
        
    $conexion = conexion();

    $denegar_promo = $conexion->prepare("UPDATE uso_promociones SET estado = ? WHERE codCliente = ? AND codPromo = ?");
    $denegar_promo->bind_param("sii",$estado,  $codCliente, $codPromo);
    if($denegar_promo->execute()){
        echo "Promo rechazada con éxito";}
    else{
        echo "Error al rechazar la promo";
    }

    // Cerrar la conexión
    $denegar_promo->close();
    $conexion->close();

    header("Location: /TP ENTORNOS/Page/index.php?vista=discountRequest");

?>