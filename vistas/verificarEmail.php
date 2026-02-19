<?php 
require_once __DIR__ . '/../php/verificarEmail.php';

$token = isset($_GET['token']) ? $_GET['token'] : '';
$resultado = verificarTokenEmail($token);
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="card shadow-lg border-0" style="max-width: 500px; width: 100%; background-color: #212529;">
        <div class="card-body text-center p-5">
            <?php if ($resultado['exito']): ?>
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h3 class="text-white mb-3">¡Verificación exitosa!</h3>
                <p class="text-light"><?php echo htmlspecialchars($resultado['mensaje']); ?></p>
                <a href="index.php?vista=login" class="btn btn-primary mt-3 rounded-pill px-4">
                    Iniciar Sesión
                </a>
            <?php else: ?>
                <div class="mb-4">
                    <i class="fas fa-times-circle text-danger" style="font-size: 4rem;"></i>
                </div>
                <h3 class="text-white mb-3">Error de verificación</h3>
                <p class="text-light"><?php echo htmlspecialchars($resultado['mensaje']); ?></p>
                <a href="index.php?vista=signUp" class="btn btn-warning mt-3 rounded-pill px-4">
                    Registrarse nuevamente
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>