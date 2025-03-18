<?php 
    require_once "../main.php";

    $codUsuario = limpiar_cadena($_POST['codUsuario']);
    $nuevoEstado = "Activa";
        
    $conexion = conexion();
    
    $aprobar_cuenta = $conexion->prepare("UPDATE usuarios SET estadoCuenta = ? WHERE codUsuario = ?");
    $aprobar_cuenta->bind_param("si", $nuevoEstado, $codUsuario);
    if($aprobar_cuenta->execute()){
        echo "Cuenta aprobada con éxito";}
    else{
        echo "Error al aprobar la cuenta";
    }

    require_once __DIR__ . "/../enviarMail.php";

    // Cerrar la conexión
    $aprobar_cuenta->close();
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