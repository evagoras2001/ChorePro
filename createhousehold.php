<?php
session_start();
if (!isset($_SESSION['id']))
header('Location: index.php');
global $houserror, $addresserror, $postcodeerror, $householdsuccess, $householdempty, $addressempty, $postcodeempty,$cityempty,$cityerror;
include('./create.php');
include('notificationfetch.php');
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
    <title>ChorePro Create household</title>
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

          <p class="descriptions">Create <strong>Household</strong></p><br>
          <!-- MAIN CARDS STARTS HERE -->

          <div class="main__cards">
            <?php echo $householdsuccess; ?>
              <form action="" method="post" >
              							<div class="form-group">
              								<input type="text" name="name" placeholder="Household Name">
                              <?php echo $houserror; ?>
                              <?php echo $householdempty; ?>
              							</div>
              							<div class="form-group">
              								<input type="text" name="address" placeholder="Address">
                              <?php echo $addresserror; ?>
                              <?php echo $addressempty; ?>
              							</div>
                            <div class="form-group">
                              <input type="text" name="postcode" placeholder="Postcode">
                              <?php echo $postcodeerror; ?>
                              <?php echo $addressempty; ?>
                            </div>
                            <div class="form-group">
                              <input type="text" name="city" placeholder="City">
                              <?php echo $cityerror; ?>
                              <?php echo $cityempty; ?>
                            </div>
              								<button id="button" class="btn"  name="create" >Create</button>
              						</form>



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
          <div class="sidebar__link">
            <i class="fa fa-home"></i>
            <a href="dashboard.php">Dashboard</a>
          </div>
          <h2>Household</h2>
          <div class="sidebar__link ">
            <i class="far fa-user" aria-hidden="true"></i>
            <a href="members.php">Members</a>
          </div>
          <div class="sidebar__link active_menu_link">
            <i class="fa fa-home "></i>
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
     			 url: "notificationupdate.php"            });
    }
    else{
        document.getElementById("mytoggle").classList.remove("show");
        toggled = false;
    }
}

        $(document).ready(function (){

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
  </body>
</html>
