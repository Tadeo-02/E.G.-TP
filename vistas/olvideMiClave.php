<style>
    .input-wrapper {
        position: relative;
        width: 200px;
        max-width: 100%;
        height: 50px;
        margin: 0 auto;
        z-index: 1;
        transition: width 0.4s ease-in-out;
    }
    .input-wrapper:focus-within {
        width: 350px;
    }
    .custom-dark-input {
        background-color: #212529 !important;
        color: white !important;
        border: 1px solid #0d6efd;
        border-radius: 50px !important;
        width: 100% !important;
        max-width: 100% !important;
        height: 50px;
        box-sizing: border-box !important;
        padding-left: 20px;
        padding-right: 45px;
        text-align: center;
    }
    .custom-dark-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        outline: none;
    }
</style>

<section id="about" class="about">
    <div class="container-fluid">
        <?php
        // Mostrar mensajes flash
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
                            <a href="index.php?vista=login" aria-label="Volver al inicio de sesión">
                                <i class="fas fa-arrow-left"></i> Volver a Iniciar Sesión
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
