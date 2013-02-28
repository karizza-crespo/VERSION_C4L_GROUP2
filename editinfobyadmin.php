<?php
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']!='admin')
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
		<?php
			if(isset($_POST["editdormerinfo"]))
			{
				$success=$manager->editDormerInformation($_SESSION['searchUsername'], $_POST["name"],
						$_POST["studentnumber"], $_POST["course"], $_POST["birthdate"], $_POST["age"],
						$_POST["homeaddress"], $_POST["contactnumber"], $_POST["contactperson"],
						$_POST["contactpersonnumber"]);

				if($success==1)
					echo "<h2>Information successfully edited.</h2><br/>";
				else if ($success==3)
					echo "<span style='color:red'>Student Number already in the Database.</span><br /><br />";
				else
					echo "<span style='color:red'>Failed to edit information.</span><br /><br />";
			} else if(isset($_POST["editstaffinfo"]))
			{
				$success=$manager->editStaffInformation($_SESSION['searchUsername'],
						$_POST["name"], $_POST["address"], $_POST["contactnumber"], $_POST['stafftype']);

				if($success==1)
					echo "<h2>Information successfully edited.</h2><br/>";
				else
					echo "<span style='color:red'>Failed to edit information.</span><br /><br />";
			}
		?>
		<form name="editInfo" action="editinfobyadmin.php" method="post">
			<?php
					$dormers=$manager->retrieveAllDormers();
					for($i=0; $i<count($dormers); $i++)
					{
						if(isset($_POST["editdormerinfobyadmin$i"]))
						{
							$_SESSION['searchUsername'] = $dormers[$i]->getUsername();
							$manager->printEditInfoForm('dormer', $dormers[$i]);
						}
					}
						
					$staff=$manager->retrieveAllStaff();
					for($i=0; $i<count($staff); $i++)
					{
						if(isset($_POST["editstaffinfobyadmin$i"]))
						{
							$_SESSION['searchUsername'] = $staff[$i]->getStaffUsername();
							$manager->printEditInfoForm('staff', $staff[$i]);
						}
					}
			?>
		</form>
		<br />
		<a href="searchresults.php" title="Back to Search Results">Back to Search Results</a>
	</body>
</html>