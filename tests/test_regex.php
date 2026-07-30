<?php
require_once __DIR__ . '/../php/main.php';

$pasos = 0;
$acertados = 0;

function probar($descripcion, $expr, $valor, $esperadoError) {
    global $pasos, $acertados;
    $pasos++;
    $resultado = verificarDatos($expr, $valor);
    $ok = $resultado === $esperadoError;
    if ($ok) $acertados++;
    echo ($ok ? '✓' : '✗') . " $descripcion: esperado=" . ($esperadoError ? 'true' : 'false')
        . ", obtenido=" . ($resultado ? 'true' : 'false') . ($ok ? '' : ' FALLO') . "\n";
}

echo "=== test regex password ===\n\n";

$regex = "[a-zA-Z0-9\$@.\-]{7,100}";

probar('clave valida 7 chars', $regex, 'abc1234', false);
probar('clave valida con $', $regex, 'a$$$bbb', false);
probar('clave valida con @', $regex, 'a@b@cde', false);
probar('clave valida con .', $regex, 'a.b.cde', false);
probar('clave valida con -', $regex, 'a-b-cde', false);
probar('clave valida 10 chars mix', $regex, 'Abc@12.dE', false);
probar('clave demasiado corta', $regex, 'ab12', true);
probar('clave vacia', $regex, '', true);
probar('clave con espacio', $regex, 'abc 123', true);
probar('clave con acento', $regex, 'abcdéfg', true);
probar('clave con parentesis', $regex, 'abc(def', true);
probar('clave con #', $regex, 'abc#def', true);
probar('clave con !', $regex, 'abc!def', true);

echo "\n=== test regex escapado ===\n\n";

$regex2 = '[a-zA-Z0-9\$@.\-]{7,100}';
$contieneEscape = strpos($regex2, '\$') !== false;
echo ($contieneEscape ? '✓' : '✗') . " el regex contiene \\$ escapado: " . ($contieneEscape ? 'si' : 'no') . "\n";
$pasos++;
if ($contieneEscape) $acertados++;

$contieneGuionEscapado = strpos($regex2, '\-') !== false;
echo ($contieneGuionEscapado ? '✓' : '✗') . " el regex contiene \\- escapado: " . ($contieneGuionEscapado ? 'si' : 'no') . "\n";
$pasos++;
if ($contieneGuionEscapado) $acertados++;

echo "\n=== Resultado: $acertados/$pasos ===\n";
exit($acertados === $pasos ? 0 : 1);
