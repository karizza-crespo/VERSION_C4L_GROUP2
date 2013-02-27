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
	</head>
	<body>
		<form name="viewDormerInfo" action="viewdormerinformation.php" method="post">
			<?php
				$dormer = $manager->searchDormer($current_user);
				$manager->printViewInfo($dormer, 'dormer');
				echo "<br />";
			?>
		</form>
		<br />
		<a href="dormer_db.php" title="Back to Dormer Home Page">Back to Dormer Home Page</a>
	</body>
</html>