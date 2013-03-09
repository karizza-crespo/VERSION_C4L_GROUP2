<?php
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']!='dormer')
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
		<br />
		<?php
			if(isset($_POST["editdormerinfo"]))
			{
				$success=$manager->editDormerInformation($_SESSION['username'], $_POST["name"],
						$_POST["course"], $_POST["birthdate"], $_POST["homeaddress"],
						$_POST["contactnumber"], $_POST["contactperson"], $_POST["contactpersonnumber"]);

				if($success==1)
					echo "<center><h2>Information successfully edited.</h2></center><br/>";
				else if ($success==3)
					echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Birthdate is Invalid.</center></span><br /><br />";
				else
					echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Failed to edit information.</center></span><br /><br />";
			}
		?>
		<form name="editDormerInformation" onsubmit="return validateEditDormerInformationForm();" action="editdormerinformation.php" method="post">
			<?php
				$dormer = $manager->searchDormer($_SESSION['username']);
				$manager->printEditInfoForm('dormer', $dormer[0], -1);
			?>
		</form>
		<br />
		<a class="back" href="viewdormerinformation.php" title="Back to Personal Information">Back to Personal Information</a><br /><br />
	</body>
</html>