<?php
$pasos = 0;
$acertados = 0;

function probar($descripcion, $ok) {
    global $pasos, $acertados;
    $pasos++;
    if ($ok) $acertados++;
    echo ($ok ? '✓' : '✗') . " $descripcion" . ($ok ? '' : ' FALLO') . "\n";
}

$raiz = dirname(__DIR__);

echo "=== Issue 6: bloque de inicio de sesión centralizado ===\n\n";

$contenidoMain = file_get_contents("$raiz/php/main.php");
$tieneHelper = strpos($contenidoMain, 'function iniciarSesion()') !== false;
$tieneGuard = strpos($contenidoMain, 'session_status() !== PHP_SESSION_ACTIVE') !== false;
$tieneNombre = strpos($contenidoMain, 'session_name("UNR")') !== false;
probar('iniciarSesion() definida en php/main.php', $tieneHelper);
probar('iniciarSesion() tiene guard de session_status()', $tieneGuard);
probar('iniciarSesion() usa session_name("UNR")', $tieneNombre);

echo "\n=== session_start()/session_name() solo en main.php ===\n\n";

$excluidos = ['php/main.php', 'inc/sessionStart.php'];
$archivosIncluir = [];

foreach (['php', 'vistas', 'inc'] as $dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("$raiz/$dir", FilesystemIterator::SKIP_DOTS));
    foreach ($iterator as $archivo) {
        if ($archivo->getExtension() !== 'php') continue;
        $rutaRel = substr($archivo->getPathname(), strlen($raiz) + 1);
        if (!in_array($rutaRel, $excluidos, true)) {
            $archivosIncluir[] = $rutaRel;
        }
    }
}

$violaciones = [];
$usosIniciarSesion = [];
foreach ($archivosIncluir as $rutaRel) {
    $contenido = file_get_contents("$raiz/$rutaRel");
    if (preg_match('/session_start\s*\(|session_name\s*\(/', $contenido)) {
        $violaciones[] = $rutaRel;
    }
    if (strpos($contenido, 'iniciarSesion()') !== false) {
        $usosIniciarSesion[] = $rutaRel;
    }
}

probar('Ningún archivo llama session_start()/session_name() fuera de main.php', count($violaciones) === 0);
if ($violaciones) {
    foreach ($violaciones as $v) echo "   violación: $v\n";
}

echo "\n=== Todo uso de iniciarSesion() carga main.php ===\n\n";

$sinMain = [];
foreach ($usosIniciarSesion as $rutaRel) {
    if ($rutaRel === 'inc/sessionStart.php') continue;
    $contenido = file_get_contents("$raiz/$rutaRel");
    if (strpos($contenido, 'main.php') === false) {
        $sinMain[] = $rutaRel;
    }
}
probar('Todos los usos de iniciarSesion() incluyen main.php', count($sinMain) === 0);
if ($sinMain) {
    foreach ($sinMain as $s) echo "   sin main.php: $s\n";
}

echo "\n=== Resultado: $acertados/$pasos ===\n";
exit($acertados === $pasos ? 0 : 1);
