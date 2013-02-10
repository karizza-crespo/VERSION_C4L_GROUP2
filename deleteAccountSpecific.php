<?php 
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;
session_start();
?>

<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="js/script.js"></script>
	</head>
	<body>
		<form name="retrieveAll" action="deleteaccount.php" method="post">
			<input type="button" value="Check All" name="check" onclick="checkall();"/>
			<input type="button" value="Uncheck All" name="uncheck" onclick="uncheckall();"/>
			<input type="submit" value="Delete" name="delete" />
			<br />
			<?php
				if(isset($_POST['searchDormerByUsername']))
				{
					$dormers = $manager->searchDormer($_POST['deleteDormer']);
					
					if($dormers!=null)
					{
						echo "<br />DORMERS: <br /><br />";
						$manager->printDelete($dormers, 'dormer');
					}
					else
						echo "<span style='color:red'>Dormer Table is Empty.</span><br />";
						
					echo "<br />";
				}
				if(isset($_POST['searchStaffByNumber']))
				{
					$staff = $manager->searchStaff($_POST['deleteStaff']);
				
					if($staff!=null)
					{
						echo "<br />STAFF: <br /><br />";
						$manager->printDelete($staff, 'staff');
					}
					else
						echo "<span style='color:red'>Staff Table is Empty.</span><br />";
				}
				if(isset($_POST['delete']))
				{
					$deleteDormers=$_POST['dormer'];
					$deleteStaff=$_POST['staff'];
					$manager->deleteAccounts($deleteDormers, $deleteStaff);
					header('Location: deleteaccount.php');
				}
			?>
		</form>
		<a href="deleteaccount.php" title="back to list of accounts">Back to List of Accounts</a>
	</body>
</html>