<?php
include("database.php");
$db = new Database();
global $active,$completed;
$active="";
$completed="";
$house_check_query = $db->prepare("SELECT * FROM users WHERE email =:id");
$house_check_query->bindValue(':id',$_SESSION['id'], SQLITE3_TEXT);
$house_check_query = $house_check_query->execute()->fetchArray();
$token=$house_check_query['jointoken'];
$rows=$db->prepare("SELECT * FROM users WHERE jointoken='$token'");
$rows=$rows->execute();
while($users=$rows->fetchArray()){
  if($users['email']!=$_SESSION['id']){
$chores=$db->prepare("SELECT * FROM chores WHERE user=:email");
$chores->bindValue(':email', $users['email'], SQLITE3_TEXT);
$chores=$chores->execute();
$active.='<p id="heading" class="descriptions">Name: <strong>'.$users['firstname'].' '.$users['firstname'].'</strong></p><br>';
$completed.='<p id="heading" class="descriptions">Name: <strong>'.$users['firstname'].' '.$users['firstname'].'</strong></p><br>';
while($row=$chores->fetchArray()){
$now = new DateTime();
$date = new DateTime($row['duedate']);
$now = new DateTime();
$datediff=intval($date->diff($now)->format("%d"));
if ($datediff>=0 && $row['completed']==0){
$active.='<div class="card">
  <p class="task"> '.$row['task'].'</p>

                <div class="card_inner">

    <p>Description:</p>
    <p class="description">'.$row['description'].'</p>
    <span class="font-bold text-title"> Days Left:'.$datediff.'</span>
  </div>
  </div>';
}else if($datediff>=0 && $row['completed']==1 ){
$completed.='<div class="card">
  <p class="task"> '.$row['task'].'</p>

                <div class="card_inner">

    <p>Description:</p>
    <p class="description">'.$row['description'].'</p>
    <span class="font-bold text-title">Days Left:0</span>
  </div>
 </div>';
}else if ($datediff<0){
$frequency=$row['frequency'];
switch ($frequency) {
  case 1:
  $add=1;
      break;
  case 2:
  $add=7;
      break;
  case 3:
  $add=14;
      break;
  case 4:
  $add=0;
      break;
}
if ($add!=0){
$now = new DateTime();
$result = $now->format('d-m-Y');
$result=strtotime($result);
do {
$second =date('d-m-Y', strtotime("+".$add."day",$result));
$date = new DateTime($second);
$datediff=intval($date->diff($now)->format("%d"));
}while($datediff<0);
$choreid=$row["id"];
$update=$db->prepare("UPDATE chores SET duedate='$second',completed=0 WHERE id='$choreid'");
$update=$update->execute();
$active.='<div class="card">
  <p class="task"> '.$row['task'].'</p>

                <div class="card_inner">

    <p>Description:</p>
    <p class="description">'.$row['description'].'</p>
    <span class="font-bold text-title">Days Left:'.$datediff.'</span>
  </div>
   </div>';
} else {
  $active.='<div class="card">
    <p class="task"> '.$row['task'].'</p>

                  <div class="card_inner">

      <p>Description:</p>
      <p class="description">'.$row['description'].'</p>
      <span class="font-bold text-title">Days Left:0</span>
    </div>
     </div>';
}
}
}
}
}
?>