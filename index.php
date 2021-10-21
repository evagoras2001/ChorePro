<?php     
   ob_start();
   include('./authenticate.php'); include('./activate.php');  
   include('./login.php'); 
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>ChorePro Login</title>
      <link rel="stylesheet" href="index.css">
      <script src="jquery-3.6.0.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
   </head>
   <body>
      <div id="blurring">
         <header id="blur">
            <nav>
               <i class="icon"></i>
               <ul>
                  <li><a href="https://www.dcs.warwick.ac.uk/~u2059476/cs133/Aboutme/index.html">About</a></li>
               </ul>
            </nav>
         </header>
         <div class="main-container" id="main-container">
            <div class="bg-image">
               <div class="overwash"></div>
            </div>
            <div class="loginsignup">
               <div class="containers">
                  <div class="row justify-content-between">
                     <div class="content-left">
                        <a class="name" href="./index.php"><span class="text-bold">Chore</span><span class="text-light">Pro</span></a>
                        <h2><span class="bold">Chore</span>Pro helps you connect and share chores with the people in your life.</h2>
                     </div>
                     <div class="content-right">
                        <form action="" method="post" >
                           <div class="col-12 mb-5 text-center">
                              <?php echo $email_already_verified; ?>
                              <?php echo $email_verified; ?>
                              <?php echo $email_verify_success; ?>
                              <?php echo $activation_error; ?>
                              <?php echo $emailPwdErr; ?>
                              <?php echo $verificationRequiredErr; ?>
                           </div>
                           <div class="form-group">
                              <input type="text" name="email" placeholder="Email address">
                              <?php echo $emailerrorempty; ?>
                              <?php echo $accountNotExistErr; ?>
                           </div>
                           <div class="form-group">
                              <input type="password" name="password" id="password" placeholder="Password">
                              <i class="far fa-eye" id="togglePassword"></i>
                              <?php echo $passerrorempty; ?>
                              <?php echo $wrongPwdErr; ?>
                           </div>
                           <div class="login">
                              <button id="buttons" class="btn" type="submit" name="login">log in</button>
                           </div>
                           <div class="forgot">
                              <a href=""></a>
                           </div>
                           <hr>
                           <div class="create-btn">
                              <button id="button" class="btn"  onclick="myFunction(event)">create new account</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="omonoia" id="omonoia">
         <div class="container" id="container">
            <label for="show" onclick="openLoginForm()" class="close-btn fas fa-times" title="close" ></label>
            <div class="text">
               Sign Up
            </div>
            <p>It's quick and easy.</p>
            <hr id="up">
            <span id="line"><span>
            <div class="popup-overlay"></div>
            <form action="" id="forms" method="post">
               <div class="data">
                  <input type="text" name="firstname" placeholder="Name" >				
               </div>
               <?php echo $f_error; ?>
               <?php echo $fNameEmptyErr; ?>
               <div class="data">
                  <input type="text" name="surname" placeholder="Surname">
               </div>
               <?php echo $s_error; ?>
               <?php echo $sNameEmptyErr; ?>
               <div class="data">
                  <input type="email" name="email" placeholder="Email address" >
               </div>
               <?php echo $email_exist; ?>
               <?php echo $emailerror; ?>
               <?php echo $emailEmptyErr; ?>
               <div class="data">
                  <input type="password" name="password" placeholder="Password" >
               </div>
               <?php echo $passworderror; ?>
               <?php echo $passwordEmptyErr; ?>
               <div class="data">
                  <input type="password" name="passwordverify" placeholder="Retype-pasword">
               </div>
               <?php echo $match; ?>
               <div class="btns">
                  <div class="inner"></div>
                  <button type="submit" name="submit">Sign Up</button>
               </div>
            </form>
         </div>
      </div>
      <?php echo $blurred; ?>
      <script src="app2.js"></script>
      <?php echo $verify; ?>
   </body>
</html>