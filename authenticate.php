<?php
    include("database.php");
    $db = new Database();

    global $success_msg, $email_exist, $f_error, $s_error, $emailerror,$passworerror,$passwordverifyerror;
    global $fNameEmptyErr, $sNameEmptyErr, $emailEmptyErr,$passwordEmptyErr, $email_verify_err, $email_verify_success,$passworderror,$match;
    global $verify, $blurred;	
    if(isset($_POST["submit"])) {
 $blurred='<script> 
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
  document.getElementById("omonoia").classList.remove("omonoia");
  document.getElementById("blurring").classList.add("blurring");
</script>';

        $firstname     = trim(html($_POST["firstname"]));
        $surname      = trim(html($_POST["surname"]));
        $email         = trim(html($_POST["email"]));
        $password      = $_POST["password"];
        $passwordverify   = trim($_POST["passwordverify"]);

        // check if email already exist
        $email_check_query = $db->prepare("SELECT * FROM users WHERE email =:email");
        $email_check_query->bindValue(':email', $email, SQLITE3_TEXT);
        $email_check_query = $email_check_query->execute()->fetchArray();


        // PHP validation
        // Verify if form values are not empty
        if(!empty($firstname) && !empty($surname) && !empty($email) && !empty($password) && !empty($passwordverify)) {

          if ($password!=$passwordverify){
              $match='
                  <div class="alert alert-danger" role="alert">
                      The passwords do not match! 
                  </div>
              ';
          }else if($email_check_query!=false) {
                $email_exist = '
                    <div class="alert alert-danger" role="alert">
                        User with email already exist!
                    </div>
                ';
            } else {

                // perform validation
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
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailerror = '<div class="alert alert-danger">
                            Email format is invalid.
                        </div>';
                }
                if(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,25}$/", $password)) {
                    $passworderror = '<div class="alert alert-danger">
                             Password should be between 8 to 25 charcters long, contains at least one special chacter, lowercase, uppercase and a digit.
                        </div>';
                }

                // Store the data in db, if all the preg_match condition met
                if( $password==$passwordverify && (preg_match("/^[a-zA-Z ]*$/", $firstname)) && (preg_match("/^[a-zA-Z ]*$/", $surname)) &&
                 (filter_var($email, FILTER_VALIDATE_EMAIL)) && (preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password))){

                    // Generate random activation token
                    $token = md5(uniqid(mt_rand(), true));

                    // Password hash
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    $date = date('d-m-Y');
                    $userQuery = $db->prepare("INSERT INTO users (firstname,surname,email,password, token, active,created) VALUES
                     (:firstname, :surname, :email, :password,'$token','0','$date')");
                    $userQuery->bindValue(':firstname', $firstname, SQLITE3_TEXT);
                    $userQuery->bindValue(':surname', $surname, SQLITE3_TEXT);
                    $userQuery->bindValue(':email', $email, SQLITE3_TEXT);
                    $userQuery->bindValue(':password', $password_hash, SQLITE3_TEXT);
                    $userQuery = $userQuery->execute();

                    // Send verification email
                    $to = $email;
                    $subject = "Email Verification ChorePro";
                        $msg = "<!DOCTYPE html>
                        <html>
                          <head>
                            <title>Please confirm your e-mail</title>
                            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1'>
                            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                            <style type='text/css'>
                              body,table,td,a{
                              -webkit-text-size-adjust:100%;
                              -ms-text-size-adjust:100%;
                              }
                              table,td{
                              mso-table-lspace:0pt;
                              mso-table-rspace:0pt;
                              }
                              img{
                              -ms-interpolation-mode:bicubic;
                              }
                              img{
                              border:0;
                              height:auto;
                              line-height:100%;
                              outline:none;
                              text-decoration:none;
                              }
                              table{
                              border-collapse:collapse !important;
                              }
                              body{
                              height:100% !important;
                              margin:0 !important;
                              padding:0 !important;
                              width:100% !important;
                              }
                              a[x-apple-data-detectors]{
                              color:inherit !important;
                              text-decoration:none !important;
                              font-size:inherit !important;
                              font-family:inherit !important;
                              font-weight:inherit !important;
                              line-height:inherit !important;
                              }
                              a{
                              color:#00bc87;
                              text-decoration:underline;
                              }
                              * img[tabindex=0]+div{
                              display:none !important;
                              }
                              @media screen and (max-width:350px){
                              h1{
                              font-size:24px !important;
                              line-height:24px !important;
                              }
                              }   div[style*=margin: 16px 0;]{
                              margin:0 !important;
                              }
                              @media screen and (min-width: 360px){
                              .headingMobile {
                              font-size: 40px !important;
                              }
                              .headingMobileSmall {
                              font-size: 28px !important;
                              }
                              }
                            </style>
                          </head>
                          <body bgcolor='#ffffff' style='background-color: #ffffff; margin: 0 !important; padding: 0 !important;'>
                            <div style='display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: ".'Helvetica Neue'.", Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;'> - to finish signing up, you just need to confirm that we got your e-mail right. To confirm please click the VERIFY button.</div>
                            <center>

                                              <table border='0' cellpadding='0' cellspacing='0' width='100%' style='margin-top: 50px;max-width: 500px;border-bottom: 1px solid #e4e4e4;'>
                                                <tbody>
                                                  <tr>
                                                    <td bgcolor='#ffffff' align='left' style='padding: 20px 0 0 0; color: #666666; font-family: ".'Helvetica Neue'.", Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400;-webkit-font-smoothing:antialiased;'>
                                                                        <p class='headingMobile' style='margin: 0;color: #171717;font-size: 26px;font-weight: 200;line-height: 130%;margin-bottom:5px;'>Verify your e-mail to finish signing up for ChorePro.</p>
                                                    </td>
                                                  </tr>
                                                                    <tr>
                                                                      <td height='20'></td>
                                                                    </tr>
                                                  <tr>
                                                    <td bgcolor='#ffffff' align='left' style='padding:0; color: #666666; font-family: ".'Helvetica Neue'.", Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400;-webkit-font-smoothing:antialiased;'>
                                                                        <p style='margin:0;color:#585858;font-size:14px;font-weight:400;line-height:170%;'>Thank you for choosing ChorePro.</p>
                                                                        <p style='margin:0;margin-top:20px;line-height:0;'></p>
                                                                        <p style='margin:0;color:#585858;font-size:14px;font-weight:400;line-height:170%;'>Please confirm that <b></b> is your e-mail address by clicking on the button below or use this link <a style='color: #00bc87;text-decoration: underline;' target='_blank' href="."https://cs139.dcs.warwick.ac.uk/~u2059476/cs139/cw/index.php?token=".$token.">"."www.cs139.dcs.warwick.ac.uk"."</a></p>
                                                    </td>
                                                  </tr>
                                                                    <tr>
                                                                      <td align='center'>
                                                                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                                          <tr>
                                                                            <td align='center' style='padding: 33px 0 33px 0;'>
                                                                              <table border='0' cellspacing='0' cellpadding='0' width='100%'>
                                                                                <tr>
                                                                                  <td align='center' style='border-radius: 4px;' bgcolor='#00bc87'><a href=".'https://cs139.dcs.warwick.ac.uk/~u2059476/cs139/cw/index.php?token='.$token." style='text-transform:uppercase;background:#00bc87;font-size: 13px; font-weight: 700; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none !important; padding: 20px 25px; border-radius: 4px; border: 1px solid #00bc87; display: block;-webkit-font-smoothing:antialiased;' target='_blank'><span style='color: #ffffff;text-decoration: none;'>Verify</span></a></td>
                                                                                </tr>
                                                                              </table>
                                                                            </td>
                                                                          </tr>
                                                                        </table>
                                                                      </td>
                                                                    </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>

                                          <tr>
                                            <td bgcolor='#ffffff' align='center' style='padding: 0;'>
                                              <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 500px;'>
                                                <tbody>
                                                  <tr>
                                                    <td bgcolor='#ffffff' align='center' style='padding: 30px 0 30px 0; color: #666666; font-family: ".'Helvetica Neue'.", Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 18px;'>
                                                                        <p style='margin: 0;color: #585858;font-size: 12px;font-weight: 400;-webkit-font-smoothing:antialiased;line-height: 170%;'>Need help? Ask at <a href='mailto:evagoras.savva@warwick.ac.uk' style='color: #00bc87;text-decoration: underline;' target='_blank'>evagoras.savva@warwick.ac.uk</a> </p>
                                                                        <tr>
                                                                          <td bgcolor='#ffffff' align='center' style='padding: 0; color: #666666; font-family: ".'Helvetica Neue'.", Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 18px;'>
                                                                            <p style='margin: 0;color: #585858;font-size: 12px;font-weight: 400;-webkit-font-smoothing:antialiased;line-height: 170%;'></p>
                                                                          </td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td bgcolor='#ffffff' align='center' style='padding: 15px 0 30px 0; color: #666666; font-family: ".'Helvetica Neue'.", Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 18px;'>
                                                                            <p style='margin: 0;color: #585858;font-size: 12px;font-weight: 400;-webkit-font-smoothing:antialiased;line-height: 170%;'>ChorePro, Inc.<br> Warwick University<br> Coventry, UK</p>
                                                                          </td>
                                                                        </tr>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </center>


                          </body>
                        </html>";

    $headers=""; 
    $headers .= 'From: <evagoras.savva@warwick.ac.uk>' . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\r\n";
    $headers .= "Cc:".$email. "\r\n";

                        mail($to,$subject,$msg,$headers);
            $verify='<script> document.getElementById("omonoia").classList.add("omonoia");
  document.getElementById("blurring").classList.remove("blurring");
    var elements = document.getElementsByClassName("success");
    while(elements.length > 0){
        elements[0].parentNode.removeChild(elements[0]);
    }

    var elements = document.getElementsByClassName("alerts");
    while(elements.length > 0){
        elements[0].parentNode.removeChild(elements[0]);
    }
</script>';

                            $email_verify_success = '<div class="successes">
                                Verification email has been sent!
                            </div>';

                    }
                }

        } else {
          if ($password!=$passwordverify){
              $match='
                  <div class="alert alert-danger" role="alert">
                      The passwords do not match!
                  </div>
              ';
          }
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
            if(empty($email)){
                $emailEmptyErr = '<div class="alert alert-danger">
                    Email can not be blank.
                </div>';
            }
            if(empty($password)){
                $passwordEmptyErr = '<div class="alert alert-danger" role="alert">
                    Password can not be blank.
                </div>';
            }
        }
    }
?>
