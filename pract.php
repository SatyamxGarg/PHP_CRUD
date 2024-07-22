<?php

    $showerror = false;
    $show_alert = false;
    include 'connect.php';
    $sql1="select * from Country";
    $result1 = mysqli_query($con, $sql1);

// $sql3="select * from city";
// $result3=mysqli_query($conn, $sql3);

if(isset($_POST['submit'])){
      $errors = [];
      if(empty($_POST['fname'])) {
        $errors['fname'] = "*Firstname is required.";
      } else {
        $fname = $_POST['fname'];
      }
      if(empty($_POST['lname'])) {
        $errors['lname'] = "*Lastname is required.";
      } else {
          $lname = $_POST['lname'];
      }
      if(empty($_POST['country'])) {
        $errors['country'] = "*Country name is required";
      } else {
        $country = $_POST['country'];
        //   $country_id= $_POST['country'];
        //   $get_country = "select country_name from country where id=".$country_id;
        //   $result =  mysqli_query($con, $get_country);
        //   $row= mysqli_fetch_array($result);
        //   //$country = $row['country_name'];
      }
      // if(empty($_POST['state'])) {
      //   $errors['state'] = "State is required";
      // } else {
      //   $state_id = $_POST['state'];
      //   $get_state = "select s_name from state where s_id=$state_id";
      //   $result =  mysqli_query($conn, $get_state);
      //   $row= mysqli_fetch_array($result);
      //   $state = $row['s_name'];
      // }
      // if(empty($_POST['city'])) {
      //   $errors['city'] = "City name is required";
      // } else {
      //     $city_id = $_POST['city'];
      //     $get_city = "select city_name from city where city_id=$city_id";
      //     $result =  mysqli_query($conn, $get_city);
      //     $row= mysqli_fetch_array($result);
      //     $city = $row['city_name'];
      // }
      if(empty($_POST['email'])) {
        $errors['email'] = "*Email is required";
      } else {
          $email = $_POST['email'];
          if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $errors['email'] = "*Invalid email format";
          } else {
              $sql_check_email = "SELECT * FROM `employees` WHERE email='$email'";
              $result_check_email = $con->query($sql_check_email);
              if ($result_check_email->num_rows > 0) {
                  $errors['email'] = "*Email already exists";
              }
          }
      }
      if(empty($_POST['mobile'])) {
        $errors['mobile'] = "*Mobile number is required";
      } else {
          $mobile = $_POST['mobile'];
      }
      if(empty($_POST['password'])) {
          $errors['password']="*Password is required";
      } else{   
          $password = $_POST['password'];
          $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>.]{8,}$/';
          
          if (!preg_match($pattern, $password)) {
              $errors['password'] = "*Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character";
          } else {
              $password = md5($password);
              $c_password = $_POST["c_password"];
              
          }
      }
    //   if(empty($_POST['role'])) {
    //     $errors['role'] = "*Role_id is required";
    //   } else {
    //       $role = $_POST['role'];
    //   }
      if(empty($errors)) {
        
          $country = $_POST['country'];
          // $state = $_POST['state'];
          // $city = $_POST['city'];
          $mobile = $_POST['mobile'];
          $createdAt = time();
          $updatedAt = time();
        //   if($password==$c_password){
          $sql = "INSERT INTO `employees` (fname, lname,  country, email, mobile, password, createdAt,updatedAt) 
                  VALUES ('$fname', '$lname', '$country',  '$email', '$mobile', '$password', '$createdAt','$updatedAt')";
          if ($con->query($sql) === TRUE) {
            $show_alert = true;
            header('location: dashboard.php');
            exit(); 
            } else {
                $showerror = true; 
                echo "Error: " . $sql . "<br>" . $con->error;
            }
          }
         else {
          echo " ";
      }
    }
?>
  
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup</title>
    <link rel="stylesheet" href="login.css">
    <!-- Bootstrap -->
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
  </head>
<body>

<?php
    if($show_alert){
        echo '
          <div class="s_success" style="background-color:rgba(85, 143, 85, 0.438); width:700px;padding:8px;margin:5px;">
            <strong>Success! </strong>Your account is now created and you can login.
            </div>
        ';
    }
    if($showerror===TRUE){
        echo '
          <div class="s_error"style="background-color:rgba(133, 56, 56, 0.438); width:700px;padding:8px;margin:5px;">
            <strong>Error!</strong> Password do not match
            </div>
        ';
    }


?>




<div class="login_section">
    <div class="wrapper relative"><div style="display:none" class="meassage_successful_login">You have Successfull Edit </div>
        <div class="heading-top"><div class="logo-cebter"><a href="#"><img src="images/at your service_banner.png"></a></div></div>
        <div class="box" style="height: 850px";>
        <div class="outer_div">
        
        <h2>User <span>Signup</span></h2>
        <!-- <div class="error-message-div error-msg"></div> -->
                <form class="margin_bottom" role="form" method="POST" action="">
                    <div class="form-group">
                        <label for="fname">Firstname</label>
                        <input type="text" class="form-control" name="fname"/>
                        <span class="error"><?php echo isset($errors['fname']) ? $errors['fname'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="lname">Lastname</label>
                        <input type="text" class="form-control" name="lname"/>
                        <span class="error" ><?php echo isset($errors['lname']) ? $errors['lname'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label><br>
                        <!-- <input type="text" class="form-control" name="country"/> -->
                        <select name="country" id="countryId">
                        <option value="">Select Country</option>
                        <?php
                            while($row1=mysqli_fetch_array($result1)){
                                echo "<option value='$row1[id]'>$row1[c_name]</option>";
                            }
                            ?>
                        </select>
                        <span class="error"><?php echo isset($errors['country']) ? $errors['country'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email"/>
                        <span class="error" ><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input type="text" class="form-control" name="mobile"/>
                        <span class="error" ><?php echo isset($errors['mobile']) ? $errors['mobile'] : ''; ?></span> 
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password"/>
                        <span class="error" ><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
                    </div>
                    <!-- <div class="form-group">
                        <label for="role">Role</label>
                        <input type="number" class="form-control" name="role"/>
                        <span class="error" ># echo isset($errors['role']) ? $errors['role'] : ''; ?></span>
                    </div> -->
                    <div class="form-group">
                        <label for="c_password">Confirm Password</label>
                        <input type="password" class="form-control" name="c_password"/>
                    </div>
                        <button type="submit" name="submit" class="btn_login">sign Up</button>
                </form>
                <div class="si-in">
                    <span>Have an Account?  </span> <button class="btn_login"><a style="color: white;padding:4px;" href="login.php">SignIn</a> </button>
                </div>
         </div>
        </div>
</div>
</body>
</html>