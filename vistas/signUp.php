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
					<form action="php/saveUser.php" method="POST" class="form" autocomplete="off" style="padding: 20px;">
						<h1>Bienvenido a NovaShopping</h1>
						<h2>Formulario de Registro</h2>

						<div class="mb-3">
							<label for="nombreUsuario">Email</label>
							<input id="nombreUsuario" class="form-control" type="email" name="nombreUsuario" placeholder="alguien@ejemplo.com" maxlength="70" required aria-describedby="emailHelp">
							<small id="emailHelp" class="form-text text-muted" style="margin-top: 5px;">Por favor, introduce un correo válido.</small>
						</div>

						<div class="mb-3">
							<label for="claveUsuario1">Clave</label>
                            <div style="position: relative;">
                                <input id="claveUsuario1" class="form-control" type="password" name="claveUsuario1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required aria-describedby="passwordHelp" style="padding-right: 40px;">
                                <button type="button" onclick="togglePasswordVisibility('claveUsuario1', 'toggleIcon1')" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; padding: 0; margin: 0; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; outline: none;" aria-label="Mostrar u ocultar contraseña" tabindex="-1">
                                    <i id="toggleIcon1" class="fas fa-eye" style="font-size: 16px; color: #6c757d; pointer-events: none;"></i>
                                </button>
                            </div>
							<small id="passwordHelp" class="form-text text-muted" style="margin-top: 5px;">La contraseña debe tener al menos 7 caracteres.</small>
						</div>

						<div class="mb-3">
							<label for="claveUsuario2">Repetir clave</label>
                            <div style="position: relative;">
                                <input id="claveUsuario2" class="form-control" type="password" name="claveUsuario2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required aria-describedby="repeatPasswordHelp" style="padding-right: 40px;">
                                <button type="button" onclick="togglePasswordVisibility('claveUsuario2', 'toggleIcon2')" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; padding: 0; margin: 0; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; outline: none;" aria-label="Mostrar u ocultar contraseña" tabindex="-1">
                                    <i id="toggleIcon2" class="fas fa-eye" style="font-size: 16px; color: #6c757d; pointer-events: none;"></i>
                                </button>
                            </div>
							<small id="repeatPasswordHelp" class="form-text text-muted" style="margin-top: 5px;">Por favor, repite la contraseña para confirmar.</small>
						</div>

						<div class="form-check mb-3 d-flex justify-content-center align-items-center">
							<input class="form-check-input me-2" type="checkbox" value="1" id="flexCheckDefault" name="esDueño">
							<label for="flexCheckDefault" class="form-check-label">¿Es Dueño de Local?</label>
						</div>

						<div class="text-center">
							<button type="submit" class="btn btn-primary" value="Ingresar" href="login.php">Registrar</button>
							<p style="margin-top: 15px;">
								<a href="index.php?vista=login" aria-label="Inicia sesión en tu cuenta">¿Ya tienes una cuenta? Inicia sesión</a>
							</p>
						</div>

					</form>

                    <script>
                        function togglePasswordVisibility(inputId, iconId) {
                            const input = document.getElementById(inputId);
                            const icon = document.getElementById(iconId);
                            
                            if (input.type === 'password') {
                                input.type = 'text';
                                icon.classList.remove('fa-eye');
                                icon.classList.add('fa-eye-slash');
                            } else {
                                input.type = 'password';
                                icon.classList.remove('fa-eye-slash');
                                icon.classList.add('fa-eye');
                            }
                        }
                    </script>
			</div>
	</div>			
</section>
