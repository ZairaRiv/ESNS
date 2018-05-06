<?php
/**
 * Created by PhpStorm.
 * User: agustin
 * Date: 11/16/2017
 * Time: 1:38 PM
 */

$_POST = json_decode(file_get_contents('php://input'), true);
$subject = $_POST["subject"];
$to = $_POST["to"];
$message = $_POST["message"];
$name = $_POST["name"];

require_once ('/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php');
$mail             = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "smtp.gmail.com"; // SMTP servertesting)
$mail->SMTPDebug = false;
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

$mail->AddAddress($to, $name);


if(!$mail->Send()) {
    $myObj->success = false;
} else {
    $myObj->success = true;
}

header('Content-Type: application/json');
echo json_encode($myObj);
