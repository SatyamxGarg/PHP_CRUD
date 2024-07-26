<?php

include('connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function  signup_Msg($fname, $email)
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
        $mail->Subject = 'Successfully Signedin!';
        // $mail->Body = 'Hello ' . $get_name . ',<br><br>This is a test email sent from PHPMailer. Your reset token is: ' . $token;

        $mail->Body = "
<div class='outer' style='background-color:#CFD6F4;height:500px; display:flex; align-items:center; justify-content: center;'>
        <div class='inner' style='border-radius:10px; height:320px; margin-left:450px;margin-top:60px; background-color: white; padding:20px;'>
        <h1 style='color:#506BEC';>Dear $fname!</h1>
<h4>Congratulations, your account has been successfully created.</h4>
<span style='background-color: #506BEC;  border-radius: 4px; color: white; padding: 6px 13px; cursor:pointer; margin-top:20px; display:inline-block;'><a href = 'http://localhost/Crud_design/login.php?' style='text-decoration:none; color:white;'>Login</a></span>
<p style='margin-top:10px;'>Please use the link to login to your account.</p>
    <p style='margin-top:80px;''>Thankyou for choosing us!.</p>

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



