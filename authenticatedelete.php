<?php
    // Database connection
    $db = new Database();
global $passesscript,$match,$passwordsuccess,$verification,$match,$passwordEmptyErr,$passworderror,$passcript,$currentempty;
    if(isset($_POST["deleteaccount"])) {
	$passesscript='<script> var content=document.getElementById("button5");
			      content.style.display = "block";
			</script>';
        $password      = $_POST["delete"];
        if(!empty($password)) {
                          $pass_check_query = $db->prepare("SELECT * FROM users WHERE email =:email");
                          $pass_check_query->bindValue(':email', $_SESSION['id'], SQLITE3_TEXT);
                          $pass_check_query = $pass_check_query->execute()->fetchArray();
                          $salt=$pass_check_query['password'];
          if(password_verify($password, $salt) ) {



                            $house_check_query = $db->prepare("SELECT * FROM users WHERE email =:id");
                      			$house_check_query->bindValue(':id',$_SESSION['id'], SQLITE3_TEXT);
                      			$house_check_query = $house_check_query->execute()->fetchArray();
                      		  	$already=0;
                      		   if (!empty($house_check_query['jointoken'])){
                      		    $already=1;
                      		    $token=$house_check_query['jointoken'];
                      			}
                                                  $userQuery = $db->prepare("DELETE FROM chores WHERE user = :email");
                                                  $userQuery->bindValue(':email',$_SESSION['id'], SQLITE3_TEXT);
                                                  $userQuery = $userQuery->execute();


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
                    $house_check_query = $db->prepare("DELETE FROM users WHERE email =:id");
                    $house_check_query->bindValue(':id',$_SESSION['id'], SQLITE3_TEXT);
                    $house_check_query = $house_check_query->execute()->fetchArray();
                    header('Location: index.php');

              }  else {
                  $verification = '<div class="alert alert-danger" role="alert">
                                        Provided wrong password!
                                    </div>';


                }
        }
        else {
            if(empty($password)){
              $passwordEmptyErr = '<div class="alert alert-danger" role="alert">
                  Password can not be blank.
              </div>';}

            }
        }
?>
