<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST["botonAnashe"])){
    $mail = new PHPMailer(true);
    $mail -> isSMTP();
    $mail -> Host = 'smtp.gmail.com';
    $mail -> SMTPAuth = true;
    $mail -> Username ='novashopping00@gmail.com';
    $mail -> Password = 'zyvhsqfvwloruife';
    $mail -> SMTPSecure = 'ssl';
    $mail -> Port = 465;
    
    $mail -> setFrom('shoppingnovarosario@gmail.com');

    $mail -> addAddress($_POST["email"]);

    $mail -> isHTML(true);

    $mail -> Subject = $_POST["asunto"];
    $mail -> Body = $_POST["mensaje"];
    $mail -> Body .= '<br><p>NOVA SHOPPING</p>';

    $mail -> send();

}

?>