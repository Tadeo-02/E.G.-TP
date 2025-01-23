

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
      if(is_file("./vistas/".$_GET['vista'].".php") && $_GET['vista'] != "login" && $_GET['vista'] != "404"){ //is_file comprueba si un archivo existe en el directorio indicado
        
        /*== Cerrar sesion ==*/
      //    if((!isset($_SESSION['codUsuario']) || $_SESSION['codUsuario']=="") || (!isset($_SESSION['nombreUsuario']) || $_SESSION['nombreUsuario']=="")){
      //      include "./vistas/logout.php";
      //      exit();
      //  }
        
        // <!-- NAVBAR -->
        include "./inc/navbar.php";

        include "./vistas/".$_GET['vista'].".php";

        // <!-- CAROUSEL DE IMAGENES HOME -->         
        include "./inc/carousel.php";
        
        // <!-- MAPA DEL LOCAL -->     
        include "./inc/mapaDeLocal.php";

        // <!-- CONTACTO -->
        include "./inc/form.php";  

        // <!-- FOOTER -->   
        include "./inc/footer.php";
          
        // <!-- JS -->
        include "./inc/script.php";
          
      } else {
          if($_GET['vista'] == 'login'){
            include "vistas/login.php";
          }else{
            
            include "vistas/404.php";
            }
          }

      

      ?>
      
  </body>
</html>




