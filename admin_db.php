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
	</head>

	<body>

		<h1>Welcome, Administrator!</h1>

		<a href="register.php">Register </a><br /><br />
		<a href="deleteaccount.php">Delete Accounts</a><br /><br />
		<a href="viewinfobyadmin.php">Personal Information of Dormers &amp; Staff</a><br /><br />
		<a href='addpayment.php' title='Add Payment Records'>Add Payment Records</a><br /><br />
		<a href='updatepayment.php' title='Update Payment Records'>Update Payment Records</a><br /><br />
		<a href='viewlogs.php' title='View Logs'>View Logs</a><br /><br />
		<a href='roomavailability.php' title='View Room Availability'>View Room Availability</a><br /><br />
		<?php
		echo "<form name='sched' action='sched.php' method='post'>
				<input type='submit' value='Staff Schedule' name='viewSched' />
		</form>";
		?>
		<br />
		<a href="signout.php">Sign Out </a></br>
	</body>
</html>