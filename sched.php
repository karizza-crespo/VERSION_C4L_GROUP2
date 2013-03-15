<?php
	session_start();

	include("functions.php");
	
	$dormManager=new databaseManager;
	
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
	
	//sets the value of the day to view, add,edit and delete from the schedule
	if(!isset($_SESSION["day"]))
		$_SESSION["day"]=0;
	
	//sets view as default session
	$_SESSION["view"]=1;

	//if session add,edit,delete are not yet set
	if(!isset($_SESSION["add"]))
		$_SESSION["add"]=0;
	if(!isset($_SESSION["edit"]))
		$_SESSION["edit"]=0;
	if(!isset($_SESSION["delete"]))
		$_SESSION["delete"]=0;
	if(!isset($_SESSION["d"])) //in deleting per day
		$_SESSION["d"]=0;

	//if add sched is clicked
	if(isset($_POST["addSched"]) || $_SESSION["add"]==1){
		//triggers: add-on, the rest off
		$_SESSION["add"]=1;
		$_SESSION["edit"]=0;
		$_SESSION["view"]=0;
		$_SESSION["delete"]=0;
	}
		
	//if edit is clicked
	if(isset($_POST["editSched"]) || $_SESSION["edit"]==1){
		//triggers: edit-on, rest off
		$_SESSION["edit"]=1;
		$_SESSION["add"]=0;
		$_SESSION["view"]=0;
		$_SESSION["delete"]=0;
	}
	
	//if delete is clicked
	if(isset($_POST["deleteSched"]) || $_SESSION["delete"]==1){
		//triggers: delete-on, the rest off
		$_SESSION["edit"]=0;
		$_SESSION["add"]=0;
		$_SESSION["view"]=0;
		$_SESSION["delete"]=1;
	}
	
	//if view is clicked start the viewing session from the present day
	if(isset($_POST["viewSched"])){
		//triggers: view-on, the rest off
		$_SESSION["day"]=0;
		$_SESSION["edit"]=0;
		$_SESSION["add"]=0;
		$_SESSION["delete"]=0;
		$_SESSION["view"]=1;
	}

	
	//checks for every session if it is add,edit or view
	//trigger session if one is being used
	//for viewing the next schedule for a week
	if(isset($_POST["nextSched"])){
		if($_SESSION["add"]==1){
			$_SESSION["view"]=0;
			$_SESSION["edit"]=0;
			$_SESSION["delete"]=0;
		}
		if($_SESSION["edit"]==1){
			$_SESSION["view"]=0;
			$_SESSION["add"]=0;
			$_SESSION["delete"]=0;
		}
		if($_SESSION["delete"]==1){
			$_SESSION["view"]=0;
			$_SESSION["edit"]=0;
			$_SESSION["add"]=0;
		}
		if($_SESSION["view"]==1){
			$_SESSION["add"]=0;
			$_SESSION["edit"]=0;
			$_SESSION["delete"]=0;
		}
		
		$_SESSION["day"]++;//increase the day
	}
	
	//for 7 days only
	if($_SESSION["day"]>6)
		$_SESSION["day"]=0;
	
	//for viewing the previous schedules

	//still make sure that the session is still set
	if(isset($_POST["prevSched"])){
		if($_SESSION["add"]==1){
			$_SESSION["view"]=0;
			$_SESSION["edit"]=0;
			$_SESSION["delete"]=0;
		}
		if($_SESSION["edit"]==1){
			$_SESSION["view"]=0;
			$_SESSION["add"]=0;
			$_SESSION["delete"]=0;
		}
		if($_SESSION["delete"]==1){
			$_SESSION["add"]=0;
			$_SESSION["edit"]=0;
			$_SESSION["view"]=0;
		}
		if($_SESSION["view"]==1){
			$_SESSION["add"]=0;
			$_SESSION["edit"]=0;
			$_SESSION["delete"]=0;
		}
		
		$_SESSION["day"]--;//decrease the day
	}
	
	
	
	$dayToSee=$_SESSION["day"];
	//used for inserting information to the database
	//creating a new week if first time and if the
	//current day is greater than the last date
	//of the previous week or latest week

	//creates a new checker for the week
	$wCount=$dormManager->countWeek();

	if($wCount==0){
		$dormManager->addWeek(1);//first week
	}else{
		$dormManager->checkAddWeek($wCount,$dayToSee);//week next
	}
	
	
	
	$addSuccess=0;
	$editSuccess=0;
	
	//week where the schedule belongs
	$week = $dormManager->whichWeek($dayToSee);
	//index whick to update when adding entry to the schedule
	$index = $dormManager->whichIndex($dayToSee,$week);
	
	
	//once no more viewing
	//when in add session and save is clicked
	if(isset($_POST["saveSched"])){
		
		//make sure other triggers are off
		$_SESSION["view"]=0;
		$_SESSION["edit"]=0;
		$_SESSION["delete"]=0;
		
		$d=array();//array for getting the posted dorm manager
		$m=array();//for maintenance
		$g=array();//and for the guard
		
		//week the schdule belongs
		$week = $dormManager->whichWeek($dayToSee);
		//index of the entry to be updated
		$index = $dormManager->whichIndex($dayToSee,$week);
		
		for($i=1 ; $i<4 ; $i++){
			//checks if there is already set dorm manager for the specified slot
			$dm="dm$i";
			$checkStaff=$dormManager->checkIfThereIs($dm,$index,$week);
			
			//if none
			if($checkStaff==0){
				//checks if not null or not chosen any of the options
				if($_POST["dm$i"]!=" " ){
					//if there is no entry yet in the schedule table
					if($dormManager->countSchedEntry()==0)
						$schedid=1001;
					else $schedid=$dormManager->lastSchedEntry() + 1;//if there is just add 1 from the last schedule id entered
					
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
						

						$dormManager->updateCheck($dm,$index,$week,$d[$i-1]);//updates the dorm manager checker array
					}
				}
			}
		}
		
		//same with the dorm manager
		for($i=1 ; $i<7 ; $i++){
			$man="man$i";
			$checkStaff=$dormManager->checkIfThereIs($man,$index,$week);
			
			if($checkStaff==0){
				if($_POST["man$i"]!=" "){
			
					if($dormManager->countSchedEntry()==0)
						$schedid=1001;
					else $schedid=$dormManager->lastSchedEntry() + 1;
				
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
						$dormManager->updateCheck($man,$index,$week,$m[$i-1]);
					}
				}
			}
		}
		
		//same with the maintenance
		for($i=1 ; $i<7 ; $i++){
			$guard="guard$i";
			$checkStaff=$dormManager->checkIfThereIs($guard,$index,$week);
			
			if($checkStaff==0){
				if($_POST["g$i"]!=" "){
			
					if($dormManager->countSchedEntry()==0)
						$schedid=1001;
					else $schedid=$dormManager->lastSchedEntry() + 1;
				
					$gname=$_POST["g$i"];
					$stmt="SELECT staff_number from staff where name like '$gname';";
					$result= pg_query($stmt);
					$a = pg_fetch_array($result);
					$g[$i-1]=$a[0];
					
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
						$dormManager->updateCheck($guard,$index,$week,$g[$i-1]);
					}
				}
			}
		}
			
	}
	
	//for updating info
	//same as saving info
	if(isset($_POST["updateSched"])){
		$_SESSION["view"]=0;
		$_SESSION["add"]=0;
		$_SESSION["delete"]=0;
		
		//week the schdule belongs
		$week = $dormManager->whichWeek($dayToSee);
		//index of the entry to be updated
		$index = $dormManager->whichIndex($dayToSee,$week);
		
		for($i=1 ; $i<4 ; $i++)
		{
			if(isset($_POST["dm$i"])){
				$dm="dm$i";
				//get the staff number of the chosen staff
				$dmname=$_POST["dm$i"];
				$stmt="SELECT staff_number from staff where name like '$dmname';";
				$result= pg_query($stmt);
				$a = pg_fetch_array($result);
	
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
				$check = $dormManager->updateStaffSchedule($dm,$index,$week,$a[0],'informationarea',$dayToSee,$time);				
			}
		}
		
		//same with the dorm manager
		for($i=1 ; $i<7 ; $i++){
			if(isset($_POST["man$i"])){
				$man="man$i";
				$mname=$_POST["man$i"];
				$stmt="SELECT staff_number from staff where name like '$mname';";
				$result= pg_query($stmt);
				$a = pg_fetch_array($result);
				
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
					$check = $dormManager->updateStaffSchedule($man,$index,$week,$a[0],'unit2',$dayToSee,$time);
				else $check = $dormManager->updateStaffSchedule($man,$index,$week,$a[0],'unit1',$dayToSee,$time);
			}
		}
		
		//same with the maintenance
		for($i=1 ; $i<7 ; $i++){
			if(isset($_POST["g$i"])){
				$guard="guard$i";
				$gname=$_POST["g$i"];
				$stmt="SELECT staff_number from staff where name like '$gname';";
				$result= pg_query($stmt);
				$a = pg_fetch_array($result);
				
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
					$check = $dormManager->updateStaffSchedule($guard,$index,$week,$a[0],'westgate',$dayToSee,$time);
				else $check = $dormManager->updateStaffSchedule($guard,$index,$week,$a[0],'eastgate',$dayToSee,$time);
			}
		}
	}
	
	//when delete is clicked
	if(isset($_POST["delete"])){
		$_SESSION["add"]=0;
		$_SESSION["edit"]=0;
		$_SESSION["view"]=0;
		
		
		$week = $dormManager->whichWeek($dayToSee);
		$index = $dormManager->whichIndex($dayToSee,$week);

		//deletes schedule per week
		$dormManager->deleteSchedule($dayToSee,$index);
	}

?>
<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="js/toast/resources/css/jquery.toastmessage.css" />
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/toast/javascript/jquery.toastmessage.js"></script>
		<script src="js/script.js"></script>
		<script type="text/javascript"> 
			
			function confirmDelete(){
				var prompt = confirm("Are you sure you want to delete the schedule for this day?");
				if(prompt){
					var prompt2 = confirm("Are you really sure you want delete?");
					return prompt2;
				}else return prompt;
			}
			
			function confirmEdit(){
				var prompt = confirm("Are you sure you want to apply the change(s) you made?");
				return prompt;
			}
			function checkSelect()
			{
				var i;
				var target=document.getElementsByTagName('select');
				var a = false;
				for(i=0; i<target.length; i++)
				{
					if(target[i].value!=" "){
						a = true;
						break;
					}
				}
				return a;
			}
			
			function confirmAdd(){
				if(checkSelect()){
					var prompt = confirm("Are you sure you want to add these person(s) to their respected schedules?");
					if(prompt){
						var prompt2 = confirm("Are you really sure you want to add these person(s)?");
						return prompt2;
					}else return prompt;
				}
			}
			
		</script>
	
	</head>
	<body>
		<div id="container">
			<br />
			<br />
			<div id="body">
				<?php
					//depending on the session, onsubmit changes
					if($_SESSION["view"]==1)
						echo '<form name="sched" action="sched.php" method="post">';
					if($_SESSION["add"]==1)
						echo '<form name="sched" action="sched.php" method="post" onsubmit="return confirmAdd()">';
					if($_SESSION["edit"]==1)
						echo '<form name="sched" action="sched.php" method="post" onsubmit="return confirmEdit()">';
					if($_SESSION["delete"]==1)
						echo '<form name="sched" action="sched.php" method="post" onsubmit="return confirmDelete()">';
				?>
				
					<table width="100%" border='1'>
					<?php
						$dayToSee=$_SESSION["day"];//show the header for the day
						$dormManager->printSchedule($dayToSee);
					?>
					
					
					<tr>
						<!--time slot-->
						<th class="schedTable"></th>
						<th class="schedTable">10pm - 6am</th>
						<th class="schedTable">6am - 2pm</th>
						<th class="schedTable">2pm - 10pm</th>
					</tr>
					<tr>
						<th class="schedTable" align="left">Dorm Manager</th>
						<?php
							//list of dorm managers
							$listOfDormMan = $dormManager->retrieveStaff('Dorm Manager');
							
							echo '<td align="center">';
								//if session set is view or delete
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
									//displays the name set the specified slot
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'22:00:00');
									//if($printName!=0)
										echo $printName;
								}
								//if session set is add
								if($_SESSION["add"]==1){
									//displays the name if there is already assigned person to the slot
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'22:00:00');
									if($printName!=NULL)
										echo $printName;
									else{//if none, shows a dropdown of options from the list of dorm managers
										echo '<select id="selItem"   name="dm1">';
											//default is " " used for posting info
											echo '<option selected="true" value=" "></option>';
											for($i=0; $i<count($listOfDormMan); $i++){
												//name of the dorm manger to choose from
												echo '<option  value="'.$listOfDormMan[$i].'">';
												echo $listOfDormMan[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								//if session set is edit
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'22:00:00');
									if($printName!=NULL){
										//dropdown options
										//default is the one already set on the specified slot
										//can't set to null or " "
										//only those slots with already added entry can be edited
										echo '<select id="selItem"  name="dm1">';
											for($i=0; $i<count($listOfDormMan); $i++){
												if($printName==$listOfDormMan[$i])
													echo '<option selected="true" value="'.$listOfDormMan[$i].'">';
												else
													echo '<option value="'.$listOfDormMan[$i].'">';
												echo $listOfDormMan[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								
							echo '</td>';
							//----------------------------------------------------------------------
							//same for the other slots just changes the list if maintenance or guard
							//----------------------------------------------------------------------
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
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
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'06:00:00');
									if($printName!=NULL){
										echo '<select id="selItem"  name="dm2">';
											for($i=0; $i<count($listOfDormMan); $i++){
												if($printName==$listOfDormMan[$i])
													echo '<option selected="true" value="'.$listOfDormMan[$i].'">';
												else
													echo '<option value="'.$listOfDormMan[$i].'">';
												echo $listOfDormMan[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
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
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('informationarea',$dayToSee,'14:00:00');
									if($printName!=NULL){
										echo '<select id="selItem"  name="dm3">';
											for($i=0; $i<count($listOfDormMan); $i++){
												if($printName==$listOfDormMan[$i])
													echo '<option selected="true" value="'.$listOfDormMan[$i].'">';
												else
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
						<th class="schedTable"></th>
						 <th class="schedTable" colspan=4>Maintenance</th>
					</tr>
					<tr>
						<th class="schedTable" align="left">Unit1</th>
						<?php
							$listOfMan = $dormManager->retrieveStaff('Maintenance');
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
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
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit1',$dayToSee,'22:00:00');
									if($printName!=NULL){
										echo '<select id="selItem"  name="man1">';
											for($i=0; $i<count($listOfMan); $i++){
												if($printName==$listOfMan[$i])
													echo '<option selected="true" value="'.$listOfMan[$i].'">';
												else
													echo '<option value="'.$listOfMan[$i].'">';
												echo $listOfMan[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
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
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit1',$dayToSee,'06:00:00');
									if($printName!=NULL){
										echo '<select id="selItem" name="man2">';
											for($i=0; $i<count($listOfMan); $i++){
												if($printName==$listOfMan[$i])
													echo '<option selected="true" value="'.$listOfMan[$i].'">';
												else
													echo '<option value="'.$listOfMan[$i].'">';
												echo $listOfMan[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit1',$dayToSee,'14:00:00');
									//if($printName!=0)
										echo $printName; 
								}
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
								if($_SESSION["edit"]==1){
								$printName=$dormManager->retrieveStafffromSched('unit1',$dayToSee,'14:00:00');
									if($printName!=NULL){
										echo '<select id="selItem"  name="man3">';
											for($i=0; $i<count($listOfMan); $i++){
												if($printName==$listOfMan[$i])
													echo '<option selected="true" value="'.$listOfMan[$i].'">';
												else
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
						<th class="schedTable" align="left">Unit2</th>
						<?php
							$listOfMan = $dormManager->retrieveStaff('Maintenance');
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
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
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit2',$dayToSee,'22:00:00');
									if($printName!=NULL){
										echo '<select id="selItem"  name="man4">';
											for($i=0; $i<count($listOfMan); $i++){
												if($printName==$listOfMan[$i])
													echo '<option selected="true" value="'.$listOfMan[$i].'">';
												else
													echo '<option value="'.$listOfMan[$i].'">';
												echo $listOfMan[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
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
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit2',$dayToSee,'06:00:00');
									if($printName!=NULL){
										echo '<select id="selItem"  name="man5">';
											for($i=0; $i<count($listOfMan); $i++){
												if($printName==$listOfMan[$i])
													echo '<option selected="true" value="'.$listOfMan[$i].'">';
												else
													echo '<option value="'.$listOfMan[$i].'">';
												echo $listOfMan[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
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
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('unit2',$dayToSee,'14:00:00');
									if($printName!=NULL){
										echo '<select id="selItem"  name="man6">';
											for($i=0; $i<count($listOfMan); $i++){
												if($printName==$listOfMan[$i])
													echo '<option selected="true" value="'.$listOfMan[$i].'">';
												else
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
						<th class="schedTable"></th>
						 <th class="schedTable" colspan=4>Guard</th>
					</tr>
					<tr>
						<th class="schedTable" align="left">East Gate</th>
						<?php
							$listOfGuard = $dormManager->retrieveStaff('Guard');
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
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
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('eastgate',$dayToSee,'22:00:00');
									if($printName!=NULL){
										echo '<select id="selItem" name="g1">';
											for($i=0; $i<count($listOfGuard); $i++){
												if($printName==$listOfGuard[$i])
													echo '<option selected="true" value="'.$listOfGuard[$i].'">';
												else
													echo '<option value="'.$listOfGuard[$i].'">';
												echo $listOfGuard[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
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
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('eastgate',$dayToSee,'06:00:00');
									if($printName!=NULL){
										echo '<select id="selItem"  name="g2">';
											for($i=0; $i<count($listOfGuard); $i++){
												if($printName==$listOfGuard[$i])
													echo '<option selected="true" value="'.$listOfGuard[$i].'">';
												else
													echo '<option value="'.$listOfGuard[$i].'">';
												echo $listOfGuard[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
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
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('eastgate',$dayToSee,'14:00:00');
									if($printName!=NULL){
										echo '<select id="selItem"  name="g3">';
											for($i=0; $i<count($listOfGuard); $i++){
												if($printName==$listOfGuard[$i])
													echo '<option selected="true" value="'.$listOfGuard[$i].'">';
												else
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
						<th class="schedTable" align="left">West Gate</th>
						<?php
							$listOfGuard = $dormManager->retrieveStaff('Guard');
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
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
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'22:00:00');
									if($printName!=NULL){
										echo '<select id="selItem"  name="g4">';
											for($i=0; $i<count($listOfGuard); $i++){
												if($printName==$listOfGuard[$i])
													echo '<option selected="true" value="'.$listOfGuard[$i].'">';
												else
													echo '<option value="'.$listOfGuard[$i].'">';
												echo $listOfGuard[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'06:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'06:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem"   name="g5">';
											echo '<option selected="true" value=" "></option>';
											for($i=0; $i<count($listOfGuard); $i++){
												
												echo '<option value="'.$listOfGuard[$i].'">';
												echo $listOfGuard[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'06:00:00');
									if($printName!=NULL){
										echo '<select id="selItem"  name="g5">';
											for($i=0; $i<count($listOfGuard); $i++){
												if($printName==$listOfGuard[$i])
													echo '<option selected="true" value="'.$listOfGuard[$i].'">';
												else
													echo '<option value="'.$listOfGuard[$i].'">';
												echo $listOfGuard[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
							echo '</td>';
							echo '<td align="center">';
								if($_SESSION["view"]==1 || $_SESSION["delete"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'14:00:00');
									//if($printName!=0)
										echo $printName; 
								}
								if($_SESSION["add"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'14:00:00');
									if($printName!=NULL)
										echo $printName;
									else{
										echo '<select id="selItem"   name="g6">';
											echo '<option selected="true" value=" "></option>';
											for($i=0; $i<count($listOfGuard); $i++){
												
												echo '<option value="'.$listOfGuard[$i].'">';
												echo $listOfGuard[$i];
												echo '</option>';
											}
										echo '</select>';
									}
								}
								if($_SESSION["edit"]==1){
									$printName=$dormManager->retrieveStafffromSched('westgate',$dayToSee,'14:00:00');
									if($printName!=NULL){
										echo '<select id="selItem"  name="g6">';
											for($i=0; $i<count($listOfGuard); $i++){
												if($printName==$listOfGuard[$i])
													echo '<option selected="true" value="'.$listOfGuard[$i].'">';
												else
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
					
						<?php
						
							if(isset($_POST["addSched"]) || $_SESSION["add"]==1){
								echo '<tr><td colspan=5 align="center">';
								if($dormManager->countSchedEntryForDay($dayToSee)==15)
									echo '<input type="submit"   name="saveSched" value="Save"  disabled/>';
								else{
									echo '<input type="submit"  id="save"  name="saveSched" value="Save"/>';
								}
								echo '</td></tr>';
							}
							if(isset($_POST["editSched"]) || $_SESSION["edit"]==1){
								echo '<tr><td colspan=5 align="center">';
								echo '<input type="submit" name="updateSched" value="Update"/>';
								echo '</td></tr>';
							}
							if(isset($_POST["deleteSched"]) || $_SESSION["delete"]==1){
								echo '<tr><td colspan=5 align="center">';
								if($dormManager->countSchedEntryForDay($dayToSee)==0)
									echo '<input type="submit" name="delete" value="Delete" disabled />';
								else echo '<input type="submit" name="delete" value="Delete" />';
								echo '</td></tr>';
							}
							echo '</form>';
						
							echo '<form name="sched" action="sched.php" method="post">';
							echo '<tr><td colspan=5  align="center">';
								if($_SESSION["day"]>0)
									echo '<input type="submit" name="prevSched" value="Previous"/>';
								if($_SESSION["day"]<6)
									echo '<input  type="submit" name="nextSched" value="Next"/>';
							echo '</td></tr>';
							echo '</form>';
						?>
					</table>
					<div id="choose">
						<form name="chooseFrom" action="sched.php" method="post">
							<?php
								//yung $disable po na variable, pang disable ng button, kapag dormer and staff yung nakalog in, $disable = "disabled=true" kapag admin tsaka dorm manager $disable = null
								echo "<br /><center>";
								if($_SESSION["add"]==0){
									if($disable=="null")
										echo "<input type='submit' class='schedButtons' name='addSched' value='Add Sched' />";
								}
								if($_SESSION["edit"]==0){
									if($disable=="null")
										echo "<input type='submit' class='schedButtons' name='editSched' value='Edit Sched'/>";
								}
								if($_SESSION["view"]==0){
									if($disable=="null")
										echo "<input type='submit' class='schedButtons' name='viewSched' value='View Sched'/>";
								}
								if($_SESSION["delete"]==0){
									if($disable=="null")
										echo "<input type='submit' class='schedButtons' name='deleteSched' value='Delete Sched'/>";
								echo "</center>";
								}
							?>
	
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
