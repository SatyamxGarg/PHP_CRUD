<?php

session_start();
if(!isset($_SESSION['loggedin']) || ($_SESSION['loggedin'])!=TRUE){
  header("location:../login");
  exit;
}
    include '../connect.php';

    $myID=$_SESSION['id'];
    $sq='select role_id from employees where id='.$myID;
    $res=mysqli_query($con,$sq);
    $row1=mysqli_fetch_array($res);
    $id = $_GET["deleteid"];

    if($row1['role_id']!=1 && $row1['role_id']!=5 && $myID!=$id){
        header("location: ../dashboard");
        exit;
      }
    $deletedAT=time();
    if(isset($_GET["deleteid"])){
        $id=$_GET["deleteid"];
        $sql="update employees set isdeleted=1,deletedAt=$deletedAT where id=$id";
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