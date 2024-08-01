<?php
include '../connect.php';
include '../mailTemplates.php';
session_start();

if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])==TRUE){
    header("location:../dashboard");
    exit;
  }

if (isset($_POST['reset_password'])) {
        $user_email = mysqli_real_escape_string($con, $_POST['email']);
        $token = md5(rand());
    
        $check_email = "SELECT user_email, user_first_name,user_id FROM em_users WHERE user_email = '$user_email' AND user_isDeleted!=1 LIMIT 1";
        $check_email_run = mysqli_query($con, $check_email);
    
        if (mysqli_num_rows($check_email_run) > 0) {
            $row = mysqli_fetch_array($check_email_run);
            $get_name = $row['user_first_name'];
            $get_email = $row['user_email'];
            $get_id= $row['user_id'];
            echo $get_email;
    
            $time=time();
            $update_token = "UPDATE em_users SET user_token = '$token',user_token_startAt='$time' WHERE user_email = '$get_email' LIMIT 1";
            $update_token_run = mysqli_query($con, $update_token);
    
            if ($update_token_run) {
                send_mail($get_name, $get_email, "forgotpassword", $token, $get_id);
                $_SESSION['status'] = "We have e-mail you a password reset link.";
                header("Location: ../forgetPassword");
                exit(0);
            } else {
                $_SESSION['status'] = "Something went wrong.";
                header("Location: ../forgetPassword");
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
    <link href="../css/dashboard.css" rel="stylesheet">
</head>

<body>
  <div class="login_section">
    <div class="wrapper relative" style="height:300px">
     
      <div class="heading-top">
        <div class="logo-cebter"><a href="#"><img src="../images/at your service_banner.png"></a></div>
      </div>
      <div class="box" style="height:280px">
        <div class="pswd-div" style="padding:24px;">
          <h2 style="text-align:center;background-color:rgb(239, 239, 239); padding:7px 12px;width:90%;font-size:larger;margin-bottom:35px;">Reset Password <span></span></h2>
          <?php if (isset($_SESSION['status'])) : ?>
            <div class="error-message-div error-msg"><?php echo $_SESSION['status'];
                                                      unset($_SESSION['status']); ?></div>
          <?php endif; ?>
          <form novalidate class="margin_bottom" role="form" method="POST">
           
            <div class="form-group">
              <label for="e-mail">Email: *</label>
              <input type="email" class="form-control" name="email" placeholder="Enter Email Id..." />
            
            </div>
          
            <button class="submit-btn" type="submit" name="reset_password">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>


</html>