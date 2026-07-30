<?php 
    require_once "../verificarTipoUsuarioAdmin.php";
    require_once "../main.php";

    $codUsuario = limpiar_cadena($_POST['codUsuario']);
    $nuevoEstado = "Activa";
        
    $conexion = conexion();
    
    $aprobar_cuenta = $conexion->prepare("UPDATE usuarios SET estadoCuenta = ? WHERE codUsuario = ?");
    $aprobar_cuenta->bind_param("si", $nuevoEstado, $codUsuario);
    $aprobar_cuenta->execute();

    $_SESSION['mensaje'] = ['texto' => 'Solicitud de cuenta aprobada con éxito', 'tipo' => 'success'];

    // Cerrar la conexión
    $aprobar_cuenta->close();
    $conexion->close();

    redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');

?>