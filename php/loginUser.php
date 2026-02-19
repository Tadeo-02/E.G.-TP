<?php
    require_once "main.php";

    $email = limpiar_cadena($_POST['nombreUsuario']);
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

    $checkUser = mysqli_query($conexion, $consulta_usuario);

    if($checkUser -> num_rows==1){ 

        $checkUser = $checkUser -> fetch_assoc(); 

        if($checkUser['nombreUsuario'] == $email && password_verify($password, $checkUser['claveUsuario'])){// password_verifiy es la funcion para procesar las cadenas encriptadas
                
            if($checkUser['estadoCuenta'] == 'Activa'){
                // Hacemos un array con los datos del usuario; son las Variables de Sesion
                $_SESSION['nombreUsuario'] = $email;
                $_SESSION['codUsuario'] = $checkUser['codUsuario'];
                $_SESSION['tipoUsuario'] = $checkUser['tipoUsuario'];
                $_SESSION['categoriaCliente'] = $checkUser['categoriaCliente'];

                if(headers_sent()){ //comprobamos si existen encabezados para hacer una redireccion con js o php
                    echo "<script> window.location.href='index.php?vista=home'; </script>"; //redireccionamos a la pagina principal
                }else{
                    header("Location: index.php?vista=home");
                }
            }   elseif ($checkUser['estadoCuenta'] == 'PendienteVerificacion'){
                    echo '<div class="alert alert-warning" role="alert">
                     Tu email aún no ha sido verificado. Revisá tu bandeja de entrada y hacé clic en el enlace de verificación.
                    </div>';
            }  elseif ($checkUser['estadoCuenta'] == 'Pendiente'){
                echo "<script>alert('Su solicitud de cuenta de dueño de local se encuentra bajo revisión.');</script>";
            }
             else{
                echo "<script>alert('Su solicitud de cuenta de dueño de local ha sido rechazda. Por favor, contacte a un administrador.');</script>";
             }
                                                     
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