<?php
/**
 * Created by PhpStorm.
 * User: agustin
 * Date: 11/16/2017
 * Time: 1:38 PM
 */

$subject = $_POST["subject"];
$from = $_POST["email"];
$message = $_POST["message"];
$name = $_POST["name"];

require_once ('/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php');
$mail             = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "smtp.gmail.com"; // SMTP server
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "tls";
$mail->Host       = "smtp.gmail.com";      // SMTP server
$mail->Port       = 587;                   // SMTP port
$mail->Username   = "esns.life@gmail.com";  // username
$mail->Password   = "Toronto17";            // password

$mail->SetFrom('esns.life@gmail.com', 'ESNS Email Service');

$mail->Subject = $subject;

$mail->MsgHTML($message);

$mail->AddAddress($from, $name);

if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
