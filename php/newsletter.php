<?php
    require_once __DIR__ . "/enviarMail.php";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
?>