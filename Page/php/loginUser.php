<?php
    // require_once "main.php";
        
    // // saco la data del formulario
    // $email = $_POST["nombreUsuario"];
    // $password = $_POST["claveUsuario"];

    $email = limpiar_cadena($_POST['nombreUsuario']); //comillas simples
    $password = limpiar_cadena($_POST['claveUsuario']);


    // Verificar campos obligatorios
    if($email == "" || $password == ""){
        echo '<div class="alert alert-danger" role="alert">
            Debe completar todos los campos
            </div>';
        // header("Location: /TP ENTORNOS/Page/locales.php"); esto lo puso la extensión
        exit();
    }

    // Verificar si los datos tienen el formato correcto

    // if(verificarDatos("[a-zA-Z0-9]{4,20}", $email)){
    //     echo '<div class="alert alert-danger" role="alert">
    //         El nombre de usuario no cumple con el formato requerido
    //         </div>';
    //     // header("Location: /TP ENTORNOS/Page/locales.php"); esto lo puso la extensión
    //     exit();
    // }

    if(verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $password)){
        echo '<div class="alert alert-danger" role="alert">
            La contraseña no cumple con el formato requerido
            </div>';
        // header("Location: /TP ENTORNOS/Page/locales.php"); esto lo puso la extensión
        exit();
    }


    // Conexion a la DB

    $checkUser = conexion();
    $checkUser = $checkUser -> query("SELECT * FROM usuarios WHERE nombreUsuario = '$email'"); //  AND claveUsuario = '$password'" 

    if($checkUser -> num_rows==1) //rowCount() es para PDO, num_rows es para mysqli
    {

        $checkUser = $checkUser -> fetch_assoc(); //fetch_assoc() es para mysqli, fetch() es para PDO

        if($checkUser['nombreUsuario'] == $email && password_verify($password, $checkUser['claveUsuario']))// password_verifiy es la funcion para procesar las cadenas encriptadas
        { 
            
            // Hacemos un array con los datos del usuario; son las Variables de Sesion
            $_SESSION['nombreUsuario'] = $email;
            $_SESSION['codUsuario'] = $checkUser['codUsuario'];
            $_SESSION['tipoUsuario'] = $checkUser['tipoUsuario'];
            $_SESSION['categoriaCliente'] = $checkUser['categoriaCliente'];

            if(headers_sent()){ //comprobamos si existen encabezados para hacer una redireccion con js o php???
                echo "<script> window.location.href='index.php?vista=home'; </script>"; //esto ni idea si anda
            }else{
				header("Location: index.php?vista=home");
			};
        
        } else {
            echo '<div class="alert alert-danger" role="alert">
                El usuario o contraseña son incorrectos
                </div>';
            // header("Location: /TP ENTORNOS/Page/locales.php"); esto lo puso la extensión
            exit();
        }

    }else{
        echo '<div class="alert alert-danger" role="alert">
            El usuario o contraseña son incorrectos
            </div>';
        // header("Location: /TP ENTORNOS/Page/locales.php"); esto lo puso la extensión
        exit();
        }
        $checkUser = null;






    // // me conecto a la base de datos
    // $link = conexion();
    // $vSql = "SELECT Count(*) as canti FROM usuarios WHERE nombreUsuario='$email'and codUsuario='$password'";
    // $vResultado = mysqli_query($link, $vSql) or die(mysqli_error($link));;
    // $vCuenta = mysqli_fetch_assoc($vResultado);
    // if($vCuenta['canti'] == 0){ // si no existe la cuenta
    //     echo '<div class="alert alert-danger" role="alert">
    //         La cuenta no existe
    //         </div>';
    //     header("Location: /TP ENTORNOS/Page/locales.php");      
    //     exit();
    // } else { 
    //     header("Location: /TP ENTORNOS/Page/index.php");
    //     exit();
    // }


//todo esto creo que va
    // // cierro la conexion
    // mysqli_close($link);
?>