<?php

include('connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function send_password_reset($get_name, $get_email, $token,$get_id)
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
        $mail->addAddress($get_email, $get_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        // $mail->Body = 'Hello ' . $get_name . ',<br><br>This is a test email sent from PHPMailer. Your reset token is: ' . $token;

        $mail->Body = "
 
    
         <div class='outer' style='background-color:#CFD6F4;height:500px; display:flex; align-items:center; justify-content: center;'>
        <div class='inner' style='border-radius:10px; height:320px; margin-left:450px;margin-top:60px; background-color: white; padding:20px;'>
        <h1 style='color:#506BEC';>Hello $get_name!</h1>
<h4>We have received a password reset request for your account.</h4>
<span style='background-color: #506BEC;  border-radius: 4px; color: white; padding: 6px 13px; cursor:pointer; margin-top:20px; display:inline-block;'><a href = 'http://localhost/Crud_design/change-password.php?token=$token&id=$get_id' style='text-decoration:none; color:white;'>Reset Password</a></span>
<p style='margin-top:10px;'>This link can only be used <b>once</b> and is valid for only <b>two minutes.</b></p>
    <p style='margin-top:80px;''>Didn’t request a password reset? You can ignore this message.</p>

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


function changePassword_Msg($fname, $email)
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
<p style='margin-top:40px;'>If done by you then you can ignore this message.</p>

    <p style='margin-top:60px;''>If you have any problems, please contact us by visiting our website.</p>

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



