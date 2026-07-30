<?php 
    require_once "../verificarTipoUsuarioAdmin.php";
    require_once "../main.php";

    $codPromo = limpiar_cadena($_POST['codPromo']);
    $nuevoEstado = "Denegado";
    
    $conexion = conexion();

    $denegar_promo = $conexion->prepare("UPDATE promociones SET estadoPromo = ? WHERE codPromo = ?");
    $denegar_promo->bind_param("si",$nuevoEstado,  $codPromo);
    if($denegar_promo->execute()){
        $_SESSION['mensaje'] = ['texto' => 'Promoción denegada con éxito', 'tipo' => 'success'];
    }
    else{
        $_SESSION['mensaje'] = ['texto' => 'Error al denegar la promoción', 'tipo' => 'danger'];
    }

    // Cerrar la conexión
    $denegar_promo->close();
    $conexion->close();

    redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');
?>