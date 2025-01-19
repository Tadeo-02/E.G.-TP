<?php
include "./inc/navbarUNR.php";
?>
<section id="about" class="about">
          <div class="container-fluid">
              <div class="row ">
                  <div class="col-12">
                    <form class="loginBox" action="login.php" method="POST">
                        <br>
                        <br>  
                        <br>
                    <h1>INICIO DE SESIÓN</h1>
                      <br>
                      <h3>Correo electrónico:</h3>
                      <input type="email" name="email" placeholder="" class="form-control">
                      <h3>Contraseña:</h3>
                      <input type="password" name="password" placeholder="" class="form-control">
                      <input type="submit" class="btn btn-primary" value="Ingresar">
                      <a href="#">¿Has olvidado la contraseña?</a>
                      <br>
                      <a href="/TP ENTORNOS/Page/vistas/signUp.php">Crear Cuenta</a>
                    </form>
                  </div>
              </div>
          </div>
</section>

<?php

    include "./inc/head.php";
    include "./inc/script.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        // saco la data del formulario
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Conexion con la DB
        $host = "localhost";
        $dbemail = "root";
        $dbpassword = "";
        $dbname = "auth";

        $conn = new mysqli($host, $dbemail, $dbpassword, $dbname);
        
        if($conn->connect_error){
            die("Falló la conexión :v " . $conn->connect_error);
        }

        // Consulta a la DB: validar login y password
        $query = "SELECT *FROM login WHERE email = '$email' AND password = '$password'";

        $result = $conn->query($query);

        if($result->num_rows == 1){
            // Login exitoso
            // echo "Bienvenido";
            header("Location: eureka.html");
            exit();  

        }else{          
            // Login fallido
                // echo "Usuario o contraseña incorrectos";
                header("Location: fail.html");
                exit();
            }
        $conn->close();
    }
?>