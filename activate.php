<?php
    // Database connection
        

    global $email_verified, $email_already_verified, $activation_error;

    // GET the token = ?token
    if(!empty($_GET['token'])){
       $token = html($_GET['token']);
    } else {
        $token = "";
    }

    if($token != "") {
        $db = new Database();
        $tokenquery = $db->prepare("SELECT * FROM users WHERE token = :token");
        $tokenquery->bindValue(':token', $token, SQLITE3_TEXT);
        $tokenquery = $tokenquery->execute()->fetchArray();

        if($tokenquery!=false){
                $active = $tokenquery['active'];
                  if($active == 0) {
                     $update = $db->exec("UPDATE users SET active = 1 WHERE token = '$token'");
                           $email_verified = '<div id="token" class="success">
                                  User email successfully verified!
                                </div>
                           ';
                       }
                   else {
                        $email_already_verified = '<div id="token" class="alerts">
                               User email already verified!
                            </div>
                        ';
                  }
        } else {
            $activation_error = '<div id="token" class="alerts">
                    Activation error!
                </div>
            ';
        }
    }

?>
