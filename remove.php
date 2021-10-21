<?php
session_start();
include("database.php");
$db = new Database();
$email=$_SESSION['id'];
$choreid=$_POST['id'];
$userQuery = $db->prepare("DELETE FROM chores WHERE id ='$choreid'");
$userQuery->bindValue(':email', $email, SQLITE3_TEXT);
$userQuery = $userQuery->execute();
$counterquery=$db->prepare("SELECT COUNT (*) AS 'count' FROM chores WHERE user=:email AND completed=0" );
$counterquery->bindValue(':email', $email, SQLITE3_TEXT);
$counterquery=$counterquery->execute()->fetchArray();
$counter=$counterquery['count'];
echo $counter;



?>
