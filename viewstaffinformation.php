<?php
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']!='staff')
{
	header('Location: signin.php');
	die;
}

$current_user = $_SESSION['username'];
?>

<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<form name="viewStaffInfo" action="editstaffinformation.php" method="post">
			<?php
				$staff = $manager->searchStaffByUname($current_user);
				$manager->printViewInfo($staff, 'staff');
				echo "<br />";
			?>
		</form>
		<br />
		<a href="staff_db.php" title="Back to Staff Home Page">Back to Staff Home Page</a>
	</body>
</html>