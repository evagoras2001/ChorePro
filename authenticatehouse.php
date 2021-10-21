<?php
    // Database connection
    $db = new Database();
global $houseadded,$nohouse,$housescript;
if(isset($_POST["house"])) {
	$housescript='<script> var content=document.getElementById("button4");
			      content.style.display = "block";
			</script>';
  $house=html(trim($_POST["houseid"]));
  $house_check_query = $db->prepare("SELECT * FROM household WHERE jointoken =:id");
  $house_check_query->bindValue(':id', $house, SQLITE3_TEXT);
  $house_check_query = $house_check_query->execute()->fetchArray();
  if(!empty($house_check_query['jointoken'])){
  $namehouse= $house_check_query['houseid'];
   if ($house_check_query['ownerid']!=$_SESSION['id']){
	$house_check_query = $db->prepare("SELECT * FROM users WHERE email =:id");
	$house_check_query->bindValue(':id',$_SESSION['id'], SQLITE3_TEXT);
	$house_check_query = $house_check_query->execute()->fetchArray();
	$already=0;
	if (!empty($house_check_query['jointoken'])){
		$already=1;
		 $token=$house_check_query['jointoken'];
	}
  $houseadded = '<div class="successes">
                        Added to the house successesfuly!
                    </div>';
                    $userQuery = $db->prepare("UPDATE users SET houseid=:house,jointoken=:join WHERE email=:email");
                    $userQuery->bindValue(':house',$namehouse, SQLITE3_TEXT);
                    $userQuery->bindValue(':email',$_SESSION['id'], SQLITE3_TEXT);
                    $userQuery->bindValue(':join', $house, SQLITE3_TEXT);
                    $userQuery = $userQuery->execute();

                    $users = $db->prepare("SELECT * FROM users WHERE jointoken =:token");
                    $users->bindValue(':token',$token,SQLITE3_TEXT);
                    $users = $users->execute();
	while($row=$users->fetchArray()){
  $updateQuery = $db->prepare("INSERT INTO notifications (title,msg,seen,username,created,jointoken) VALUES (:task,:message,0,:user,:date,:token)");
  $updateQuery->bindValue(':task',"A user has just joined the household", SQLITE3_TEXT);
$updateQuery->bindValue(':message',$house_check_query['firstname']." ".$house_check_query['surname'], SQLITE3_TEXT);
  $updateQuery->bindValue(':user',$row['email'], SQLITE3_TEXT);
  $updateQuery->bindValue(':date',date('d-m-Y'), SQLITE3_TEXT);
  $updateQuery->bindValue(':token',$house, SQLITE3_TEXT);
$updateQuery=$updateQuery->execute();}

					    if ($already==1){

                    $house_check_query = $db->prepare("SELECT * FROM household WHERE ownerid = :id AND jointoken =:token");
                    $house_check_query->bindValue(':id',$_SESSION['id'],SQLITE3_TEXT);
                    $house_check_query->bindValue(':token',$token,SQLITE3_TEXT);
                    $house_check_query = $house_check_query->execute()->fetchArray();

                            if ($house_check_query!=false){
                            $userQuery = $db->prepare("DELETE FROM household WHERE ownerid=:email AND jointoken =:token");
                            $userQuery->bindValue(':email',$_SESSION['id'], SQLITE3_TEXT);
                  	    $userQuery->bindValue(':token',$token,SQLITE3_TEXT);
                            $userQuery = $userQuery->execute();
                            $userQuery = $db->prepare("UPDATE users SET houseid=NULL, jointoken=NULL WHERE jointoken=:token");
                            $userQuery->bindValue(':token',$token, SQLITE3_TEXT);
                            $userQuery = $userQuery->execute();
                            $userQuery = $db->prepare("DELETE FROM chores WHERE jointoken = :token");
                            $userQuery->bindValue(':token',$token, SQLITE3_TEXT);
                            $userQuery = $userQuery->execute();

			}
                    }
	

}
}
 else
 {
   $nohouse='
       <div class="alert alert-danger" role="alert">
           Please provide a valid House ID.
       </div>
   ';
 }

}
?>