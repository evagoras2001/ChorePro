<?php
    // Database connection
    include("database.php");
    $db = new Database();
global $fname,$sname,$namescript;
$house_check_query = $db->prepare("SELECT * FROM users WHERE email =:id");
$house_check_query->bindValue(':id',$_SESSION['id'], SQLITE3_TEXT);
$house_check_query = $house_check_query->execute()->fetchArray();
$fname=$house_check_query['firstname'];
$sname=$house_check_query['surname'];
    global $f_error, $s_error, $namesuccess, $fNameEmptyErr, $sNameEmptyErr;
    if(isset($_POST["name"])) {
	$namescript='<script> var content=document.getElementById("button1");
			      content.style.display = "block";
			</script>';

        $firstname     = trim(html($_POST["firstname"]));
        $surname      = trim(html($_POST["surname"]));

        if(!empty($firstname) && !empty($surname)) {
                if(!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
                    $f_error = '<div class="alert alert-danger">
                            Only letters are allowed.
                        </div>';
                }
                if(!preg_match("/^[a-zA-Z ]*$/", $surname)) {
                    $s_error = '<div class="alert alert-danger">
                            Only letters are allowed.
                        </div>';
                }

                // Store the data in db, if all the preg_match condition met
                if((preg_match("/^[a-zA-Z ]*$/", $firstname)) && (preg_match("/^[a-zA-Z ]*$/", $surname))){
                    $userQuery = $db->prepare("UPDATE users SET firstname=:firstname, surname=:surname WHERE email=:email");
                    $userQuery->bindValue(':firstname', $firstname, SQLITE3_TEXT);
                    $userQuery->bindValue(':surname', $surname, SQLITE3_TEXT);
                    $userQuery->bindValue(':email', $_SESSION['id'], SQLITE3_TEXT);
                    $userQuery = $userQuery->execute();
                    $namesuccess = '<div class="successes">
                                Name changed successesfuly!
                            </div>';

                    
		}
                }

         else {
            if(empty($firstname)){
                $fNameEmptyErr = '<div class="alert alert-danger" role="alert">
                    First name can not be blank.
                </div>';
            }
            if(empty($surname)){
                $sNameEmptyErr = '<div class="alert alert-danger">
                    Surname can not be blank.
                </div>';
            }
        }
    }
?>
