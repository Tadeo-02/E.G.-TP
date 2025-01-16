<?php
    require_once "./main.php";
    $link = conexion();

    // ingreso datos?
    $vnombreLocal = $_POST['nombreLocal'];
    $vubicacionLocal = $_POST['ubicacionLocal'];
    $vrubroLocal = $_POST['rubroLocal'];

    //! fijarse si el codigo que ingresa existe!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $vcodUsuario = $_POST['codUsuario'];

    //Arma la instrucción SQL y luego la ejecuta
    $vSql = "SELECT Count(*) as canti FROM locales WHERE nombreLocal='$vcodLocal'and codUsuario='$vcodUsuario' and ubicacionLocal='$vubicacionLocal' and rubroLocal='$vrubroLocal'";
    $vResultado = mysqli_query($link, $vSql) or die(mysqli_error($link));;
    $vCantLocales = mysqli_fetch_assoc($vResultado);

    if ($vCantLocales['canti'] != 0) {
        echo ("El local ya existe<br>");

    } else {
        
        $vSql = "INSERT INTO locales (nombreLocal, ubicacionLocal, rubroLocal, codUsuario) values ('$vnombreLocal', '$vubicacionLocal', '$vrubroLocal', '$vcodUsuario')";
        mysqli_query($link, $vSql) or die(mysqli_error($link));
        echo ("El local fue registrado con éxito. <br>");

        // Liberar conjunto de resultados
        mysqli_free_result($vResultado);
    }
    // Cerrar la conexion
    mysqli_close($link);