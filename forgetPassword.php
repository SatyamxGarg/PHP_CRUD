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
            <div class="box1">
                <div class="outer_div">
                    <h2 style="text-align:left;background-color:rgb(239, 239, 239); padding:7px 12px;width:90%;font-size:larger;">Reset Password <span></span></h2>
                    <?php if (isset($_SESSION['status'])): ?>
                <div class="error-message-div error-msg"><?php echo $_SESSION['status']; unset($_SESSION['status']); ?></div>
            <?php endif; ?>
                    <form class="margin_bottom" action="password-code-reset.php" role="form" method="POST">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Email Address"  />
                        </div>
                        <button style="margin-top:15px; padding:5px;background-color:#007FFF;border:0px;border-radius:2px; color:white;" type="submit" name="password_reset_link">Send Recover mail</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>