<?php


include '../connect.php';
$login = false;
$showError = false;
session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){
    header("location: ../dashboard");
    exit;
}


if (isset($_POST['submit'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hash_password = md5($password);
    $sql = "SELECT * from employees where email='$email' AND password='$hash_password'";

    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    $row5=mysqli_fetch_array($result);
    if ($num >= 1) {
        $login = "true";
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['fname'] = $row5['fname'];
        $_SESSION['id'] = $row5['id'];
        header("location:../dashboard");
    } else {
        $showError = "Invalid credentials";
    }
}
?>


<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link rel="stylesheet" href="login.css">
    <!-- Bootstrap -->
    <link href="../css/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
 <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
 <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 <![endif]-->

 <script>
    function validateForm() {
      var isValid = true;
      var email = document.forms["loginForm"]["email"].value;
      var password = document.forms["loginForm"]["password"].value;
      var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

      document.getElementById("emailError").innerHTML = "";
      document.getElementById("passwordError").innerHTML = "";


      if (email == "") {
        document.getElementById("emailError").innerHTML = "Email must be filled out.";
        isValid = false;
      } else if (!email.match(emailPattern)) {
        document.getElementById("emailError").innerHTML = "Please enter a valid email address.";
        isValid = false;
      }

      if (password == "") {
        document.getElementById("passwordError").innerHTML = "Password must be filled out.";
        isValid = false;
      }

      return isValid;

    }
</script>
</head>

<body>
    <div class="login_section">
        <div class="wrapper relative">
            <div style="display:none" class="meassage_successful_login">You have Successfull Edit </div>
            <div class="heading-top">
                <div class="logo-cebter"><a href="#"><img src="../images/at your service_banner.png"></a></div>
            </div>
            <?php if (isset($_SESSION['status'])) : ?>
            <div class="error-message-div error-msg" style="margin-bottom:10px;"><?php echo $_SESSION['status'];
                                                      unset($_SESSION['status']); ?></div>
          <?php endif; ?>
            <div class="box">
                <div class="outer_div" style="overflow-y:unset">

                    <h2>User <span>Login</span></h2>
                    
                    <?php
                    if ($login) {
                        echo '<div class="error-message-div error-msg"><img src="../images/sucess-msg.png"><strong>Success!!</strong>Sign-In Successfully</div>';
                    }
                    if ($showError) {
                        echo '<div class="error-message-div error-msg"><img src="../images/unsucess-msg.png"><strong>Invalid!</strong> username or password </div>';
                    }
                    ?>
                    <form name="loginForm" class="margin_bottom" role="form" method="POST" onsubmit=" return validateForm()">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" />
                            <span id="emailError" class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" />
                            <span id="passwordError" class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
                        </div>
                        <button type="submit" name="submit" class="btn_login">Login</button>
                        <a href="../forgetPassword.php" style="float:right">Forget Password?</a>
                        <p id="signup">Don't have an account?<a href="../signup"> signup</a></p>
                    </form>
                </div>
            </div>
</body>

</html>