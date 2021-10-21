<?php
$db = new Database();
global $date,$choresuccess,$needederror,$taskerror,$discriptionempty,$descriptionerror, $dateerror,$neededempty,$taskempty,$descriptionempty, $dateempty,$neededempty;
if(isset($_POST["add"])){
  $description     = trim(html($_POST["description"]));
  $task      = trim(html($_POST["task"]));
  $frequency = $_POST["frequency"];
  $needed = $_POST["number"];
  $date = strtotime($_POST['date']);
  $date = date('d-m-Y',$date);
$email=$_SESSION['id'];
$email_check_query = $db->prepare("SELECT * FROM users WHERE email =:email");
$email_check_query->bindValue(':email', $email, SQLITE3_TEXT);
$email_check_query = $email_check_query->execute()->fetchArray();
$user=$email_check_query['jointoken'];
$counterquery=$db->prepare("SELECT COUNT (*) AS 'count' FROM users WHERE jointoken=:token");
$counterquery->bindValue(':token',$user, SQLITE3_TEXT);
$counterquery=$counterquery->execute()->fetchArray();
$counter=$counterquery['count'];
  if(!empty($description) && !empty($task) && !empty($needed) && !empty($date) ) {
	        if(strlen ($task)>20) {
                    $taskerror = '<div class="alert alert-danger">
                            Provide a task name up to 20 characters.
                        </div>';
                }
                if(strlen ($description) >30) {
                    $descriptionerror = '<div class="alert alert-danger">
                            Provide a description up to 30 characters.
                        </div>';
                }
                if(date('d-m-Y')>$date) {
                    $dateerror = '<div class="alert alert-danger">
                            Provide a valid date.
                        </div>';
                }

		$preg="/^[1-".$counter."]+$/";
                if(!preg_match($preg, $needed)) {
                    $needederror = '<div class="alert alert-danger">
                            Provide a valid number.
                        </div>';
                }
  if (preg_match($preg, $needed) && date('d-m-Y')<=$date && strlen ($description) <=30 && strlen ($task)<=20){
  $house_check_query = $db->prepare("SELECT * FROM users WHERE email =:id");
  $house_check_query->bindValue(':id',$_SESSION['id'], SQLITE3_TEXT);
  $house_check_query = $house_check_query->execute()->fetchArray();
  $token=$house_check_query['jointoken'];
  $userQuery = $db->prepare("SELECT * FROM users WHERE jointoken=:token ORDER BY RANDOM() LIMIT '$needed'");
  $userQuery->bindValue(':token', $token, SQLITE3_TEXT);
  $userQuery = $userQuery->execute();
  $date=strtotime($date);
  switch ($frequency) {
    case 1:
    $date=date('d-m-Y', strtotime("+1 day", $date));
        break;
    case 2:
    $date=date('d-m-Y', strtotime("+7 day", $date));
        break;
    case 3:
    $date=date('d-m-Y', strtotime("+14 day", $date));
        break;
    case 4:
    $date=date('d-m-Y',$date);
        break;
}

                      do{
                    $key = '';
                     $keys = array_merge(range(0, 9));

                     for ($i = 0; $i < 10; $i++) {
                         $key .= $keys[array_rand($keys)];
                     }

                    $house_check_query = $db->prepare("SELECT * FROM chores WHERE id = :id");
                    $house_check_query->bindValue(':id',$key,SQLITE3_TEXT);
                    $house_check_query = $house_check_query->execute()->fetchArray();
                  }while ($house_check_query!=false);

  for ($i = 0; $i < $needed; $i++) {
  $row=$userQuery->fetchArray();
  $updateQuery = $db->prepare("INSERT INTO chores (id,jointoken,task,completed,description,frequency,user,duedate) VALUES ('$key',:token,:task,0,:description,'$frequency',:user,:day)");
  $updateQuery->bindValue(':token',$token, SQLITE3_TEXT);
  $updateQuery->bindValue(':task', $task , SQLITE3_TEXT);
  $updateQuery->bindValue(':description',$description, SQLITE3_TEXT);
  $updateQuery->bindValue(':user',$row['email'], SQLITE3_TEXT);
$updateQuery->bindValue(':day',$date, SQLITE3_TEXT);
$updateQuery=$updateQuery->execute();
  $updateQuery = $db->prepare("INSERT INTO notifications (title,msg,seen,username,created,jointoken) VALUES (:task,:message,0,:user,:date,:token)");
  $updateQuery->bindValue(':task',"You have been assigned to a new Chore", SQLITE3_TEXT);
$updateQuery->bindValue(':message',$task, SQLITE3_TEXT);
  $updateQuery->bindValue(':user',$row['email'], SQLITE3_TEXT);
  $updateQuery->bindValue(':date','DUE:'.$date, SQLITE3_TEXT);
  $updateQuery->bindValue(':token',$token, SQLITE3_TEXT);
$updateQuery=$updateQuery->execute();
}
$choresuccess = '<div class="successes">
    Chore added successesfuly!
</div>';
} } else {
           if(empty($description)){
                $discriptionempty = '<div class="alert alert-danger" role="alert">
                    Description name can not be blank.
                </div>';
            }
            if(empty($task)){
                $taskempty = '<div class="alert alert-danger">
                    Task can not be blank.
                </div>';
            }
            if(empty($needed)){
                $neededempty = '<div class="alert alert-danger" role="alert">
                    Number of people can not be blank.
                </div>';
            }
            if(empty($date)){
                $dateempty = '<div class="alert alert-danger" role="alert">
                    Date can not be blank.
                </div>';
            }

}



} 
?>