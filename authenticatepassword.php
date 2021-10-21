<?php
    // Database connection
    $db = new Database();
global $match,$passwordsuccess,$verification,$match,$passwordEmptyErr,$passworderror,$passcript,$currentempty;
    if(isset($_POST["passwordchange"])) {
	$passcript='<script> var content=document.getElementById("button3");
			      content.style.display = "block";
			</script>';

        $current         = $_POST["current"];
        $password      = $_POST["password"];
        $passwordverify   = $_POST["verifypassword"];

        if(!empty($current) && !empty($password) && !empty($passwordverify)) {
                          $pass_check_query = $db->prepare("SELECT * FROM users WHERE email =:email");
                          $pass_check_query->bindValue(':email', $_SESSION['id'], SQLITE3_TEXT);
                          $pass_check_query = $pass_check_query->execute()->fetchArray();
                          $salt=$pass_check_query['password'];
          if(password_verify($current, $salt) ) {
            if(preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,25}$/", $password)) {
                    $passworderror = '<div class="alert alert-danger">
                             Password should be between 8 to 25 characters long, contains at least one special chacter, lowercase, uppercase and a digit.
                        </div>';
                }

                if(($password==$passwordverify) && (preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password))){

                    // Password hash
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    $userQuery = $db->prepare("UPDATE users SET password=:password WHERE email=:email");
                    $userQuery->bindValue(':email',$_SESSION['id'], SQLITE3_TEXT);
                    $userQuery->bindValue(':password', $password_hash, SQLITE3_TEXT);
                    $userQuery = $userQuery->execute();
          $passwordsuccess = '<div class="successes">
                                Password changed successesfuly!
                            </div>';

                    }
                }
                else {
                  $verification = '                  <div class="alert alert-danger" role="alert">
                                        Provided wrong password!
                                    </div>';


                }
        }
        else {
          if(empty($current)){
              $currentempty = '<div class="alert alert-danger" role="alert">
                  Password can not be blank.
              </div>';

} 
          else if(empty($password)){
              $passwordEmptyErr = '<div class="alert alert-danger" role="alert">
                  Password can not be blank.
              </div>';}
          else  {
              $match='
                  <div class="alert alert-danger" role="alert">
                      The passwords do not match!
                  </div>
              ';
          }

            }
        }
?>
