<?php
include '../mailTemplates.php';
session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){
    header("location: ../dashboard");
    exit;
}
    $showerror = false;
    $show_alert = false;
    include '../connect.php';
    $sql1="select * from Country";
    $result1 = mysqli_query($con, $sql1);

// $sql3="select * from city";
// $result3=mysqli_query($conn, $sql3);
   $gender='';
   $country='';
   $state='';
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
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
      } else {
        $sql_check_email = "SELECT * FROM `employees` WHERE email='$email'";
        $result_check_email = $con->query($sql_check_email);
  
        if ($result_check_email->num_rows > 0) {
          $errors['email'] = "Email already exists";
        }
      }
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
      $errors['role'] = 'Role is required.';
    } else {
      $role = $_POST['role'];
    }
  
    if (!empty($_POST['password'])) {
      $password = $_POST['password'];
      $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>.]{8,}$/';
  
      if (!preg_match($pattern, $password)) {
        $errors['password'] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
      }
    } else {
      $errors['password'] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
    }

    if (empty($_POST['cpassword'])) {
        $errors['cpassword'] = 'Please Retype Password Again.';
      } else {
        $cpassword = $_POST['cpassword'];
        if($cpassword!=$password){
            $error['cpassword']='Password not match';
        }
        else{
            $password=md5($password);
        }
      }
  
    if(empty($_POST['country'])){
      $errors['country']='Country name required';
  }
  else{
      $country_id = $_POST['country'];
  $get_country = "select c_name from Country where id=$country_id";
  $result =  mysqli_query($con, $get_country);
  $row= mysqli_fetch_array($result);
  $country = $row['c_name'];
  }
  
  
  if(empty($_POST['state'])){
    $errors['state']='State name required';
  }
  else{
    $state_id = $_POST['state'];
  $get_state = "select state_name from State where id=$state_id";
  $result =  mysqli_query($con, $get_state);
  $row= mysqli_fetch_array($result);
  $state = $row['state_name'];
  }
  
  if(empty($_POST['city'])){
    $errors['city']='City name required';
  }
  else{
    $city_id = $_POST['city'];
  $get_city = "select city_name from City where id=$city_id";
  $result =  mysqli_query($con, $get_city);
  $row= mysqli_fetch_array($result);
  $city = $row['city_name'];
  }
  
    $createdAT = time();

      if(empty($errors)) {
        
         
          $createdAt = time();
          $updatedAt = time();
        //   if($password==$c_password){
            $sql = "insert into `employees` (fname,lname,age,gender,email,mobile,role_id,password,country,state,city,createdAT) values('$fname','$lname','$age','$gender','$email','$mobile','$role','$password','$country','$state','$city','$createdAT')";
   
          if ($con->query($sql) === TRUE) {
            $show_alert = true;
            $get_name=$fname;
            send_mail($get_name, $email, "signup",null,null);
            header('location:../login');
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
    <link rel="stylesheet" href="../login/login.css">
    <!-- Bootstrap -->
    <link href="../css/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css">

    <script>
    function validateForm() {
      var isValid = true;
      var fname = document.forms["signupForm"]["fname"].value;
      var lname = document.forms["signupForm"]["lname"].value;
      var age = document.forms["signupForm"]["age"].value;
      var gender = document.forms["signupForm"]["gender"].value;
      var email = document.forms["signupForm"]["email"].value;
      var mobile = document.forms["signupForm"]["mobile"].value;
      var role = document.forms["signupForm"]["role"].value;
      var country = document.forms["signupForm"]["country"].value;
      var state = document.forms["signupForm"]["state"].value;
      var city = document.forms["signupForm"]["city"].value;
      var password = document.forms["signupForm"]["password"].value;
      var cpassword = document.forms["signupForm"]["cpassword"].value;
      var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
      var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
      var mobilePattern = '/^[0-9]{10}+$/';

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


      if (fname == "") {
        document.getElementById("firstnameError").innerHTML = "First name must be filled out.";
        isValid = false;
      }

      if (lname == "") {
        document.getElementById("lastnameError").innerHTML = "Last name must be filled out.";
        isValid = false;
      }

      if (age == "") {
        document.getElementById("ageError").innerHTML = "Age must be filled out.";
        isValid = false;
      }

      if (gender == "") {
        document.getElementById("genderError").innerHTML = "Gender must be filled out.";
        isValid = false;
      }

      if (email == "") {
        document.getElementById("emailError").innerHTML = "Email must be filled out.";
        isValid = false;
      } else if (!email.match(emailPattern)) {
        document.getElementById("emailError").innerHTML = "Please enter a valid email address.";
        isValid = false;
      }


      if (mobile == "") {
        document.getElementById("mobileError").innerHTML = "Mobile Number must be filled out.";
        isValid = false;
      }
      else if (!mobile.match(mobilePattern)) {
        document.getElementById("mobileError").innerHTML = "Please enter a valid mobile number.";
        isValid = false;
      }


      if (role == "") {
        document.getElementById("roleError").innerHTML = "Role must be filled out.";
        isValid = false;
      }

      if (country == "") {
        document.getElementById("countryError").innerHTML = "Country must be filled out.";
        isValid = false;
      }

      if (state == "") {
                    document.getElementById("stateError").innerHTML = "State must be filled out";
                    isValid = false;
                }

       if (city == "") {
                  document.getElementById("cityError").innerHTML = "City must be filled out";
                    isValid = false;
            }

      if (password == "") {
        document.getElementById("passwordError").innerHTML = "Password must be filled out.";
        isValid = false;
      } else if (!password.match(passwordPattern)) {
        document.getElementById("passwordError").innerHTML = "Password must be at least 8 characters long and include at least one lowercase letter, one uppercase letter, one numeric digit, and one special character.";
        isValid = false;
      }

      if (cpassword == "") {
                  document.getElementById("cpasswordError").innerHTML = "Please Retype Password.";
                    isValid = false;
            }
        else if(!cpassword.match(password)){
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
        <div class="heading-top"><div class="logo-cebter"><a href="#"><img src="../images/at your service_banner.png"></a></div></div>
        <div class="box" style="height: 650px; width: 70%;">
        <div class="outer_div">
        
        <h2>User <span>Signup</span></h2>
        <!-- <div class="error-message-div error-msg"></div> -->
                <form class="margin_bottom" role="form" method="POST" action="" name="signupForm" onsubmit=" return validateForm()">
                <div class="add-msgs" id="error-box">
            <div class="error-message-div error-msg" id="msg" style="display:none"><img src="../images/unsucess-msg.png"><strong>UnSucess!</strong> You
             have not been signed up </div>
            </div>
                    <div class="form-group">
                        <label for="fname">Firstname: <span>*</span></label>
                        <div class="input-field">
                <input type="text" class="search-box" name="fname" placeholder="Enter First Name" style="width:640px" value="<?php echo isset($fname) ? $fname : ''; ?>" />
                <span id="firstnameError" class="error"><?php echo isset($errors['fname']) ? $errors['fname'] : ''; ?></span>
              </div>
                    </div>

                    <div class="form-group">
                        <label for="lname">Lastname: <span>*</span></label>
                        <div class="input-field">
                <input type="text" class="search-box" name="lname" placeholder="Enter Last Name" style="width:640px" value="<?php echo isset($lname) ? $lname : ''; ?>" />
                <span id="lastnameError" class="error"><?php echo isset($errors['lname']) ? $errors['lname'] : ''; ?></span>
              </div>
                    </div>

                    <div class="form-group">
                    <label for="lname">Age: <span>*</span></label>
                    <div class="input-field">
                <input type="text" class="search-box" name="age" placeholder="Enter Age" style="width:640px" value="<?php echo isset($age) ? $age : ''; ?>" />
                <span id="ageError" class="error"><?php echo isset($errors['age']) ? $errors['age'] : ''; ?></span>
              </div>
                    </div>


                    <div class="form-group radio-row">
             <div> <label for="gender">Gender: <span>*</span></label></div>
                   
            <div class="input-field" id="label-gender">
        <label><input type="radio" name="gender" value="Male" <?php if($gender=='Male') { echo 'checked';}?> > <span>Male </span></label><label> <input type="radio" name="gender" value="Female" ?<?php if($gender=='Female') { echo 'checked';}?>> <span>Female</span> </label><br>
        <span id="genderError" class="error"><?php echo isset($errors['gender']) ? $errors['gender'] : ''; ?></span>

 </div>
 </div>

                         <div class="form-group">
                        <label for="email">Email: <span>*</span></label>
                        <div class="input-field">
                <input type="text" class="search-box" name="email" style="width:640px" placeholder="Enter Email" value="<?php echo isset($email) ? $email : ''; ?>" />
                <span id="emailError" class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
              </div>
                    </div>


                    <div class="form-group">
                        <label for="mobile">Mobile: <span>*</span></label>
                        <div class="input-field">
                <input type="text" class="search-box" name="mobile" placeholder="Enter Mobile No." style="width:640px" value="<?php echo isset($mobile) ? $mobile : ''; ?>" />
                <span id="mobileError" class="error"><?php echo isset($errors['mobile']) ? $errors['mobile'] : ''; ?></span>
              </div>
                    </div>

                    <div class="form-group">
                <label for="role">Role: <span>*</span></label>
              
              <div class="input-field">
                <div class="select">
                  <select name="role" class="role-info" id="role" style="width:640px" >
                    <option value="">Select Your Role</option>
                  <?php
                    $sql1= "select *from emp_roles";
                    $result1=mysqli_query($con,$sql1);
                    while($row1=mysqli_fetch_array( $result1)) {
                      if($role==$row1['id']){
                        echo "<option selected value='$row1[id]'>$row1[role]</option>";
                      }
                      echo "<option value='$row1[id]'>$row1[role]</option>";
                    }
                    ?>
                  </select>
                  <span id="roleError" class="error"><?php echo isset($errors['role']) ? $errors['role'] : ''; ?></span>
                </div>
              
              </div>
            </div> 


            <div class="form-group">
                <label for="country">Country: <span>*</span> </label>
        
              <div class="input-field">
                <div class="select">
                  <select name="country" class="country-info" id="countryId" style="width:640px" onchange="cntry_change()" value="<?php echo $country; ?>">
                    <option value="">Select Your Country</option>
                    <?php
                 $sql1 = "select *from Country";
                 $result1 = $con->query($sql1);
                    while ($row1 = mysqli_fetch_array($result1)) {
                      if ($country == $row1['id']) {
                        echo "<option selected value='$row1[id]'>$row1[c_name]</option>";
                      }
                      echo "<option value='$row1[id]'>$row1[c_name]</option>";
                    }
                    ?>
                  </select>
                  <span id="countryError" class="error"><?php echo isset($errors['country']) ? $errors['country'] : ''; ?></span>
                </div>

              </div>
            </div>

            <div class="form-group">
                <label for="state">State: <span>*</span> </label>
              <div class="input-field">
                <div class="select">
                <select disabled name="state" class="countries form-control" id="stateId" style="width:640px" onclick="state_change()">
                                <option value="null">Select State</option>
                               
                            </select>
                  <span id="stateError" class="error"><?php echo isset($errors['state']) ? $errors['state'] : ''; ?></span>
                </div>
              </div>
            </div>

            <div class="form-group">
                <label for="city">City: <span>*</span> </label>
              <div class="input-field">
                <div class="select">
                <select disabled name="city" class="countries form-control" style="width:640px" id="cityId">
                                <option value="null">Select City</option>
                                
                            </select>
                  <span id="cityError" class="error"><?php echo isset($errors['city']) ? $errors['city'] : ''; ?></span>
                </div>
              </div>
            </div>


            <div class="form-group">
                <label for="password">Password: <span>*</span></label>
              <div class="input-field">
                <input type="password" class="search-box" name="password" placeholder="Enter Password" style="width:640px" value="<?php echo isset($password) ? $password : ''; ?>" />
                <span id="passwordError" class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
              </div>
            </div>
                 
                    
                    <div class="form-group">
                        <label for="c_password">Confirm Password: <span>*</span></label>
                        <div class="input-field">
                <input type="password" class="search-box" name="cpassword" style="width:640px" placeholder="Retype Password"  />
                <span id="cpasswordError" class="error"><?php echo isset($errors['cpassword']) ? $errors['cpassword'] : ''; ?></span>
              </div>
                    </div>
                        <button type="submit" name="submit" class="btn_login">sign Up</button>
                </form>
                <div class="si-in">
                <p id="login">Have an Account?<a href="../login"> Login</a></p>
                </div>
         </div>
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