<section id="about" class="about">
    <div class="container-fluid">
        <?php
        // Mostrar mensajes flash
        if (isset($_SESSION['mensaje'])) {
            $tipoMsg = 'info';
            $textoMsg = '';
            if (is_array($_SESSION['mensaje'])) {
                $tipoMsg = $_SESSION['mensaje']['tipo'] ?? 'info';
                $textoMsg = $_SESSION['mensaje']['texto'] ?? '';
            } else {
                $textoMsg = $_SESSION['mensaje'];
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
        <div class="row">
            <div class="col-12">
                <form action="php/solicitarResetPassword.php" method="POST" class="form" autocomplete="off" style="padding: 20px;">
                    <h1 class="text-center" style="margin-bottom: 15px;">Recuperar contraseña</h1>
                    <p class="text-center text-muted" style="margin-bottom: 30px;">
                        Ingresá tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                    </p>

                    <div class="mb-3 text-center">
                        <label for="emailRecuperar">Correo electrónico:</label>
                        <div class="input-wrapper">
                            <input
                                id="emailRecuperar"
                                class="form-control custom-dark-input"
                                type="email"
                                name="emailRecuperar"
                                placeholder="alguien@ejemplo.com"
                                maxlength="70"
                                required
                                aria-describedby="emailRecuperarHelp">
                        </div>
                        <small id="emailRecuperarHelp" class="form-text text-muted" style="margin-top: 5px; display:block;">Introduce el correo con el que te registraste.</small>
                    </div>

                    <div class="text-center" style="margin-top: 30px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Enviar enlace de recuperación
                        </button>
                        <p style="margin-top: 15px;">
                            <a href="index.php?vista=login">
                                <i class="fas fa-arrow-left"></i> Volver a Iniciar Sesión
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
