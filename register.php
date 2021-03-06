<?php
include("functions.php");

session_start();
if($_SESSION['accountType']!='admin'){
	header('Location: signin.php');
	die;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>.::Dormitory Management System::.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="js/toast/resources/css/jquery.toastmessage.css" />
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/toast/javascript/jquery.toastmessage.js"></script>
		<script src="js/script.js"></script>
	</head>

	<body onload="showhide()">

	<center><h1>REGISTRATION FORM</h1></center>
	<?php
	$errors = array(); /*list array of errors*/
	$default_char = 'none';
	$default_int = 0;
	$default_date= '1950-01-01';

	if(isset($_POST['register'])){ /* get the name of the button that is inside the same php file*/
		$username = $_POST['username'];
		$password = $_POST['password'];
		$c_password = $_POST['c_password'];
		$type = $_POST['type'];
		
		//add to postgres case when username entered already exists 	
		if($username == ''){
			$errors[] = 'Username is blank';
		}
		
		$stmt="SELECT count(*) FROM dormer WHERE username='$username';";
		$count=pg_fetch_array(pg_query($stmt));
		
		if($count[0]!=0){
			$errors[] = 'Username already exists';
		}else{	
			$stmt="SELECT count(*) FROM staff WHERE username='$username';";
			$count=pg_fetch_array(pg_query($stmt));
			
			if($count[0]!=0)
			$errors[] = 'Username already exists';
		}	
		
		if($type==1)
		{
			//check if the room number entered is in the database
			$room_number = $_POST['roomnumber'];
			$stmt="SELECT count(*) FROM room WHERE room_number='$room_number';";
			$count=pg_fetch_array(pg_query($stmt));
			
			if($count[0]==0)
				$errors[] = 'Room Number does not exist';
			else
			{
				//check if the room is still available or not
				$stmt="SELECT count(*) FROM dormer WHERE room_number='$room_number';";
				$count=pg_fetch_array(pg_query($stmt));
				$stmt="SELECT slots FROM room WHERE room_number='$room_number';";
				$slots=pg_fetch_array(pg_query($stmt));
				
				$available = $slots[0]-$count[0];
				if($available==0)
					$errors[] = 'Room '.$room_number.' is already full';
			}
			
			//checks if the student number is already in the database
			$studentnumber = $_POST['studentnumber'];
			$stmt="SELECT count(*) FROM dormer WHERE student_number='$studentnumber';";
			$count=pg_fetch_array(pg_query($stmt));
			
			if($count[0]!=0){
				$errors[] = 'Student number already exists';
			}
		}
		
		//checks if the password fields are black
		if($password == '' || $c_password == ''){
			$errors[] = 'Passwords are blank';
		}
		//checks if the passwords match or don't
		if($password != $c_password){
			$errors[] = 'Passwords do not match';
		}
			
		if(count($errors) == 0){		
			 if ($type == 1){
				//insert values into the table named dormer
				$roomnumber = $_POST['roomnumber'];
				$stmt="INSERT INTO dormer VALUES ('$username', '$password','$default_char','$studentnumber','$default_char','$default_char','$default_date','$default_int','$default_char','$default_char','$default_char','$roomnumber');";
				$success=pg_query($stmt);
				if($success)
					echo "<span style='color:cyan; font-size:1.35em; font-weight:bold'><center>Dormer successfully added.</center></span><br /><br />";
				else
					echo "<span style='color:red; font-size:1.35em; font-weight:bold'><center>Failed to add Dormer.</center></span><br />";
			}
		
		
			if ($type == 2){
				//insert values into the table named staff
				$stafftype = $_POST['stafftype'];
				$stmt="INSERT INTO staff (name, address, contact_number, type, username, password) VALUES ('$default_char','$default_char','$default_char','$stafftype','$username','$password');";
				$success=pg_query($stmt);
				if($success)
					echo "<span style='color:cyan; font-size:1.35em; font-weight:bold'><center>Staff successfully added.</center></span><br /><br />";
				else
					echo "<span style='color:red; font-size:1.35em; font-weight:bold'><center>Failed to add Staff.</center></span><br />";
			}
		}
	}
	?>
		<form name="registerForm" onsubmit="return validateRegister()" method="post" action="">
			<?php
			if(count($errors) > 0){ //print list of errors
				echo "<span style='color:red; font-size:1.25em; font-weight:bold;'><ul class='listErrors'>";
				foreach($errors as $e){
					echo '<li>' . $e . '</li>';
				}
				echo '</ul></span>';
			
			} 
			?>
			<table class='registerForm'>
				<tr>
					<td><label for="username">Username:</label></td>
					<td> <input type="text" name="username" id="username" size="20" /></td>
				</tr>
				<tr>
					<td><label for="password">Password:</label></td>
					<td><input type="password" name="password" id="password" size="20" /></td>
				</tr>
				<tr>
					<td><label for="c_password">Confirm Password:</label></td>
					<td><input type="password" id="c_password" name="c_password" size="20" /></td>
				</tr>
				<tr>
					<td><label for="type">Account Type:</label></td>
					<td><input type="radio" name="type" id="dormer" value="1" checked="checked" onclick="showhide()"/><label for="dormer">DORMER</label>
					<input type="radio" name="type" id="staff" value="2" onclick="showhide()"/><label for="staff">STAFF</label></td>
				</tr>
				<tr>
					<td>
						<label id="studentnumberlabel" for='studentnumber'>Student Number:</label>
						<label id="stafftypelabel" for='stafftype'>Staff Type: </label>
					</td>
					<td>
						<input type='text' id='studentnumber' name='studentnumber' pattern='[0-9]{4}[-][0-9]{5}'/>
						<select id='stafftype' name='stafftype'>
							<option value='Dorm Manager'>Dorm Manager</option>
							<option value='Maintenance'>Maintenance</option>
							<option value='Guard'>Guard</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label id="roomnumberlabel" for='roomnumber'>Room Number: </label></td>
					<td><input type="number" id="roomnumber" name="roomnumber" min="1"/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="register" class = "register" value="REGISTER" /></td>
				</tr>
			</table>
		</form>
		<br />
	</body>
</html>
