<?php
    include "../inc/navbarUNR.php";
	include "../inc/script.php";
?>
<head>
	<?php 
		include "../inc/head.php";  
	?> 
</head>
<section id="about" class="about">
          <div class="container-fluid">
              <div class="row ">
                  <div class="col-12">
                    <form action="/TP ENTORNOS/Page/php/loginUser.php" method="POST" class="FormularioAjax" autocomplete="off" >
                        <br>
                        <br>  
                        <br>
                        <h1>INICIO DE SESIÓN</h1>
                        <br>
                        <label>Correo electrónico:</label>
                        <input class="form-control" type="email" name="nombreUsuario" placeholder="alguien@ejemplo.com" maxlength="70" required>
                        <label>Contraseña:</label>
                        <input class="form-control" type="password" name="claveUsuario" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required>
                        <p class="has-text-centered">
                            <br>    
                            <button type="submit" class="btn btn-primary" value="Ingresar" href="./index.php">Confirmar</button>
                            <br>
                            <br>
                            <a href="#">¿Has olvidado la contraseña?</a>
                            <br>
                            <br>
                            <a href="/TP ENTORNOS/Page/vistas/signUp.php">Crear Cuenta</a>
                        </p>
                    </form>
                  </div>
              </div>
          </div>
</section>