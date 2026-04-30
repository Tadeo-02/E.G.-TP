<?php 
    require_once "../verificarTipoUsuarioAdmin.php";
    require_once "../main.php";

    $codPromo = limpiar_cadena($_POST['codPromo']);
    $nuevoEstado = "Activa";
        
    $conexion = conexion();
    
    $aprobar_promo = $conexion->prepare("UPDATE promociones SET estadoPromo = ? WHERE codPromo = ?");
    $aprobar_promo->bind_param("si",$nuevoEstado,  $codPromo);
    
    if($aprobar_promo->execute()){
        $_SESSION['mensaje'] = ['texto' => 'Promoción aprobada con éxito', 'tipo' => 'success'];
    } else{
        $_SESSION['mensaje'] = ['texto' => 'Error al aprobar la promoción', 'tipo' => 'danger'];
    }

    // Cerrar la conexión
    $aprobar_promo->close();
    $conexion->close();

    // Redireccionar a la lista de promociones
    header("Location: ../../index.php?vista=promocionesList");
    exit();
    
?>