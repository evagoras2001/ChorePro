<?php
session_start();
include("database.php");
$db = new Database();
$email=$_SESSION['id'];
$email_check_query = $db->prepare("SELECT * FROM users WHERE email =:email");
$email_check_query->bindValue(':email', $email, SQLITE3_TEXT);
$email_check_query = $email_check_query->execute()->fetchArray();
$user=$email_check_query['token'];
if(file_exists('profile/'.$user.'.jpg')){
  $image='profile/'.$user.'.jpg';
  $deleted = unlink($image);
}
else if(file_exists('profile/'.$user.".png")){
$image='profile/'.$user.".png";  
$deleted = unlink($image);
}
else if (file_exists('profile/'.$user.".jpeg")){
$image='profile/'.$user.".jpeg";
$deleted = unlink($image);
}
?>
