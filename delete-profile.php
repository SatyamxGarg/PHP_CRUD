
<?php
session_start();

if (!isset($_SESSION['loggedin']) || ($_SESSION['loggedin']) != TRUE) {
    header("location:login");
    exit;
}

include 'connect.php';

if (isset($_GET['deleteid'])) {
    $userId = intval($_GET['deleteid']);

  
    $sql = "SELECT user_image FROM em_users WHERE user_id = $userId";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = 'upload/' . $row['user_image'];

      
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        
        $sql = "UPDATE em_users SET user_image = NULL WHERE user_id = $userId";
        mysqli_query($con, $sql);

       
        header("Location:myProfile");
        exit;
    } else {
        echo "Error: Profile not found.";
    }
} else {
    echo "Error: No user ID specified.";
}
?>
