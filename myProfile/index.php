<?php

session_start();
if (!isset($_SESSION['loggedin']) || ($_SESSION['loggedin']) != TRUE) {
  header("location:../login");
  exit;
}
include '../connect.php';
$myData = $_SESSION['user_id'];
$sql = "select *from em_users where user_id=$myData";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

$user_first_name = $row['user_first_name'];
$user_last_name = $row['user_last_name'];
$user_age = $row['user_age'];
$user_gender = $row['user_gender'];
$user_email = $row['user_email'];
$user_phone = $row['user_phone'];
$user_role_id = $row['user_role_id'];
$sql1 = "select *from em_roles";
$result1 = mysqli_query($con, $sql1);
while ($row1 = mysqli_fetch_array($result1)) {
  if ($user_role_id == $row1['role_id']) {
    $user_role_id_name = $row1['role_name'];
  }
}

$user_country = $row['user_country'];
$user_state = $row['user_state'];
$user_city = $row['user_city'];

?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	
  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="../css/dashboard.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="pop-outer" id="modal">
		<div class="box-dlt">
			<h2>Would you like to delete image?</h2>

			<div class="outer-popdlt">
				<a class="btn-pop" id="dlt">Delete</a>
				<button id="can" onclick="document.getElementById('modal').style.display= 'none';">Cancel</button>
			</div>

		</div>
	</div>
  <?php include "../header.php"; ?>
  <div class="clear"></div>
  <div class="clear"></div>
  <div class="content">
    <div class="wrapper">
      <div class="bedcram">
        <ul>
          <li><a href="../dashboard">Home</a></li>
          <!-- <li><a href="../list-users">List Users</a></li> -->
          <li>My Profile</li>
        </ul>
      </div>
      <div class="left_sidebr">
        <ul>
          <li><a href="../dashboard" class="dashboard">Dashboard</a></li>
          <li><a href="../list-users" class="user">Users</a>
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
              <!-- <img src="images/user.png" alt="img" id="profile-image"> -->
              <img src="<?php echo isset($row['user_image']) ? '../upload/' . $row['user_image'] : '../images/user_icon.jpeg'; ?>" alt="img" id="profile-image">

              <form id="image-form" action="../upload_image.php" method="post" enctype="multipart/form-data">
                <div class=edit-btn>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24" class="icon-xl-heavy">
                    <path d="M15.673 3.913a3.121 3.121 0 1 1 4.414 4.414l-5.937 5.937a5 5 0 0 1-2.828 1.415l-2.18.31a1 1 0 0 1-1.132-1.13l.311-2.18A5 5 0 0 1 9.736 9.85zm3 1.414a1.12 1.12 0 0 0-1.586 0l-5.937 5.937a3 3 0 0 0-.849 1.697l-.123.86.86-.122a3 3 0 0 0 1.698-.849l5.937-5.937a1.12 1.12 0 0 0 0-1.586M11 4A1 1 0 0 1 10 5c-.998 0-1.702.008-2.253.06-.54.052-.862.141-1.109.267a3 3 0 0 0-1.311 1.311c-.134.263-.226.611-.276 1.216C5.001 8.471 5 9.264 5 10.4v3.2c0 1.137 0 1.929.051 2.546.05.605.142.953.276 1.216a3 3 0 0 0 1.311 1.311c.263.134.611.226 1.216.276.617.05 1.41.051 2.546.051h3.2c1.137 0 1.929 0 2.546-.051.605-.05.953-.142 1.216-.276a3 3 0 0 0 1.311-1.311c.126-.247.215-.569.266-1.108.053-.552.06-1.256.06-2.255a1 1 0 1 1 2 .002c0 .978-.006 1.78-.069 2.442-.064.673-.192 1.27-.475 1.827a5 5 0 0 1-2.185 2.185c-.592.302-1.232.428-1.961.487C15.6 21 14.727 21 13.643 21h-3.286c-1.084 0-1.958 0-2.666-.058-.728-.06-1.369-.185-1.96-.487a5 5 0 0 1-2.186-2.185c-.302-.592-.428-1.233-.487-1.961C3 15.6 3 14.727 3 13.643v-3.286c0-1.084 0-1.958.058-2.666.06-.729.185-1.369.487-1.961A5 5 0 0 1 5.73 3.545c.556-.284 1.154-.411 1.827-.475C8.22 3.007 9.021 3 10 3A1 1 0 0 1 11 4"></path>
                  </svg>
                  <input type="file" name="profile" id="select-file" onchange="imgChange(event)" >
                </div>
                <!-- <button type="submit" name="upload" class='submit-btn'>Upload Image</button> -->
              </form>
              <?php
             echo " <button onclick='myFunction($row[user_id])'><i id='profile-dlt'class='fa-solid fa-trash'></i></button> "?>
           
            </div>
            <div class="info-bar">
              <table class="user-info-table">
                <tr>
                  <th>First Name:</th>
                  <td><?php echo $user_first_name ?></td>
                </tr>
                <tr>
                  <th>Last Name:</th>
                  <td><?php echo $user_last_name ?></td>
                </tr>
                <tr>
                  <th>Age:</th>
                  <td><?php echo $user_age ?></td>
                </tr>
                <tr>
                  <th>Gender:</th>
                  <td><?php echo $user_gender ?></td>
                </tr>
                <tr>
                  <th>E-Mail:</th>
                  <td><?php echo $user_email ?></td>
                </tr>
                <tr>
                  <th>Mobile:</th>
                  <td><?php echo $user_phone ?></td>
                </tr>
                <tr>
                  <th>Role:</th>
                  <td><?php echo $user_role_id_name ?></td>
                </tr>
                <tr>
                  <th>Country:</th>
                  <td><?php echo $user_country; ?></td>
                </tr>
                <tr>
                  <th>State:</th>
                  <td><?php echo $user_state ?></td>
                </tr>
                <tr>
                  <th>City:</th>
                  <td><?php echo $user_city ?></td>
                </tr>
              </table>
            </div>
          </div>


          <div class="edit-data">
            <a href="<?php echo '../edit-user?u_id=' . $myData . '' ?> " class='submit-btn add-user'>Update Profile</a>
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
      document.getElementById("image-form").submit()

    }

    function myFunction(id) {
					document.getElementById('modal').style.display = 'flex';
					document.getElementById('dlt').href = "../delete-profile.php?deleteid=" + id;
				}
  </script>
</body>

</html>