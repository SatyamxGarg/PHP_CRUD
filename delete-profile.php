
<?php
session_start();

if (!isset($_SESSION['loggedin']) || ($_SESSION['loggedin']) != TRUE) {
    header("location:login");
    exit;
}

include 'connect.php';

if (isset($_GET['deleteid'])) {
    $userId = intval($_GET['deleteid']);

  
    $sql = "SELECT profile_image FROM employees WHERE id = $userId";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = 'upload/' . $row['profile_image'];

      
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        
        $sql = "UPDATE employees SET profile_image = NULL WHERE id = $userId";
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
