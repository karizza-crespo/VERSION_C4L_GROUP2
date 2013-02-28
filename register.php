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
		<script src="js/script.js"></script>
	</head>

	<body onload="showhide()">

	<h1>REGISTRATION FORM</h1>
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
			$errors[] = 'username already exists';
		}else{	
			$stmt="SELECT count(*) FROM staff WHERE username='$username';";
			$count=pg_fetch_array(pg_query($stmt));
			
			if($count[0]!=0)
			$errors[] = 'username already exists';
		}	
		
		$studentnumber = $_POST['studentnumber'];
		$stmt="SELECT count(*) FROM dormer WHERE student_number='$studentnumber';";
		$count=pg_fetch_array(pg_query($stmt));
		
		if($count[0]!=0){
			$errors[] = 'student number already exists';
		}
		
		if($password == '' || $c_password == ''){
			$errors[] = 'Passwords are blank';
		}
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
					echo "Dormer successfully added.<br />";
				else
					echo "Failed to add Dormer.<br />";
			}
		
		
			if ($type == 2){
				//insert values into the table named staff
				$stafftype = $_POST['stafftype'];
				$stmt="INSERT INTO staff (name, address, contact_number, type, username, password) VALUES ('$default_char','$default_char','$default_char','$stafftype','$username','$password');";
				$success=pg_query($stmt);
				if($success)
					echo "Staff successfully added.<br />";
				else
					echo "Failed to add Staff.<br />";
			}
		}
	}
	?>
		<form method="post" action="">
			<?php
			if(count($errors) > 0){ //print list of errors
				echo '<ul>';
				foreach($errors as $e){
					echo '<li>' . $e . '</li>';
				}
				echo '</ul>';
			
			} 
			?>
			<table>
				<tr>
					<td>Username</td>
					<td> <input type="text" name="username" size="20" /></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="password" size="20" /></td>
				</tr>
				<tr>
					<td>Confirm Password</td>
					<td><input type="password" name="c_password" size="20" /></td>
				</tr>
				<tr>
					<td>Account Type</td>
					<td><input type="radio" name="type" id="dormer" value="1" checked="checked" onclick="showhide()"/><label for="dormer">DORMER</label>
					<input type="radio" name="type" id="staff" value="2" onclick="showhide()"/><label for="staff">STAFF</label></td>
				</tr>
				<tr>
					<td>
						<label id="roomnumberlabel" for='roomnumber'>Room Number: </label>
						<label id="stafftypelabel" for='stafftype'>Staff Type: </label>
					</td>
					<td>
						<input type="number" id="roomnumber" name="roomnumber" min="1" value='1'/>
						<select id='stafftype' name='stafftype'>
							<option value='Dorm Manager'>Dorm Manager</option>
							<option value='Maintenance'>Maintenance</option>
							<option value='Guard'>Guard</option>
						</select>
					</td>
				<tr>
					<td><label id="studentnumberlabel" for='studentnumber'>Student Number: </label></td>
					<td><input type='text' id='studentnumber' name='studentnumber' pattern='[0-9]{4}[-][0-9]{5}'/></td>
<<<<<<< HEAD
=======
				</tr>
					<td></td>
					<td></td>
>>>>>>> origin/master
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="register" class = "register" value="REGISTER" /></td>
				</tr>
			</table>
		</form>
		<br />
		<a href="admin_db.php" title="Back to Admin Home Page">Back to Admin Home Page </a></br>
	</body>
</html>
