<?php
require("../includes/database_connect.php");

$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$hashed_password = sha1($password);
$college_name = $_POST['college_name'];
$gender = $_POST['gender'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	$response = array("success"=>false , "message" => "Something went wrong");
	echo json_encode($response);
	exit;
}

$row_count = mysqli_num_rows($result);
if ($row_count != 0) {
	$response = array("success"=>false, "message" => "This email is already resgistered");
	echo json_encode($response);
	exit;
}

$sql = "INSERT INTO users (email, password, full_name, phone_number, gender, college_name) VALUES ('$email', '$hashed_password', '$full_name', '$phone', '$gender', '$college_name')";
$result = mysqli_query($conn, $sql);
if (!$result) {
	$response = array("success"=>false , "message" => "Something went wrong");
	echo json_encode($response);
	exit;
}

$response = array("success"=>true , "message" => "Your account has been created successfully");
echo json_encode($response);
mysqli_close($conn);

?>