<style>
    /* 1. The Wrapper acts as the dynamic container */
    .input-wrapper {
        position: relative;
        /* Start with the smaller size */
        width: 200px; 
        max-width: 100%; /* Safety on mobile */
        height: 50px;
        margin: 0 auto; /* Centers the wrapper */
        z-index: 1;
        /* The Animation Logic */
        transition: width 0.4s ease-in-out;
    }

    /* 2. When the user clicks inside the wrapper (focus-within), expand it */
    .input-wrapper:focus-within {
        width: 350px; /* Expands to your desired max width */
    }

    /* 3. The Input just fills the wrapper */
   .custom-dark-input {
        background-color: #212529 !important;
        color: white !important;
        border: 1px solid #0d6efd;
        border-radius: 50px !important;
        
        /*  input to match wrapper exactly */
        width: 100% !important; 
        max-width: 100% !important;
        height: 50px;
        box-sizing: border-box !important; /* Includes padding in the width calculation */
        
        /* Padding for text (left) and icon (right) */
        padding-left: 20px; 
        padding-right: 45px; 
        text-align: center;
    }

    .custom-dark-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        outline: none;
    }

    /* 4. The Eye Icon - Now pinned to the dynamic wrapper */
    .eye-btn {
        position: absolute;
        right: 15px; /* Distance from the edge of the WRAPPER */
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        cursor: pointer;
        z-index: 10;
        color: #6c757d;
        display: flex;
        align-items: center;
     /*impide que la transicion suba el input */   
        height: 24px;
        width: 35px;
        /* line-height: 1; 
        overflow: hidden;
        outline: none !important; */
    }
</style>

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
                            <div class="input-wrapper">
                                <input id="claveUsuario1"  class="form-control custom-dark-input password-padding" type="password" name="claveUsuario1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required aria-describedby="passwordHelp" style="padding-right: 40px;">
                                 <button 
                                type="button" 
                                onclick="togglePasswordVisibility('claveUsuario1', 'toggleIconLogin')" 
                                class="eye-btn"
                                aria-label="Mostrar u ocultar contraseña" 
                                tabindex="-1">
                                <i id="toggleIconLogin" class="fas fa-eye" style="font-size: 1.2rem;"></i>
                            </button>
                            </div>
							<small id="passwordHelp" class="form-text text-muted" style="margin-top: 5px;">La contraseña debe tener al menos 7 caracteres.</small>
						</div>

						<div class="mb-3">
							<label for="claveUsuario2">Repetir clave</label>
                            <div class="input-wrapper">
                                <input id="claveUsuario2"  class="form-control custom-dark-input password-padding" type="password" name="claveUsuario2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required aria-describedby="repeatPasswordHelp" style="padding-right: 40px;">
                                 <button 
                                type="button" 
                                onclick="togglePasswordVisibility('claveUsuario2', 'toggleIconLogin')" 
                                class="eye-btn"
                                aria-label="Mostrar u ocultar contraseña" 
                                tabindex="-1">
                                <i id="toggleIconLogin" class="fas fa-eye" style="font-size: 1.2rem;"></i>
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
