<?php
	session_start();

	include("functions.php");
	
	$dormManager=new databaseManager;
	
	//-------------------------------------------------------------------------kuya e2 po yung dinagdag ko-------------------------------------------------------------------------
	//dito po check kung anu klase yung user, kapag hindi dorm manager or admin, disabled yung add and update sched
	//tpos kapag hindi nakalog in, babalik sa log in page
	if($_SESSION['accountType']=='notLoggedIn')
	{
		header('Location: login.php');
		die;
	}
	else
	{
		if($_SESSION['accountType']=='dormer')
			$disable = "disabled=true";
		else if($_SESSION['accountType']=='staff')
		{
			$stmt="SELECT type from staff WHERE username='".$_SESSION['username']."';";
			$result=pg_fetch_array(pg_query($stmt));
			
			if($result[0]!='Dorm Manager')
			{
				$disable = "disabled=true";
			}
			else
				$disable = "null";
		}
		else
			$disable = "null";
	}
	//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	
		$_SESSION["view"]=1;
	
	//checks for every session if it is add,edit or view
	//trigger session if one is being used
	//for viewing the next schedules
	if(isset($_POST["nextSched"])){
		if($_SESSION["add"]==1){
			$_SESSION["view"]=0;
			$_SESSION["edit"]=0;
		}
		if($_SESSION["edit"]==1){
			$_SESSION["view"]=0;
			$_SESSION["add"]=0;
		}
		if($_SESSION["view"]==1){
			$_SESSION["add"]=0;
			$_SESSION["edit"]=0;
		}
		$_SESSION["day"]++;//increase the day
	}
	
	//for viewing the previous schedules
	if(isset($_POST["prevSched"])){
		if($_SESSION["add"]==1){
			$_SESSION["view"]=0;
			$_SESSION["edit"]=0;
		}
		if($_SESSION["edit"]==1){
			$_SESSION["view"]=0;
			$_SESSION["add"]=0;
		}
		if($_SESSION["view"]==1){
			$_SESSION["add"]=0;
			$_SESSION["edit"]=0;
		}
		$_SESSION["day"]--;//decrease the day
	}
	
	
	
	//if add sched is clicked
	if(isset($_POST["addSched"])){
		//triggers
		$_SESSION["add"]=1;
		$_SESSION["edit"]=0;
		$_SESSION["view"]=0;
	}
		
	//if edit is clicked
	if(isset($_POST["editSched"])){
		//triggers
		$_SESSION["edit"]=1;
		$_SESSION["add"]=0;
		$_SESSION["view"]=0;
	}
	
	//start the viewing session from the present day
	if(isset($_POST["viewSched"])){
		//triggers
		$_SESSION["day"]=0;
		$_SESSION["edit"]=0;
		$_SESSION["add"]=0;
		$_SESSION["view"]=1;
	}

	//once no more viewing and in adding info
	if(isset($_POST["saveSched"])){
		
		//triggers
		$_SESSION["view"]=0;
		$_SESSION["edit"]=0;
		
		
		
		$d=array();
		$m=array();
		$g=array();
		
		for($i=1 ; $i<4 ; $i++){
			if($_POST["dm$i"]!=""){
				if(!isset($_SESSION["schedid"]) || $_SESSION["schedid"]>=1106)
					$_SESSION["schedid"]=1001;
				else $_SESSION["schedid"]++;
				
				$schedid=$_SESSION["schedid"];
			
			
				$dmname=$_POST["dm$i"];
				$stmt="SELECT staff_number from staff where name like '$dmname';";
				$result= pg_query($stmt);
				$a = pg_fetch_array($result);
				$d[$i-1]=$a[0];
	
	
				if($i==1){
					$time='22:00';
				}
				if($i==2){
					$time='06:00';
				}
				if($i==3){
					$time='14:00';
				}
				
				$dayToSee=$_SESSION["day"];
				$check = $dormManager->addScheduleEntry($schedid,$dayToSee,$time,'informationarea',$d[$i-1]);
				if($check==1)
					echo "Added Succesfully";
				else echo "Error";
				
			}
		}
		for($i=1 ; $i<7 ; $i++){
			if($_POST["man$i"]){
				
				if(!isset($_SESSION["schedid"]))
					$_SESSION["schedid"]=1001;
				else $_SESSION["schedid"]++;
		
				$schedid=$_SESSION["schedid"];
			
				$mname=$_POST["man$i"];
				$stmt="SELECT staff_number from staff where name like '$mname';";
				$result= pg_query($stmt);
				$a = pg_fetch_array($result);
				$m[$i-1]=$a[0];
				
				if($i==1){
					$time='22:00';
				}
				if($i==2){
					$time='06:00';
				}
				if($i==3){
					$time='14:00';
				}
				
				$dayToSee=$_SESSION["day"];
				$check = $dormManager->addScheduleEntry($schedid,$dayToSee,$time,'informationarea',$m[$i-1]);
				if($check==1)
					echo "Added Succesfully";
				else echo "Error";
			}
		}
		for($i=1 ; $i<7 ; $i++){
			if($_POST["g$i"]){
			
				if(!isset($_SESSION["schedid"]))
					$_SESSION["schedid"]=1001;
				else $_SESSION["schedid"]++;
		
				$schedid=$_SESSION["schedid"];
			
				$gname=$_POST["g$i"];
				$stmt="SELECT staff_number from staff where name like '$gname';";
				$result= pg_query($stmt);
				$a = pg_fetch_array($result);
				$g[$i-1]=$a[0];
				echo $g[$i-1];
				
				if($i==1){
					$time='22:00';
				}
				if($i==2){
					$time='06:00';
				}
				if($i==3){
					$time='14:00';
				}
				
				$dayToSee=$_SESSION["day"];
				$check = $dormManager->addScheduleEntry($schedid,$dayToSee,$time,'informationarea',$g[$i-1]);
				if($check==1)
					echo "Added Succesfully";
				else echo "Error";
			}
		}
			
	}
	
	//once no more viewing and in updating info
	if(isset($_POST["updateSched"])){
		$_SESSION["view"]=0;
		$_SESSION["add"]=0;
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
							
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'22:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'22:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem" value="" name="dm1">';
											echo '<option value=NULL></option>';
											for($i=0; $i<count($listOfDormMan); $i++){
												
												echo '<option value="'.$listOfDormMan[$i].'">';
												echo $listOfDormMan[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'06:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'06:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem" value="" name="dm2">';
											echo '<option value=NULL></option>';
											for($i=0; $i<count($listOfDormMan); $i++){
												
												echo '<option value="'.$listOfDormMan[$i].'">';
												echo $listOfDormMan[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'02:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'02:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem" value="" name="dm3">';
											echo '<option value=NULL></option>';
											for($i=0; $i<count($listOfDormMan); $i++){
												
												echo '<option value="'.$listOfDormMan[$i].'">';
												echo $listOfDormMan[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								
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
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit1',$dayToSee,'22:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit1',$dayToSee,'22:00:00');
									if($printName!=NULL)
										echo $printName;
									else {
										echo '<select id="selItem" value="" name="man1">';
										echo '<option value=NULL></option>';
										for($i=0; $i<count($listOfMan); $i++){
											
											echo '<option value="'.$listOfMan[$i].'">';
											echo $listOfMan[$i];
											echo '</option>';
										}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit1',$dayToSee,'06:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit1',$dayToSee,'06:00:00');
									if($printName!=NULL)
										echo $printName;
									else {
										echo '<select id="selItem" value="" name="man2">';
										echo '<option value=NULL></option>';
										for($i=0; $i<count($listOfMan); $i++){
											
											echo '<option value="'.$listOfMan[$i].'">';
											echo $listOfMan[$i];
											echo '</option>';
										}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit1',$dayToSee,'02:00:00');
									//if($printName!=0)
										echo $printName; 
								}else
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit1',$dayToSee,'02:00:00');
									if($printName!=NULL)
										echo $printName;
									else {
										echo '<select id="selItem" value="" name="man3">';
										echo '<option value=NULL></option>';
										for($i=0; $i<count($listOfMan); $i++){
											
											echo '<option value="'.$listOfMan[$i].'">';
											echo $listOfMan[$i];
											echo '</option>';
										}
										echo '</select>';
									}
								}
								
							echo '</td>';
						?>
					</tr>
					<tr>
						<th align="left">Unit2</th>
						<?php
							$listOfMan = $dormManager->retrieveStaff('maintenance');
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit2',$dayToSee,'22:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit2',$dayToSee,'22:00:00');
									if($printName!=NULL)
										echo $printName;
									else {
										echo '<select id="selItem" value="" name="man4">';
										echo '<option value=NULL></option>';
										for($i=0; $i<count($listOfMan); $i++){
											
											echo '<option value="'.$listOfMan[$i].'">';
											echo $listOfMan[$i];
											echo '</option>';
										}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit2',$dayToSee,'06:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit2',$dayToSee,'06:00:00');
									if($printName!=NULL)
										echo $printName;
									else {
										echo '<select id="selItem" value="" name="man5">';
										echo '<option value=NULL></option>';
										for($i=0; $i<count($listOfMan); $i++){
											
											echo '<option value="'.$listOfMan[$i].'">';
											echo $listOfMan[$i];
											echo '</option>';
										}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit2',$dayToSee,'02:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit2',$dayToSee,'02:00:00');
									if($printName!=NULL)
										echo $printName;
									else {
										echo '<select id="selItem" value="" name="man6">';
										echo '<option value=NULL></option>';
										for($i=0; $i<count($listOfMan); $i++){
											
											echo '<option value="'.$listOfMan[$i].'">';
											echo $listOfMan[$i];
											echo '</option>';
										}
										echo '</select>';
									}
								}
								
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
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('eastgate',$dayToSee,'22:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('eastgate',$dayToSee,'22:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem" value="" name="g1">';
											echo '<option value=NULL></option>';
											for($i=0; $i<count($listOfGuard); $i++){
												
												echo '<option value="'.$listOfGuard[$i].'">';
												echo $listOfGuard[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('eastgate',$dayToSee,'06:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('eastgate',$dayToSee,'06:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem" value="" name="g2">';
											echo '<option value=NULL></option>';
											for($i=0; $i<count($listOfGuard); $i++){
												
												echo '<option value="'.$listOfGuard[$i].'">';
												echo $listOfGuard[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('eastgate',$dayToSee,'02:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('eastgate',$dayToSee,'02:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem" value="" name="g3">';
											echo '<option value=NULL></option>';
											for($i=0; $i<count($listOfGuard); $i++){
												
												echo '<option value="'.$listOfGuard[$i].'">';
												echo $listOfGuard[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
							echo '</td>';
						?>
					</tr>
					<tr>
						<th align="left">West Gate</th>
						<?php
							$listOfGuard = $dormManager->retrieveStaff('guard');
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'22:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'22:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem" value="" name="g4">';
											echo '<option value=NULL></option>';
											for($i=0; $i<count($listOfGuard); $i++){
												
												echo '<option value="'.$listOfGuard[$i].'">';
												echo $listOfGuard[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'06:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'06:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem" value="" name="g5">';
											echo '<option value=NULL></option>';
											for($i=0; $i<count($listOfGuard); $i++){
												
												echo '<option value="'.$listOfGuard[$i].'">';
												echo $listOfGuard[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'02:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'02:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem" value="" name="g6">';
											echo '<option value=NULL></option>';
											for($i=0; $i<count($listOfGuard); $i++){
												
												echo '<option value="'.$listOfGuard[$i].'">';
												echo $listOfGuard[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
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
		<?php
		//link lang to pabalik sa dormer_db, staff_db or admin_db
		echo "<a href='".$_SESSION['accountType']."_db.php' Title='Back to ".$_SESSION['accountType']." Home Page'>Back to ".$_SESSION['accountType']." Home Page</a>";
		?>
	</body>
</html>
