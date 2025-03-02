<?php 
    require_once "../main.php";

    $codUsuario = limpiar_cadena($_POST['codUsuario']);
    $nuevoEstado = "Activa";
    

    // Verificar campos Obligatorios
    
    $conexion = conexion();


    
    $aprobar_cuenta = $conexion->prepare("UPDATE usuarios SET estadoCuenta = ? WHERE codUsuario = ?");
    $aprobar_cuenta->bind_param("si",$nuevoEstado,  $codUsuario);
    if($aprobar_cuenta->execute()){
        echo "Cuenta aprobada con éxito";}
    else{
        echo "Error al aprobar la cuenta";
    }

    // Cerrar la conexión
    $aprobar_cuenta->close();
    $conexion->close();

    header("Location: /TP ENTORNOS/Page/index.php?vista=ownerAccountRequest");

?>