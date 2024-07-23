<?php

session_start();
if(!isset($_SESSION['loggedin']) || ($_SESSION['loggedin'])!=TRUE){
  header("location: login.php");
  exit;
}
    include 'connect.php';
    $myData= $_SESSION['id']; 
    $sql = "select *from employees where id=$myData";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
  
    $fname = $row['fname'];
    $lname = $row['lname'];
    $age = $row['age'];
    $gender = $row['gender'];
    $email = $row['email'];
    $mobile = $row['mobile'];
    $role=$row['role_id'];
    $sql1= "select *from emp_roles";
    $result1=mysqli_query($con,$sql1);
    while($row1=mysqli_fetch_array( $result1)) {
      if($role==$row1['id']){
        $role_name=$row1['role'];

      }
    
    }
   
    $country = $row['country'];
    $state = $row['state'];
    $city = $row['city'];
    
    ?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="css/dashboard.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php include "header.php";?>
  <div class="clear"></div>
  <div class="clear"></div>
  <div class="content">
    <div class="wrapper">
      <div class="bedcram">
        <ul>
          <li><a href="dashboard.php">Home</a></li>
          <li><a href="list-users.php ">List Users</a></li>
          <li>My Profile</li>
        </ul>
      </div>
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
        <h1>My Profile</h1>
        <div class="list-contet">
        <div class="user-data">
  <div class="profile-pic">
    <img src="images/user.png" alt="img" id="profile-image">
    <form id="image-form">
    <input type="file" name="profile" id="select-file" onchange="imgChange(event)">
    </form>
  
  </div>
  <div class="info-bar">
    <table class="user-info-table">
      <tr>
        <th>First Name:</th>
        <td><?php echo $fname ?></td>
      </tr>
      <tr>
        <th>Last Name:</th>
        <td><?php echo $lname ?></td>
      </tr>
      <tr>
        <th>Age:</th>
        <td><?php echo $age ?></td>
      </tr>
      <tr>
        <th>Gender:</th>
        <td><?php echo $gender ?></td>
      </tr>
      <tr>
        <th>E-Mail:</th>
        <td><?php echo $email ?></td>
      </tr>
      <tr>
        <th>Mobile:</th>
        <td><?php echo $mobile ?></td>
      </tr>
      <tr>
        <th>Role:</th>
        <td><?php echo $role_name ?></td>
      </tr>
      <tr>
        <th>Country:</th>
        <td><?php echo $country ?></td>
      </tr>
      <tr>
        <th>State:</th>
        <td><?php echo $state ?></td>
      </tr>
      <tr>
        <th>City:</th>
        <td><?php echo $city ?></td>
      </tr>
    </table>
  </div>
</div>


<div class="edit-data">
<a href="<?php echo 'update-user.php?u_id='.$myData. ''?> " class='submit-btn add-user'>Update Profile</a>
</div>
        </div>
      </div>

    </div>
</div>
  <div class="footer">
    <div class="wrapper">
      <p>Copyright © 2014 yourwebsite.com. All rights reserved</p>
    </div>

  </div>
  <script>
    function imgChange(event) {
      const image = event.target.files[0];
      const img = document.getElementById("profile-image");
      const imageUrl = URL.createObjectURL(image);
      img.src = imageUrl;
      console.log(imageUrl);
    }
  </script>


</body>

</html>