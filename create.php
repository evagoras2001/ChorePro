<?php
    // Database connection
    include("database.php");
    global $db;
    $db = new Database();
    global $houserror, $addresserror, $postcodeerror, $householdsuccess, $householdempty, $addressempty, $postcodeempty,$cityempty,$cityerror;
    if(isset($_POST["create"])) {
        $household     = trim(html($_POST["name"]));
        $address      = trim(html($_POST["address"]));
        $postcode         = trim(html($_POST["postcode"]));
        $city         = trim(html($_POST["city"]));
        if(!empty($household) && !empty($address) && !empty($postcode) && !empty($city) ) {

                // perform validation
                if(!preg_match("/^[a-zA-Z ]*$/", $household)) {
                    $houserror = '<div class="alert alert-danger">
                            Only letters are allowed.
                        </div>';
                }
                if(!preg_match("/^[a-zA-Z0-9 ]+$/", $address)) {
                    $addresserror = '<div class="alert alert-danger">
                            Provide a valid address
                        </div>';
                }
                if(!preg_match("/^[a-zA-Z0-9 ]+$/", $postcode)) {
                    $postcodeerror = '<div class="alert alert-danger">
                            Provide a valid postcode.
                        </div>';
                }
                if(!preg_match("/^[a-zA-Z ]+$/", $city)) {
                    $cityerror = '<div class="alert alert-danger">
                            Provide a city postcode.
                        </div>';
                }
                // Store the data in db, if all the preg_match condition met
                if( preg_match("/^[a-zA-Z ]+$/", $city)&& preg_match("/^[a-zA-Z ]*$/", $household) && preg_match("/^[a-zA-Z0-9 ]+$/", $address) && preg_match("/^[a-zA-Z0-9 ]+$/", $postcode)) {

                    do{
                    $key = '';
                     $keys = array_merge(range(0, 9), range('A', 'Z'));

                     for ($i = 0; $i < 5; $i++) {
                         $key .= $keys[array_rand($keys)];
                     }

                    $house_check_query = $db->prepare("SELECT * FROM household WHERE jointoken = :id");
                    $house_check_query->bindValue(':id',$key,SQLITE3_TEXT);
                    $house_check_query = $house_check_query->execute()->fetchArray();
                  }while ($house_check_query!=false);
			$house_check_query = $db->prepare("SELECT * FROM users WHERE email =:id");
			$house_check_query->bindValue(':id',$_SESSION['id'], SQLITE3_TEXT);
			$house_check_query = $house_check_query->execute()->fetchArray();
		  	$already=0;
		   if (!empty($house_check_query['jointoken'])){
		    $already=1;
		    $token=$house_check_query['jointoken'];
			}
                            $householdsuccess = '<div class="successes">
                                Household created successesfuly!
                            </div>';
                            $userQuery = $db->prepare("UPDATE users SET houseid=:house,jointoken =:id WHERE email=:email");
                            $userQuery->bindValue(':house',$household, SQLITE3_TEXT);
                            $userQuery->bindValue(':id',$key, SQLITE3_TEXT);
                            $userQuery->bindValue(':email',$_SESSION['id'], SQLITE3_TEXT);
                            $userQuery = $userQuery->execute();

                    $house_check_query = $db->prepare("INSERT INTO household (houseid,ownerid,address,postcode,city,jointoken)  VALUES (:houseid,:ownerid,:address,:postcode,:city,:jointoken)");
                    $house_check_query->bindValue(':houseid',$household,SQLITE3_TEXT);
                    $house_check_query->bindValue(':ownerid',$_SESSION['id'],SQLITE3_TEXT);
                    $house_check_query->bindValue(':address',$address,SQLITE3_TEXT);
                    $house_check_query->bindValue(':postcode',$postcode,SQLITE3_TEXT);
                    $house_check_query->bindValue(':jointoken',$key,SQLITE3_TEXT);
                    $house_check_query->bindValue(':city',$city,SQLITE3_TEXT);
                    $house_check_query = $house_check_query->execute()->fetchArray();

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
                  }
                }

        else {
            if(empty($household)){
                $householdempty = '<div class="alert alert-danger" role="alert">
                    Household name can not be blank.
                </div>';
            }
            if(empty($address)){
                $addressempty = '<div class="alert alert-danger">
                    Address can not be blank.
                </div>';
            }
            if(empty($postcode)){
                $postcodeempty = '<div class="alert alert-danger">
                    Postcode can not be blank.
                </div>';
            }
            if(empty($city)){
                $cityempty = '<div class="alert alert-danger" role="alert">
                    City can not be blank.
                </div>';
            }
        }
    }
?>
