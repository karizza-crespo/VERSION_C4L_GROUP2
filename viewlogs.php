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
	</head>
	<body>
		<br />
		<form name="searchSpecificLog" action="viewlogs.php" method="post">
			<table>
				<tr>
					<td>Search By Username: </td>
					<td>
						<select id="logUsername" name="logUsername"><?php $manager->printUsername();?></select>
					</td>
					<td>
						<input type="submit" value="Search" name="searchLogByUsername"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
			if(isset($_POST['searchLogByUsername']))
				$logs=$manager->searchSpecificLog($_POST['logUsername']);
			else
				$logs=$manager->viewAllLogs();
			if($logs!=null)
			{
				echo "LOGS: <br /><br />";
				$manager->printAllLogs($logs);
			}
			else
			{
				if(isset($_POST['searchLogByUsername']))
					echo "<span style='color:red'>".$_POST['logUsername']." is not in the Logs Table.</span><br /><br />";
				else
					echo "<span style='color:red'>Logs Table is Empty.</span><br /><br />";
			}
		echo "<br /><a href='".$_SESSION['accountType']."_db.php' title='Back to ".$_SESSION['accountType']." Home Page'>Back to ".$_SESSION['accountType']." Home Page</a>";
		?>
	</body>
</html>
