<?php

session_start();
if(!isset($_SESSION['loggedin']) || ($_SESSION['loggedin'])!=TRUE){
  header("location:../login");
  exit;
}
    include '../connect.php';

    $myID=$_SESSION['user_id'];
    $sq='select user_role_id from em_users where user_id='.$myID;
    $res=mysqli_query($con,$sq);
    $row1=mysqli_fetch_array($res);
    $id = $_GET["deleteid"];

    if($row1['user_role_id']!=1 && $row1['user_role_id']!=5 && $myID!=$id){
        header("location: ../dashboard");
        exit;
      }
    $user_deletedAt=time();
    if(isset($_GET["deleteid"])){
        $id=$_GET["deleteid"];
        $sql="update em_users set user_isDeleted=1,user_deletedAt=$user_deletedAt where user_id=$id";
        $result=mysqli_query($con,$sql);
        if($result){
            header('location:../list-users');
        }
        else{
            die(mysqli_error($con));
        }
    }
    else{
        header('location:../dashboard');
    }
?>