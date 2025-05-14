<?php 
    require_once "../main.php";

    $codCliente = limpiar_cadena($_POST['codCliente']);
    $codPromo = limpiar_cadena($_POST['codPromo']);
    $estado = "Aprobada";
        
    $conexion = conexion();

    $aprobar_promo = $conexion->prepare("UPDATE uso_promociones SET estado = ? WHERE codCliente = ? AND codPromo = ? LIMIT 1");
    $aprobar_promo->bind_param("sii",$estado,  $codCliente, $codPromo);

    if($aprobar_promo->execute()){
        echo "Promo aprobada con éxito";}
    else{
        echo "Error al aprobar la promo";
    }
    //Informo via mail
    require_once __DIR__ . "/../enviarMail.php";

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