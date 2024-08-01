<?php

session_start();
if (!isset($_SESSION['loggedin']) || ($_SESSION['loggedin']) != TRUE) {
  header("location:../login");
  exit;
}
include '../connect.php';

$myID = $_SESSION['user_id'];
$sq = 'select user_role_id from em_users where user_id=' . $myID;
$res = mysqli_query($con, $sq);
$row1 = mysqli_fetch_array($res);




$id = $_GET["u_id"];
$sql = "select *from em_users where user_id=$id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);


if ($row1['user_role_id'] != 1 && $row1['user_role_id'] != 5 && $myID != $row['user_id']) {
  header("location: ../dashboard");
  exit;
}

$user_first_name = $row['user_first_name'];
$user_last_name = $row['user_last_name'];
$user_age = $row['user_age'];
$user_gender = $row['user_gender'];
$user_email = $row['user_email'];
$user_phone = $row['user_phone'];
$user_role_id = $row['user_role_id'];

$user_country = $row['user_country'];


$user_state = $row['user_state'];

// echo $user_state;
$sql2 = 'select * from em_states  ';
$result2 = mysqli_query($con, $sql2);

$user_city = $row['user_city'];
$sql3 = 'select * from em_cities';
$result3 = mysqli_query($con, $sql3);
echo $user_country;
echo $user_state;
echo $user_city;

$confirmation = $row['user_confirm'];



if (isset($_POST['submit'])) {
  $errors = [];
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

  if (empty($_POST['age'])) {
    $errors['age'] = 'Age is required';
  } else {
    $user_age = $_POST['age'];
  }
  if (empty($_POST['gender'])) {
    $errors['gender'] = 'Gender is required';
  } else {
    $user_gender = $_POST['gender'];
  }
  if (empty($_POST['email'])) {
    $errors['email'] = 'Email is required';
  } else {
    $new_email = $_POST['email'];

    if ($new_email != $user_email) {
      if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid E-Mail Format';
      } else {
        $sql_check_email = "SELECT * FROM `em_users` WHERE email='$new_email'";
        $result_check_email = $con->query($sql_check_email);

        if ($result_check_email->num_rows > 0) {
          $errors['email'] = "Email already exists";
        }
      }
    }
  }
  if (!empty($_POST['mobile'])) {
    $user_phone = $_POST['mobile'];
    $pattern = '/^[0-9]{10}+$/';
    if (!preg_match($pattern, $user_phone)) {
      $errors['mobile'] = "Mobile Number must be 10 digits long and contains number from [0 to 9].";
    } else {
      $user_phone = $_POST['mobile'];
    }
  }

  if (empty($_POST['role'])) {
    $errors['role'] = 'Role is required';
  } else {
    $user_role_id = $_POST['role'];
  }

  if (empty($_POST['country'])) {
    $errors['country'] = 'Country name required';
  } else {
    $user_country = $_POST['country'];
  }

  if (empty($_POST['state'])) {
    $errors['state'] = 'State name required';
  } else {
    $user_state = $_POST['state'];

    $q1 = "select state_name from em_states where state_id=$user_state";
    $r = mysqli_query($con, $q1);
    $r = mysqli_fetch_array($r);
    $user_state = $r['state_name'];
  }

  if (empty($_POST['city'])) {
    $errors['city'] = 'City name required';
  } else {
    $user_city = $_POST['city'];

    $q1 = "select city_name from em_cities where city_id=$user_city";
    $r = mysqli_query($con, $q1);
    $r = mysqli_fetch_array($r);
    $user_city = $r['city_name'];
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
    $errors['cpassword'] = 'Please Retype Password.';
  } else {
    $cpassword = $_POST['cpassword'];
    if ($cpassword != $password) {
      $errors['cpassword'] = 'Password not match';
    } else {
      $password = md5($password);
    }
  }
  if (!empty($_POST['confirmation'])) {
    $confirmation = 1;
  } else {
    $confirmation = 0;
  }
  $user_updatedAt = time();
  if (empty($errors)) {
    $sql = "update `em_users` set user_first_name='$user_first_name',user_last_name='$user_last_name',user_age='$user_age',user_gender='$user_gender',user_email='$new_email',user_phone='$user_phone',user_country='$user_country',user_role_id='$user_role_id',user_state='$user_state',user_city='$user_city',user_password='$password',user_updatedAt='$user_updatedAt',user_confirm='$confirmation' where user_id=$id";
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
</head>

<body>
  <?php include "../header.php"; ?>
  <div class="clear"></div>
  <div class="clear"></div>
  <div class="content">
    <div class="wrapper">
      <div class="bedcram">
        <ul>
          <li><a href="../dashboard">Home</a></li>
          <!-- <li><a href="../list-users ">List Users</a></li> -->
          <li>Update User</li>
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
        <h1>Update User</h1>
        <div class="list-contet">


          <form novalidate class="form-edit" method="POST">
            <?php
            if (!empty($errors)) {
              echo '<div class="add-msgs" id="error-box">
          <div class="error-message-div error-msg" id="msg"><img src="../images/unsucess-msg.png"><strong>UnSucess!</strong> Your
           Data hasn not been Updated </div>
          </div>';
            }
            ?>
            <div class="add-msgs" id="error-box">
              <div class="error-message-div error-msg" id="msg" style="display:none"><img src="../images/unsucess-msg.png"><strong>UnSucess!</strong> Your
                Data hasn't been Send </div>
            </div>

            <div class="form-row">
              <div class="form-label">
                <label>First Name : <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="user_first_name" placeholder="Enter First Name" autocomplete="off" value="<?php echo $user_first_name ?>">
                <span id="firstnameError" class="error"><?php echo isset($errors['user_first_name']) ? $errors['fuser_first_name'] : ''; ?></span>
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>Last Name : <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="user_last_name" placeholder="Enter Last Name" autocomplete="off" value="<?php echo $user_last_name ?>" />
                <span id="lastnameError" class="error"><?php echo isset($errors['user_last_name']) ? $errors['user_last_name'] : ''; ?></span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-label">
                <label>Age: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="age" placeholder="Enter Age" value="<?php echo $user_age ?>" />
                <span id="ageError" class="error"><?php echo isset($errors['age']) ? $errors['age'] : ''; ?></span>
              </div>
            </div>

            <div class="form-row radio-row set-radio">
              <div class="form-label">
                <label>Gender: <span>*</span> </label>
              </div>
              <div class="input-field">
                <label><input type="radio" name="gender" <?php if ($user_gender == "Male") echo "checked='checked'"; ?> value="Male"> <span>Male </span></label><label> <input type="radio" name="gender" <?php if ($user_gender == "Female") echo "checked='checked'"; ?> value="Female"> <span>Female</span> </label><br>
                <span id="genderError" class="error"><?php echo isset($errors['gender']) ? $errors['gender'] : ''; ?></span>

              </div>
            </div>


            <div class="form-row">
              <div class="form-label">
                <label>Email: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="email" placeholder="Enter Email" value="<?php echo $user_email ?>" />
                <span id="emailError" class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-label">
                <label>Mobile: <span>*</span></label>
              </div>
              <div class="input-field">
                <input type="text" class="search-box" name="mobile" placeholder="Enter Mobile No." value="<?php echo $user_phone ?>" />
                <span id="mobileError" class="error"><?php echo isset($errors['mobile']) ? $errors['mobile'] : ''; ?></span>
              </div>
            </div>
            <div class="form-row">
              <div class="form-label">
                <label>Role: <span>*</span></label>
              </div>
              <div class="input-field">
                <div class="select">
                  <select name="role" class="role-info" id="role" value="<?php echo $user_role_id; ?>">
                    <option value="">Select Your Role</option>
                    <?php
                    $sql1 = "select *from em_roles";
                    $result1 = mysqli_query($con, $sql1);
                    while ($row1 = mysqli_fetch_array($result1)) {
                      if ($user_role_id == $row1['role_id']) {
                        echo "<option selected value='$row1[role_id]'>$row1[role_name]</option>";
                      } else {
                        echo "<option value='$row1[role_id]'>$row1[role_name]</option>";
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
                  <select name="country" class="country-info" id="countryId" onchange="cntry_change()" value="<?php echo $user_country; ?>">
                    <option value="">Select Your Country</option>
                    <?php
                    $sql1 = 'select * from em_countries';
                    $result1 = mysqli_query($con, $sql1);
                    while ($row11 = mysqli_fetch_array($result1)) {

                      if ($user_country == $row11['country_name']) {
                        echo "<option selected value='$row11[country_name]'>$row11[country_name]</option>";
                      } else {
                        echo "<option value='$row11[country_name]'>$row11[country_name]</option>";
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
                  <select disabled name="state" class="countries form-control" id="stateId" onchange="state_change()" value="<?php echo $user_state; ?>">
                    <option value="null">Select State</option>

                    <?php


                    while ($row12 = mysqli_fetch_array($result2)) {

                      if ($user_state == $row12['state_name']) {
                        echo "<option selected value='$row12[state_name]'>$row12[state_name]</option>";
                      } else {
                        echo "<option value='$row12[state_name]'>$row12[state_name]</option>";
                      }
                    }
                    ?>

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
                  <select disabled name="city" class="countries form-control" id="cityId" value="<?php echo $user_city; ?>">
                    <option value="">Select City</option>
                    <?php

                    while ($row13  = mysqli_fetch_array($result3)) {
                      if ($user_city == $row13['city_name']) {
                        echo "<option selected value='$row13[city_name]'>$row13[city_name]</option>";
                      } else {
                        echo "<option value='$row13[city_name]'>$row13[city_name]</option>";
                      }
                    }
                    ?>
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
                <input type="password" class="search-box" name="cpassword" placeholder="Retype Password" />
                <span id="cpasswordError" class="error"><?php echo isset($errors['cpassword']) ? $errors['cpassword'] : ''; ?></span>
              </div>
            </div>
            <div class="news-letter">
              <input type="checkbox" <?php if ($confirmation == 1) echo "checked='checked'"; ?> id="confirmation" name="confirmation" style="margin-left: 223px;"><span style="color: red;"> </span>
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

      fetch("../fetchData.php/", requestOptions)
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
      console.log("wjkq lksjl");
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