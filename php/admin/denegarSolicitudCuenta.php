<?php 
    require_once "../verificarTipoUsuarioAdmin.php";
    require_once "../main.php";

    $codUsuario = limpiar_cadena($_POST['codUsuario']);
    $nuevoEstado = "Rechazado";
        
    $conexion = conexion();

    $denegar_cuenta = $conexion->prepare("UPDATE usuarios SET estadoCuenta = ? WHERE codUsuario = ?");
    $denegar_cuenta->bind_param("si",$nuevoEstado,  $codUsuario);
    $denegar_cuenta->execute();

    $_SESSION['mensaje'] = ['texto' => 'Solicitud de cuenta denegada con éxito', 'tipo' => 'success'];

    // Cerrar la conexión
    $denegar_cuenta->close();
    $conexion->close();

    redirigirSeguro($_SERVER['HTTP_REFERER'] ?? '', 'index.php');

?>