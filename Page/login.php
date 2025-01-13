<?php
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