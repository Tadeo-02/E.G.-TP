<?php 
    require_once "main.php";

    // Guardar datos de los inputs
    $nombre= limpiar_cadena($_POST['usuario_nombre']);
    $apellido= limpiar_cadena($_POST['usuario_apellido']);

    $usuario= limpiar_cadena($_POST['usuario_usuario']);
    $email= limpiar_cadena($_POST['usuario_email']);

    $clave_1= limpiar_cadena($_POST['usuario_clave_1']);
    $clave_2= limpiar_cadena($_POST['usuario_clave_2']);

    // Verificar campos Obligatorios
    if($nombre="" || $apellido="" || $usuario="" || $clave_1="" || $clave_2=""){
        echo '<div class="alert alert-danger" role="alert">
                Todos los campos obligatorios no han sido completados
              </div>';
        exit();

    }

    // Verificar si los datos son iguales

    if(verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre) || verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)){
        echo '<div class="alert alert-danger" role="alert">
                Los nombres y apellidos solo pueden contener letras y espacios
              </div>';
        exit();
    }
    if(verificarDatos("[a-zA-Z0-9]{4,20}", $usuario)){
        echo '<div class="alert alert-danger" role="alert">
                El usuario solo puede contener letras y números
              </div>';
        exit();
    }
    if(verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave_1) || verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave_2)){
        echo '<div class="alert alert-danger" role="alert">
                La clave debe contener al menos 7 caracteres
              </div>';
        exit();
    }
    if($clave_1 != $clave_2){
        echo '<div class="alert alert-danger" role="alert">
                Las claves no coinciden
              </div>';
        exit();
    }
    
    // Verificar Email
    if($email != ""){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo '<div class="alert alert-danger" role="alert">
                    El email no es válido
                  </div>';
            exit();
        }else{
            $checkEmail = conexion();
            $checkEmail = $checkEmail->query("SELECT usuario_email FROM usuarios WHERE usuario_email = '$email'");
            if($checkEmail -> num_rows > 0){ //! El tipo usa rowCount(); tener en cuenta por si falla num_rows
                echo '<div class="alert alert-danger" role="alert">
                        El email ya está registrado
                      </div>';
                exit();
            }
            $checkEmail = null;
        }
    }














