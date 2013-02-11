<?php

  session_start();
	
	include("functions.php");
	
	$db=pg_connect("host=localhost dbname=postgres port=5432 user=postgres password=000000");
	$dormManager=new databaseManager;
	
	//for viewing the next schedules
	if(isset($_POST["nextSched"])){
		$_SESSION["day"]++;//increase the day
	}
	
	//for viewing the previous schedules
	if(isset($_POST["prevSched"])){
		$_SESSION["day"]--;//decrease the day
	}
	
	//once no more viewing and in adding info
	if(isset($_POST["saveSched"])){
		
	}
	
	//once no more viewing and in updating info
	if(isset($_POST["updateSched"])){
		
	}
	
	//if add sched is clicked
	if(isset($_POST["addSched"])){
		$_SESSION["add"]=1;
		$_SESSION["edit"]=0;
		$_SESSION["view"]=0;
	}
		
	//if edit is clicked
	if(isset($_POST["editSched"])){
		$_SESSION["edit"]=1;
		$_SESSION["add"]=0;
		$_SESSION["view"]=0;
	}
	
	//start the viewing session from the present day
	if(isset($_POST["viewSched"])){
		$_SESSION["day"]=0;
		$_SESSION["edit"]=0;
		$_SESSION["add"]=0;
		$_SESSION["view"]=1;
	}




?>
<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<div id="container">
			SCHEDULE
			<div id="body">
				<form name="sched" action="sched.php" method="post">
					<table width="100%" border='1'>
					<?php
						$dayToSee=$_SESSION["day"];//show the header for the day
						$dormManager->printSchedule($dayToSee);
					?>
					
					
					<tr>
						<!--time slot-->
						<th></th>
						<th>10pm - 6am</th>
						<th>6am - 2pm</th>
						<th>2pm - 10pm</th>
					</tr>
					<tr>
						<th align="left">Dorm Manager</th>
						<?php
							$listOfDormMan = $dormManager->retrieveStaff('dormmanager');
							echo '<td>';
								echo '<select id="selItem" value="" name="dm1">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfDormMan); $i++){
										
										echo '<option value="'.$listOfDormMan[$i].'">';
										echo $listOfDormMan[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
							echo '<td>';
								echo '<select id="selItem" value="" name="dm2">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfDormMan); $i++){
										
										echo '<option value="'.$listOfDormMan[$i].'">';
										echo $listOfDormMan[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
							echo '<td>';
								echo '<select id="selItem" value="" name="dm3">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfDormMan); $i++){
										
										echo '<option value="'.$listOfDormMan[$i].'">';
										echo $listOfDormMan[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
						?>
					</tr>
					
					<tr>
						<th></th>
						<th colspan=4>Maintenance</th>
					</tr>
					<tr>
						<th align="left">Unit1</th>
						<?php
							$listOfMan = $dormManager->retrieveStaff('maintenance');
							echo '<td>';
								echo '<select id="selItem" value="" name=man1">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfMan); $i++){
										
										echo '<option value="'.$listOfMan[$i].'">';
										echo $listOfMan[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
							echo '<td>';
								echo '<select id="selItem" value="" name="man2">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfMan); $i++){
										
										echo '<option value="'.$listOfMan[$i].'">';
										echo $listOfMan[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
							echo '<td>';
								echo '<select id="selItem" value="" name="man3">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfMan); $i++){
										
										echo '<option value="'.$listOfMan[$i].'">';
										echo $listOfMan[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
						?>
					</tr>
					<tr>
						<th align="left">Unit2</th>
						<?php
							$listOfMan = $dormManager->retrieveStaff('maintenance');
							echo '<td>';
								echo '<select id="selItem" value="" name=man4">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfMan); $i++){
										
										echo '<option value="'.$listOfMan[$i].'">';
										echo $listOfMan[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
							echo '<td>';
								echo '<select id="selItem" value="" name="man5">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfMan); $i++){
										
										echo '<option value="'.$listOfMan[$i].'">';
										echo $listOfMan[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
							echo '<td>';
								echo '<select id="selItem" value="" name="man6">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfMan); $i++){
										
										echo '<option value="'.$listOfMan[$i].'">';
										echo $listOfMan[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
						?>
					</tr>
					<tr>
						<th></th>
						<th colspan=4>Guard</th>
					</tr>
					<tr>
						<th align="left">East Gate</th>
						<?php
							$listOfGuard = $dormManager->retrieveStaff('guard');
							echo '<td>';
								echo '<select id="selItem" value="" name="g1">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfGuard); $i++){
										
										echo '<option value="'.$listOfGuard[$i].'">';
										echo $listOfGuard[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
							echo '<td>';
								echo '<select id="selItem" value="" name="g2">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfGuard); $i++){
										
										echo '<option value="'.$listOfGuard[$i].'">';
										echo $listOfGuard[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
							echo '<td>';
								echo '<select id="selItem" value="" name="g3">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfGuard); $i++){
										
										echo '<option value="'.$listOfGuard[$i].'">';
										echo $listOfGuard[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
						?>
					</tr>
					<tr>
						<th align="left">West Gate</th>
						<?php
							$listOfGuard = $dormManager->retrieveStaff('guard');
							echo '<td>';
								echo '<select id="selItem" value="" name="g4">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfGuard); $i++){
										
										echo '<option value="'.$listOfGuard[$i].'">';
										echo $listOfGuard[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
							echo '<td>';
								echo '<select id="selItem" value="" name="g5">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfGuard); $i++){
										
										echo '<option value="'.$listOfGuard[$i].'">';
										echo $listOfGuard[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
							echo '<td>';
								echo '<select id="selItem" value="" name="g6">';
									echo '<option value=NULL></option>';
									for($i=0; $i<count($listOfGuard); $i++){
										
										echo '<option value="'.$listOfGuard[$i].'">';
										echo $listOfGuard[$i];
										echo '</option>';
									}
								echo '</select>';
							echo '</td>';
						?>
					</tr>
					<tr>
						<td colspan=5 align="center">
						<?php
							
							if($_SESSION["day"]>0)
								echo '<input type="submit" name="prevSched" value="Previous"/>';
							
							if(isset($_POST["addSched"]) || $_SESSION["add"]==1){
								echo '<input type="submit" name="saveSched" value="Save"/>';
							}
							if(isset($_POST["editSched"]) || $_SESSION["edit"]==1){
								echo '<input type="submit" name="updateSched" value="Update"/>';
							}
							
							echo '<input type="submit" name="nextSched" value="Next"/>';
							
						?>
						</td>
					</tr>
			
			
					
					</table>
				</form>
					<div id="choose">
						<form name="chooseFrom" action="sched.php" method="post">
							<?php
								if($_SESSION["add"]==0)
									echo '<input type="submit" name="addSched" value="Add Sched"/>';
								if($_SESSION["edit"]==0)
									echo '<input type="submit" name="editSched" value="Edit Sched"/>';
								if($_SESSION["view"]==0)
									echo '<input type="submit" name="viewSched" value="View Sched"/>';
							?>
	
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
