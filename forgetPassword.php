<?php
include 'connect.php';
include 'reset-password.php';
session_start();

if (isset($_POST['reset_password'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $token = md5(rand());
    
        $check_email = "SELECT email, fname FROM employees WHERE email = '$email' LIMIT 1";
        $check_email_run = mysqli_query($con, $check_email);
    
        if (mysqli_num_rows($check_email_run) > 0) {
            $row = mysqli_fetch_array($check_email_run);
            $get_name = $row['fname'];
            $get_email = $row['email'];
            echo $get_email;
    
            $time=time();
            $update_token = "UPDATE employees SET token_id = '$token',token_startAT='$time' WHERE email = '$get_email' LIMIT 1";
            $update_token_run = mysqli_query($con, $update_token);
    
            if ($update_token_run) {
                send_password_reset($get_name, $get_email, $token);
                $_SESSION['status'] = "We have e-mail you a password reset link.";
                header("Location: forgetPassword.php");
                exit(0);
            } else {
                $_SESSION['status'] = "Something went wrong.";
                header("Location: forgetPassword.php");
            }
        } else {
            $_SESSION['status'] = "No Email Found";
        }
    }


?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link href="css/dashboard.css" rel="stylesheet">
</head>

<body>
    <div class="login_section">
        <div class="wrapper relative" style="height:300px">

            <div class="heading-top">
                <div class="logo-center"><a href="#"><img src="images/at your service_banner.png"></a></div>
            </div>

            <div class="main-div">
                <h1 style="text-align:center;background-color:rgb(239, 239, 239); padding:7px 12px;width:90%;font-size:larger;">Reset Password <span></span></h1>
                <?php if (isset($_SESSION['status'])) : ?>
                    <div class="error-message-div error-msg"><?php echo $_SESSION['status'];
                                                                unset($_SESSION['status']); ?></div>
                <?php endif; ?>
                <form class="margin_bottom" role="form" method="POST">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter Email Id..." />
                    </div>
                    <button class="submit-btn" type="submit" name="reset_password">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>