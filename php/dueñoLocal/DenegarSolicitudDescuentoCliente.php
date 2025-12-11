<?php 
    require_once "../main.php";

    $codUso = limpiar_cadena($_POST['codUsoPromociones']);
    $estado = "Rechazado";
        
    $conexion = conexion();

    $denegar_promo = $conexion->prepare("UPDATE uso_promociones SET estado = ? WHERE codUsoPromociones = ?");
    $denegar_promo->bind_param("si", $estado, $codUso);
    $denegar_promo->execute();

    //Informo via mail
    // require_once __DIR__ . "/../enviarMail.php"; // FUNCIONALIDAD DE EMAIL DESHABILITADA

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