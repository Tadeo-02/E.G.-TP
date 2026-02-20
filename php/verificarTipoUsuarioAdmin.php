<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipoUsuario'] !== 'Admin') {
    header("Location: /index.php?vista=login");
    exit();
}

// Deshabilitar caché para evitar que el usuario vea esta página después del logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
?>