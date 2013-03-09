<?php
include("functions.php");
session_start();
if($_SESSION['accountType']!='admin'){
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
		<style>
			body
			{
				overflow:hidden;
				background-image:url('pics/pic2.jpg');
			}
		</style>
		<script src="js/script.js"></script>
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/admin.jquery.js"></script>
	</head>
	<body>
		<div id="largeContainer">
			<img src="css/pics/dorm(1).jpg" />
		</div>
		<div id='welcomeUser'>
			<a class='welcomeHeader'><span class="refreshpage" title="Home Page">Welcome</span>, Administrator: <?php echo $current_user ?>!</a>
			<input type="button" onclick="location.href='signout.php'" title="Sign Out" value="Sign Out" /></br>
		</div>
		<div id="adminListContainer">
			<ul class='listLinks'>
				<li><input type="button" class="registeruser" title="Register" value="Register" /></li>
				<li><input type="button" class="deleteaccount" title="Delete Accounts" value="Delete Accounts" /></li>
				<li><input type="button" class="personalinfolist" title="Personal Information" value="Personal Information of Dormers &amp; Staff" /></li>
				<li><input type="button" class="addpayment" title='Add Payment Records' value="Add Payment Records" /></li>
				<li><input type="button" class="updatepayment" title='Update Payment Records' value="Update Payment Records" /></li>
				<li><input type="button" class="viewlogs" title='View Logs' value="View Logs" /></li>
				<li><input type="button" class="roomavailability" title='Room Availability' value="Room Availability" /></li>
				<li><input type="button" class="staffschedule" title="Staff Schedule" name='viewSched' value="Staff Schedule"/></li>
			</ul>
		</div>
		<div id="adminBodyContainer">
		</div>
		<div id='longFooter'>
			Copyright &copy;2013. CMSC 128 C-4L Group 2. All rights reserved.
		</div>
	</body>
</html>