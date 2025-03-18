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
    require_once __DIR__ . "/../enviarMail.php";

    // Cerrar la conexión
    $denegar_promo->close();
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

