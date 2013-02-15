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
		<LINK HREF="style.css" rel="stylesheet" TYPE="text/css">
	</head>

	<body>

		<h1>Welcome, Administrator!</h1>

		<a href="register.php">Register </a><br /><br />
		<a href="deleteaccount.php">Delete Accounts</a><br /><br />
		<a href="addinfobyadmin.php">Add Personal Information to Dormer/Staff</a><br /><br />
		<?php
		echo "<form name='sched' action='sched.php' method='post'>
				<input type='submit' value='Staff Schedule' name='viewSched' />
		</form>";
		?>
		<br />
		<a href="signout.php">Logout </a></br>
	</body>
</html>