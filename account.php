<?php
   session_start();
   if (!isset($_SESSION['id']))
   header('Location: index.php');
   include('./authenticatename.php');  include('./authenticatehouse.php');include('./authenticatepassword.php');include('./authenticateemail.php');
   include('notificationfetch.php');
   include('authenticatedelete.php');
   $email=$_SESSION['id'];
   $email_check_query = $db->prepare("SELECT * FROM users WHERE email =:email");
   $email_check_query->bindValue(':email', $email, SQLITE3_TEXT);
   $email_check_query = $email_check_query->execute()->fetchArray();
   $user=$email_check_query['token'];
   if(file_exists('profile/'.$user.'.jpg'))
     $image='profile/'.$user.'.jpg';
   else if(file_exists('profile/'.$user.".png"))
   $image='profile/'.$user.".png";
   else if (file_exists('profile/'.$user.".jpeg"))
   $image='profile/'.$user.".jpeg";
   else
   $image="profile/image.jpeg";
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link
         rel="stylesheet"
         href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
         integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
         crossorigin="anonymous"
         />
      <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
      <link rel="stylesheet" href="styles.css" />
      <script src="https://kit.fontawesome.com/6b23de7647.js" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
      <title>ChorePro Account Settings</title>
   </head>
   <body id="body">
      <div class="container">
         <nav class="navbar">
            <div class="nav_icon" onclick="toggleSidebar()">
               <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
            <div class="navbar__left">
            </div>
            <div class="navbar__right">
               <nav onclick="toggle()" class="navbar">
                  <ul class="nav justify-content-end" >
                     <li class="dropdown">
                        <div  class="dropdown-toggle text-light"  id="count_change" style="cursor: pointer;" role="button" data-toggle="dropdown"  >
                           <span class="counter"><?php echo $counter;?></span><i class="fas fa-bell" style="font-size: 20px;"></i>
                        </div>
                        <div id = "mytoggle" class="dropdown-menu overflow-h-menu dropdown-menu-right">
                           <?php echo $notifications; ?>
                        </div>
                     </li>
                  </ul>
               </nav>
               <a href="account.php" style="margin-left:0px;">
               <i class="far fa-user" aria-hidden="true"></i> Account
               </a>
               <a href="logout.php">
               <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Log Out
               </a>
            </div>
         </nav>
         <main>
         <div class="main__container">
            <main class="main">
               <p class="settingshead">General Account Settings</p>
               <div class="main__cards">
                  <div class="setting">
                     <div class="profile-pic-div">
                        <img src="<?php echo $image; ?>" id="photo">
                        <input class="class" type="file" accept=".png, .jpg, .jpeg" id="file">
                        <label for="file" id="uploadBtn">Choose Photo</label>
                     </div>
                     <button type="button" id="removebtn" class="omo">remove</button>
                     <div class="alerts alert-danger" id="alert" role="alerts">Only jpg/jpeg and png files are allowed!</div>
                     <script src="app.js"></script>
                  </div>
                  <button type="button" class="collapsible">Name<i class="far fa-edit" id="edit" aria-hidden="true"> Edit</i></button>
                  <div id="button1" class="button1 content">
                     <form action="" method="post" >
                        <?php echo $namesuccess; ?>
                        <div class="form-group">
                           <input type="text" name="firstname" value="<?php echo $fname;?>" placeholder="Firstname">
                        </div>
                        <?php echo $f_error; ?>
                        <?php echo $fNameEmptyErr;?>
                        <div class="form-group">
                           <input type="text" name="surname" value="<?php echo $sname;?>" placeholder="Surname">
                        </div>
                        <?php echo $s_error; ?>
                        <?php echo $sNameEmptyErr;?>
                        <button class="btn"  name="name" >Change</button>
                     </form>
                     <?php echo $namescript;?>
                  </div>
                  <button type="button" class="collapsible">Email<i class="far fa-edit" id="edit" aria-hidden="true"> Edit</i></button>
                  <div id="button2" class="content">
                     <form action="" method="post" >
                        <?php echo $emailsuccess; ?>
                        <div class="form-group">
                           <input type="text" value="<?php echo $_SESSION['id']; ?>" name="email" placeholder="Email">
                        </div>
                        <?php echo $email_exist; ?>
                        <?php echo $emailerror;?>
                        <?php echo $emailEmptyErr;?>
                        <button class="btn"  name="emailchange" >Change</button>
                     </form>
                  </div>
                  <button type="button" class="collapsible">Password<i class="far fa-edit" id="edit" aria-hidden="true"> Edit</i></button>
                  <div id="button3" class="content">
                     <?php echo $passwordsuccess;?>
                     <form action="" method="post" >
                        <div class="form-group">
                           <input type="password" name="current" placeholder="Current">
                        </div>
                        <?php echo $verification;?>
                        <?php echo $currentempty;?>
                        <div class="form-group">
                           <input type="password" name="password" placeholder="New">
                        </div>
                        <?php echo $passworderror;?>
                        <?php echo $passwordEmptyErr;?>
                        <div class="form-group">
                           <input type="password" name="verifypassword" placeholder="Re-type new">
                        </div>
                        <?php echo $match;?>
                        <button class="btn" name="passwordchange" >Change</button>
                     </form>
                  </div>
                  <button type="button" class="collapsible">Household<i class="far fa-edit" id="edit" aria-hidden="true"> Edit</i></button>
                  <div id="button4" class="content">
                     <?php echo $houseadded;?>
                     <?php echo $nohouse;?>
                     <form action="" method="post" >
                        <div class="form-group">
                           <input type="text" name="houseid" placeholder="Household ID">
                        </div>
                        <button class="btn"  name="house" >Join</button>
                     </form>
                     <?php echo $emailscript;?>
                     <?php echo $passcript;?>
                     <?php echo $housescript;?>
                  </div>
                  <button type="button" class="collapsible">Delete Account<i class="far fa-edit" id="edit" aria-hidden="true"> Edit</i></button>
                  <div id="button5" class="content">
                     <form action="" method="post" >
                        <div class="form-group">
                           <input type="password" name="delete" placeholder="Password">
                        </div>
                        <?php echo $passworderror;?>
                        <?php echo $verification;?>
                        <?php echo $passwordEmptyErr;?>
                        <button class="btn"  name="deleteaccount" >Delete</button>
                     </form>
                     <?php echo $passesscript; ?>
                  </div>
               </div>
         </div>
         </main>
         <div id="sidebar">
            <div class="sidebar__title">
               <div class="sidebar__img">
                  <img src="White.png" />
                  <h1 style="letter-spacing: 1px;">Chore<span id="light">Pro</span></h1>
               </div>
               <i
                  onclick="closeSidebar()"
                  class="fa fa-times"
                  id="sidebarIcon"
                  aria-hidden="true"
                  ></i>
            </div>
            <div class="sidebar__menu">
               <div class="sidebar__link ">
                  <i class="fa fa-home"></i>
                  <a href="dashboard.php">Dashboard</a>
               </div>
               <h2>Household</h2>
               <div class="sidebar__link ">
                  <i class="far fa-user" aria-hidden="true"></i>
                  <a href="members.php">Members</a>
               </div>
               <div class="sidebar__link">
                  <i class="fa fa-home"></i>
                  <a href="createhousehold.php">Create a Household</a>
               </div>
               <div class="sidebar__link ">
                  <i class="far fa-edit" aria-hidden="true"></i>
                  <a href="modifyhousehold.php">Modify Household</a>
               </div>
               <h2>Chores</h2>
               <div class="sidebar__link">
                  <i class="fa fa-home"></i>
                  <a href="household.php">Household Assigned Chores</a>
               </div>
               <div class="sidebar__link">
                  <i class="fas fa-plus"></i>
                  <a href="addchore.php">Add a chore</a>
               </div>
            </div>
         </div>
      </div>
      <script src="script.js"></script>
      <script type="text/javascript">
         if ( window.history.replaceState ) {
             window.history.replaceState( null, null, window.location.href );
         }
         var toggled = false;
         function toggle(){
         if (toggled == false){
             document.getElementById("mytoggle").classList.add("show");
             toggled = true;
             		$.ajax({
           			type: "POST",
          			 url: "notificationupdate.php"
                 });
         }
         else{
             document.getElementById("mytoggle").classList.remove("show");
             toggled = false;
         }
         }
         
         
         
         
         
             $(document).ready(function (){
         
           $("#file").change(function() {
             var file_data = $('#file').prop('files')[0];
             var form_data = new FormData();  // Create a FormData object
             form_data.append('file', file_data);  // Append all element in FormData  object
         
             $.ajax({
                     url         : 'uploadprofile.php',     
                     dataType    : 'text',           
                     cache       : false,
                     contentType : false,
                     processData : false,
                     data        : form_data,                         
                     type        : 'post',
              });
         });
         
         
               $('#removebtn').on('click',function (){
                 $('#photo').attr('src', 'image.jpeg');
                 $.ajax({
                     url         : 'removeprofile.php',     
                     dataType    : 'text',           
                     cache       : false,
                     contentType : false,
                     processData : false,
                     type        : 'post',
              });s
               });
               $(document).on("mousenter", ".profile-pic-div", function() {
                 $('#uploadBtn').attr('style', 'display: block !important');
                });
               $( ".profile-pic-div" ).mouseover(function() {
                 $('#uploadBtn').attr('style', 'display: block !important');
               });
               $( ".profile-pic-div" ).mouseleave(function() {
                 $('#uploadBtn').attr('style', 'display: none');
               });
                 if($('.counter').text()=='0')
                 $('.counter').hide();
         
                 $('#count_change').on('click',function (){
                   $('.counter').text('0').show();
                     $('.counter').text('0').hide();
                     $.post("notificationupdate.php");
                 });
                 $(document).on("click", "#remove", function() {
                         var billid=parseInt($(this).next().text());
                        $(this).parent().remove();
                        $.post("remove.php",{id:billid});
                 });
         
                 $(document).on("click", "#completed", function() {
                         var billid=parseInt($(this).next().text());
                         var cln = $(this).parent().clone();
                        $(this).parent().remove();
                        cln.find("span").remove();
                        cln.find("#completed").remove();
                        cln.find(".description").after("<span class='font-bold text-title'> Days Left: 0</span>");
                        $(".completed_chores").append(cln);
                        $.post("completed.php",{id:billid});
                 });
             });
         
      </script>
      <script>
         var coll = document.getElementsByClassName("collapsible");
         var i;
         
         for (i = 0; i < coll.length; i++) {
           coll[i].addEventListener("click", function() {
             this.classList.toggle("active");
             var content = this.nextElementSibling;
             if (content.style.display === "block") {
               content.style.display = "none";
             } else {
               content.style.display = "block";
             }
           });
         }
      </script>
   </body>
</html>