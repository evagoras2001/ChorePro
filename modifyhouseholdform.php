<?php
$db = new Database();
global $form1,$form2,$form3,$form4,$form5;
$house_check_query = $db->prepare("SELECT * FROM users WHERE email =:id");
$house_check_query->bindValue(':id',$_SESSION['id'], SQLITE3_TEXT);
$house_check_query = $house_check_query->execute()->fetchArray();
if (empty($house_check_query['jointoken'])){
$form1='                     <form action="" method="post">
              							<div class="form-group">
              								<input type="text" name="name" placeholder="Household Name" disabled>
              							</div>
              							<div class="form-group">
              								<input type="text" name="address" placeholder="Address" disabled>
              							</div>
                            <div class="form-group">
                              <input type="text" name="postcode" placeholder="Postcode" disabled>
                            </div>
                            <div class="form-group">
                              <input type="text" name="city" placeholder="City" disabled>
                            </div>
              								<button id="button" class="btn" disabled>Create</button></form>';}
else {
$token=$house_check_query['jointoken'];
$house_check_query = $db->prepare("SELECT * FROM household WHERE jointoken =:id");
$house_check_query->bindValue(':id',$token, SQLITE3_TEXT);
$house_check_query = $house_check_query->execute()->fetchArray();
if ($house_check_query['ownerid']!= $_SESSION['id']){
  $form1='                     <form action="" method="post" >
                							<div class="form-group">
                								<input type="text" name="name" value='.$house_check_query["houseid"].' disabled>
                							</div>
                							<div class="form-group">
                								<input type="text" value='.$house_check_query["address"].'  disabled>
                							</div>
                              <div class="form-group">
                                <input type="text" value='.$house_check_query["postcode"].' disabled>
                              </div>
                              <div class="form-group">
                                <input type="text" value='.$house_check_query["city"].' disabled>
                              </div>
                								<button id="button" class="btn"  disabled>Create</button>
                						</form>';
}
else {
      $form1='            <form action="" method="post" >
                    							<div class="form-group">
                    								<input type="text" name="name" value='.$house_check_query["houseid"].' placeholder="Household Name">
                    							</div>';
                    							$form2='<div class="form-group">
                    								<input type="text" name="address" value='.$house_check_query["address"].' placeholder="Address">
                    							</div>';
                                  $form3='<div class="form-group">
                                    <input type="text" name="postcode" value='.$house_check_query["postcode"].' placeholder="Postcode">
                                  </div>';
                                  $form4='<div class="form-group">
                                    <input type="text" name="city"  value='.$house_check_query["city"].' placeholder="City">
                                  </div>';
                    								$form5='<button id="button" class="btn"  name="modify" >Modify</button>
                    						</form>';
}



}
?>
