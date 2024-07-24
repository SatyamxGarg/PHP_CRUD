<?php
    include 'connect.php';
    $deletedAT=time();
    if(isset($_GET["deleteid"])){
        $id=$_GET["deleteid"];
        $sql="update employees set profile_image= NULL where id=$id";
        $result=mysqli_query($con,$sql);
        if($result){
            header('location:myProfile.php');
        }
        else{
            die(mysqli_error($con));
        }
    }
?>