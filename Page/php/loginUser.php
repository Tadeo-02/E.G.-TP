<?php
    require_once "main.php";
        
    // saco la data del formulario
    $email = $_POST["nombreUsuario"];
    $password = $_POST["claveUsuario"];

    $link = conexion();
    $vSql = "SELECT Count(*) as canti FROM usuarios WHERE nombreUsuario='$email'and codUsuario='$password'";
    $vResultado = mysqli_query($link, $vSql) or die(mysqli_error($link));;
    $vCuenta = mysqli_fetch_assoc($vResultado);
    if($vCuenta['canti'] == 0){
        echo '<div class="alert alert-danger" role="alert">
            La cuenta no existe
            </div>';
        header("Location: /TP ENTORNOS/Page/locales.php");      
        exit();
    } else {
        header("Location: /TP ENTORNOS/Page/index.php");
        exit();
    }
    mysqli_close($link);
?>