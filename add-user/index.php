<?php
session_start();
if(!isset($_SESSION['loggedin']) || ($_SESSION['loggedin'])!=TRUE){
  header("location: ../login");
  exit;
}

include '../connect.php';
$id=$_SESSION['user_id']; 
$sq='select user_role_id from em_users where user_id='.$id;
$res=mysqli_query($con,$sq);
$row=mysqli_fetch_array($res);
if($row['user_role_id']!=1 && $row['user_role_id']!=5){
	header("location: ../dashboard");
	exit;
}


$sql3 = "select *from em_cities";
$result3 = $con->query($sql3);

$user_gender='';
if (isset($_POST['submit'])) {
  $errors = [];
  // echo ' <div class="error-message-div error-msg" id="msg"><img src="../images/unsucess-msg.png"><strong>UnSucess!</strong> Your
  //           Message hasn not been Send </div>';

  if (empty($_POST['user_first_name'])) {
    $errors["user_first_name"] = "First name is required.";
  } else {
    $user_first_name = $_POST['user_first_name'];
  }

  if (empty($_POST['user_last_name'])) {
    $errors['user_last_name'] = 'Last name is required.';
  } else {
    $user_last_name = $_POST['user_last_name'];
  }

  if (empty($_POST['user_age'])) {
    $errors['user_age'] = 'Age is required';
  } else {
    $user_age = $_POST['user_age'];
  }
  if (empty($_POST['user_gender'])) {
    $errors['user_gender'] = 'Gender is required';
  } else {
    $user_gender = $_POST['user_gender'];
  }

  if (empty($_POST['user_email'])) {
    $errors['user_email'] = 'Email is required';
  } else {
    $user_email = $_POST['user_email'];
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
      $errors['user_email'] = "Invalid email format";
    } else {
      $sql_check_email = "SELECT * FROM `em_users` WHERE user_email='$user_email'";
      $result_check_email = $con->query($sql_check_email);

      if ($result_check_email->num_rows > 0) {
        $errors['user_email'] = "Email already exists";
      }
    }
  }
  if (!empty($_POST['user_phone'])) {
    $user_phone = $_POST['user_phone'];
    $pattern = '/^[0-9]{10}+$/';
    if (!preg_match($pattern, $user_phone)) {
      $errors['user_phone'] = "Mobile Number must be 10 digits long and contains number from [0 to 9].";
    } else {
      $user_phone = $_POST['user_phone'];
    }
  }else{
    $errors['user_phone']="Mobile Number must be filled out";
  }
  if (empty($_POST['user_role_id'])) {
    $errors['user_role_id'] = 'Role is required.';
  } else {
    $user_role_id = $_POST['user_role_id'];
  }

  if (!empty($_POST['user_password'])) {
    $user_password = $_POST['user_password'];
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>.]{8,}$/';

    if (!preg_match($pattern, $user_password)) {
      $errors['user_password'] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
    } 
  } else {
    $errors['user_password'] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
  }

  if (empty($_POST['cpassword'])) {
    $errors['cpassword'] = 'Please Retype Password Again.';
  } else {
    $cpassword = $_POST['cpassword'];
    if($cpassword!=$user_password){
        $error['cpassword']='Password not match';
    }
    else{
        $password=md5($user_password);
    }
  }

  if(empty($_POST['user_country'])){
    $errors['user_country']='Country name required';
}
else{
    $country_id = $_POST['user_country'];
$get_country = "select country_name from em_countries where country_id=$country_id";
$result =  mysqli_query($con, $get_country);
$row= mysqli_fetch_array($result);
$user_country = $row['country_name'];
}


if(empty($_POST['user_state'])){
  $errors['user_state']='State name required';
}
else{
  $state_id = $_POST['user_state'];
$get_state = "select state_name from em_states where state_id=$state_id";
$result =  mysqli_query($con, $get_state);
$row= mysqli_fetch_array($result);
if(mysqli_num_rows($result)> 0){
$user_state = $row['state_name'];}
else{
  $errors['user_state']='State name required';
}
}

if(empty($_POST['user_city'])){
  $errors['user_city']='City name required';
}
else{
  $city_id = $_POST['user_city'];
$get_city = "select city_name from em_cities where city_id=$city_id";
$result =  mysqli_query($con, $get_city);
$row= mysqli_fetch_array($result);
if(mysqli_num_rows($result)> 0){
  $user_city = $row['city_name'];}
  else{
    $errors['user_city']='City name required';
  }

}


if (!empty($_POST['confirmation'])) {
  $confirmation = 1;
}
else{
  $confirmation = 0;
}
  $user_createdAt = time();

  //  echo var_dump($errors);
  if (empty($errors)) {
   // $country = $_POST['country'];
    $sql = "insert into `em_users` (user_first_name,user_last_name,user_age,user_gender,user_email,user_phone,user_role_id,user_password,user_country,user_state,user_city,user_createdAt,user_confirm) values('$user_first_name ','$user_last_name ','$user_age','$user_gender','$user_email','$user_phone','$user_role_id','$user_password','$user_country','$user_state','$user_city','$user_createdAt','$confirmation')";
    $result = mysqli_query($con, $sql);

    if ($result) {
      header('location:../list-users');
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
  <link rel="stylesheet" type="text/css" href="../css/dashboard.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <script>
    function validateForm() {
      var isValid = true;
      var user_first_name  = document.forms["signupForm"]["user_first_name "].value;
      var user_last_name  = document.forms["signupForm"]["user_lastt_name "].value;
      var user_age = document.forms["signupForm"]["user_age"].value;
      var user_gender = document.forms["signupForm"]["user_gender"].value;
      var user_email = document.forms["signupForm"]["user_email"].value;
      var user_phone = document.forms["signupForm"]["user_phone"].value;
      var user_role_id = document.forms["signupForm"]["user_role_id"].value;
      var user_country = document.forms["signupForm"]["user_country"].value;
      var user_state = document.forms["signupForm"]["user_state"].value;
      var user_city = document.forms["signupForm"]["user_city"].value;
      var user_password = document.forms["signupForm"]["user_password"].value;
      var cpassword = document.forms["signupForm"]["cpassword"].value;
      var user_emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
      var user_passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

      document.getElementById("firstnameError").innerHTML = "";
      document.getElementById("lastnameError").innerHTML = "";
      document.getElementById("ageError").innerHTML = "";
      document.getElementById("genderError").innerHTML = "";
      document.getElementById("emailError").innerHTML = "";
      document.getElementById("mobileError").innerHTML = "";
      document.getElementById("roleError").innerHTML = "";
      document.getElementById("countryError").innerHTML = "";
      document.getElementById("stateError").innerHTML = "";
      document.getElementById("cityError").innerHTML = "";
      document.getElementById("passwordError").innerHTML = "";
      document.getElementById("cpasswordError").innerHTML = "";


      if (user_first_name== "") {
        document.getElementById("firstnameError").innerHTML = "First name must be filled out.";
        isValid = false;
      }

      if (user_last_name== "") {
        document.getElementById("lastnameError").innerHTML = "Last name must be filled out.";
        isValid = false;
      }

      if (user_age == "") {
        document.getElementById("ageError").innerHTML = "Age must be filled out.";
        isValid = false;
      }

      if (user_gender == "") {
        document.getElementById("genderError").innerHTML = "Gender must be filled out.";
        isValid = false;
      }

      if (user_email == "") {
        document.getElementById("emailError").innerHTML = "Email must be filled out.";
        isValid = false;
      } else if (!user_email.match(user_emailPattern)) {
        document.getElementById("emailError").innerHTML = "Please enter a valid email address.";
        isValid = false;
      }


      if (user_phone == "") {
        document.getElementById("mobileError").innerHTML = "Mobile Number must be filled out.";
        isValid = false;
      }

      if (user_role_id == "") {
        document.getElementById("roleError").innerHTML = "Role must be filled out.";
        isValid = false;
      }

      if (user_country == "") {
        document.getElementById("countryError").innerHTML = "Country must be filled out.";
        isValid = false;
      }

      if (user_state == "") {
                    document.getElementById("stateError").innerHTML = "State must be filled out";
                    isValid = false;
                }

       if (user_city == "") {
                  document.getElementById("cityError").innerHTML = "City must be filled out";
                    isValid = false;
            }

      if (user_password == "") {
        document.getElementById("passwordError").innerHTML = "Password must be filled out.";
        isValid = false;
      } else if (!user_password.match(user_passwordPattern)) {
        document.getElementById("passwordError").innerHTML = "Password must be at least 8 characters long and include at least one lowercase letter, one uppercase letter, one numeric digit, and one special character.";
        isValid = false;
      }

      if (cpassword == "") {
                  document.getElementById("cpasswordError").innerHTML = "Please Retype Password.";
                    isValid = false;
            }
        else if(!cpassword.match(user_password)){
            document.getElementById("cpasswordError").innerHTML = "Password dosen't match.";
            isValid = false;
        }
      if (!isValid) {
       
       // document.getElementById('error-box').innerHTML = "<strong>UnSucess!</strong> Your Message hasn't been Send";
       document.getElementById('msg').style.display='block';
        
      }

      return isValid;
    }
  </script>


</head>

<body>
  <?php include "../header.php";?>
  <div class="clear"></div>
  <div class="clear"></div>
  <div class="content">
    <div class="wrapper">
      <div class="bedcram">
        <ul>
          <li><a href="../dashboard ">Home</a></li>
          <li><a href="../list-users">List Users</a></li>
          <li>Add User</li>
        </ul>
      </div>
      <div class="left_sidebr">
        <ul>
          <li><a href="../dashboard" class="dashboard">Dashboard</a></li>
          <li><a href="" class="user">Users</a>
            <ul class="submenu">
              <li><a href="">Manage Users</a></li>

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
        <h1>Add User</h1>
        <div class="list-contet">

          <form novalidate name="signupForm" method="POST" onsubmit=" return validateForm()" class="form-edit">

            <div class="add-msgs" id="error-box">
            <div class="error-message-div error-msg" id="msg" style="display:none"><img src="../images/unsucess-msg.png"><strong>UnSucess!</strong> New
             user has not been added. </div>
            </div>

            <div class="form-row">
              <div class="form-label">
                <label>First Name : <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="user_first_name" placeholder="Enter First Name" value="<?php echo isset($user_first_name) ? $user_first_name : ''; ?>" />
                <span id="firstnameError" class="error"><?php echo isset($errors['user_first_name']) ? $errors['user_first_name'] : ''; ?></span>
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>Last Name : <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="user_last_name" placeholder="Enter Last Name" value="<?php echo isset($user_last_name) ? $user_last_name : ''; ?>" />
                <span id="lastnameError" class="error"><?php echo isset($errors['user_last_name']) ? $errors['user_last_name'] : ''; ?></span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-label">
                <label>Age: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="user_age" placeholder="Enter Age" value="<?php echo isset($user_age) ? $user_age : ''; ?>" />
                <span id="ageError" class="error"><?php echo isset($errors['user_age']) ? $errors['user_age'] : ''; ?></span>
              </div>
            </div>

            <div class="form-row radio-row set-radio">
             <div class="form-label">
               <label>Gender: <span>*</span> </label>
          </div>
            <div class="input-field">
        <label><input type="radio" name="user_gender" value="Male" <?php if($user_gender=='Male') { echo 'checked';}?>> <span>Male </span></label><label> <input type="radio" name="user_gender" value="Female" <?php if($user_gender=='Female') { echo 'checked';}?>> <span>Female</span> </label><br>
        <span id="genderError" class="error"><?php echo isset($errors['user_gender']) ? $errors['user_gender'] : ''; ?></span>

 </div>
 </div>


            <div class="form-row">
              <div class="form-label">
                <label>Email: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="user_email" placeholder="Enter Email" value="<?php echo isset($user_email) ? $user_email : ''; ?>" />
                <span id="emailError" class="error"><?php echo isset($errors['user_email']) ? $errors['user_email'] : ''; ?></span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-label">
                <label>Mobile: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="user_phone" placeholder="Enter Mobile No." value="<?php echo isset($user_phone) ? $user_phone : ''; ?>" />
                <span id="mobileError" class="error"><?php echo isset($errors['user_phone']) ? $errors['user_phone'] : ''; ?></span>
              </div>
            </div>
           <div class="form-row">
              <div class="form-label">
                <label>Role: <span>*</span></label>
              </div>
              <div class="input-field">
                <div class="select">
                  <select name="user_role_id" class="role-info" id="role">
                    <option value="">Select Your Role</option>
                  <?php
                    $sql1= "select *from em_roles";
                    $result1=mysqli_query($con,$sql1);
                    while($row1=mysqli_fetch_array( $result1)) {
                      if($user_role_id==$row1['role_id']){
                        echo "<option selected value='$row1[role_id]'>$row1[role_name]</option>";
                      }
                      else{
                        if($row1['role_id']==2){
                          echo "<option selected value='$row1[role_id]'>$row1[role_name]</option>";
                        }
                        else{
                        echo "<option value='$row1[role_id]'>$row1[role_name]</option>";
                      }
                      } }
                    ?>
                  </select>
                  <span id="roleError" class="error"><?php echo isset($errors['user_role_id']) ? $errors['user_role_id'] : ''; ?></span>
                </div>
              
              </div>
            </div> 

        
         <div class="form-row">
              <div class="form-label">
                <label>Country: <span>*</span> </label>
              </div>
              <div class="input-field">
                <div class="select">
                  <select name="user_country" class="country-info" id="countryId" onchange="cntry_change()">
                    <option value="">Select Your Country</option>
                    <?php
                 $sql1 = "select *from em_countries";
                 $result1 = $con->query($sql1);
                    while ($row1 = mysqli_fetch_array($result1)) {
                      if ($user_country == $row1['country_id']) {
                        echo "<option selected value='$row1[country_id]'>$row1[country_name]</option>";
                      }
                      echo "<option value='$row1[country_id]'>$row1[country_name]</option>";
                    }
                    ?>
                  </select>
                  <span id="countryError" class="error"><?php echo isset($errors['user_country']) ? $errors['user_country'] : ''; ?></span>
                </div>

              </div>
            </div>

            <div class="form-row">
              <div class="form-label">
                <label>State: <span>*</span> </label>
              </div>
              <div class="input-field">
                <div class="select">
                <select disabled name="user_state" class="countries form-control" id="stateId" onclick="state_change()">
                                <option value="null">Select State</option>
                               
                            </select>
                  <span id="stateError" class="error"><?php echo isset($errors['user_state']) ? $errors['user_state'] : ''; ?></span>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-label">
                <label>City: <span>*</span> </label>
              </div>
              <div class="input-field">
                <div class="select">
                <select disabled name="user_city" class="countries form-control" id="cityId">
                                <option value="null">Select City</option>
                                
                            </select>
                  <span id="cityError" class="error"><?php echo isset($errors['user_city']) ? $errors['user_city'] : ''; ?></span>
                </div>
              </div>
            </div>

            <div class="form-row">
            <p style="border-bottom: 1px dashed black; margin-bottom: 10px;"></p>
              <div class="form-label">
                <label>Password: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="password" class="search-box" name="user_password" placeholder="Enter Password" value="<?php echo isset($user_password) ? $user_password : ''; ?>" />
                <span id="passwordError" class="error"><?php echo isset($errors['user_password']) ? $errors['user_password'] : ''; ?></span>
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
              <input type="checkbox" id="confirmation" name="confirmation" style="margin-left: 223px;"><span style="color: red;"> </span>
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

            fetch("../getData.php/", requestOptions)
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

            fetch("../getData2.php/", requestOptions)
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