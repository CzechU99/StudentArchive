<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/..' . "/vendor/autoload.php";

$mail = new PHPMailer(true);

$mail->SMTPOptions = array(
  'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true,
  )
);

$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = "student.archive.smtp@gmail.com";
$mail->Password = "ebpr egoe arzf qhvi";

$mail->isHtml(true);

return $mail;
