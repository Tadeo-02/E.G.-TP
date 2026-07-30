<?php
$pasos = 0;
$acertados = 0;

function probar($descripcion, $ok) {
    global $pasos, $acertados;
    $pasos++;
    if ($ok) $acertados++;
    echo ($ok ? '✓' : '✗') . " $descripcion" . ($ok ? '' : ' FALLO') . "\n";
}

echo "=== Grupo 3: Bugs en listaPromociones.php ===\n\n";

$contenido = file_get_contents(__DIR__ . '/../php/listaPromociones.php');

$tieneCondicionesWMayuscula = strpos($contenido, '$condicionesW') !== false;
$tieneCondicioneswMinuscula = strpos($contenido, '$condicionesw') !== false;
$tieneCondicionesWArr = preg_match('/\$condicionesW\s*=\s*\[/', $contenido);
$tieneCondicioneswArr = preg_match('/\$condicionesw\s*=\s*\[/', $contenido);

probar('variable $condicionesW (mayuscula)', $tieneCondicionesWMayuscula);
probar('NO existe $condicionesw (minuscula)', !$tieneCondicioneswMinuscula);

$parentesisCorrecto = strpos($contenido, '!empty($diaDesde) && !empty($diaHasta)') !== false;
probar('parentesis de empty() correctos', $parentesisCorrecto);

$parentesisIncorrecto = strpos($contenido, '!empty($diaDesde && !empty($diaHasta))') !== false;
probar('NO tiene parentesis incorrecto', !$parentesisIncorrecto);

echo "\n=== loginUser.php: exit() tras headers_sent() ===\n\n";

$contenidoLogin = file_get_contents(__DIR__ . '/../php/loginUser.php');

$tieneExit = (bool)preg_match('/\}\s*else\s*\{[^}]*header\([^}]*\)\s*;[^}]*\}\s*exit\s*\(\)\s*;/s', $contenidoLogin);
$tieneExit2 = preg_match('/\}\s*else\s*\{[^}]*header\([^}]*\)\s*;[^}]*\}\s*;\s*exit\s*\(\)\s*;/s', $contenidoLogin);
$tieneExit3 = (bool)preg_match('/\}\s*exit\s*\(\)\s*;\s*\}/s', $contenidoLogin);
probar('exit() despues del bloque headers_sent()', $tieneExit || $tieneExit2 || $tieneExit3);

echo "\n=== Regex escapado en loginUser.php ===\n\n";
$tieneRegexEscapadoLogin = strpos($contenidoLogin, '\$@.\-') !== false;
probar('regex con \$ y \- escapados en loginUser.php', $tieneRegexEscapadoLogin);

echo "\n=== Regex escapado en saveUser.php ===\n\n";
$contenidoSave = file_get_contents(__DIR__ . '/../php/saveUser.php');
$tieneRegexEscapadoSave = strpos($contenidoSave, '\$@.\-') !== false;
probar('regex con \$ y \- escapados en saveUser.php', $tieneRegexEscapadoSave);

echo "\n=== Regex escapado en procesarResetPassword.php ===\n\n";
$contenidoReset = file_get_contents(__DIR__ . '/../php/procesarResetPassword.php');
$tieneRegexEscapadoReset = strpos($contenidoReset, '\$@.\-') !== false;
probar('regex con \$ y \- escapados en procesarResetPassword.php', $tieneRegexEscapadoReset);

echo "\n=== Resultado: $acertados/$pasos ===\n";
exit($acertados === $pasos ? 0 : 1);
