<?php
session_start();
include('connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function send_password_reset($get_name, $get_email, $token)
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
<h2>Hello</h2>
<h3>You are receiving this email because we have received a password reset request for your account.</h3>
<a href = 'http://localhost/Crud_design/change-password.php?token=$token'>Click Me </a>
";
        // Send email
        $mail->send();
        echo 'Message sent';
        header("Location: " . $_SERVER['HTTP_REFERER'] . "");
    } catch (Exception $e) {
        echo "Message not sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// if (isset($_POST['reset_password'])) {
//     $email = mysqli_real_escape_string($con, $_POST['email']);
//     $token = md5(rand());

//     $check_email = "SELECT email, fname FROM employees WHERE email = '$email' LIMIT 1";
//     $check_email_run = mysqli_query($con, $check_email);

//     if (mysqli_num_rows($check_email_run) > 0) {
//         $row = mysqli_fetch_array($check_email_run);
//         $get_name = $row['fname'];
//         $get_email = $row['email'];
//         echo $get_email;


//         $update_token = "UPDATE employees SET verify_token = '$token' WHERE email = '$get_email' LIMIT 1";
//         $update_token_run = mysqli_query($con, $update_token);

//         if ($update_token_run) {
//             send_password_reset($get_name, $get_email, $token);
//             $_SESSION['status'] = "We have e-mail you a password reset link";
//             header("Location: forgetPassword.php");
//             exit(0);
//         } else {
//             $_SESSION['status'] = "Something went wrong.";
//             header("Location: forgetPassword.php");
//         }
//     } else {
//         $_SESSION['status'] = "No Email Found";
//         header("Location: forgetPassword.php");
//     }
// }


// if (isset($_POST['password_update'])) {
//     $email = mysqli_real_escape_string($con, $_POST['email']);
//     $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
//     $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
//     $token = mysqli_real_escape_string($con, $_POST['password_token']);
//     if (!empty($token)) {
//         if (!empty($email) && !empty($new_password) && !empty($token)) {
//             // checking token is valid or not
//             $check_token = "SELECT verify_token FROM employees WHERE verify_token='$token' LIMIT 1";
//             $check_token_run = mysqli_query($con, $check_token);
//             if (mysqli_num_rows($check_token_run) > 0) {
//                 if ($new_password == $confirm_password) {
//                     $new_password = md5($new_password);
//                     $update_password = "UPDATE employees SET password = '$new_password' WHERE verify_token='$token' LIMIT 1";
//                     $update_password_run = mysqli_query($con, $update_password);
//                     if ($update_password_run) {
//                         $_SESSION['status'] = "Password Successfully Updated";
//                         header("Location: login.php");
//                         exit(0);
//                     } else {
//                         $_SESSION['status'] = "Did not update password, something went wrong.";
//                         header("Location: change-password.php");
//                         exit(0);
//                     }
//                 } else {
//                     $_SESSION['status'] = "Password Does not match";
//                     header("Location: change-password.php");
//                     exit(0);
//                 }
//             }
//         } else {
//             $_SESSION['status'] = "All fields are mendatory";
//             header("Location: change-password.php?token=$token&email=$email");
//             exit(0);
//         }
//     } else {
//         $_SESSION['status'] = "No token available";
//         header("Location: forgetPassword.php");
//         exit(0);
//     }
// }
