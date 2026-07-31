<?php

if (defined('APP_URL') && defined('RESEND_API_KEY') && defined('MAIL_FROM') &&
    defined('DB_HOST') && defined('DB_USER') && defined('DB_PASS') && defined('DB_NAME')) {
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

        if ($valor !== '' && ($valor[0] === '"' || $valor[0] === "'")) {
            $comilla = $valor[0];
            $cierre = strrpos($valor, $comilla);

            if ($cierre !== false && $cierre > 0) {
                $valor = substr($valor, 1, $cierre - 1);
            }
        } else {
            $partes = preg_split('/\s+#/', $valor, 2);
            if ($partes !== false) {
                $valor = trim($partes[0]);
            }
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

if (!defined('DB_HOST')) {
    $dbHost = getenv('DB_HOST');
    if ($dbHost === false) { $dbHost = $_ENV['DB_HOST'] ?? 'mysql'; }
    define('DB_HOST', $dbHost);
}

if (!defined('DB_USER')) {
    $dbUser = getenv('DB_USER');
    if ($dbUser === false) { $dbUser = $_ENV['DB_USER'] ?? 'root'; }
    define('DB_USER', $dbUser);
}

if (!defined('DB_PASS')) {
    $dbPass = getenv('DB_PASS');
    if ($dbPass === false) { $dbPass = $_ENV['DB_PASS'] ?? 'pw'; }
    define('DB_PASS', $dbPass);
}

if (!defined('DB_NAME')) {
    $dbName = getenv('DB_NAME');
    if ($dbName === false) { $dbName = $_ENV['DB_NAME'] ?? 'tp_entornos'; }
    define('DB_NAME', $dbName);
}
