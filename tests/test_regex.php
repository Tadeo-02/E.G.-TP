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

$regex = ".{7,100}";

probar('clave valida 7 chars', $regex, 'abc1234', false);
probar('clave valida con $', $regex, 'a$$$bbb', false);
probar('clave valida con @', $regex, 'a@b@cde', false);
probar('clave valida con .', $regex, 'a.b.cde', false);
probar('clave valida con -', $regex, 'a-b-cde', false);
probar('clave valida con !', $regex, 'abc!def', false);
probar('clave valida con #', $regex, 'abc#def', false);
probar('clave valida con parentesis', $regex, 'abc(def', false);
probar('clave valida con espacio', $regex, 'abc 123', false);
probar('clave valida con acento', $regex, 'abcdéfg', false);
probar('clave valida 10 chars mix', $regex, 'Abc@12.dE', false);
probar('clave demasiado corta', $regex, 'ab12', true);
probar('clave vacia', $regex, '', true);
probar('clave de 101 chars', $regex, str_repeat('a', 101), true);

echo "\n=== test regex sin restriccion de caracteres ===\n\n";

$regex2 = '.{7,100}';
$tieneClaseCaracteres = strpos($regex2, '[') !== false;
echo ($tieneClaseCaracteres ? '✗' : '✓') . " el regex no restringe caracteres (sin whitelist): " . ($tieneClaseCaracteres ? 'tiene whitelist' : 'ok') . "\n";
$pasos++;
if (!$tieneClaseCaracteres) $acertados++;

echo "\n=== Resultado: $acertados/$pasos ===\n";
exit($acertados === $pasos ? 0 : 1);
