<?php
include 'connect.php';
session_start();
if(empty($_SESSION['email']) && empty($_SESSION['password'])){
    header('location:signin.php');
}
// print_r($_SESSION);
$email=$_SESSION['email'];
// echo "$email";
// $password=$_SESSION['password'];
$sql="SELECT user_firstname,user_lastname,user_email,user_country_id,
user_state_id,user_city_id,user_street_address,user_phone,user_password,
user_role_id,gender FROM employee_users WHERE user_email='$email'";
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)){
    $user_firstname=$row['user_firstname'];
    // $admin=$row['is_Admin'];
}?>
<?php
// include('connect.php');
$sql="SELECT * FROM `employee_roles` LEFT JOIN `employee_users` ON employee_roles.role_id=employee_users.user_role_id WHERE employee_users.deleted_at is null";
$result=mysqli_query($con,$sql);
$num=mysqli_num_rows($result);
// echo "$num";
$week1= "SELECT * FROM `employee_users` WHERE deleted_at is null AND createdAt between '2024-07-1' AND '2024-07-6'";
$result1=mysqli_query($con,$week1);
$w1=mysqli_num_rows($result1);
// echo "$w1";
$week2= "SELECT * FROM `employee_users` WHERE deleted_at is null AND createdAt between '2024-07-7' AND '2024-07-13'";
$result2=mysqli_query($con,$week2);
$w2=mysqli_num_rows($result2);
// echo "$w2";
$week3= "SELECT * FROM `employee_users` WHERE deleted_at is null AND createdAt between '2024-07-14' AND '2024-07-20'";
$result3=mysqli_query($con,$week3);
$w3=mysqli_num_rows($result3);
// echo "$w3";
$week4= "SELECT * FROM `employee_users` WHERE deleted_at is null AND createdAt between '2024-07-21' AND '2024-07-27'";
$result4=mysqli_query($con,$week4);
$w4=mysqli_num_rows($result4);
// echo "$w4";
$week5= "SELECT * FROM `employee_users` WHERE deleted_at is null AND createdAt between '2024-07-28' AND '2024-07-31'";
$result5=mysqli_query($con,$week5);
$w5=mysqli_num_rows($result5);
$mon=[];
for($i=0;$i<=12;$i++){
    $month= "SELECT * FROM `employee_users` WHERE deleted_at is null AND month(createdAt)=$i";
    $resultMonth=mysqli_query($con,$month);
    $mon[]=mysqli_num_rows($resultMonth);
}
print_r($mon[7]);

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <!-- Bootstrap -->
    <link href="css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="barchart.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>
<div class="header">
    <div class="wrapper">
    <div class="logo"><a href="#"><img src="images/logo.png"></a></div>

    
<div class="right_side">
    <ul><li>Welcome <?php echo $user_firstname;?></li>
    <li><a href="logout.php">Log Out</a></li>
    </ul>
</div>
<div class="nav_top">
    <ul>
    <li class="active"><a href=" dashboard.php ">Dashboard</a></li>
    <?php 
    // if($admin=='yes'){
    //  echo "";
    // }
    ?>
    <li><a href=' list-users.php '>Users</a></li>
    <li><a href=" agentloclist.php ">Setting</a></li>
    <li><a href=" geoloclist.php ">Configuration</a></li></ul>

</div>
</div>
</div>
<div class="clear"></div>
<div class="clear"></div>
<div class="content">
    <div class="wrapper">
    <div class="left_sidebr">
    <ul>
    <li><a href="" class="dashboard">Dashboard</a></li>
    <li><a href="" class="user">Users</a>
    <ul class="submenu">
    <li><a href="">Mange Users</a></li>
    </ul>
    </li>
    <li><a href="" class="Setting">Setting</a>
    <ul class="submenu">
    <li><a href="">Chnage Password</a></li>
    <li><a href="">Mange Contact Request</a></li>
    <li><a href="#">Manage Login Page</a></li>

    </ul>
    
    </li>
    <li><a href="" class="social">Configuration</a>
    <ul class="submenu">
    <li><a href="">Payment Settings</a></li>
    <li><a href="">Manage Email Content</a></li>
     <li><a href="#">Manage Limits</a></li>
    </ul>

    </li>
    </ul>
    </div>
    <div class="right_side_content">
    <h1>Dashboard</h1>
    <!-- <div class="tab"> -->
    <figure class="highcharts-figure">
        <div id="container"></div>
    </figure>
    <!-- <ul><li class="selected"><a href=""><span class="left"><img class="selected-act" src="images/dashboard-hover.png"><img src="images/dashboard.png" class="hidden" /></span><span class="right">Dashboard</span></a></li>
    <li><a href='list-users.php'><span class='left'><img class='selected-act' src='images/user-hover.png'><img class='hidden'  src='images/user.png'/></span><span class='right'>Users</span></a></li>
    <li><a href="myProfile.php"><span class="left"><img class="selected-act" src="images/setting-hover.png"><img class="hidden"  src="images/setting.png"/></span><span class="right">Setting</span></a></li>
    <li><a href=""><span class="left"><img class="selected-act" src="images/configuration-hover.png"><img class="hidden" src="images/configuration.png"/></span><span class="right">Configuration</span></a></li>
    
    </ul> -->
    <!-- </div> -->
    </div>
    <script>
      Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Users Signed in July',
        align: 'left'
    },
    // subtitle: {
    //     text:
    //         'Source: <a target="_blank" ' +
    //         'href="https://www.indexmundi.com/agriculture/?commodity=corn">indexmundi</a>',
    //     align: 'left'
    // },
    xAxis: {
        categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4','Week 5'],
        crosshair: true,
        accessibility: {
            description: 'Countries'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number'
        }
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'Users',
            data:<?php echo "[$w1,$w2, $w3, $w4, $w5]"; ?> 
        }
    ]
});
    </script>
    </div>
</div>
<div class="footer" style="position: fixed; bottom: 0px; ">
<div class="wrapper">
<p>Copyright © 2014 yourwebsite.com. All rights reserved</p>
</div>
  
</div>

</body>
</html>

