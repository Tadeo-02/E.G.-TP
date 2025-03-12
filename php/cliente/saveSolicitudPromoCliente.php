<?php
   require_once "../main.php";

   // Guardar datos de los inputs
   $codCliente = limpiar_cadena($_POST['codUsuario']);
   $codPromo = limpiar_cadena($_POST['codPromo']);
   $hoy = date("Y-m-d");

   // Verificar campos Obligatorios
   if( $codCliente == "" || $codPromo == "" ){ 
       echo '<div class="alert alert-danger" role="alert">
               Todos los campos obligatorios no han sido completados
             </div>';
       exit();
   }
   
   // Guardando datos
   $guardar_promo=conexion();
   $guardar_promo=$guardar_promo->query("INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estado) VALUES ('$codCliente', '$codPromo', '$hoy', 'Pendiente')");


   echo '<div class="alert alert-success" role="alert">
           Solicitud registrada con exito
       </div>';

   //Cerrar conexion    
   $guardar_promo = null;

   header("Location: /TP ENTORNOS/Page/index.php?vista=promocionesList");
   ?>




































