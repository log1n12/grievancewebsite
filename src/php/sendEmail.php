<?php
require_once 'mail/PHPMailer.php';
require_once 'mail/Exception.php';
require_once 'mail/OAuth.php';
require_once 'mail/POP3.php';
require_once 'mail/SMTP.php';

$mail = new PHPMailer\PHPMailer\PHPMailer(true);

//SMTP Settings
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls"; //tls
$mail->Host = "smtp.gmail.com";
$mail->Port = 587; //587
$mail->isHTML();
$mail->Username = "crlv.brmndo@gmail.com";
$mail->Password = 'crl11056327';
$mail->setFrom('no-response@fourth.web');
$mail->Subject = $mailsubject;
$mail->Body = $mailbody;
$mail->addAddress($useremail);

if ($mail->send()) {
} else {
    echo "Message" . $mail->ErrorInfo;
}
