<?php



session_start();
include '../connect.php';
include '../mailTemplates.php';

if (isset($_GET['token'])) {
  $token = $_GET['token'];
  $id= $_GET['id'];
  $sql = "select * from employees where id='$id' AND token_id='$token'";
  $result = mysqli_query($con, $sql);
  $row = mysqli_num_rows($result);
  $data = mysqli_fetch_array($result);
  $fname=$data['fname'];
  $email=$data['email'];
  $time1 = time();
  if ($row <= 0) {
    $_SESSION['status'] = "Invalid URL.";
    header("Location:../login");
  } else {
    $time_store = $data['token_startAT'];
    if ($time_store + (60 * 2) < $time1) {
      $sql = "UPDATE employees SET token_id=NULL,token_startAT=NULL WHERE id='$id'";
      $result = mysqli_query($con, $sql);
      if ($result) {
        $_SESSION['status'] = "Time Expired.";
        header("Location:../login");
        exit(0);
      } else {
        header("Location:../login");
        exit(0);
      }
     
      
    }
  }
} else {
  $_SESSION['status'] = "Password not Updated";
  header('location:../login');
}


if (isset($_POST['password_update'])) {

  $errors = [];
  if (empty($_POST['password_token'])) {
    $errors["password_token"] = "Token is empty.";
  } else {
    $token = $_POST['password_token'];
  }

  if (!empty($_POST['new_password'])) {
    $new_password = $_POST['new_password'];
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>.]{8,}$/';

    if (!preg_match($pattern, $new_password)) {
      $errors['new_password'] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
    }
  } else {
    $errors['new_password'] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
  }

  if (empty($_POST['confirm_password'])) {
    $errors['confirm_password'] = 'Please Retype Password Again.';
  } else {
    $confirm_password = $_POST['confirm_password'];
    if ($confirm_password != $new_password) {
      $error['confirm_password'] = 'Password not match';
    } else {
      $new_password = $confirm_password;
    }
  }

  if (empty($errors)) {
    echo "$token";




    if (!empty($token)) {

      // checking token is valid or not
      $check_token = "SELECT token_id FROM employees WHERE token_id='$token' LIMIT 1";
      $check_token_run = mysqli_query($con, $check_token);
      if (mysqli_num_rows($check_token_run) > 0) {
        if ($new_password == $confirm_password) {
          $new_password = md5($new_password);
          $update_password = "UPDATE employees SET password = '$new_password', token_id=NULL,token_startAT=NULL WHERE id='$id'";
          $update_password_run = mysqli_query($con, $update_password);
          if ($update_password_run) {
            $_SESSION['status'] = "Password Successfully Updated";
            send_mail($fname, $email, "changepassword",null,null);
            header("Location:../login");
            exit(0);
          } else {
            $_SESSION['status'] = "Did not update password, something went wrong.";
            header("Location: change-password");
            exit(0);
          }
        }
      }
    }
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

  <script>
    function validateForm() {
      var isValid = true;

      var new_password = document.forms["passForm"]["new_password"].value;
      var confirm_password = document.forms["passForm"]["confirm_password"].value;
      var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

      document.getElementById("passwordError").innerHTML = "";
      document.getElementById("cpasswordError").innerHTML = "";



      if (new_password == "") {
        document.getElementById("passwordError").innerHTML = "Password must be filled out.";
        isValid = false;
      } else if (!new_password.match(passwordPattern)) {
        document.getElementById("passwordError").innerHTML = "Password must be at least 8 characters long and include at least one lowercase letter, one uppercase letter, one numeric digit, and one special character.";
        isValid = false;
      }

      if (confirm_password == "") {
        document.getElementById("cpasswordError").innerHTML = "Please Retype Password.";
        isValid = false;
      } else if (confirm_password != new_password) {
        document.getElementById("cpasswordError").innerHTML = "Password dosen't match.";
        isValid = false;
      }
      return isValid;

    }
  </script>


</head>

<body>
  <div class="login_section">
    <div class="wrapper relative" style="height:300px">
      <div style="display:none" class="meassage_successful_login">You have Successfull Edit </div>
      <div class="heading-top">
        <div class="logo-cebter"><a href="#"><img src="../images/at your service_banner.png"></a></div>
      </div>
      <div class="box" style="height:300px">
        <div class="pswd-div" style="padding:24px;">
          <h2 style="text-align:center;background-color:rgb(239, 239, 239); padding:7px 12px;width:90%;font-size:larger;">Reset Password <span></span></h2>
          <?php if (isset($_SESSION['status'])) : ?>
            <div class="error-message-div error-msg"><?php echo $_SESSION['status'];
                                                      unset($_SESSION['status']); ?></div>
          <?php endif; ?>
          <form name="passForm" class="margin_bottom" onsubmit="return validateForm()" action="" role="form" method="POST">
            <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) {
                                                                echo $_GET['token'];
                                                              } ?>">


            <div class="form-group">
              <label for="new_password">Password</label>
              <input type="password" class="form-control" name="new_password" placeholder="Enter New Password" />
              <span id="passwordError" class="error"><?php echo isset($errors['new_password']) ? $errors['new_password'] : ''; ?></span>
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" />
              <span id="cpasswordError" class="error"><?php echo isset($errors['confirm_password']) ? $errors['confirm_password'] : ''; ?></span>
            </div>
            <button class="submit-btn" type="submit" name="password_update" style="margin-top:10px;">Update Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

</html>