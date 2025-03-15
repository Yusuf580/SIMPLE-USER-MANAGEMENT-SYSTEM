<?php
session_start();
#script to handle deleting user details 
$email=$_SESSION['email'];
$servername = "localhost";
$username = "root";
$password = "";
$database = "user_management";
echo "$email";

$conn = new mysqli($servername,$username,$password,$database);


// Query to fetch profile picture name to be deleted
$query = "SELECT profile_pic FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $email);  
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();  
$image=$user['profile_pic'];

$imagepath="uploads/".$image;



$sql="DELETE FROM users WHERE email=?";
$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$email);

if($stmt->execute()){
global $imagepath;
unlink("$imagepath");   //deletes image from server

//release resources
    session_destroy();
    $stmt->close();
    $conn->close();
   header("location:login.html");
}
else{
    echo "Error deleting account!";
}



?>