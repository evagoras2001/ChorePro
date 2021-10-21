<?php
include("./database.php");
$db = new Database();
global $active,$completed,$db,$counts,$firstname;
$active="";
$completed="";
$chores=$db->prepare("SELECT * FROM chores WHERE user=:email");
$chores->bindValue(":email", $_SESSION['id'], SQLITE3_TEXT);
$chores=$chores->execute();
$email=$_SESSION['id'];
$email_check_query = $db->prepare("SELECT * FROM users WHERE email =:email");
$email_check_query->bindValue(':email', $email, SQLITE3_TEXT);
$email_check_query = $email_check_query->execute()->fetchArray();
$firstname=$email_check_query ['firstname'];
$counts=0;
while($row=$chores->fetchArray()){
$now = new DateTime();
$date = new DateTime($row['duedate']);
$now = new DateTime();
$datediff=intval($date->diff($now)->format("%d"));
if ($datediff>=0 && $row['completed']==0){
$counts+=1;
$active.='<div class="card">
<label for="show" id="remove" class="remove-btn fas fa-times"></label>
<span style="display:none;">'.$row['id'].'</span>
<label for="show" id="completed" class="completed-btn fas fa-clipboard-check"></label>
  <p class="task"> '.$row['task'].'</p>

                <div class="card_inner">

    <p>Description:</p>
    <p class="description">'.$row['description'].'</p>
    <span class="font-bold text-title"> Days Left:'.$datediff.'</span>
  </div>
 </div>';
}else if( ($datediff>=0 && $row['completed']==1 )){
$completed.='
		<div class="card">
<label for="show" id="remove" class="remove-btn fas fa-times"></label>
<span id="inv">'.$row['id'].'</span>
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
$counts+=1;
$active.='
 		<div class="card">
<label for="show" id="remove" class="remove-btn fas fa-times"></label>
<span id="inv">'.$row['id'].'</span>
<label for="show" id="completed" class="completed-btn fas fa-clipboard-check"></label>
  <p class="task"> '.$row['task'].'</p>

                <div class="card_inner">

    <p>Description:</p>
    <p class="description">'.$row['description'].'</p>
    <span class="font-bold text-title">Days Left:'.$datediff.'</span>
  </div>
</div>';
} else {
  $counts+=1;
  $active.='
		<div class="card">
  <label for="show" id="remove" class="remove-btn fas fa-times"></label>
<span id="inv">'.$row['id'].'</span>
  <label for="show" id="completed" class="completed-btn fas fa-clipboard-check"></label>
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



?>
