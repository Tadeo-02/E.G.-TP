<?php require "./inc/sessionStart.php";  ?>

<!DOCTYPE html>
<html lang="es">
<head>
<?php 
      include "./inc/head.php";  
    ?> 

</head>
<body>         
    
    <?php 

      // Si la variable tipo GET 'vista' no está definida o está vacía, le damos el valor "login", que sel mismo nombre que el archivo .php pero sin la extension
      if(!isset($_GET['vista']) || $_GET['vista'] == ""){
        $_GET['vista'] = "home";
      }
      // Condicional que evalua el valor de la variable tipo GET 'vista' y realiza la acción correspondiente
      // si existe el archivo y es distinto al login y es distinto a 404 cargamos todo lo normal
      if(is_file("./vistas/".$_GET['vista'].".php") && $_GET['vista'] != "404"){ //is_file comprueba si un archivo existe en el directorio indicado
        
        /*== Cerrar sesion ==*/
      //    if((!isset($_SESSION['codUsuario']) || $_SESSION['codUsuario']=="") || (!isset($_SESSION['nombreUsuario']) || $_SESSION['nombreUsuario']=="") && $vista !== 'login'){
      //      session_destroy();
      //      header("Location: index.php?vista=login");
      //  }

        // <!-- NAVBAR -->
        include "./inc/navbar.php";

        include "./vistas/".$_GET['vista'].".php";

        // <!-- FOOTER -->   
        include "./inc/footer.php";
            
        // <!-- JS -->
        include "./inc/script.php";
          
      } else {
        include "vistas/404.php";
      }
      

      ?>
      
      <!-- <script>
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };
      </script> -->
 </script>
  </body>
</html>




