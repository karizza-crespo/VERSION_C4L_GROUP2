<?php
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']!='admin')
{
	header('Location: login.php');
	die;
}
?>

<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<form name="searchResults" action="addinfobyadminspecific.php" method="post">
			<?php
				if(isset($_POST['searchDormerByUsername']))
				{
					$dormers = $manager->searchDormer($_POST['addInfoDormer']);
					
					if($dormers!=null)
					{
						echo "<br />DORMERS: <br /><br />";
						$manager->printAddInfo($dormers, 'dormer');
					}
					else
						echo "<span style='color:red'>Dormer Table is Empty.</span><br />";
						
					echo "<br />";
				}
				if(isset($_POST['searchStaffByNumber']))
				{
					$staff = $manager->searchStaff($_POST['addInfoStaff']);
				
					if($staff!=null)
					{
						echo "<br />STAFF: <br /><br />";
						$manager->printAddInfo($staff, 'staff');
					}
					else
						echo "<span style='color:red'>Staff Table is Empty.</span><br />";
				}
			?>
		</form>
		<br />
		<a href="addinfobyadmin.php" title="Back to List of Dormers and Staff">Back to List of Dormers and Staff</a>
	</body>
</html>