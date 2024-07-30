<?php
session_start();
if(!isset($_SESSION['loggedin']) || ($_SESSION['loggedin'])!=TRUE){
	header("location:../login");
	exit;
}
include '../connect.php';

$id=$_SESSION['id']; 
$sq='select role_id from employees where id='.$id;
$res=mysqli_query($con,$sq);
$row=mysqli_fetch_array($res);
if($row['role_id']!=1 && $row['role_id']!=5){
	header("location:../dashboard");
	exit;
}
// 	 Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


$sql_total = "SELECT COUNT(*) as total FROM employees WHERE isdeleted != 1";
$result_total = $con->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_records = $row_total['total'];
$total_pages = ceil($total_records / $limit);

//sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'fname';
$order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'desc' : 'asc';
$new_order = $order === 'asc' ? 'desc' : 'asc';
$valid_columns = ['id', 'fname', 'lname', 'email', 'mobile', 'role'];

if (!in_array($sort, $valid_columns)) {
	$sort_column = 'id';
}

// Searching
$search = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
	$search = trim($_GET['search']);

	$sql_total = "SELECT COUNT(*) as total FROM employees WHERE isdeleted != 1 AND (fname LIKE '%$search%' 
        OR lname LIKE '%$search%' 
        OR email LIKE '%$search%' 
        OR age LIKE '%$search%' 
        OR mobile LIKE '%$search%' 
        OR role_id LIKE '%$search%' ) ";
$result_total = $con->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_records = $row_total['total'];
$total_pages = ceil($total_records / $limit);

}


$sql = "SELECT employees.id, fname,lname,email,mobile,emp_roles.role from `employees` left join emp_roles on employees.role_id=emp_roles.id where isdeleted!=1 
        AND (fname LIKE '%$search%' 
        OR lname LIKE '%$search%' 
        OR email LIKE '%$search%' 
        OR age LIKE '%$search%' 
        OR mobile LIKE '%$search%' 
        OR role_id LIKE '%$search%' ) 
        ORDER BY $sort $order 
        LIMIT $limit OFFSET $offset";

//$sql="SELECT employees.id, fname,lname,email,mobile,emp_roles.role from `employees` left join emp_roles on employees.role_id=emp_roles.id where isdeleted!=1 ";

$result = $con->query($sql);

if (!$result) {
	die(mysqli_error($con));
}
$i = $offset + 1;
?>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin</title>

	<!-- Bootstrap -->
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<link href="../css/dashboard.css" rel="stylesheet">

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
			<h2>Would you like to delete this user?</h2>

			<div class="outer-popdlt">
				<a class="btn-pop" id="dlt">Delete</a>
				<button id="can" onclick="document.getElementById('modal').style.display= 'none';">Cancel</button>
			</div>

		</div>
	</div>
	<?php include "../header.php";?>
	<div class="clear"></div>
	<div class="clear"></div>
	<div class="content">
		<div class="wrapper">
			<div class="bedcram">
				<ul>
					<li><a href="../dashboard">Home</a></li>
					<li><a href="../list-users">List Users</a></li>
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
				<h1>List Users</h1>
				<div class="list-contet">
					<div class="form-left">
						<div class="form">
							<form role="form">

								<label>Sort By : </label>
								<div class="select">
									<select name="sort" onchange="sortSelect()" id="sortInput">">
										<option value="null">Select column</option>
										<option <?php echo 'fname' == $sort ? 'selected' : ''; ?> value='fname'>First Name</option>
										<option <?php echo 'lname' == $sort ? 'selected' : ''; ?> value='lname'>Last Name</option>
										<option <?php echo 'email' == $sort ? 'selected' : ''; ?> value='email'>E-mail</option>
										<option <?php echo 'mobile' == $sort ? 'selected' : ''; ?> value='mobile'>Mobile</option>
										<option <?php echo 'role' == $sort ? 'selected' : ''; ?> value='role'>Role</option>

									</select>
								</div>
								<input type="text" class="search-box search-upper" placeholder="Search.." name="search" value="<?php echo htmlspecialchars($search); ?>" />

								<input type="submit" class="submit-btn" value="Search">
							</form>
							<!--<input type="text" class="search-box search-upper" placeholder="Search.."/>-->
							<!--<input type="submit" class="submit-btn" value="Search">-->
							</form>
						</div>
						<a href="../add-user" class="submit-btn add-user">Add More Users</a>
					</div>
					<table width="100%" cellspacing="0">
						<tbody>
							<tr>
								<th width="10px">Sr No.</th>
								<th width="180px"><a href="<?php echo '../list-users?sort=fname&order=' . $new_order . '&search=' . $search ?> ">First Name <?php if($sort == 'fname'){ if($order=='asc'){ echo "<i class='fa-solid fa-arrow-down'></i> ";} else{ echo "<i class='fa-solid fa-arrow-up'></i>"; }} ?></a></th>
								<th width="195x"><a href="<?php echo '../list-users?sort=lname&order=' . $new_order . '&search=' . $search ?> ">Last Name <?php if($sort == 'lname'){ if($order=='asc'){ echo "<i class='fa-solid fa-arrow-down'></i> ";} else{ echo "<i class='fa-solid fa-arrow-up'></i>"; }} ?></a></th>
								<th width="120px"><a href="<?php echo '../list-users?sort=email&order=' . $new_order . '&search=' . $search ?> ">E-Mail <?php if($sort == 'email'){ if($order=='asc'){ echo "<i class='fa-solid fa-arrow-down'></i> ";} else{ echo "<i class='fa-solid fa-arrow-up'></i>"; }} ?></a></th>
								<th width="110px"><a href="<?php echo '../list-users?sort=mobile&order=' . $new_order . '&search=' . $search ?> ">Mobile <?php if($sort == 'mobile'){ if($order=='asc'){ echo "<i class='fa-solid fa-arrow-down'></i> ";} else{ echo "<i class='fa-solid fa-arrow-up'></i>"; }} ?></a></th>
								<th width="100px"><a href="<?php echo '../list-users?sort=role&order=' . $new_order . '&search=' . $search ?> ">Role <?php if($sort == 'role'){ if($order=='asc'){ echo "<i class='fa-solid fa-arrow-down'></i> ";} else{ echo "<i class='fa-solid fa-arrow-up'></i>"; }} ?></a></th>
								<th width="98px">Operation</th>
							</tr>
							<?php

							while ($row = mysqli_fetch_array($result)) {
								
								echo "
        <tr><td>$i</td>
        <td>" . $row["fname"] . "</td>
        <td>" . $row["lname"] . "</td>
        <td>" . $row["email"] . "</td>
        <td>" . $row["mobile"] . "</td>
        <td>" . $row["role"] . "</td>
        <td> 
		 <button><a href='../edit-user?u_id=$row[id]'><img src='../images/edit-icon.png'></a></button>
             <button onclick='myFunction($row[id])'><img src='../images/cross.png'></button> 
           
        </td>
        </tr>";
								$i++;
							}
							?>
						</tbody>
					</table>
					<!--	<div class="paginaton-div">
				<ul>
					<li><a href="#">Prev</a></li>
					<li><a href="#" class="active">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">Next</a></li>
					

				</ul>
			</div>-->

					<?php
					echo "<div class='pagination-div'>";
					if ($page > 1) {
						echo "<a href='?page=" . ($page - 1) . "&sort=" . htmlspecialchars($sort) . "&order=" . htmlspecialchars($order) . "&search=" . urlencode($search) . "'> Prev</a>";
					} else {
						echo "<span style='pointer-events: none' class='a-dis'> Prev</span>";
					}
					for ($i = 1; $i <= $total_pages; $i++) {
						echo "<a href='?page=$i&sort=" . htmlspecialchars($sort) . "&order=" . htmlspecialchars($order) . "&search=" . urlencode($search) . "' class='" . ($i === $page ? 'active' : '') . "'>$i</a>";
					}

					if ($page < $total_pages) {
						echo "<a href='?page=" . ($page + 1) . "&sort=" . htmlspecialchars($sort) . "&order=" . htmlspecialchars($order) . "&search=" . urlencode($search) . "'>Next</a>";
					} else {
						echo "<span style='pointer-events: none;color=white' class='a-dis'>Next</span>";
					}

					echo "</div>";
					?>


				</div>
			</div></div></div>
			</div>
			<div class="footer">
				<div class="wrapper">
					<p>Copyright © 2014 yourwebsite.com. All rights reserved</p>
				</div>

			</div>
			<script>
				function sortSelect() {
					const value = document.getElementById(' sortInput').value
					window.location.href = "http://localhost/Employee_management/../list-users?sort=" + value
				}

				function myFunction(id) {
					document.getElementById('modal').style.display = 'flex';
					document.getElementById('dlt').href = "../delete?deleteid=" + id;
				}
			</script>
</body>

</html>