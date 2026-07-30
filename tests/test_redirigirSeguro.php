<?php
$_SERVER['HTTP_HOST'] = 'localhost';

$fallback = 'index.php';
$pasos = 0;
$acertados = 0;

function probar($descripcion, $url, $esperado) {
    global $fallback, $pasos, $acertados;
    $pasos++;
    $hostPropio = $_SERVER['HTTP_HOST'] ?? '';
    if ($url === '' || $url === null) {
        $resultado = $fallback;
    } else {
        $componentes = parse_url($url);
        if (isset($componentes['host']) && $componentes['host'] !== $hostPropio) {
            $resultado = $fallback;
        } else {
            $resultado = $url;
        }
    }
    $ok = $resultado === $esperado;
    if ($ok) $acertados++;
    echo ($ok ? '✓' : '✗') . " $descripcion: esperado='$esperado', obtenido='$resultado'" . ($ok ? '' : ' FALLO') . "\n";
}

echo "=== test redirigirSeguro ===\n\n";

probar('URL vacia va al fallback', '', 'index.php');
probar('URL nula va al fallback', null, 'index.php');
probar('URL relativa se mantiene', 'index.php?vista=home', 'index.php?vista=home');
probar('URL absoluta mismo host', 'http://localhost/pagina.php', 'http://localhost/pagina.php');
probar('URL externo va al fallback', 'http://evil.com/robo.php', 'index.php');
probar('URL https externo va al fallback', 'https://malicious.com', 'index.php');
probar('URL mismo host con puerto', 'http://localhost:80/test.php', 'http://localhost:80/test.php');

echo "\n=== Resultado: $acertados/$pasos ===\n";
exit($acertados === $pasos ? 0 : 1);
