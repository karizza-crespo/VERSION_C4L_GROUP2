<?php
include("functions.php");

session_start();

if($_SESSION['accountType']!='staff'){
	header('Location: signin.php');
	die;
}

$current_user = $_SESSION['username'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>.::Dormitory Management System::.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
<body>
	<h1>Welcome, Staff: <?php echo $current_user ?> 	!!!</h1>
	
	<input type="button" onclick="location.href='viewstaffinformation.php'" title="Personal Information" value="Personal Information"/>
	<br />
	<br />
	<?php
		$stmt="SELECT type from staff WHERE username='$current_user';";
		$result=pg_fetch_array(pg_query($stmt));
	
		if($result[0]=='Dorm Manager')
		{
	?>
			<input type="button" onclick="location.href='viewinfobyadmin.php'" title="Personal Information" value="Personal Information of Dormers &amp; Staff" /><br /><br />
		<input type="button" onclick="location.href='addpayment.php'" title='Add Payment Records' value="Add Payment Records" /><br /><br />
		<input type="button" onclick="location.href='updatepayment.php'" title='Update Payment Records' value="Update Payment Records" /><br /><br />
		<input type="button" onclick="location.href='viewlogs.php'" title='View Logs' value="View Logs" /><br /><br />
		<input type="button" onclick="location.href='roomavailability.php'" title='Room Availability' value="Room Availability" /><br /><br />
	<?php
		}
	?>
	<form name='sched' action='sched.php' method='post'>
		<input type='submit' value='Staff Schedule' name='viewSched' />
	</form>
	<br />
	<input type="button" onclick="location.href='signout.php'" title="Sign Out" value="Sign Out" /></br>


</body>
</html>