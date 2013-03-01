<?php
	include("functions.php");
	$manager = new databaseManager;
	
	session_start();
	
	if($_SESSION['accountType']=='staff')
	{
		$stmt="SELECT type from staff WHERE username='".$_SESSION['username']."';";
		$result=pg_fetch_array(pg_query($stmt));
		
		if($result[0]!='Dorm Manager')
			header('Location: signin.php');
	}
	else if($_SESSION['accountType']!='admin')
	{
		header('Location: signin.php');
		die;
	}
	
?>
<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="js/script.js"></script>
	</head>
	<body>
		ROOM AVAILABILITY:<br /><br /><br />
		<?php
			$roomTable = $manager->viewRoomAvailability();
			$manager->printRoomAvailability($roomTable);
			echo "<br /><br />";
			echo "<a href='".$_SESSION['accountType']."_db.php' Title='Back to ".$_SESSION['accountType']." Home Page'>Back to ".$_SESSION['accountType']." Home Page</a>";
		?>
	</body>
</html>