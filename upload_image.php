<?php
session_start();
if (!isset($_SESSION['loggedin']) || ($_SESSION['loggedin']) != TRUE) {
  header("location:../login");
  exit;
}

include 'connect.php';
$userId = $_SESSION['user_id'];

$sql='select user_image from em_users where user_id='.$userId;
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);
if($row['user_image']!=NULL){
  $imagePath = 'upload/' . $row['user_image'];

      
  if (file_exists($imagePath)) {
      unlink($imagePath);
  }
}

// Check if a file was uploaded
if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
  $fileTmpPath = $_FILES['profile']['tmp_name'];
  $fileName = $_FILES['profile']['name'];
  $fileSize = $_FILES['profile']['size'];
  $fileType = $_FILES['profile']['type'];
  $fileNameCmps = explode('.', $fileName);
  $fileExtension = strtolower(end($fileNameCmps));

  // Define allowed file extensions and upload directory
  $allowedExts = array('jpg', 'jpeg', 'png', 'gif');
  $uploadDir = 'upload/';   // $uploadDir = 'upload/'.$userId;(String)

  if (in_array($fileExtension, $allowedExts)) {
    $newFileName = uniqid() . '.' . $fileExtension;
    $dest_path = $uploadDir . $newFileName;

    // Move the file to the upload directory
    if (move_uploaded_file($fileTmpPath, $dest_path)) {
      // Update the database with the new file name
      $sql = "UPDATE em_users SET user_image = ? WHERE user_id = ?";
      $stmt = $con->prepare($sql);
      $stmt->bind_param('si', $newFileName, $userId);
      $stmt->execute();

      if ($stmt->affected_rows > 0) {
     header("Location:myProfile");
      } else {
        echo "Database update failed.";
      }
      $stmt->close();
    } else {
      echo "Failed to move uploaded file.";
    }
  } else {
    echo "Invalid file extension.";
  }
} else {
    header("Location:myProfile");
}

$con->close();
?>
