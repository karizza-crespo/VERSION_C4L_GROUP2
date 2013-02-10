<?php 
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']!='dormer')
{
	header('Location: login.php');
	die;
}

?>

<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<?php
			if(isset($_POST["adddormerinfo"]))
			{
				$success=$manager->addDormerInformation($_SESSION['username'], $_POST["name"], $_POST["studentnumber"], $_POST["course"], $_POST["birthdate"], $_POST["age"], $_POST["homeaddress"], $_POST["contactnumber"], $_POST["contactperson"], $_POST["contactpersonnumber"]);
				
				if($success==1)
					echo "<h2>Information successfully added.</h2><br/>";
				else if ($success==3)
					echo "<span style='color:red'>Student Number already in the Database.</span><br /><br />";
				else
					echo "<span style='color:red'>Failed to Add Information.</span><br /><br />";
			}
		?>
		<form name="addDormerInformation" action="adddormerinformation.php" method="post">
			<table>
				<tr>
					<td><label for="name">Name: </label></td>
					<td><input type="text" id="name" name="name" maxlength="80"></td>
				</tr>
				<tr>
					<td><label for="studentnumber">Student Number: </label></td>
					<td><input type="text" id="studentnumber" name="studentnumber" pattern="[0-9]{4}[-][0-9]{5}"></td>
				</tr>
				<tr>
					<td><label for="course">Course: </label></td>
					<td><input type="text" id="course" name="course" pattern="[A-Za-z]{3,20}"></td>
				</tr>
				<tr>
					<td><label for="birthdate">Birthdate: </label></td>
					<td><input type="date" id="birthdate" name="birthdate"></td>
				</tr>
				<tr>
					<td><label for="age">Age: </label></td>
					<td><input type="text" id="age" name="age" pattern="[0-9]{1,3}"></td>
				</tr>
				<tr>
					<td><label for="homeaddress">Home Address: </label></td>
					<td><input type="text" id="homeaddress" name="homeaddress" maxlength="80"></td>
				</tr>
				<tr>
					<td><label for="contactnumber">Contact Number: </label></td>
					<td><input type="text" id="contactnumber" name="contactnumber" pattern="[0-9]{11}"></td>
				</tr>
				<tr>
					<td><label for="contactperson">Contact Person: </label></td>
					<td><input type="text" id="contactperson" name="contactperson" maxlength="80"></td>
				</tr>
				<tr>
					<td><label for="contactpersonnumber">Contact Person Number: </label></td>
					<td><input type="text" id="contactpersonnumber" name="contactpersonnumber" pattern="[0-9]{11}"></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" id="adddormerinfo" name="adddormerinfo" value="Add Information"></td>
				</tr>
			</table>
		</form>
		<br />
		<a href="dormer_db.php" title="Back to Dormer Home Page">Back to Dormer Home Page</a>
	</body>
</html>