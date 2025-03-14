<?php 
    require_once "main.php";

    // Guardar datos de los inputs
    $email = limpiar_cadena($_POST['nombreUsuario']);
    $clave_1 = limpiar_cadena($_POST['claveUsuario1']);
    $clave_2 = limpiar_cadena($_POST['claveUsuario2']);
    $checkBox = limpiar_cadena($_POST['esDueño']);

    // Verificar campos Obligatorios
    if( $clave_1 == "" || $clave_2 == "" || $email == ""){
        echo '<div class="alert alert-danger" role="alert">
                Todos los campos obligatorios no han sido completados
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
            $checkEmail = $checkEmail->query("SELECT nombreUsuario FROM usuarios WHERE nombreUsuario = '$email'");
            if($checkEmail -> num_rows > 0){ 
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
    } 
    else {
        $clave = password_hash($clave_1, PASSWORD_BCRYPT,["cost"=>10]); 
    }

    // Guardando datos
    $guardar_usuario = conexion();
    if($checkBox == 1){
        $guardar_usuario = $guardar_usuario->query("INSERT INTO usuarios(claveUsuario, nombreUsuario, categoriaCliente, tipoUsuario, estadoCuenta) VALUES('$clave', '$email', NULL, 'Dueño', 'Pendiente')");
    }else{
       $guardar_usuario = $guardar_usuario->query("INSERT INTO usuarios(claveUsuario, nombreUsuario, categoriaCliente, tipoUsuario, estadoCuenta) VALUES('$clave', '$email', 'Inicial', 'Cliente','Activa')");
    }

    header("Location: /TP ENTORNOS/index.php?vista=login");


?>



