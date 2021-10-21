<?php
session_start();
include("database.php");
$db = new Database();
$userid=$_POST['id'];
$userQuery = $db->prepare("DELETE FROM chores WHERE user =:userid");
$userQuery->bindValue(':userid', $userid, SQLITE3_TEXT);
$userQuery = $userQuery->execute();
$userQuery = $db->prepare("UPDATE users SET jointoken=NULL, houseid=NULL WHERE email= :userids");
$userQuery->bindValue(':userids', $userid, SQLITE3_TEXT);
$userQuery = $userQuery->execute();
echo $userid;
?>
