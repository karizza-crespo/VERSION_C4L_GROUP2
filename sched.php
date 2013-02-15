<?php
	session_start();

	include("functions.php");
	
	$dormManager=new databaseManager;
	
	//-------------------------------------------------------------------------kuya e2 po yung dinagdag ko-------------------------------------------------------------------------
	//dito po check kung anu klase yung user, kapag hindi dorm manager or admin, disabled yung add and update sched
	//tpos kapag hindi nakalog in, babalik sa log in page
	if($_SESSION['accountType']=='notLoggedIn')
	{
		header('Location: signin.php');
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
	
<<<<<<< HEAD
=======
	if(!isset($_SESSION["day"]))
		$_SESSION["day"]=0;
	
>>>>>>> fd5935510e3342ff30b9960f409296519d5e59a2
	$_SESSION["view"]=1;
	
	//creating checker arrays 
	//used for inserting information to the database
	if(!isset($_SESSION["dmarray"])){
		$_SESSION["dmarray"] = array(
			array(0,0,0),//currentday
			array(0,0,0),//currentday+1
			array(0,0,0),//currentday+2
			array(0,0,0),//currentday+3
			array(0,0,0),//currentday+4
			array(0,0,0),//currentday+5
			array(0,0,0)//currentday+6
		);
		
	}
	if(!isset($_SESSION["manarray"])){
		$_SESSION["manarray"]=array(
			array(0,0,0,0,0,0),
			array(0,0,0,0,0,0),
			array(0,0,0,0,0,0),
			array(0,0,0,0,0,0),
			array(0,0,0,0,0,0),
			array(0,0,0,0,0,0),
			array(0,0,0,0,0,0)
			
		);
	}
	if(!isset($_SESSION["garray"])){
		$_SESSION["garray"]=array(
			array(0,0,0,0,0,0),
			array(0,0,0,0,0,0),
			array(0,0,0,0,0,0),
			array(0,0,0,0,0,0),
			array(0,0,0,0,0,0),
			array(0,0,0,0,0,0),
			array(0,0,0,0,0,0)
			
		);
	}
	
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
	
	//start the viewing session from the present day
	if(isset($_POST["viewSched"])){
		//triggers
		$_SESSION["day"]=0;
		$_SESSION["edit"]=0;
		$_SESSION["add"]=0;
		$_SESSION["view"]=1;
	}
	
	//for 7 days only
	if($_SESSION["day"]>6)
		$_SESSION["day"]=0;
	
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
	
	
	//once no more viewing and in adding info
	if(isset($_POST["saveSched"])){
		
		//triggers
		$_SESSION["view"]=0;
		$_SESSION["edit"]=0;
		
		
		$dayToSee=$_SESSION["day"];
		
		$d=array();
		$m=array();
		$g=array();
		
		for($i=1 ; $i<4 ; $i++){
			//checks if there is already set dorm manager for the specified slot
			if($_SESSION["dmarray"][$dayToSee][$i-1]==0){
				//checks if not null or not chosen any of the options
				if($_POST["dm$i"]!=" " ){
<<<<<<< HEAD
					//set the sched id if not yet set or greater than 106 entries
					if(!isset($_SESSION["schedid"]) || $_SESSION["schedid"]>=1106)
						$_SESSION["schedid"]=1001;
					else $_SESSION["schedid"]++;
					
					$schedid=$_SESSION["schedid"];
=======
					
					
					$schedid=1001 + $dormManager->countSchedEntry();
>>>>>>> fd5935510e3342ff30b9960f409296519d5e59a2
				
					//get the staff number of the chosen staff
					$dmname=$_POST["dm$i"];
					$stmt="SELECT staff_number from staff where name like '$dmname';";
					$result= pg_query($stmt);
					$a = pg_fetch_array($result);
					$d[$i-1]=$a[0];
		
					//sets the time schedule since there are 3 time slots
					if($i==1){
						$time='22:00';
					}
					if($i==2){
						$time='06:00';
					}
					if($i==3){
						$time='14:00';
					}
					
					
					
					//add to the database
					$check = $dormManager->addScheduleEntry($schedid,$dayToSee,$time,'informationarea',$d[$i-1]);
					if($check==1){
						echo "Added Succesfully";
						$_SESSION["dmarray"][$dayToSee][$i-1]=1;//updates the dorm manager checker array
					}else echo "Error";
					
				}
			}
		}
		
		//same with the dorm manager
		for($i=1 ; $i<7 ; $i++){
			if($_SESSION["manarray"][$dayToSee][$i-1]==0){
				if($_POST["man$i"]!=" "){
<<<<<<< HEAD
					
					if(!isset($_SESSION["schedid"]))
						$_SESSION["schedid"]=1001;
					else $_SESSION["schedid"]++;
			
					$schedid=$_SESSION["schedid"];
=======
			
					$schedid=1001 + $dormManager->countSchedEntry();
>>>>>>> fd5935510e3342ff30b9960f409296519d5e59a2
				
					$mname=$_POST["man$i"];
					$stmt="SELECT staff_number from staff where name like '$mname';";
					$result= pg_query($stmt);
					$a = pg_fetch_array($result);
					$m[$i-1]=$a[0];
					
					//since there are 6 slots, 2 location* 3 time slots
					if($i==1 || $i==4){
						$time='22:00';
					}
					if($i==2 || $i==5){
						$time='06:00';
					}
					if($i==3 || $i==6){
						$time='14:00';
					}
					
					
					
					
					//checks for the location
					if($i>3)
						$check = $dormManager->addScheduleEntry($schedid,$dayToSee,$time,'unit2',$m[$i-1]);
					else $check = $dormManager->addScheduleEntry($schedid,$dayToSee,$time,'unit1',$m[$i-1]);
					
					if($check==1){
						echo "Added Succesfully";
						$_SESSION["manarray"][$dayToSee][$i-1]=1;
					}else echo "Error";
				}
			}
		}
		
		//same with the maintenance
		for($i=1 ; $i<7 ; $i++){
			if($_SESSION["garray"][$dayToSee][$i-1]==0){
				if($_POST["g$i"]!=" "){
<<<<<<< HEAD
				
					if(!isset($_SESSION["schedid"]))
						$_SESSION["schedid"]=1001;
					else $_SESSION["schedid"]++;
			
					$schedid=$_SESSION["schedid"];
=======
			
					$schedid=1001 + $dormManager->countSchedEntry();
>>>>>>> fd5935510e3342ff30b9960f409296519d5e59a2
				
					$gname=$_POST["g$i"];
					$stmt="SELECT staff_number from staff where name like '$gname';";
					$result= pg_query($stmt);
					$a = pg_fetch_array($result);
					$g[$i-1]=$a[0];
<<<<<<< HEAD
					echo $g[$i-1];
=======
>>>>>>> fd5935510e3342ff30b9960f409296519d5e59a2
					
					if($i==1  || $i==4){
						$time='22:00';
					}
					if($i==2 || $i==5){
						$time='06:00';
					}
					if($i==3  || $i==6){
						$time='14:00';
					}
					
					
					
					if($i>3)
						$check = $dormManager->addScheduleEntry($schedid,$dayToSee,$time,'westgate',$g[$i-1]);
					else $check = $dormManager->addScheduleEntry($schedid,$dayToSee,$time,'eastgate',$g[$i-1]);
					if($check==1){
						echo "Added Succesfully";
						$_SESSION["garray"][$dayToSee][$i-1]=1;
					}else echo "Error";
				}
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
										echo '<select id="selItem"  name="dm1">';
											echo '<option selected="true" value=" "></option>';
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
										echo '<select id="selItem"  name="dm2">';
											echo '<option selected="true" value=" "></option>';
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
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'14:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'14:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem"  name="dm3">';
											echo '<option selected="true" value=" "></option>';
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
										echo '<select id="selItem"  name="man1">';
										echo '<option selected="true" value=" "></option>';
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
										echo '<select id="selItem"  name="man2">';
										echo '<option selected="true" value=" "></option>';
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
									$printName=$dormManager->retrieveStafffromSched('unit1',$dayToSee,'14:00:00');
									//if($printName!=0)
										echo $printName; 
								}else
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit1',$dayToSee,'14:00:00');
									if($printName!=NULL)
										echo $printName;
									else {
										echo '<select id="selItem"  name="man3">';
										echo '<option selected="true" value=" "></option>';
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
										echo '<select id="selItem"  name="man4">';
										echo '<option selected="true" value=" "></option>';
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
										echo '<select id="selItem"  name="man5">';
										echo '<option selected="true" value=" "></option>';
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
									$printName=$dormManager->retrieveStafffromSched('unit2',$dayToSee,'14:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit2',$dayToSee,'14:00:00');
									if($printName!=NULL)
										echo $printName;
									else {
										echo '<select id="selItem"  name="man6">';
										echo '<option selected="true" value=" "></option>';
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
										echo '<select id="selItem"  name="g1">';
											echo '<option selected="true" value=" "></option>';
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
										echo '<select id="selItem"  name="g2">';
											echo '<option selected="true" value=" "></option>';
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
									$printName=$dormManager->retrieveStafffromSched('eastgate',$dayToSee,'14:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('eastgate',$dayToSee,'14:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem"  name="g3">';
											echo '<option selected="true" value=" "></option>';
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
										echo '<select id="selItem"  name="g4">';
											echo '<option selected="true" value=" "></option>';
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
										echo '<select id="selItem"  name="g5">';
											echo '<option selected="true" value=" "></option>';
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
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'14:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'14:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem"  name="g6">';
											echo '<option selected="true" value=" "></option>';
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
								//yung $disable po na variable, pang disable ng button, kapag dormer and staff yung nakalog in, $disable = "disabled=true" kapag admin tsaka dorm manager $disable = null
<<<<<<< HEAD
								if($_SESSION["add"]==0)
									echo "<input type='submit' name='addSched' value='Add Sched' $disable/>";
								if($_SESSION["edit"]==0)
									echo "<input type='submit' name='editSched' value='Edit Sched' $disable/>";
								if($_SESSION["view"]==0)
									echo "<input type='submit' name='viewSched' value='View Sched' $disable/>";
=======
								if($_SESSION["add"]==0){
									if($disable=="null")
										echo "<input type='submit' name='addSched' value='Add Sched' />";
								}
								if($_SESSION["edit"]==0){
									if($disable=="null")
										echo "<input type='submit' name='editSched' value='Edit Sched'/>";
								}
								if($_SESSION["view"]==0){
									if($disable=="null")
										echo "<input type='submit' name='viewSched' value='View Sched'/>";
								}
>>>>>>> fd5935510e3342ff30b9960f409296519d5e59a2
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
