<?php
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']!='admin')
{
<<<<<<< HEAD
	header('Location: login.php');
=======
	header('Location: signin.php');
>>>>>>> fd5935510e3342ff30b9960f409296519d5e59a2
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
					$dormer = $manager->searchDormer($_POST['addInfoDormer']);

					if($dormer!=null)
					{
						$_SESSION['searchUsername'] = $dormer[0]->getUsername();
						echo "<br />DORMERS: <br /><br />";
						$manager->printAddInfo($dormer, 'dormer');
					}
					else
						echo "<span style='color:red'>Dormer Table is Empty.</span><br />";
						
					echo "<br />";
				} else if(isset($_POST['searchStaffByNumber']))
				{
					$staff = $manager->searchStaff($_POST['addInfoStaff']);
				
					if($staff!=null)
					{
						$_SESSION['searchUsername'] = $staff[0]->getStaffUsername();
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