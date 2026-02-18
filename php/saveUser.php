<?php 
    require_once "main.php";
    require_once __DIR__ . '/mailer.php';

    // Ensure session is started for flash messages with the same session name
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_name("UNR");
        session_start();
    }

    // Standardize session messages for alerts
    if (isset($_SESSION['mensaje'])) {
        $_SESSION['mensaje'] = [
            'texto' => $_SESSION['mensaje'],
            'tipo' => 'danger' // Default to danger for errors
        ];
    }

    // Guardar datos de los inputs
    $email = limpiar_cadena($_POST['nombreUsuario']);
    $clave_1 = limpiar_cadena($_POST['claveUsuario1']);
    $clave_2 = limpiar_cadena($_POST['claveUsuario2']);
    $checkBox = isset($_POST['esDueño']) ? limpiar_cadena($_POST['esDueño']) : '';

    // Verificar campos Obligatorios
    if( $clave_1 == "" || $clave_2 == "" || $email == ""){
        $_SESSION['mensaje'] = 'Todos los campos obligatorios no han sido completados';
        header('Location: ../index.php?vista=signUp');
        exit();
    }
    
    if(verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave_1) || verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave_2)){
        $_SESSION['mensaje'] = 'La clave debe contener al menos 7 caracteres';
        header('Location: ../index.php?vista=signUp');
        exit();
    }
    
    // Verificar Email
    if($email != ""){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['mensaje'] = 'El email no es válido';
            header('Location: ../index.php?vista=signUp');
            exit();
        }else{
            $checkEmail = conexion();
            $checkEmail = $checkEmail->query("SELECT nombreUsuario FROM usuarios WHERE nombreUsuario = '$email'");
            if($checkEmail -> num_rows > 0){ 
                $_SESSION['mensaje'] = 'El email ya está registrado';
                header('Location: ../index.php?vista=signUp');
                exit();
            }
            $checkEmail = null;
        }
    }

    // Verficando claves
    if($clave_1 != $clave_2){
        $_SESSION['mensaje'] = 'Las claves que ha ingresado no coinciden';
        header('Location: ../index.php?vista=signUp');
        exit();
    } 
    else {
        $clave = password_hash($clave_1, PASSWORD_BCRYPT,["cost"=>10]); 
    }

    // Guardando datos
    $guardar_usuario = conexion();
    if($checkBox == 1){
        $guardar_usuario = $guardar_usuario->query("INSERT INTO usuarios(claveUsuario, nombreUsuario, categoriaCliente, tipoUsuario, estadoCuenta) VALUES('$clave', '$email', NULL, 'Dueño', 'Pendiente')");
        $tipoUsuario = 'Dueño';
    }else{
       $guardar_usuario = $guardar_usuario->query("INSERT INTO usuarios(claveUsuario, nombreUsuario, categoriaCliente, tipoUsuario, estadoCuenta) VALUES('$clave', '$email', 'Inicial', 'Cliente','Activa')");
       $tipoUsuario = 'Cliente';
    }

    // Enviar correo de confirmación de registro
    enviarConfirmacionRegistro($email, $tipoUsuario);

    header("Location: ../index.php?vista=login");


?>



