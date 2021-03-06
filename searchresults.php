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
		<link rel="stylesheet" type="text/css" href="js/toast/resources/css/jquery.toastmessage.css" />
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/toast/javascript/jquery.toastmessage.js"></script>
		<script src="js/script.js"></script>
	</head>
	<body>
		<form name="searchResults" action="editinfobyadmin.php" method="post">
			<?php
				echo "<br />";
				if(isset($_POST['searchDormerByUsername']))
				{
					$_SESSION['infoSearchFlagDormer']=1;
					$_SESSION['searchUsername']=$_POST['viewDormerInfo'];
					$dormer = $manager->searchDormer($_POST['viewDormerInfo']);

					if($dormer!=null)
					{
						$_SESSION['searchUsername'] = $dormer[0]->getUsername();
						echo "<br /><center><h2>DORMER:</h2></center>";
						$manager->printViewInfoByAdmin($dormer, 'dormer');
					}
					else if(count($dormer)==0)
						echo "<span style='color:red;font-size:1.35em; font-weight:bold;'><center>".$_SESSION['searchUsername']." is not in the database.</center></span><br />";
					else
						echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Dormer Table is Empty.</center></span><br /><br />";
						
					echo "<br />";
				} else if(isset($_POST['searchStaffByNumber']))
				{
					$_SESSION['infoSearchFlagStaff']=1;
					$_SESSION['searchUsername']=$_POST['viewStaffInfo'];
					$staff = $manager->searchStaff($_POST['viewStaffInfo']);
				
					if($staff!=null)
					{
						$_SESSION['searchUsername'] = $staff[0]->getStaffNumber();
						echo "<br /><center><h2>STAFF:</h2></center>";
						$manager->printViewInfoByAdmin($staff, 'staff');
					}
					else if (count($staff)==0)
						echo "<span style='color:red;font-size:1.35em; font-weight:bold;'><center>".$_SESSION['searchUsername']." is not in the database.</center></span><br />";
					else
						echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Staff Table is Empty.</center></span><br /><br />";
				}
			?>
		</form>
		<br />
		<center><a class="back" href="viewinfobyadmin.php" title="Back to List of Dormers and Staff">Back to List of Dormers and Staff</a></center>
	</body>
</html>