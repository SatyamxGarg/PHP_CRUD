<div class="header">
    <div class="wrapper">
        <div class="logo"><a href="#"><img src="images/logo.png"></a></div>


        <div class="right_side">
            <ul>
                <li>Welcome <?php echo $_SESSION["fname"]; ?></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
        <div class="nav_top">
            <ul>
                <li><a href=" dashboard.php ">Dashboard</a></li>
                <li><a href="list-users.php">Users</a></li>
                <li><a href=" agentloclist.php ">Setting</a></li>
                <li><a href=" geoloclist.php ">Configuration</a></li>
            </ul>

        </div>
    </div>
</div>