<?php
$pasos = 0;
$acertados = 0;

function probar($descripcion, $ok) {
    global $pasos, $acertados;
    $pasos++;
    if ($ok) $acertados++;
    echo ($ok ? '✓' : '✗') . " $descripcion" . ($ok ? '' : ' FALLO') . "\n";
}

echo "=== test XSS disp-message.php ===\n\n";

$contenido = file_get_contents(__DIR__ . '/../php/disp-message.php');

$tieneHtmlspecialchars = strpos($contenido, 'htmlspecialchars') !== false;
probar('usa htmlspecialchars()', $tieneHtmlspecialchars);

$patronDirecto = '". $message ."';
$tieneDirecto = strpos($contenido, $patronDirecto) !== false;
probar('NO hay echo con $message concatenado directamente', !$tieneDirecto);

echo "\n=== test SQL injection (no ->query con interpolacion) ===\n\n";

$archivosSql = [
    '../php/admin/altaLocales.php',
    '../php/admin/editarLocales.php',
    '../php/admin/altaNovedades.php',
    '../php/admin/editarNovedades.php',
    '../php/dueñoLocal/savePromociones.php',
    '../php/loginUser.php',
    '../php/cliente/saveSolicitudPromoCliente.php',
    '../php/cliente/listaMisDescuentos.php',
    '../php/listaLocales.php',
    '../php/listaPromociones.php',
    '../php/admin/aprobarSolicitudCuenta.php',
    '../php/admin/denegarSolicitudCuenta.php',
    '../php/admin/denegarPromocion.php',
    '../php/dueñoLocal/aprobarSolicitudDescuentoCliente.php',
    '../php/dueñoLocal/DenegarSolicitudDescuentoCliente.php',
    '../php/cliente/utilizarDescuento.php',
    '../php/dueñoLocal/reporteDescuento.php',
    '../php/dueñoLocal/listaSolicitudDescuentos.php',
    '../php/listaNovedades.php',
    '../php/vencimientoPromociones.php',
    '../php/saveUser.php',
];

foreach ($archivosSql as $ruta) {
    $contenido = file_get_contents(__DIR__ . '/' . $ruta);
    $tieneInterpolacion = preg_match('/\bquery\s*\(\s*["\'][^"\']*\$[^"\']*["\']/', $contenido);
    $nombre = basename(dirname($ruta)) . '/' . basename($ruta);
    probar("$nombre sin interpolacion en query()", !$tieneInterpolacion);
}

echo "\n=== test Open Redirect (no HTTP_REFERER directo) ===\n\n";

$archivosReferer = [
    '../php/admin/altaLocales.php',
    '../php/admin/editarLocales.php',
    '../php/admin/altaNovedades.php',
    '../php/admin/editarNovedades.php',
    '../php/admin/aprobarSolicitudCuenta.php',
    '../php/admin/denegarSolicitudCuenta.php',
    '../php/admin/denegarPromocion.php',
    '../php/dueñoLocal/aprobarSolicitudDescuentoCliente.php',
    '../php/dueñoLocal/DenegarSolicitudDescuentoCliente.php',
    '../php/cliente/saveSolicitudPromoCliente.php',
    '../php/cliente/mensajePromocion.php',
    '../php/cliente/utilizarDescuento.php',
];

foreach ($archivosReferer as $ruta) {
    $contenido = file_get_contents(__DIR__ . '/' . $ruta);
    $headerDirecto = preg_match('/header\s*\(\s*["\']Location:\s*["\']\s*\.\s*\$_SERVER\[\'HTTP_REFERER\'\]/', $contenido);
    $nombre = basename(dirname($ruta)) . '/' . basename($ruta);
    probar("$nombre sin header() directo con HTTP_REFERER", !$headerDirecto);
}

echo "\n=== test helper redirigirSeguro en main.php ===\n\n";
$contenidoMain = file_get_contents(__DIR__ . '/../php/main.php');
$tieneHelper = strpos($contenidoMain, 'function redirigirSeguro') !== false;
probar('main.php contiene function redirigirSeguro()', $tieneHelper);

echo "\n=== Resultado: $acertados/$pasos ===\n";
exit($acertados === $pasos ? 0 : 1);
