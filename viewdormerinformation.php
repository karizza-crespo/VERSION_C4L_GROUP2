<?php
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']!='dormer')
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
		<link rel="stylesheet" type="text/css" href="js/toast/resources/css/jquery.toastmessage.css" />
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/toast/javascript/jquery.toastmessage.js"></script>
		<script src="js/script.js"></script>
	</head>
	<body>
		<form name="viewDormerInfo" action="editdormerinformation.php" method="post">
			<?php
				$dormer = $manager->searchDormer($current_user);
				$manager->printViewInfo($dormer, 'dormer');
			?>
		</form>
		<br />
	</body>
</html>