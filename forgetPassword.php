<?php
include 'connect.php';
session_start();
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
                    <button class="submit-btn" type="submit" name="reset_pzassword">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>