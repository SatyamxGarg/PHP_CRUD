<?php



session_start();
include 'connect.php';


if (isset($_POST['submit'])) {
  $errors = [];
  if (empty($_POST['email'])) {
    $errors["email"] = "E-Mail is required.";
  } else {
    $email = $_POST['email'];
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
      $new_password = $confrim_password;
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
  <link href="css/dashboard.css" rel="stylesheet">

  <script>
    function validateForm() {
      var isValid = true;
      var email = document.forms["passForm"]["email"].value;

      var new_password = document.forms["passForm"]["new_password"].value;
      var confirm_password = document.forms["passForm"]["confirm_password"].value;
      var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
      var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

      document.getElementById("emailError").innerHTML = "";
      document.getElementById("passwordError").innerHTML = "";
      document.getElementById("cpasswordError").innerHTML = "";

      if (email == "") {
        document.getElementById("emailError").innerHTML = "Email must be filled out.";
        isValid = false;
      } else if (!email.match(emailPattern)) {
        document.getElementById("emailError").innerHTML = "Please enter a valid email address.";
        isValid = false;
      }

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
      } else if (confirmpassword != new_password) {
        document.getElementById("cpasswordError").innerHTML = "Password dosen't match.";
        isValid = false;
      }
      console.log(isValid)
      return false;

    }
  </script>


</head>

<body>
  <div class="login_section">
    <div class="wrapper relative" style="height:300px">
      <div style="display:none" class="meassage_successful_login">You have Successfull Edit </div>
      <div class="heading-top">
        <div class="logo-cebter"><a href="#"><img src="images/at your service_banner.png"></a></div>
      </div>
      <div class="box" style="height:400px">
        <div class="outer_div">
          <h2 style="text-align:center;background-color:rgb(239, 239, 239); padding:7px 12px;width:90%;font-size:larger;">Reset Password <span></span></h2>
          <?php if (isset($_SESSION['status'])) : ?>
            <div class="error-message-div error-msg"><?php echo $_SESSION['status'];
                                                      unset($_SESSION['status']); ?></div>
          <?php endif; ?>
          <form name="passForm" class="margin_bottom" onsubmit="return validateForm()" action="reset-password.php" role="form" method="POST">
            <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) {
                                                                echo $_GET['token'];
                                                              } ?>">

            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" class="form-control" name="email" value="<?php echo isset($email) ? $email : ''; ?>" placeholder="Enter Email Address" />
              <span id="emailError" class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
            </div>
            <div class="form-group">
              <label for="new_password">Password</label>
              <input type="password" class="form-control" name="new_password" placeholder="Enter New Password" />
              <span id="passwordError" class="error"><?php echo isset($errors['new_password']) ? $errors['new_password'] : ''; ?></span>
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" class="form-control" name="confirm_password" placeholder="Update Password" />
              <span id="cpasswordError" class="error"><?php echo isset($errors['confirm_password']) ? $errors['confirm_password'] : ''; ?></span>
            </div>
            <button class="submit-btn" name="password_update">Update Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

</html>