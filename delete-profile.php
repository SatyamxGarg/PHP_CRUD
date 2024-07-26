
<?php
session_start();

if (!isset($_SESSION['loggedin']) || ($_SESSION['loggedin']) != TRUE) {
    header("location: login.php");
    exit;
}

include 'connect.php';

if (isset($_GET['deleteid'])) {
    $userId = intval($_GET['deleteid']);

    // Fetch the profile image path from the database
    $sql = "SELECT profile_image FROM employees WHERE id = $userId";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = 'upload/' . $row['profile_image'];

        // Delete the image file from the server if it exists
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Update the database to remove the image reference
        $sql = "UPDATE employees SET profile_image = NULL WHERE id = $userId";
        mysqli_query($con, $sql);

        // Redirect to the profile page
        header("Location: myProfile.php");
        exit;
    } else {
        echo "Error: Profile not found.";
    }
} else {
    echo "Error: No user ID specified.";
}
?>
