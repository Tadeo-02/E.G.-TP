<?php
    

    $email = limpiar_cadena($_POST['nombreUsuario']); //comillas simples
    $password = limpiar_cadena($_POST['claveUsuario']);


    // Verificar campos obligatorios
    if($email == "" || $password == ""){
        echo '<div class="alert alert-danger" role="alert">
            Debe completar todos los campos
            </div>';
        exit();
    }

    if(verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $password)){
        echo '<div class="alert alert-danger" role="alert">
            La contraseña no cumple con el formato requerido
            </div>';
        exit();
    }


    // Conexion a la DB
    $conexion = conexion();

    $consulta_usuario = "SELECT * FROM usuarios WHERE nombreUsuario = '$email'";

    $checkUser = mysqli_query($conexion, $consulta_usuario); //  AND claveUsuario = '$password'" 

    if($checkUser -> num_rows==1){ //rowCount() es para PDO, num_rows es para mysqli

        $checkUser = $checkUser -> fetch_assoc(); //fetch_assoc() es para mysqli, fetch() es para PDO

        if($checkUser['nombreUsuario'] == $email && password_verify($password, $checkUser['claveUsuario'])){// password_verifiy es la funcion para procesar las cadenas encriptadas
         
            
            // Hacemos un array con los datos del usuario; son las Variables de Sesion
            $_SESSION['nombreUsuario'] = $email;
            $_SESSION['codUsuario'] = $checkUser['codUsuario'];
            $_SESSION['tipoUsuario'] = $checkUser['tipoUsuario'];
            $_SESSION['categoriaCliente'] = $checkUser['categoriaCliente'];

            if(headers_sent()){ //comprobamos si existen encabezados para hacer una redireccion con js o php
                echo "<script> window.location.href='index.php?vista=home'; </script>"; //redireccionamos a la pagina principal
            }else{
				header("Location: index.php?vista=home");
			};
        
        } else {
            echo '<div class="alert alert-danger" role="alert">
                El usuario o contraseña son incorrectos
                </div>';
            exit();
        }

    }else{
        echo '<div class="alert alert-danger" role="alert">
            El usuario o contraseña son incorrectos
            </div>';
        exit();
    }
    
    $checkUser = null;

?>