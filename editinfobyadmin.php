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
		<?php
			echo "<br />";
			if(isset($_POST["editdormerinfo"]))
			{
				$success=$manager->editDormerInformation($_SESSION['searchUsername'], $_POST["name"],
						$_POST["course"], $_POST["birthdate"], $_POST["homeaddress"],
						$_POST["contactnumber"], $_POST["contactperson"], $_POST["contactpersonnumber"]);

				if($success==1)
					echo "<center><h2>Information successfully edited.</h2></center><br/>";
				else if ($success==3)
					echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Birthdate is Invalid.</center></span><br /><br />";
				else
					echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Failed to edit information.</center></span><br /><br />";
			} else if(isset($_POST["editstaffinfo"]))
			{
				$success=$manager->editStaffInformation($_SESSION['searchUsername'],
						$_POST["name"], $_POST["address"], $_POST["contactnumber"]);

				if($success==1)
					echo "<center><h2>Information successfully edited.</h2></center><br/>";
				else
					echo "<span style='color:red; font-size:1.35em;'><center>Failed to edit information.</center></span><br /><br />";
			}
			echo "<form name='editInfoDormer' onsubmit='return validateEditInfoByAdminDormer();' action='editinfobyadmin.php' method='post'>";
					if($_SESSION['infoSearchFlagDormer']==1)
						$dormers = $manager->searchDormer($_SESSION['searchUsername']);
					else
						$dormers=$manager->retrieveAllDormers();
					for($i=0; $i<count($dormers); $i++)
					{
						if(isset($_POST["editdormerinfobyadmin$i"]))
						{
							$_SESSION['searchUsername'] = $dormers[$i]->getUsername();
							$manager->printEditInfoForm('dormer', $dormers[$i], $i);
						}
					}
			echo "</form>";
			echo "<form name='editInfoStaff' onsubmit='return validateEditInfoByAdminStaff();' action='editinfobyadmin.php' method='post'>";
					if($_SESSION['infoSearchFlagStaff']==1)
						$staff = $manager->searchStaff($_SESSION['searchUsername']);
					else
						$staff=$manager->retrieveAllStaff();
					for($i=0; $i<count($staff); $i++)
					{
						if(isset($_POST["editstaffinfobyadmin$i"]))
						{
							$_SESSION['searchUsername']=$staff[$i]->getStaffNumber();
							$manager->printEditInfoForm('staff', $staff[$i], $i);
						}
					}
			echo "</form>";
			?>
		<br />
		<center><a class="back" href="viewinfobyadmin.php" title="Back to List of Dormers and Staff">Back to List of Dormers and Staff</a></center>
	</body>
</html>