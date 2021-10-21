<?php
session_start();
include("database.php");
$db = new Database();
$useremail=$_SESSION['id'];
$notificationupdate=$db->prepare("UPDATE notifications SET seen = 1 WHERE username=:email");
$notificationupdate->bindValue(':email', $useremail, SQLITE3_TEXT);
$notificationupdate = $notificationupdate->execute();
?>
