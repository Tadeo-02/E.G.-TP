<section id="about" class="about">
    <div class="container-fluid">
        <?php
        // Mostrar mensajes flash (ej: cuenta dada de baja)
        if (isset($_SESSION['mensaje'])) {
            $tipoMsg = 'info';
            $textoMsg = $_SESSION['mensaje'];
            if (is_array($_SESSION['mensaje'])) {
                $tipoMsg = $_SESSION['mensaje']['tipo'] ?? 'info';
                $textoMsg = $_SESSION['mensaje']['texto'] ?? '';
            }
            echo '<div class="container" style="margin-top: 90px; position: relative; z-index: 1000;">
                    <div class="alert alert-' . htmlspecialchars($tipoMsg) . ' alert-dismissible fade show" role="alert">
                        ' . htmlspecialchars($textoMsg) . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                  </div>';
            unset($_SESSION['mensaje']);
        }
        ?>
        <div class="row ">
            <div class="col-12">
                <form method="POST" class="form" autocomplete="on" style="padding: 20px;">
                    <h1 class="text-center" style="margin-bottom: 30px;">INICIO DE SESIÓN</h1>

                    <div class="mb-3 text-center">
                        <label for="nombreUsuarioLogin">Correo electrónico:</label>
                        <div class="input-wrapper">
                            <input 
                                id="nombreUsuarioLogin" 
                                class="form-control custom-dark-input" 
                                type="email" 
                                name="nombreUsuario" 
                                placeholder="alguien@ejemplo.com" 
                                maxlength="70" 
                                required 
                                aria-describedby="emailLoginHelp">
                        </div>
                        <small id="emailLoginHelp" class="form-text text-muted" style="margin-top: 5px; display:block;">Introduce un correo válido.</small>
                    </div>

                    <div class="mb-3 text-center">
                        <label for="claveUsuarioLogin">Contraseña:</label>
                        
                        <div class="input-wrapper">
                            <input 
                                id="claveUsuarioLogin" 
                                class="form-control custom-dark-input password-padding" 
                                type="password" 
                                name="claveUsuario" 
                                pattern="[a-zA-Z0-9$@.-]{7,100}" 
                                maxlength="100" 
                                placeholder="********" 
                                required 
                                aria-describedby="passwordLoginHelp">

                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility('claveUsuarioLogin', 'toggleIconLogin')" 
                                class="eye-btn"
                                aria-label="Mostrar u ocultar contraseña">
                                <i id="toggleIconLogin" class="fas fa-eye" style="font-size: 1.2rem;"></i>
                            </button>
                        </div>
                        
                        <small id="passwordLoginHelp" class="form-text text-muted" style="margin-top: 5px; display:block;">La contraseña debe tener al menos 7 caracteres.</small>
                    </div>

                    <div class="text-center" style="margin-top: 30px;">
                        <button type="submit" class="btn btn-primary" value="Ingresar">Confirmar</button>
                        <p style="margin-top: 15px;">
                            <a href="index.php?vista=signUp">Crear Cuenta</a>
                        </p>
                        <p style="margin-top: 5px;">
                            <a href="index.php?vista=olvideMiClave" class="text-muted">
                                <i class="fas fa-lock"></i> ¿Olvidaste tu contraseña?
                            </a>
                        </p>
                    </div>

                    <?php
                        if(isset($_POST['nombreUsuario']) && isset($_POST['claveUsuario'])){ 
                            require_once "./php/main.php";
                            require_once "./php/loginUser.php";
                        }
                    ?>

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
    </div>
</section>