<section id="about" class="about">
	<div class="container-fluid">

		<?php
			
		// Mostrar mensaje de error si existe
		if (isset($_SESSION['mensaje'])) {
			$tipoMsg = 'danger';
			$textoMsg = '';
			if (is_array($_SESSION['mensaje'])) {
				$tipoMsg = $_SESSION['mensaje']['tipo'] ?? 'danger';
				$textoMsg = $_SESSION['mensaje']['texto'] ?? '';
			} else {
				$textoMsg = $_SESSION['mensaje'];
			}
			echo '<div class="container" style="margin-top: 80px; position: relative; z-index: 1000;">
					<div class="alert alert-' . htmlspecialchars($tipoMsg) . ' alert-dismissible fade show" role="alert">
						' . htmlspecialchars($textoMsg) . '
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				  </div>';
			unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
		}
		?>
			<div class="row">
				<div class="col-12">
					<form action="php/saveUser.php" method="POST" class="form" autocomplete="off" style="padding: 20px; padding-top: 100px; padding-bottom: 60px; justify-content: flex-start; min-height: auto; height: auto;">
						<h1>Bienvenido a NovaShopping</h1>
						<!-- <h2>Formulario de Registro</h2> -->

						<div class="mb-3">
							<label for="nombrePersona">Nombre</label>
							<div class="input-wrapper">
								<input id="nombrePersona" class="form-control custom-dark-input" type="text" name="nombrePersona" placeholder="Juan" maxlength="50" required>
							</div>
						</div>

						<div class="mb-3">
							<label for="apellidoPersona">Apellido</label>
							<div class="input-wrapper">
								<input id="apellidoPersona" class="form-control custom-dark-input" type="text" name="apellidoPersona" placeholder="Pérez" maxlength="50" required>
							</div>
						</div>

						<div class="mb-3">
							<label for="nombreUsuario">Email</label>
							<div class="input-wrapper">
								<input id="nombreUsuario" class="form-control custom-dark-input" type="email" name="nombreUsuario" placeholder="alguien@ejemplo.com" maxlength="70" required aria-describedby="emailHelp">
							</div>
							<small id="emailHelp" class="form-text text-muted" style="margin-top: 5px;">Por favor, introduce un correo válido.</small>
						</div>

						<div class="mb-3">
							<label for="claveUsuario1">Clave</label>
                            <div class="input-wrapper">
                                <input id="claveUsuario1"  class="form-control custom-dark-input password-padding" type="password" name="claveUsuario1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required aria-describedby="passwordHelp">
                                 <button 
                                type="button" 
                                onclick="togglePasswordVisibility('claveUsuario1', 'toggleIconSignUp1')" 
                                class="eye-btn"
                                aria-label="Mostrar u ocultar contraseña">
                                <i id="toggleIconSignUp1" class="fas fa-eye" style="font-size: 1.2rem;"></i>
                            </button>
                            </div>
							<small id="passwordHelp" class="form-text text-muted" style="margin-top: 5px;">La contraseña debe tener al menos 7 caracteres.</small>
						</div>

						<div class="mb-3">
							<label for="claveUsuario2">Repetir clave</label>
                            <div class="input-wrapper">
                                <input id="claveUsuario2"  class="form-control custom-dark-input password-padding" type="password" name="claveUsuario2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required aria-describedby="repeatPasswordHelp">
                                 <button 
                                type="button" 
                                onclick="togglePasswordVisibility('claveUsuario2', 'toggleIconSignUp2')" 
                                class="eye-btn"
                                aria-label="Mostrar u ocultar contraseña">
                                <i id="toggleIconSignUp2" class="fas fa-eye" style="font-size: 1.2rem;"></i>
                            </button>
                            </div>
							<small id="repeatPasswordHelp" class="form-text text-muted" style="margin-top: 5px;">Por favor, repite la contraseña para confirmar.</small>
						</div>

                        <div class="mb-3" id="cuitField" style="display: none;">
							<label for="cuitDueno">CUIT</label>
							<div class="input-wrapper">
								<input id="cuitDueno" class="form-control custom-dark-input" type="text" name="cuitDueno" placeholder="20-12345678-9" maxlength="13" pattern="[0-9\-]{11,13}">
							</div>
						</div>

                        <div class="form-check mb-3 d-flex justify-content-center align-items-center">
							<input class="form-check-input me-2" type="checkbox" value="1" id="flexCheckDefault" name="esDueño" onchange="toggleCuitField()">
							<label for="flexCheckDefault" class="form-check-label">¿Es Dueño de Local?</label>
						</div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" value="Ingresar">Registrar</button>
                            <p style="margin-top: 15px;">
                                <a href="index.php?vista=login">¿Ya tienes una cuenta? Inicia sesión</a>
                            </p>
						</div>

					</form>

                   <script>
                    function toggleCuitField() {
                        const checkbox = document.getElementById('flexCheckDefault');
                        const cuitField = document.getElementById('cuitField');
                        const cuitInput = document.getElementById('cuitDueno');
                        cuitField.style.display = checkbox.checked ? 'block' : 'none';
                        cuitInput.required = checkbox.checked;
                        if (!checkbox.checked) {
                            document.getElementById('cuitDueno').value = '';
                        }
                    }

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
	</div>			
</section>
