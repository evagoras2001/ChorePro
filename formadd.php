<?php
include("database.php");
$db = new Database();
global $form,$form1,$form2,$form3,$form4,$form5;
$house_check_query = $db->prepare("SELECT * FROM users WHERE email =:id");
$house_check_query->bindValue(':id',$_SESSION['id'], SQLITE3_TEXT);
$house_check_query = $house_check_query->execute()->fetchArray();
if (empty($house_check_query['jointoken'])){
$form='                     <form action="" method="post" >
              							<div class="form-group">
              								<input type="text" placeholder="Task name" disabled>
              							</div>
              							<div class="form-group">
              								<input type="text" placeholder="Description" disabled>
              							</div>
                            <div class="form-group">
                            <select id="frequency" name="frequency" disabled>
                              <option value="1">Every day</option>
                              <option value="2">Every week</option>
                              <option value="3">Every fortnight</option>
                              <option value="4">One-time</option>
                            </select>
                            </div>
                            <div class="form-group">
                            <input type="date" id="start" name="date"
                                   min='.date('Y/m/d').' disabled>
                            </div>
                            <div class="form-group">
                              <input type="number" placeholder="Number of people needed" disabled>
                            </div>
              								<button id="button" class="btn" disabled>Add</button>
              						</form>';}
else {
  $token=$house_check_query['jointoken'];
  $counterquery=$db->prepare("SELECT COUNT (*) AS 'count' FROM users WHERE jointoken=:token" );
  $counterquery->bindValue(':token', $token, SQLITE3_TEXT);
  $counterquery=$counterquery->execute()->fetchArray();
  $counter=$counterquery['count'];
  $form='                     <form action="" method="post" >
                	      <div class="form-group">
                	      <input type="text" name="task"placeholder="Task name" >
                		</div>';

 $form1='               		<div class="form-group">
                		<input type="text" name="description" placeholder="Description">
                	        </div>';

 $form2='                         <div class="form-group">
                              <select id="frequency" name="frequency">
                                <option value="1">Every day</option>
                                <option value="2">Every week</option>
                                <option value="3">Every fortnight</option>
                                <option value="4">One-time</option>
                              </select>
				</div>';
$form3='                        <div class="form-group">
                              <input type="date" id="start" name="date"
                                     min="'.date('d-m-Y').'">
                              </div>';
$form4='                       <div class="form-group">
                                <input type="number"  name="number" min="1" max="'.$counter.'"step="1" placeholder="Number of people needed">
	                       </div>';
$form5='                      <button id="button" class="btn"  name="add">Add</button>
                						</form>';
}
?>
