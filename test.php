<?php
session_start();
include('connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


$mail = new PHPMailer(true);

// Server settings
$mail->SMTPSecure = "ssl";
$mail->Host = 'smtp.gmail.com';
$mail->Port = '465';
$mail->Username = 'satyamgarg464@gmail.com'; // SMTP account username
$mail->Password = 'vrmt gcin jopd itui';
$mail->SMTPKeepAlive = true;
$mail->Mailer = "smtp";
$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPAuth = true; // enable SMTP authentication
$mail->CharSet = 'utf-8';
$mail->SMTPDebug = 0;

// Recipients
$mail->setFrom('satyamgarg464@gmail.com', 'Satyam Garg');
$mail->addAddress('satyam@yopmail.com', 'Satyam');

// Content
$mail->isHTML(true);
$mail->Subject = 'Password Reset Request';
$mail->Body = 'Hello   ,<br><br>This is a test email sent from PHPMailer. Your reset token is: ';
$mail->send();
echo "mail sent";

