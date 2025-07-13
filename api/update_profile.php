<?php
session_start();

require "../includes/database_connect.php";

if(!isset($_SESSION['user_id'])){
    echo json_encode(array("success"=>false, "is_logged_in"=>false));
    return;
}

$user_id = $_SESSION['user_id'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$college_name = $_POST['college_name'];

$sql1="UPDATE users SET full_name='$full_name', email='$email', phone_number=$phone_number, college_name='$college_name' WHERE user_id=$user_id";
$result1=mysqli_query($conn,$sql1);

if(!$result1){
    echo json_encode(array("success"=>false,"message"=>"Something went wrong!"));
    return;
}
else{
    header("Location:../dashboard.php");
}