<div class="header">
    <div class="wrapper">
        <div class="logo"><img src="../images/logo.png"></div>


        <div class="right_side">
            <ul>
                <li><a href="../myProfile">Welcome <?php echo $_SESSION["fname"]; ?></a></li>
                <li><a href="../logout">Log Out</a></li>
            </ul>
        </div>
        <div class="nav_top">
            <ul>
                <li id="dashboard"><a href=" ../dashboard ">Dashboard</a></li>
                <li id="listUsers"><a href="../list-users">Users</a></li>
             
                <li id="myProfile"><a href="../myProfile">My Profile</a></li>
            </ul>

        </div>
    </div>
</div>
<script> 
     if(window.location.pathname.includes('dashboard')){
    document.getElementById('dashboard').className="active";
    }
    else if(window.location.pathname.includes('list-users')){
    document.getElementById('listUsers').className="active";
    }
    else if(window.location.pathname.includes('myProfile')){
    document.getElementById('myProfile').className="active";
    }
</script>