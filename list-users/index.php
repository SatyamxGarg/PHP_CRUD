<?php
session_start();
if(!isset($_SESSION['loggedin']) || ($_SESSION['loggedin'])!=TRUE){
	header("location:../login");
	exit;
}
include '../connect.php';

$id=$_SESSION['user_id']; 
$sq='select user_role_id from em_users where user_id='.$id;
$res=mysqli_query($con,$sq);
$row=mysqli_fetch_array($res);
if($row['user_role_id']!=1 && $row['user_role_id']!=5){
	header("location:../dashboard");
	exit;
}
// 	 Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


$sql_total = "SELECT COUNT(*) as total FROM em_users WHERE user_isDeleted != 1";
$result_total = $con->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_records = $row_total['total'];
$total_pages = ceil($total_records / $limit);

//sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'user_first_name';
$order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'desc' : 'asc';
$new_order = $order === 'asc' ? 'desc' : 'asc';
$valid_columns = ['user_id', 'user_first_name', 'user_last_name', 'user_email', 'user_phone', 'user_role_id'];

if (!in_array($sort, $valid_columns)) {
	$sort_column = 'user_id';
}

// Searching
$search = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
	$search = trim($_GET['search']);

	$sql_total = "SELECT COUNT(*) as total FROM em_users WHERE user_isDeleted != 1 AND (user_first_name LIKE '%$search%' 
        OR user_last_name LIKE '%$search%' 
        OR user_email LIKE '%$search%' 
        OR user_age LIKE '%$search%' 
        OR user_phone LIKE '%$search%' 
        OR user_role_id LIKE '%$search%' ) ";
$result_total = $con->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_records = $row_total['total'];
$total_pages = ceil($total_records / $limit);

}


$sql = "SELECT em_users.user_id, user_first_name,user_last_name,user_email,user_phone,em_roles.role_name from `em_users` left join em_roles on em_users.user_role_id=em_roles.role_id where user_isDeleted!=1 
        AND (user_first_name LIKE '%$search%' 
        OR user_last_name LIKE '%$search%' 
        OR user_email LIKE '%$search%' 
        OR user_age LIKE '%$search%' 
        OR user_phone LIKE '%$search%' 
        OR user_role_id LIKE '%$search%' ) 
        ORDER BY $sort $order 
        LIMIT $limit OFFSET $offset";

//$sql="SELECT em_users.id, user_first_name,user_last_name,email,mobile,em_roles.role from `em_users` left join em_roles on em_users.role_id=em_roles.id where user_isDeleted!=1 ";

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
					<li><a href="../dashboard" class="dashboard">Dashboard</a></li>
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
										<option <?php echo 'user_first_name' == $sort ? 'selected' : ''; ?> value='user_first_name'>First Name</option>
										<option <?php echo 'user_last_name' == $sort ? 'selected' : ''; ?> value='user_last_name'>Last Name</option>
										<option <?php echo 'user_email' == $sort ? 'selected' : ''; ?> value='user_email'>E-mail</option>
										<option <?php echo 'user_phone' == $sort ? 'selected' : ''; ?> value='user_phone'>Mobile</option>
										<option <?php echo 'role_name' == $sort ? 'selected' : ''; ?> value='role_name'>Role</option>

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
								<th width="200px"><a href="<?php echo '../list-users?sort=user_first_name&order=' . $new_order . '&search=' . $search ?> ">First Name <?php if($sort == 'user_first_name'){ if($order=='asc'){ echo "<i class='fa-solid fa-arrow-down'></i> ";} else{ echo "<i class='fa-solid fa-arrow-up'></i>"; }} ?></a></th>
								<th width="220x"><a href="<?php echo '../list-users?sort=user_last_name&order=' . $new_order . '&search=' . $search ?> ">Last Name <?php if($sort == 'user_last_name'){ if($order=='asc'){ echo "<i class='fa-solid fa-arrow-down'></i> ";} else{ echo "<i class='fa-solid fa-arrow-up'></i>"; }} ?></a></th>
								<th width="120px"><a href="<?php echo '../list-users?sort=user_email&order=' . $new_order . '&search=' . $search ?> ">E-Mail <?php if($sort == 'user_email'){ if($order=='asc'){ echo "<i class='fa-solid fa-arrow-down'></i> ";} else{ echo "<i class='fa-solid fa-arrow-up'></i>"; }} ?></a></th>
								<th width="110px"><a href="<?php echo '../list-users?sort=user_phone&order=' . $new_order . '&search=' . $search ?> ">Mobile <?php if($sort == 'user_phone'){ if($order=='asc'){ echo "<i class='fa-solid fa-arrow-down'></i> ";} else{ echo "<i class='fa-solid fa-arrow-up'></i>"; }} ?></a></th>
								<th width="100px"><a href="<?php echo '../list-users?sort=role_name&order=' . $new_order . '&search=' . $search ?> ">Role <?php if($sort == 'role_name'){ if($order=='asc'){ echo "<i class='fa-solid fa-arrow-down'></i> ";} else{ echo "<i class='fa-solid fa-arrow-up'></i>"; }} ?></a></th>
								<th width="98px">Operation</th>
							</tr>
							<?php
								if($total_records>=1){
							while ($row = mysqli_fetch_array($result)) {
								
								echo "
        <tr><td>$i</td>
        <td>" . $row["user_first_name"] . "</td>
        <td>" . $row["user_last_name"] . "</td>
        <td>" . $row["user_email"] . "</td>
        <td>" . $row["user_phone"] . "</td>
        <td>" . $row["role_name"] . "</td>
        <td> 
		 <button><a href='../edit-user?u_id=$row[user_id]'><img src='../images/edit-icon.png'></a></button>
             <button onclick='myFunction($row[user_id])'><img src='../images/cross.png'></button> 
           
        </td>
        </tr>";
								$i++;
							}}
							else{
								echo "<td colspan='7'> No Record Found</td>";
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
						echo "<a href='?page=" . ($page - 1) . "&sort=" . htmlspecialchars($sort) . "&order=" . htmlspecialchars($order) . "&search=" . urlencode($search) . "'>Prev</a>";
					} else {
						echo "<span class='pagination-disabled'>Prev</span>";
					}
					
					
					for ($i = 1; $i <= $total_pages; $i++) {
						if ($i === $page) {
							
							echo "<span class='pagination-current'>$i</span>";
						} else {
							echo "<a href='?page=$i&sort=" . htmlspecialchars($sort) . "&order=" . htmlspecialchars($order) . "&search=" . urlencode($search) . "'>$i</a>";
						}
					}
					
				
					if ($page < $total_pages) {
						echo "<a href='?page=" . ($page + 1) . "&sort=" . htmlspecialchars($sort) . "&order=" . htmlspecialchars($order) . "&search=" . urlencode($search) . "'>Next</a>";
					} else {
						echo "<span class='pagination-disabled'>Next</span>";
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