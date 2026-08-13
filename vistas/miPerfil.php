<?php
    // Solo clientes pueden acceder
    if (!isset($_SESSION['codUsuario']) || $_SESSION['codUsuario'] == "" || $_SESSION['tipoUsuario'] !== 'Cliente') {
        header("Location: index.php?vista=login");
        exit();
    }

    require_once "./php/main.php";

    // Obtener datos actuales del usuario
    $conexion = conexion();
    $stmt = $conexion->prepare("SELECT nombreUsuario, categoriaCliente, estadoCuenta FROM usuarios WHERE codUsuario = ?");
    $stmt->bind_param("i", $_SESSION['codUsuario']);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
    $stmt->close();
    $conexion->close();
?>

<section id="about" class="about">
    <div class="container-fluid">

        <?php
        // Mostrar mensajes flash
        if (isset($_SESSION['perfil_mensaje'])) {
            $tipo = 'info';
            $texto = $_SESSION['perfil_mensaje'];
            if (is_array($_SESSION['perfil_mensaje'])) {
                $tipo = $_SESSION['perfil_mensaje']['tipo'] ?? 'info';
                $texto = $_SESSION['perfil_mensaje']['texto'] ?? '';
            }
            echo '<div class="container" style="margin-top: 90px; position: relative; z-index: 1000;">
                    <div class="alert alert-' . htmlspecialchars($tipo) . ' alert-dismissible fade show" role="alert">
                        ' . htmlspecialchars($texto) . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                  </div>';
            unset($_SESSION['perfil_mensaje']);
        }
        ?>

        <div class="profile-card">
            <h2><i class="fas fa-user-circle"></i> Mi Perfil</h2>

            <!-- Datos de solo lectura -->
            <div class="profile-field">
                <label>Categoría de cliente</label>
                <div class="field-value">
                    <?php echo htmlspecialchars($usuario['categoriaCliente'] ?? 'N/A'); ?>
                </div>
            </div>

            <!-- Sección: Cambiar Email -->
            <div class="profile-section">
                <h3><i class="fas fa-envelope"></i> Correo electrónico</h3>
                <form action="php/cliente/updateProfile.php" method="POST" autocomplete="off">
                    <input type="hidden" name="accion" value="cambiarEmail">
                    <div class="mb-3">
                        <label for="emailActual" class="form-label">Email actual</label>
                        <input type="email" class="form-control" id="emailActual" value="<?php echo htmlspecialchars($usuario['nombreUsuario']); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="emailNuevo" class="form-label">Nuevo email</label>
                        <input type="email" class="form-control" id="emailNuevo" name="emailNuevo" placeholder="nuevo@ejemplo.com" maxlength="70" required>
                    </div>
                    <div class="mb-3">
                        <label for="claveConfirmEmail" class="form-label">Contraseña actual (para confirmar)</label>
                        <div class="profile-input-wrapper">
                            <input type="password" class="form-control" id="claveConfirmEmail" name="claveConfirmEmail" placeholder="********" maxlength="100" required style="padding-right: 40px;">
                            <button type="button" onclick="togglePasswordVisibility('claveConfirmEmail', 'iconConfirmEmail')" class="eye-btn-profile" aria-label="Mostrar u ocultar contraseña">
                                <i id="iconConfirmEmail" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar email</button>
                </form>
            </div>

            <!-- Sección: Cambiar Contraseña -->
            <div class="profile-section">
                <h3><i class="fas fa-lock"></i> Cambiar contraseña</h3>
                <form action="php/cliente/updateProfile.php" method="POST" autocomplete="off">
                    <input type="hidden" name="accion" value="cambiarClave">
                    <div class="mb-3">
                        <label for="claveActual" class="form-label">Contraseña actual</label>
                        <div class="profile-input-wrapper">
                            <input type="password" class="form-control" id="claveActual" name="claveActual" placeholder="********" maxlength="100" required style="padding-right: 40px;">
                            <button type="button" onclick="togglePasswordVisibility('claveActual', 'iconClaveActual')" class="eye-btn-profile" aria-label="Mostrar u ocultar contraseña">
                                <i id="iconClaveActual" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="claveNueva1" class="form-label">Nueva contraseña</label>
                        <div class="profile-input-wrapper">
                            <input type="password" class="form-control" id="claveNueva1" name="claveNueva1" placeholder="********" pattern=".{7,100}" maxlength="100" required style="padding-right: 40px;">
                            <button type="button" onclick="togglePasswordVisibility('claveNueva1', 'iconClaveNueva1')" class="eye-btn-profile" aria-label="Mostrar u ocultar contraseña">
                                <i id="iconClaveNueva1" class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="form-text text-muted">Mínimo 7 caracteres.</small>
                    </div>
                    <div class="mb-3">
                        <label for="claveNueva2" class="form-label">Repetir nueva contraseña</label>
                        <div class="profile-input-wrapper">
                            <input type="password" class="form-control" id="claveNueva2" name="claveNueva2" placeholder="********" pattern=".{7,100}" maxlength="100" required style="padding-right: 40px;">
                            <button type="button" onclick="togglePasswordVisibility('claveNueva2', 'iconClaveNueva2')" class="eye-btn-profile" aria-label="Mostrar u ocultar contraseña">
                                <i id="iconClaveNueva2" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-key"></i> Cambiar contraseña</button>
                </form>
            </div>

            <!-- Sección: Dar de baja la cuenta -->
            <div class="profile-section">
                <h3 class="text-danger"><i class="fas fa-user-slash"></i> Dar de baja mi cuenta</h3>
                <p class="text-muted">Esta acción desactivará tu cuenta. Ya no podrás iniciar sesión. Tu email quedará disponible para registrar una nueva cuenta.</p>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalDarDeBaja">
                    <i class="fas fa-exclamation-triangle"></i> Dar de baja mi cuenta
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Modal de confirmación para dar de baja -->
<div class="modal fade" id="modalDarDeBaja" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="modalDarDeBajaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h4 class="modal-title" id="modalDarDeBajaLabel"><i class="fas fa-exclamation-triangle"></i> Confirmar baja de cuenta</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="php/cliente/updateProfile.php" method="POST">
                <input type="hidden" name="accion" value="darDeBaja">
                <div class="modal-body">
                    <p><strong>¿Estás seguro de que querés dar de baja tu cuenta?</strong></p>
                    <p class="text-muted">Esta acción cambiará el estado de tu cuenta a <em>Baja</em> y se cerrará tu sesión. No podrás volver a iniciar sesión con esta cuenta.</p>
                    <div class="mb-3">
                        <label for="claveBaja" class="form-label">Ingresá tu contraseña para confirmar:</label>
                        <div class="profile-input-wrapper">
                            <input type="password" class="form-control" id="claveBaja" name="claveBaja" placeholder="********" maxlength="100" required style="padding-right: 40px;">
                            <button type="button" onclick="togglePasswordVisibility('claveBaja', 'iconClaveBaja')" class="eye-btn-profile" aria-label="Mostrar u ocultar contraseña">
                                <i id="iconClaveBaja" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-user-slash"></i> Confirmar baja</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
