<?php
$db = new Database();
global $notifications;
global $counter;
$useremail=$_SESSION['id'];
$house_check_query = $db->prepare("SELECT * FROM users WHERE email =:id");
$house_check_query->bindValue(':id',$_SESSION['id'], SQLITE3_TEXT);
$house_check_query = $house_check_query->execute()->fetchArray();
$token=$house_check_query['jointoken'];
$counterquery=$db->prepare("SELECT COUNT (*) AS 'count' FROM notifications WHERE username=:email AND seen=0 AND jointoken='$token'" );
$counterquery->bindValue(':email', $useremail, SQLITE3_TEXT);
$counterquery=$counterquery->execute()->fetchArray();
$counter=$counterquery['count'];
$notificationsquery=$db->prepare("SELECT * FROM notifications WHERE username=:email AND jointoken='$token' ORDER BY id DESC");
$notificationsquery->bindValue(':email', $useremail, SQLITE3_TEXT);
$notificationsquery=$notificationsquery->execute();
 $notifications="";
while ($row=$notificationsquery->fetchArray()){
  $notifications.='<div class="item" >
      <h6>'.$row['title'].'</h6>
      <span>'.$row['msg'].'</span><span style="right: 23px;position: absolute;font-size:10px;margin: 8px;">'.$row['created'].'</span>
      <hr class="mt-1 mb-1">
  </div>';
}
$counterquery=$db->prepare("SELECT COUNT (*) AS 'count' FROM notifications WHERE username=:email AND jointoken='$token'" );
$counterquery->bindValue(':email', $useremail, SQLITE3_TEXT);
$counterquery=$counterquery->execute()->fetchArray();
$counting=$counterquery['count'];
if($counting==0)
$notifications='<div style="text-align: center;" class="item"><br><br><br><br><br><br><br><br><h6>No past notifications</h6><br><br><br><br><br><br><br></div>';

?>
