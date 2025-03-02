<?php 
    require_once "../main.php";

    $codUsuario = limpiar_cadena($_POST['codUsuario']);
    $nuevoEstado = "Rechazado";
    

    // Verificar campos Obligatorios
    
    $conexion = conexion();


    
    $denegar_cuenta = $conexion->prepare("UPDATE usuarios SET estadoCuenta = ? WHERE codUsuario = ?");
    $denegar_cuenta->bind_param("si",$nuevoEstado,  $codUsuario);
    if($denegar_cuenta->execute()){
        echo "Cuenta rechazada con éxito";}
    else{
        echo "Error al rechazar la cuenta";
    }

    // Cerrar la conexión
    $denegar_cuenta->close();
    $conexion->close();

    header("Location: /TP ENTORNOS/Page/index.php?vista=ownerAccountRequest");

?>