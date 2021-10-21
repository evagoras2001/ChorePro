<?php
include("database.php");
global $output;
$output = 'Join a Household!';
if (isset($_SESSION['houseid']) {
global $member,$row;
$output=$_SESSION['houseid'];
$db = new Database();
$members=db->prepare("SELECT * FROM household WHERE id=:houseid");
$members->bindValue(':houseid', $_SESSION['houseid'], SQLITE3_TEXT);
$members=$members->execute()->fetchArray();
$details=db->prepare("SELECT * FROM users WHERE houseid=:houseid");
$details->bindValue(':houseid', $_SESSION['houseid'], SQLITE3_TEXT);
$details->execute();
while ($row=$details->fetchArray()){
  if ($row['email']!=$_SESSION['id']){
    $user=$row['token'];
    if($content = file_get_contents('profile/'.$user.'.jpg'))
      $image='profile/'.$user.'.jpg';
    else if($content = file_get_contents('profile/'.$user.".png"))
    $image='profile/'.$user.".png";
    else if ($content = file_get_contents('profile/'.$user.".jpeg"))
    $image='profile/'.$user.".jpeg";
    else
    $image=="profile/image.jpeg";

    if ($members['ownerid']==$_SESSION['id']){
    $member.='<div class="memberstack">
      <label for="show" id="removes" class="remove-btn fas fa-times"></label>
      <span id="invi">.'$row['email'].'
      <div class="profile-pic-div">
                      <img src='.$image.' id="photo">
                    </div>
                    <p>Name:<br> <br> Email:<br> <br>Date Joined:</p>
                    <p>'.$row['firstname'].' '.$row['surname'].'<br><br>'.$row['email'].'<br><br>'.$row['created'].' </p>
                </div>';
  }else {
    $member.='<div class="memberstack">
      <div class="profile-pic-div">
                      <img src='.$image.'id="photo">
                    </div>
                    <p>Name:<br><br> Email:<br><br>Date Joined:</p>
                    <p>'.$row['firstname'].' '.$row['surname'].'<br><br>'.$row['email'].'<br><br>'.$row['created'].' </p>
                </div>';
  }
}
}
?>