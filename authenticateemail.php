<?php
    // Database connection
    $db = new Database();
global $emailsuccess,$emailerror,$email_exist,$emailEmptyErr,$emailscript;
    if(isset($_POST["emailchange"])) {
	$emailscript='<script> var content=document.getElementById("button2");
			      content.style.display = "block";
			</script>';
        $email         = trim(html($_POST["email"]));
        $email_check_query = $db->prepare("SELECT * FROM users WHERE email =:emails");
        $email_check_query->bindValue(':emails', $email, SQLITE3_TEXT);
        $email_check_query = $email_check_query->execute()->fetchArray();


        if(!empty($email)) {
          if($email_check_query!=false) {
                $email_exist = '
                    <div class="alert alert-danger" role="alert">
                        User with email already exist!
                    </div>
                ';
            } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailerror = '<div class="alert alert-danger">
                            Email format is invalid.
                        </div>';
                }
                if((filter_var($email, FILTER_VALIDATE_EMAIL))){
                    $userQuery = $db->prepare("UPDATE users SET email = :email WHERE email=:old");
                    $userQuery->bindValue(':email', $email, SQLITE3_TEXT);
                    $userQuery->bindValue(':old', $_SESSION['id'], SQLITE3_TEXT);
                    $userQuery = $userQuery->execute();
		    $_SESSION['id']=$email;
                            $emailsuccess = '<div class="successes">
                                Email changed successesfuly!
                            </div>';

                    }
                }

         else {
            if(empty($email)){
                $emailEmptyErr = '<div class="alert alert-danger">
                    Email can not be blank.
                </div>';
            }
        }
    }
?>
