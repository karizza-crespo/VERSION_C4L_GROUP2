<?php 
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']=='notLoggedIn')
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
			if(isset($_POST["addstaffinfo"]))
			{
				$success=$manager->addStaffInformation($_POST['staffnumber'], $_SESSION['username'], $_POST["name"], $_POST["address"], $_POST["contactnumber"], $_POST['stafftype']);
				
				if($success==1)
					echo "<h2>Information successfully added.</h2><br/>";
				else if($success==3)
					echo "<span style='color:red'>Staff Number is already in the database.</span><br /><br />";
				else
					echo "<span style='color:red'>Failed to add information.</span><br /><br />";
			}
		?>
		<form name="addStaffInformation" action="addstaffinformation.php" method="post">
			<table>
				<tr>
					<td><label for="staffnumber">Staff Number: </label></td>
					<td><input type="number" id="staffnumber" name="staffnumber" /></td>
				</tr>
				<tr>
					<td><label for="name">Name: </label></td>
					<td><input type="text" id="name" name="name" maxlength="80"></td>
				</tr>
				<tr>
					<td><label for="homeaddress">Address: </label></td>
					<td><input type="text" id="address" name="address" maxlength="80"></td>
				</tr>
				<tr>
					<td><label for="contactnumber">Contact Number: </label></td>
					<td><input type="text" id="contactnumber" name="contactnumber" pattern="[0-9]{11}"></td>
				</tr>
				<tr>
					<td><label for="stafftype">Type: </label></td>
					<td>
						<select id="stafftype" name="stafftype">
							<option value="Dorm Manager">Dorm Manager</option>
							<option value="Maintenance">Maintenance</option>
							<option value="Guard">Guard</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" id="addstaffinfo" name="addstaffinfo" value="Add Information"></td>
				</tr>
			</table>
		</form>
		<a href="staff_db.php" title="Back to Staff Home Page">Back to Staff Home Page</a>
	</body>
</html>