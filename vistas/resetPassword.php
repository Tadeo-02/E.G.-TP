<?php
/**
 * Vista para restablecer la contraseña
 * 
 * Accedida desde el enlace enviado por email.
 * Valida el token y muestra el formulario para ingresar nueva contraseña.
 */
require_once __DIR__ . '/../php/main.php';

$token = isset($_GET['token']) ? $_GET['token'] : '';
$tokenValido = false;
$mensajeError = '';

// Validar token
if (!empty($token) && strlen($token) === 64) {
    $conexion = conexion();
    $stmt = $conexion->prepare("SELECT tv.codUsuario, tv.expiracion, u.nombreUsuario 
                                FROM tokens_verificacion tv 
                                INNER JOIN usuarios u ON tv.codUsuario = u.codUsuario 
                                WHERE tv.token = ? AND tv.tipo = 'reset_password'");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $fila = $res->fetch_assoc();
        if (strtotime($fila['expiracion']) >= time()) {
            $tokenValido = true;
        } else {
            $mensajeError = 'El enlace de restablecimiento ha expirado. Solicitá uno nuevo.';
            // Eliminar token expirado
            $stmtDel = $conexion->prepare("DELETE FROM tokens_verificacion WHERE token = ?");
            $stmtDel->bind_param("s", $token);
            $stmtDel->execute();
            $stmtDel->close();
        }
    } else {
        $mensajeError = 'El enlace de restablecimiento no es válido o ya fue utilizado.';
    }
    $stmt->close();
    $conexion->close();
} else {
    $mensajeError = 'Enlace de restablecimiento inválido.';
}
?>

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
    .eye-btn {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        cursor: pointer;
        z-index: 10;
        color: #6c757d;
        display: flex;
        align-items: center;
        height: 24px;
        width: 35px;
    }
</style>

<?php if ($tokenValido): ?>

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
                <form action="php/procesarResetPassword.php" method="POST" class="form" autocomplete="off" style="padding: 20px;">
                    <h1 class="text-center" style="margin-bottom: 15px;">Restablecer contraseña</h1>
                    <p class="text-center text-muted" style="margin-bottom: 30px;">
                        Ingresá tu nueva contraseña para la cuenta <strong><?php echo htmlspecialchars($fila['nombreUsuario']); ?></strong>.
                    </p>

                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                    <div class="mb-3 text-center">
                        <label for="claveNueva1">Nueva contraseña:</label>
                        <div class="input-wrapper">
                            <input
                                id="claveNueva1"
                                class="form-control custom-dark-input"
                                type="password"
                                name="claveNueva1"
                                pattern="[a-zA-Z0-9$@.-]{7,100}"
                                maxlength="100"
                                placeholder="********"
                                required
                                aria-describedby="claveNueva1Help"
                                style="padding-right: 40px;">
                            <button
                                type="button"
                                onclick="togglePasswordVisibility('claveNueva1', 'iconClave1')"
                                class="eye-btn"
                                aria-label="Mostrar u ocultar contraseña">
                                <i id="iconClave1" class="fas fa-eye" style="font-size: 1.2rem;"></i>
                            </button>
                        </div>
                        <small id="claveNueva1Help" class="form-text text-muted" style="margin-top: 5px; display:block;">Mínimo 7 caracteres.</small>
                    </div>

                    <div class="mb-3 text-center">
                        <label for="claveNueva2">Repetir nueva contraseña:</label>
                        <div class="input-wrapper">
                            <input
                                id="claveNueva2"
                                class="form-control custom-dark-input"
                                type="password"
                                name="claveNueva2"
                                pattern="[a-zA-Z0-9$@.-]{7,100}"
                                maxlength="100"
                                placeholder="********"
                                required
                                aria-describedby="claveNueva2Help"
                                style="padding-right: 40px;">
                            <button
                                type="button"
                                onclick="togglePasswordVisibility('claveNueva2', 'iconClave2')"
                                class="eye-btn"
                                aria-label="Mostrar u ocultar contraseña">
                                <i id="iconClave2" class="fas fa-eye" style="font-size: 1.2rem;"></i>
                            </button>
                        </div>
                        <small id="claveNueva2Help" class="form-text text-muted" style="margin-top: 5px; display:block;">Repetí la contraseña para confirmar.</small>
                    </div>

                    <div class="text-center" style="margin-top: 30px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key"></i> Restablecer contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

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

<?php else: ?>

<!-- Token inválido o expirado -->
<div class="container d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="card shadow-lg border-0" style="max-width: 500px; width: 100%; background-color: #212529;">
        <div class="card-body text-center p-5">
            <div class="mb-4">
                <i class="fas fa-times-circle text-danger" style="font-size: 4rem;"></i>
            </div>
            <h3 class="text-white mb-3">Error</h3>
            <p class="text-light"><?php echo htmlspecialchars($mensajeError); ?></p>
            <a href="index.php?vista=olvideMiClave" class="btn btn-warning mt-3 rounded-pill px-4">
                Solicitar nuevo enlace
            </a>
        </div>
    </div>
</div>

<?php endif; ?>
