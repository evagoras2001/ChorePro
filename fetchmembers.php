<?php
include("database.php");
global $output,$member;
$output = 'Please join a Household';
$db = new Database();
$house_check_query = $db->prepare("SELECT * FROM users WHERE email =:id");
$house_check_query->bindValue(':id',$_SESSION['id'], SQLITE3_TEXT);
$house_check_query = $house_check_query->execute()->fetchArray();
if (!empty($house_check_query['jointoken'])){
global $member,$row,$member;
$output=$house_check_query['houseid'].' : '.$house_check_query['jointoken'];
$db = new Database();
$members=$db->prepare("SELECT * FROM household WHERE jointoken=:houseid");
$members->bindValue(':houseid', $house_check_query['jointoken'], SQLITE3_TEXT);
$members=$members->execute()->fetchArray();
$details=$db->prepare("SELECT * FROM users WHERE jointoken=:houseid");
$details->bindValue(':houseid', $house_check_query['jointoken'], SQLITE3_TEXT);
$details=$details->execute();
while ($row=$details->fetchArray()){
  if ($row['email']!=$_SESSION['id']){
    $user=$row['token'];
if(file_exists('profile/'.$user.'.jpg'))
  $image='profile/'.$user.'.jpg';
else if(file_exists('profile/'.$user.".png"))
$image='profile/'.$user.".png";
else if (file_exists('profile/'.$user.".jpeg"))
$image='profile/'.$user.".jpeg";
else
$image="profile/image.jpeg";

    if ($members['ownerid']==$_SESSION['id']){
    $member.='<div class="memberstack">
      <label for="show" id="removes" class="remove-btn fas fa-times"></label>
      <span style="display:none;">'.$row['email'].'</span>
      <div class="profile-pic-div">
                      <img src='.$image.' id="photo">
                    </div>
                    <p>Name:<br> <br> Email:<br> <br>Date Joined:</p>
                    <p>'.$row['firstname'].' '.$row['surname'].'<br><br>'.$row['email'].'<br><br>'.$row['created'].' </p>
                </div>';
  }else {
    $member.='<div class="memberstack">
      <div class="profile-pic-div">
                      <img src='.$image.' id="photo">
                    </div>
                    <p>Name:<br><br> Email:<br><br>Date Joined:</p>
                    <p>'.$row['firstname'].' '.$row['surname'].'<br><br>'.$row['email'].'<br><br>'.$row['created'].' </p>
                </div>';
  }
}
}
}
?>