<?php
include "./inc/navbarUNR.php";
include "./inc/head.php";
include "./inc/script.php";
?>	




<section id="about" class="about">
	<div class="container-fluid">
    
	<!-- SE MUESTRA EL RESULTADO DEL FORM CON ESTE DIV "form-rest" -->
		<!-- <div class="form-rest "></div> -->

			<div class="row">
				<div class="col-12">
					<form action="/TP ENTORNOS/Page/php/saveUser.php" method="POST" class="loginBox" autocomplete="off" >
						<br>
                        <br>  
                        <br>
                    	<h1>REGISTRO DE SESIÓN</h1>
                      	<br>
						<label>Email</label>
						<input class="form-control" type="email" name="nombreUsuario" placeholder="correo electronico" maxlength="70" required>
						<label>Clave</label>
						<input class="form-control" type="password" name="claveUsuario1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="contraseña" required>
						<label>Repetir clave</label>
						<input class="form-control" type="password" name="claveUsuario2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="Repita su contraseña" required>
						<p class="has-text-centered">
							<button type="submit" class="btn btn-primary" value="Ingresar">Registrar</button>
						</p>
						<a href="/TP ENTORNOS/Page/login.php">¿Ya tienes una cuenta? Inicia sesión</a>
					</form>	
				</div>	
			</div>
	</div>			
</section>

