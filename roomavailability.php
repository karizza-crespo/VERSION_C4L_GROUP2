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
		<link rel="stylesheet" type="text/css" href="js/toast/resources/css/jquery.toastmessage.css" />
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/toast/javascript/jquery.toastmessage.js"></script>
		<script src="js/script.js"></script>
	</head>
	<body>
		<br />
		<?php
			$roomTable = $manager->viewRoomAvailability();
			$manager->printRoomAvailability($roomTable);
			echo "<br /><br />";
		?>
	</body>
</html>