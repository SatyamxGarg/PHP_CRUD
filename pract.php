<!-- <?php

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
?> -->
  
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
    $country = $row['country'];
    $state = $row['state'];
    $city = $row['city'];
    $confirmation=$row['confirm'];
   
    
    
    if (isset($_POST['submit'])) {
        $errors = [];
        if (empty($_POST['fname'])) {
            $errors["fname"] = "First name is required.";
        } else {
            $fname = $_POST['fname'];
        }
    
        if (empty($_POST['lname'])) {
            $errors['lname'] = 'Last name is required.';
        } else {
            $lname = $_POST['lname'];
        }
    
        if (empty($_POST['age'])) {
            $errors['age'] = 'Age is required';
        } else {
            $age = $_POST['age'];
        }
        if (empty($_POST['gender'])) {
          $errors['gender'] = 'Gender is required';
      } else {
          $gender = $_POST['gender'];
      }
        if (empty($_POST['email'])) {
            $errors['email'] = 'Email is required';
        } else {
            $email = $_POST['email'];
            
        }
        if (!empty($_POST['mobile'])) {
            $mobile = $_POST['mobile'];
            $pattern = '/^[0-9]{10}+$/';
            if (!preg_match($pattern, $mobile)) {
                $errors['mobile'] = "Mobile Number must be 10 digits long and contains number from [0 to 9].";
            } else {
                $mobile = $_POST['mobile'];
            }
        }

        if (empty($_POST['role'])) {
            $errors['role'] = 'Role is required';
        } else {
            $role = $_POST['role'];
        }
    
        if (empty($_POST['country'])) {
            $errors['country'] = 'Country name required';
        } else {
            $country = $_POST['country'];
            
        }

        if (empty($_POST['state'])) {
          $errors['state'] = 'State name required';
      } else {
          $country = $_POST['state'];
          
      }
  
      if (empty($_POST['city'])) {
        $errors['city'] = 'City name required';
    } else {
        $country = $_POST['city'];
       
    }
   
    
        if(!empty($_POST['password'])) {
            $password = $_POST['password'];
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>.]{8,}$/';
            
            if (!preg_match($pattern, $password)) {
                $errors['password'] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
            } 
        }
        else{
            $errors['password'] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        }

        if (empty($_POST['cpassword'])) {
          $errors['cpassword'] = 'Please Retype Password.';
        } else {
          $cpassword = $_POST['cpassword'];
          if($cpassword!=$password){
              $errors['cpassword']='Password not match';
          }
          else{
              $password=md5($password);
          }
        }
        if (!empty($_POST['confirmation'])) {
          $confirmation = 1;
        }
        else{
          $confirmation = 0;
        }
          $updatedAT = time();
        if (empty($errors)) {
            $sql = "update `employees` set fname='$fname',lname='$lname',age='$age',gender='$gender',email='$email',mobile='$mobile',country='$country',role_id='$role',state='$state',city='$city',password='$password',updatedAt='$updatedAT',confirm='$confirmation' where id=$id";
            $result = mysqli_query($con, $sql);
            if ($result) {
                header('location:list-users.php');
            } else {
                die(mysqli_error($con));
            }
        }
    }
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
         

          <form class="form-edit" method="POST">
            <?php
              if(!empty($errors)){
                echo '<div class="add-msgs" id="error-box">
          <div class="error-message-div error-msg" id="msg"><img src="images/unsucess-msg.png"><strong>UnSucess!</strong> Your
           Data hasn not been Updated </div>
          </div>';
              }
            ?>
          <div class="add-msgs" id="error-box">
            <div class="error-message-div error-msg" id="msg" style="display:none"><img src="images/unsucess-msg.png"><strong>UnSucess!</strong> Your
             Data hasn't been Send </div>
            </div>
        
          <div class="form-row">
              <div class="form-label">
                <label>First Name : <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="fname" placeholder="Enter First Name" autocomplete="off" value="<?php echo $fname ?>">
                <span id="firstnameError" class="error"><?php echo isset($errors['fname']) ? $errors['fname'] : ''; ?></span>
              </div>
            </div>
          <div class="form-row">
              <div class="form-label">
                <label>Last Name : <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="lname" placeholder="Enter Last Name" autocomplete="off" value="<?php echo $lname ?>"/>
                <span id="lastnameError" class="error"><?php echo isset($errors['lname']) ? $errors['lname'] : ''; ?></span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-label">
                <label>Age: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="age" placeholder="Enter Age" value="<?php echo $age ?>"/>
                <span id="ageError" class="error"><?php echo isset($errors['age']) ? $errors['age'] : ''; ?></span>
              </div>
            </div>

            <div class="form-row radio-row set-radio">
             <div class="form-label">
               <label>Gender: <span>*</span> </label>
          </div>
            <div class="input-field">
        <label><input type="radio" name="gender" <?php if($gender=="Male") echo "checked='checked'";?> value="Male" > <span>Male </span></label><label> <input type="radio" name="gender" <?php if($gender=="Female") echo "checked='checked'";?> value="Female"> <span>Female</span> </label><br>
        <span id="genderError" class="error"><?php echo isset($errors['gender']) ? $errors['gender'] : ''; ?></span>

 </div>
 </div>


            <div class="form-row">
              <div class="form-label">
                <label>Email: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="email" placeholder="Enter Email" value="<?php echo $email ?>"/>
                <span id="emailError" class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
              </div>
            </div>
           
            <div class="form-row">
              <div class="form-label">
                <label>Mobile: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="mobile" placeholder="Enter Mobile No." value="<?php echo $mobile ?>"/>
                <span id="mobileError" class="error"><?php echo isset($errors['mobile']) ? $errors['mobile'] : ''; ?></span>
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>Role: <span>*</span></label>
              </div>
              <div class="input-field">
                <div class="select">
                  <select name="role" class="role-info" id="role" value="<?php echo $role; ?>">
                    <option value="">Select Your Role</option>
                    <?php
                    $sql1= "select *from emp_roles";
                    $result1=mysqli_query($con,$sql1);
                    while($row1=mysqli_fetch_array( $result1)) {
                      if($role==$row1['id']){
                        echo "<option selected value='$row1[id]'>$row1[role]</option>";
                      }
                      else{
                        echo "<option value='$row1[id]'>$row1[role]</option>";
                      }
                    }
                    ?>
                  </select>
                  <span id="roleError" class="error"><?php echo isset($errors['role']) ? $errors['role'] : ''; ?></span>
                </div>
              
              </div>
            </div>
            
           
            <div class="form-row">
              <div class="form-label">
                <label>Country: <span>*</span> </label>
              </div>
              <div class="input-field">
                <div class="select">
                  <select name="country" class="country-info" id="countryId" value="<?php echo $country; ?>" onchange="cntry_change()">
                    <option value="">Select Your Country</option>
                    <?php
                 $sql1 = "select *from Country";
                 $result1 = $con->query($sql1);
                    while ($row1 = mysqli_fetch_array($result1)) {
                      if ($country == $row1['id']) {
                        echo "<option selected value='$row1[id]'>$row1[c_name]</option>";
                      }
                      else{
                        echo "<option value='$row1[id]'>$row1[c_name]</option>";
                      }
                    }
                    ?>
                  </select>
                  <span id="countryError" class="error"><?php echo isset($errors['country']) ? $errors['country'] : ''; ?></span>
                </div>

              </div>
            </div>


            <div class="form-row">
              <div class="form-label">
                <label>State: <span>*</span> </label>
              </div>
              <div class="input-field">
                <div class="select">
                <select disabled name="state" class="countries form-control" id="stateId" onclick="state_change()">
                                <option value="null">Select State</option>
                               
                            </select>
                  <span id="stateError" class="error"><?php echo isset($errors['state']) ? $errors['state'] : ''; ?></span>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-label">
                <label>City: <span>*</span> </label>
              </div>
              <div class="input-field">
                <div class="select">
                <select disabled name="city" class="countries form-control" id="cityId">
                                <option value="null">Select City</option>
                                
                            </select>
                  <span id="cityError" class="error"><?php echo isset($errors['city']) ? $errors['city'] : ''; ?></span>
                </div>
              </div>
            </div>
            
            
            
            <div class="form-row">
              <p style="border-bottom: 1px dashed black; margin-bottom: 10px;"></p>
              <div class="form-label">
                <label>Password: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="password" class="search-box" name="password" placeholder="Enter Password" />
                <span id="passwordError" class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-label">
                <label>Confirm Password: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="password" class="search-box" name="cpassword" placeholder="Retype Password" value="<?php echo isset($cpassword) ? $cpassword : ''; ?>" />
                <span id="cpasswordError" class="error"><?php echo isset($errors['cpassword']) ? $errors['cpassword'] : ''; ?></span>
              </div>
            </div>
            <div class="news-letter">
              <input type="checkbox" <?php  if($confirmation==1) echo"checked='checked'";?>  id="confirmation" name="confirmation" style="margin-left: 223px;"><span style="color: red;"> </span>
              <label for="confirmation" style="color:#5d5252;;">
                <span><small>Want to receive the E-mail! </small></span>
              </label>
            </div>

            <div class="form-row">
              <div class="form-label">
                <label><span></span> </label>
              </div>
              <div class="input-field">
                <button type="submit" class="submit-btn" name="submit">Submit</button>
              </div>
            </div>
          </form>
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
        function cntry_change() {
            const countryId = document.getElementById('countryId').value;
            document.getElementById('stateId').removeAttribute("disabled");
            console.log(countryId);

            const requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    countryId: countryId
                }),
                redirect: 'follow'
            };

            fetch("getData.php/", requestOptions)
                .then(response => {
                    
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        throw new Error('Response is not JSON');
                    }
                })
                .then(result => {
                    const countrySelect = document.getElementById('stateId');
                    countrySelect.innerHTML = '';
                    let option = document.createElement('option');
                    option.textContent = "Select State";
                    option.value = "null";
                    countrySelect.appendChild(option);
                    option = null
                    result.forEach(element => {
                        let option = document.createElement('option');
                        option.textContent = element.state_name;
                        option.value = element.id;
                        countrySelect.appendChild(option);
                        option = null
                    });
                    countrySelect.removeAttribute('disabled')

                }

                )
                .catch(error => console.log('error', error));
        }

        function state_change() {
            const stateId = document.getElementById('stateId').value;
            document.getElementById('cityId').removeAttribute("disabled");
            const requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    stateId: stateId
                }),
                redirect: 'follow'
            };

            fetch("getData2.php/", requestOptions)
                .then(response => {
                    
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        throw new Error('Response is not JSON');
                    }
                })
                .then(result => {
                    const stateSelect = document.getElementById('cityId');
                    stateSelect.innerHTML = '';
                    let option = document.createElement('option');
                    option.textContent = "Select City";
                    option.value = "null";
                    stateSelect.appendChild(option);
                    option = null
                    result.forEach(element => {
                        let option = document.createElement('option');
                        option.textContent = element.city_name;
                        option.value = element.id;
                        stateSelect.appendChild(option);
                        option = null
                    });
                    stateSelect.removeAttribute('disabled')

                }

                )
                .catch(error => console.log('error', error));
        }

        </script>

</body>

</html>



<?php


$new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    $token = mysqli_real_escape_string($con, $_POST['password_token']);
    if (!empty($token)) {
        if (!empty($email) && !empty($new_password) && !empty($token)) {
            // checking token is valid or not
            $check_token = "SELECT verify_token FROM employees WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($con, $check_token);
            if (mysqli_num_rows($check_token_run) > 0) {
                if ($new_password == $confirm_password) {
                    $new_password = md5($new_password);
                    $update_password = "UPDATE employees SET password = '$new_password' WHERE verify_token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($con, $update_password);
                    if ($update_password_run) {
                        $_SESSION['status'] = "Password Successfully Updated";
                        header("Location: login.php");
                        exit(0);
                    } else {
                        $_SESSION['status'] = "Did not update password, something went wrong.";
                        header("Location: change-password.php");
                        exit(0);
                    }
                } else {
                    $_SESSION['status'] = "Password Does not match";
                    header("Location: change-password.php");
                    exit(0);
                }
            }
        } else {
            $_SESSION['status'] = "All fields are mendatory";
            header("Location: change-password.php?token=$token&email=$email");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "No token available";
        header("Location: forgetPassword.php");
        exit(0);
  
  }






  if (empty($_POST['email'])) {
    $errors['email'] = 'Email is required';
} else {
    $email = $_POST['email'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $errors['email'] = 'Invalid E-Mail Format';
    }
    else{
      $sql_check_email = "SELECT * FROM `employees` WHERE email='$email'";
$result_check_email = $con->query($sql_check_email);
if($result_check_email->num_rows>=1){
while($row=mysqli_fetch_array($result_check_email)){
  $uid=$row["id"];
  if($uid!=$id){
    $errors["email"] = "Emailm already exists";
  }
}
    }
}

}
  ?>




