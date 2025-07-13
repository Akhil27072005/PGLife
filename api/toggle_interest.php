<?php
session_start();

require "../includes/database_connect.php";

if(!isset($_SESSION['user_id'])){
    echo json_encode(array("success"=>false, "is_logged_in"=>false));
    return;
}

$user_id=$_SESSION['user_id'];
$property_id=$_GET['property_id'];

$sql1="SELECT * FROM users_properties WHERE user_id=$user_id AND property_id=$property_id";
$result1=mysqli_query($conn,$sql1);
if(!$result1){
    echo json_encode(array("success"=>false,"message"=>"Something went wrong!"));
    return;
}

if(mysqli_num_rows($result1)>0){
    $sql2="DELETE FROM users_properties WHERE user_id=$user_id AND property_id=$property_id";
    $result2=mysqli_query($conn,$sql2);
    if(!$result2){
        echo json_encode(array("success"=>false,"message"=>"Something went wrong!"));
        return;
    }
    else{
        echo json_encode(array("success"=>true,"is_interested"=>false,"property_id"=>$property_id));
        return;
    }
}
else{
    $sql3="INSERT INTO  users_properties (user_id, property_id) VALUES ('$user_id', '$property_id')";
    $result3=mysqli_query($conn,$sql3);
    if(!$result3){
        echo json_encode(array("success"=>false,"message"=>"Something went wrong!"));
        return;
    }
    else{
        echo json_encode(array("success"=>true,"is_interested"=>true,"property_id"=>$property_id));
        return;
    }
}

?>