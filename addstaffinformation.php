<?php 
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();
$_SESSION['username']='staff';
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
				$manager->addStaffInformation($_SESSION['username'], $_POST["name"], $_POST["address"],
						$_POST["contactnumber"]);
				
				echo "<h2>Information successfully added.</h2><br/>";
			}
		?>
		<form name="addStaffInformation" action="addstaffinformation.php" method="post">
			<table>
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
					<td colspan="2"><input type="submit" id="addstaffinfo" name="addstaffinfo" value="Add Information"></td>
				</tr>
			</table>
		</form>
	</body>
</html>
<?phpsession_destroy();?>