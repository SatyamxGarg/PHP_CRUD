<?php


include 'connect.php';
$login = false;
$showError = false;
session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){
    header("location: dashboard.php");
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
        header("location:dashboard.php");
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
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
 <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
 <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 <![endif]-->
</head>

<body>
    <div class="login_section">
        <div class="wrapper relative">
            <div style="display:none" class="meassage_successful_login">You have Successfull Edit </div>
            <div class="heading-top">
                <div class="logo-cebter"><a href="#"><img src="images/at your service_banner.png"></a></div>
            </div>
            <div class="box">
                <div class="outer_div">

                    <h2>User <span>Login</span></h2>
                    <?php
                    if ($login) {
                        echo '<div class="error-message-div error-msg"><img src="images/sucess-msg.png"><strong>Success!!</strong>Sign-In Successfully</div>';
                    }
                    if ($showError) {
                        echo '<div class="error-message-div error-msg"><img src="images/unsucess-msg.png"><strong>Invalid!</strong> username or password </div>';
                    }
                    ?>

                    <form class="margin_bottom" role="form" method="POST">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" />
                        </div>
                        <button type="submit" name="submit" class="btn_login">Login</button>
                        <p id="signup">Don't have an account?<a href="signup.php"> signup</a></p>
                    </form>
                </div>
            </div>
</body>

</html>