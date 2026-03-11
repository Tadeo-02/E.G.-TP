<?php require "./inc/sessionStart.php";  ?>

<!DOCTYPE html>
<html lang="es">
<head>
<?php 
      include "./inc/head.php";  
    ?> 

</head>
<body>         

    <a href="#main-content" class="visually-hidden-focusable">
        Saltar al contenido principal
    </a>

    <?php 

      // Si la variable tipo GET 'vista' no está definida o está vacía, le damos el valor "login", que sel mismo nombre que el archivo .php pero sin la extension
      if(!isset($_GET['vista']) || $_GET['vista'] == ""){
        $_GET['vista'] = "home";
      }
      // Condicional que evalua el valor de la variable tipo GET 'vista' y realiza la acción correspondiente
      // si existe el archivo y es distinto al login y es distinto a 404 cargamos todo lo normal
      if(is_file("./vistas/".$_GET['vista'].".php") && $_GET['vista'] != "404"){ //is_file comprueba si un archivo existe en el directorio indicado

        // <!-- NAVBAR -->
        include "./inc/navbar.php";

        echo '<main id="main-content" tabindex="-1">';
        include "./vistas/".$_GET['vista'].".php";
        echo '</main>';

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




