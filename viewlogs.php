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
	else if($_SESSION['accountType']!='admin' && $_SESSION['accountType']!='dormer')
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
		<form name="searchSpecificLog" action="viewlogs.php" method="post">
			<table class='search'>
				<tr>
					<td><label for='logUsername'>Search By Username: </label></td>
					<td>
						<input type="text" id="logUsername" name="logUsername" />
					</td>
					<td>
						<input type="submit" value="Search" name="searchLogByUsername"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
			echo "<div id='allLogs'>";
			if(isset($_POST['searchLogByUsername']))
				$logs=$manager->searchSpecificLog($_POST['logUsername']);
			else
				$logs=$manager->viewAllLogs();
			if($logs!=null)
				$manager->printAllLogs($logs);
			else
			{
				if(isset($_POST['searchLogByUsername']))
					echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>".$_POST['logUsername']." is not in the Logs Table.</center></span><br /><br />";
				else
					echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Logs Table is Empty.</center></span><br /><br />";
			}
		echo "</div>";
		?>
		<br />
	</body>
</html>
