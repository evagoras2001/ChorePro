<?php
    session_start();
    global $wrongPwdErr, $accountNotExistErr, $emailPwdErr, $verificationRequiredErr, $emailerrorempty, $passerrorempty,$redirect;
    if(isset($_POST['login'])) {
        $db = new Database();
        $email        = html($_POST['email']);
        $password     = $_POST['password'];
           

 $verify='<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
var elements = document.getElementsByClassName("success");
    while(elements.length > 0){
        elements[0].parentNode.removeChild(elements[0]);
    }

    var elements = document.getElementsByClassName("alerts");
    while(elements.length > 0){
        elements[0].parentNode.removeChild(elements[0]);
    }
</script>';


        // Query if email exists
                $email_check_query = $db->prepare("SELECT * FROM users WHERE email =:email");
                $email_check_query->bindValue(':email', $email, SQLITE3_TEXT);
                $email_check_query = $email_check_query->execute()->fetchArray();
   global $blurred;

        if(!empty($email) && !empty($password)){
            // Check if email exist
            if($email_check_query==false) {
                $accountNotExistErr = '<div class="logins">
                        User account does not exist.
                    </div>';
            } else {
              $salt=$email_check_query['password'];
	      $active=$email_check_query['active'];
                // Allow only verified user
                if($active == '1') {
                    if(password_verify($password, $salt)) {
                       $_SESSION['id'] = $email;
			header('Location:dashboard.php');

                    } else {
                        $emailPwdErr = '<div class="logins">
                                Either email or password is incorrect.
                            </div>';
                    }
                } else {
                    $verificationRequiredErr = '<div class="logins">
                            Account verification is required for login.
                        </div>';
                }

            }

        } else {
            if(empty($email)){
                $emailerrorempty = "<div class='logins'>
                            Email not provided.
                    </div>";
            }

            if(empty($password)){
                $passerrorempty = "<div class='logins'>
                            Password not provided.
                        </div>";
            }
        }

    }

?>
