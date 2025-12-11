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

    //Informo via mail
    // require_once __DIR__ . "/../enviarMail.php"; // FUNCIONALIDAD DE EMAIL DESHABILITADA

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