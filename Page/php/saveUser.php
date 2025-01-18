<?php 
    require_once "main.php";

    // Guardar datos de los inputs
    $email = limpiar_cadena($_POST['nombreUsuario']);
    $clave_1 = limpiar_cadena($_POST['claveUsuario1']);
    $clave_2 = limpiar_cadena($_POST['claveUsuario2']);

    // Verificar campos Obligatorios
    if( $clave_1 == "" || $clave_2 == "" || $email == ""){ //! Decidir si agregamos un perfil de usuario o simplemente usamos el mail
        echo '<div class="alert alert-danger" role="alert">
                Todos los campos obligatorios no han sido completados
              </div>';
        exit();
    }

    // Verificar si los datos son iguales

    // if(verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre) || verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)){
    //     echo '<div class="alert alert-danger" role="alert">
    //             Los nombres y apellidos solo pueden contener letras y espacios
    //           </div>';
    //     exit();
    // }

    // if(verificarDatos("[a-zA-Z0-9]{4,20}", $usuario)){
    //     echo '<div class="alert alert-danger" role="alert">
    //             El usuario solo puede contener letras y números
    //           </div>';
    //     exit();
    // }
    
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
            $checkEmail = $checkEmail->query("SELECT nombreUsuario FROM usuarios WHERE nombreUsuario = '$email'");
            if($checkEmail -> num_rows > 0){ //! El tipo usa rowCount(); tener en cuenta por si falla num_rows
                echo '<div class="alert alert-danger" role="alert">
                        El email ya está registrado
                      </div>';
                exit();
            }
            $checkEmail = null;
        }
    }

    // Verficando claves
    if($clave_1 != $clave_2){
        echo '<div class="alert alert-danger" role="alert">
            Las claves que ha ingresado no coinciden
            </div>';
        exit();
    } else {
        $clave = password_hash($clave_1, PASSWORD_BCRYPT,["cost"=>10]);
    }

    // Guardando datos
    $guardar_usuario=conexion();
    $guardar_usuario=$guardar_usuario->query("INSERT INTO usuarios(claveUsuario, nombreUsuario, categoriaCliente, tipoUsuario) VALUES('$clave', '$email', 'Inicial', 'Cliente')");









