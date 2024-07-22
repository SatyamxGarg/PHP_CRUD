<?php
    include 'connect.php';
    $deletedAT=time();
    if(isset($_GET["deleteid"])){
        $id=$_GET["deleteid"];
        $sql="update employees set isdeleted=1,deletedAt=$deletedAT where id=$id";
        $result=mysqli_query($con,$sql);
        if($result){
            header('location:list-users.php');
        }
        else{
            die(mysqli_error($con));
        }
    }
?>