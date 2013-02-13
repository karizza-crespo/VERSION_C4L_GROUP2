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
		<?php
			/*if(isset($_POST["adddormerinfo"]))
			{
				$success=$manager->addDormerInformation($_SESSION['username'], $_POST["name"],
						$_POST["studentnumber"], $_POST["course"], $_POST["birthdate"], $_POST["age"],
						$_POST["homeaddress"], $_POST["contactnumber"], $_POST["contactperson"],
						$_POST["contactpersonnumber"]);

				if($success==1)
					echo "<h2>Information successfully added.</h2><br/>";
				else if ($success==3)
					echo "<span style='color:red'>Student Number already in the Database.</span><br /><br />";
				else
					echo "<span style='color:red'>Failed to Add Information.</span><br /><br />";
			} else if(isset($_POST["addstaffinfo"]))
			{
				$success=$manager->addStaffInformation($_SESSION['username'],
						$_POST["name"], $_POST["address"], $_POST["contactnumber"], $_POST['stafftype']);

				if($success==1)
					echo "<h2>Information successfully added.</h2><br/>";
				else
					echo "<span style='color:red'>Failed to add information.</span><br /><br />";
			}*/
		?>
		<form name="addInfo" action="addinfobyadminspecific.php" method="post">
			<?php
				if(isset($_POST['adddormerinfobyadmin']))
				{
					$manager->printAddInfoForm('dormer');
				}
				if(isset($_POST['addstaffinfobyadmin']))
				{
					$manager->printAddInfoForm('staff');
				}
			?>
		</form>
		<br />
		<a href="addinfobyadmin.php" title="Back to List of Dormers and Staff">Back to List of Dormers and Staff</a>
	</body>
</html>