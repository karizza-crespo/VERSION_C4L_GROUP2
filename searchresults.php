<?php
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

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
	</head>
	<body>
		<form name="searchResults" action="editinfobyadmin.php" method="post">
			<?php
				if(isset($_POST['searchDormerByUsername']))
				{
					$_SESSION['searchUsername']=$_POST['viewDormerInfo'];
					$dormer = $manager->searchDormer($_POST['viewDormerInfo']);

					if($dormer!=null)
					{
						$_SESSION['searchUsername'] = $dormer[0]->getUsername();
						echo "<br />DORMERS: <br /><br />";
						$manager->printViewInfoByAdmin($dormer, 'dormer');
					}
					else if(count($dormer)==0)
						echo "<span style='color:red'>".$_SESSION['searchUsername']." is not in the database.</span><br />";
					else
						echo "<span style='color:red'>Dormer Table is Empty.</span><br />";
						
					echo "<br />";
				} else if(isset($_POST['searchStaffByNumber']))
				{
					$_SESSION['searchUsername']=$_POST['viewStaffInfo'];
					$staff = $manager->searchStaff($_POST['viewStaffInfo']);
				
					if($staff!=null)
					{
						$_SESSION['searchUsername'] = $staff[0]->getStaffUsername();
						echo "<br />STAFF: <br /><br />";
						$manager->printViewInfoByAdmin($staff, 'staff');
					}
					else if (count($staff)==0)
						echo "<span style='color:red'>".$_SESSION['searchUsername']." is not in the database.</span><br />";
					else
						echo "<span style='color:red'>Staff Table is Empty.</span><br />";
				}
			?>
		</form>
		<br />
		<a href="viewinfobyadmin.php" title="Back to List of Dormers and Staff">Back to List of Dormers and Staff</a>
	</body>
</html>