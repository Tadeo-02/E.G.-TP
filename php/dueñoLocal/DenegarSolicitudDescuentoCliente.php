<?php 
    require_once "../verificarTipoUsuarioDueño.php";
    require_once "../main.php";

    $codUso = limpiar_cadena($_POST['codUsoPromociones']);
    $estado = "Rechazado";
        
    $conexion = conexion();

    $denegar_promo = $conexion->prepare("UPDATE uso_promociones SET estado = ? WHERE codUsoPromociones = ?");
    $denegar_promo->bind_param("si", $estado, $codUso);
    $denegar_promo->execute();

    $_SESSION['mensaje'] = ['texto' => 'Solicitud de descuento denegada con éxito', 'tipo' => 'success'];

    // Cerrar la conexión
    $denegar_promo->close();
    $conexion->close();

    redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
?>