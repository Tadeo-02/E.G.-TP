<?php 
    require_once "main.php";
    require_once __DIR__ . '/mailer.php';
    require_once __DIR__ . '/mailConfig.php';

    // Ensure session is started for flash messages with the same session name
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_name("UNR");
        session_start();
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

    // Guardando datos — cuenta con estado PendienteVerificacion
    $conn = conexion();
    if($checkBox == 1){
        $conn->query("INSERT INTO usuarios(claveUsuario, nombreUsuario, categoriaCliente, tipoUsuario, estadoCuenta) VALUES('$clave', '$email', NULL, 'Dueño', 'PendienteVerificacion')");
        $tipoUsuario = 'Dueño';
    }else{
        $conn->query("INSERT INTO usuarios(claveUsuario, nombreUsuario, categoriaCliente, tipoUsuario, estadoCuenta) VALUES('$clave', '$email', 'Inicial', 'Cliente', 'PendienteVerificacion')");
        $tipoUsuario = 'Cliente';
    }

    // Obtener el ID del usuario recién creado
    $codUsuario = $conn->insert_id;

    // Generar token de verificación (64 caracteres hex = 32 bytes)
    $token = bin2hex(random_bytes(32));
    $expiracion = date('Y-m-d H:i:s', strtotime('+24 hours'));

    // Guardar token en la BD
    $stmtToken = $conn->prepare("INSERT INTO tokens_verificacion (codUsuario, token, tipo, expiracion) VALUES (?, ?, 'verificacion_email', ?)");
    $stmtToken->bind_param("iss", $codUsuario, $token, $expiracion);
    $stmtToken->execute();
    $stmtToken->close();
    $conn->close();

    // Enviar correo con enlace de verificación
    $enlaceVerificacion = APP_URL . '/index.php?vista=verificarEmail&token=' . $token;
    enviarCorreoVerificacion($email, $tipoUsuario, $enlaceVerificacion);

    $_SESSION['mensaje'] = [
        'texto' => 'Registro exitoso. Revisá tu correo electrónico para verificar tu cuenta.',
        'tipo' => 'success'
    ];
    header("Location: ../index.php?vista=login");
    exit();
?>