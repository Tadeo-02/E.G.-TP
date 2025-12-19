<section id="about" class="about">
	<div class="container-fluid">
		<?php
		// Mostrar mensaje de error si existe
		if (isset($_SESSION['mensaje'])) {
			echo '<div class="container" style="margin-top: 80px; position: relative; z-index: 1000;">
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						' . htmlspecialchars($_SESSION['mensaje']) . '
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				  </div>';
			unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
		}
		?>
		<div class="form-rest"></div> <!--se utiliza para mostrar el resultado dentro de este "form-rest"  -->
			<div class="row">
				<div class="col-12">
					<form action="php/saveUser.php" method="POST" class="form" autocomplete="off" >
						<br>
                        <br>  
                        <br>
                    	<h1>REGISTRO DE SESIÓN</h1>
                      	<br>
						<label for="nombreUsuario">Email</label>
						<input id="nombreUsuario" class="form-control" type="email" name="nombreUsuario" placeholder="alguien@ejemplo.com" maxlength="70" required>
						<label for="claveUsuario1">Clave</label>
						<input id="claveUsuario1" class="form-control" type="password" name="claveUsuario1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required>
						<label for="claveUsuario2">Repetir clave</label>
						<input id="claveUsuario2" class="form-control" type="password" name="claveUsuario2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required>
						<label for="flexCheckDefault">¿Es Dueño de Local?</label>
						<div class="form-check" style="display:flex ;justify-content: center; align-items: center;">
						<input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="esDueño" >
						</div>
						<p class="has-text-centered">
							<br>
							<button type="submit" class="btn btn-primary" value="Ingresar" href="login.php">Registrar</button>
							<br>
							<br>
							<a href="index.php?vista=login">¿Ya tienes una cuenta? Inicia sesión</a>
						</p>

					</form>
				</div>
			</div>
	</div>			
</section>
