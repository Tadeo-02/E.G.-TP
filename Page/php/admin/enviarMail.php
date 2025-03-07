<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST["send"])){
    $mail = new PHPMailer(true);
    $mail -> isSMTP();
    $mail -> Host = 'smtp.gmail.com';
    $mail -> SMTPAuth = true;
    $mail -> Username ='shoppingnovarosario@gmail.com';
    $mail -> Password = 'nxiwalfkdcqaiqdk';
    $mail -> SMTPSecure = 'ssl';
    $mail -> Port = 465;
    
    $mail -> setFrom('shoppingnovarosario@gmail.com');

    $mail -> addAddress($_POST["email"]);

    $mail -> isHTML(true);

    $mail -> Subject = $_POST["asunto"];
    $mail -> Body = $_POST["mensaje"];

    $mail -> send();
    echo 'Mensaje enviado correctamente';
}






















?>