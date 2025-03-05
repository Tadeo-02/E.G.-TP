<?php 
    require_once "../main.php";

    $codCliente = limpiar_cadena($_POST['codCliente']);
    $codPromo = limpiar_cadena($_POST['codPromo']);
    $estado = "Aprobada";
        
    $conexion = conexion();

    // $aumentar_contador = $conexion->prepare("UPDATE promociones SET contador = contador + 1 WHERE codPromo = ?");

    $aprobar_promo = $conexion->prepare("UPDATE uso_promociones SET estado = ? WHERE codCliente = ? AND codPromo = ?");
    $aprobar_promo->bind_param("sii",$estado,  $codCliente, $codPromo);
    if($aprobar_promo->execute()){
        echo "Promo aprobada con éxito";}
    else{
        echo "Error al aprobar la promo";
    }

    // Cerrar la conexión
    $aprobar_promo->close();
    $conexion->close();

    header("Location: /TP ENTORNOS/Page/index.php?vista=discountRequest");







?>