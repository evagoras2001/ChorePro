<?php
session_start();
include("database.php");
$db = new Database();
$house_check_query = $db->prepare("SELECT * FROM users WHERE email =:id");
$house_check_query->bindValue(':id',$_SESSION['id'], SQLITE3_TEXT);
$house_check_query = $house_check_query->execute()->fetchArray();
$path = $_FILES['file']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);
$name=$house_check_query['token'].'.'.$ext;
move_uploaded_file($_FILES['file']['tmp_name'], 'profile/' . $name)

?>
