<?php

include('connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function   changePassword_Msg($fname, $email)
{
    $mail = new PHPMailer(true);
    try {
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
        $mail->addAddress($email, $fname);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Password was Reset';
        // $mail->Body = 'Hello ' . $get_name . ',<br><br>This is a test email sent from PHPMailer. Your reset token is: ' . $token;

        $mail->Body = "

 <div class='outer' style='background-color:#CFD6F4;height:500px; display:flex; align-items:center; justify-content: center;'>
        <div class='inner' style='border-radius:10px; height:320px; margin-left:450px;margin-top:60px; background-color: white; padding:20px;'>
        <h1 style='color:#506BEC';>Hello $fname!</h1>
<h4>We wanted to let you know that your password was reset.</h4>

    <p style='margin-top:80px;''>If you have any problems, please contact us by visiting our website.</p>

        </div>
        
        </div>

";
        // Send email
        $mail->send();
        echo 'Message sent';
        header("Location: " . $_SERVER['HTTP_REFERER'] . "");
    } catch (Exception $e) {
        echo "Message not sent. Mailer Error: {$mail->ErrorInfo}";
    }
}



