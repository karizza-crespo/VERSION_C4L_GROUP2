<?php
include("functions.php");

session_start();

if($_SESSION['username']=='none'){
	header('Location: login.php');
	die;
}

$current_user = $_SESSION['username'];
/*
//ate verna, nakacomment out kasi to sa akin kasi yung pagconnect ko sa database nasa functions.php na :)

// connect to database
$host = "localhost"; 
$user = "postgres"; 
$pass = "password"; 
$db = "postgres";
 
 
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
or die ("Could not connect to server\n");

*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>.::Dormitory Management System::.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="welcome.css" rel="stylesheet" type="text/css">
	</head>
<body>
	<h1>Welcome, Staff: <?php echo $current_user ?> 	!!!</h1>
	
	<a href="addstaffinformation.php" title="Add Personal Information">Add Personal Information</a>
	<br />
	<br />
	
	 <a href="logout.php">Sign Out </a></br>


</body>
</html>