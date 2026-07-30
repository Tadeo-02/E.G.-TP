<?php

if (defined('APP_URL') && defined('RESEND_API_KEY') && defined('MAIL_FROM')) {
    return;
}

function _cargar_env(string $ruta): void {
    if (!file_exists($ruta)) {
        return;
    }

    $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lineas === false) {
        return;
    }

    foreach ($lineas as $linea) {
        $linea = trim($linea);

        if ($linea === '' || str_starts_with($linea, '#')) {
            continue;
        }

        if (str_starts_with($linea, 'export ')) {
            $linea = substr($linea, 7);
        }

        $pos = strpos($linea, '=');
        if ($pos === false) {
            continue;
        }

        $clave = trim(substr($linea, 0, $pos));
        $valor = trim(substr($linea, $pos + 1));

        if (strlen($valor) >= 2 &&
            (($valor[0] === '"' && $valor[-1] === '"') ||
             ($valor[0] === "'" && $valor[-1] === "'"))) {
            $valor = substr($valor, 1, -1);
        }

        putenv("$clave=$valor");
        $_ENV[$clave] = $valor;
    }
}

$dir = __DIR__;
$dirRaiz = dirname($dir);

_cargar_env("$dir/.env");
_cargar_env("$dirRaiz/.env");

if (!defined('APP_URL')) {
    $url = getenv('APP_URL');
    if ($url === false) { $url = $_ENV['APP_URL'] ?? 'http://localhost'; }
    define('APP_URL', rtrim($url, '/'));
}

if (!defined('RESEND_API_KEY')) {
    $key = getenv('RESEND_API_KEY');
    if ($key === false) { $key = $_ENV['RESEND_API_KEY'] ?? ''; }
    define('RESEND_API_KEY', $key);
}

if (!defined('MAIL_FROM')) {
    $from = getenv('MAIL_FROM');
    if ($from === false) { $from = $_ENV['MAIL_FROM'] ?? ''; }
    define('MAIL_FROM', $from);
}
