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
		<?php
			if(isset($_POST["editdormerinfo"]))
			{
				$success=$manager->editDormerInformation($_SESSION['username'], $_POST["name"],
						$_POST["course"], $_POST["birthdate"], $_POST["homeaddress"], $_POST["contactnumber"],
						$_POST["contactperson"], $_POST["contactpersonnumber"]);

				if($success==1)
					echo "<h2>Information successfully edited.</h2><br/>";
				else
					echo "<span style='color:red'>Failed to edit information.</span><br /><br />";
			}
		?>
		<form name="editDormerInformation" onsubmit="return validateEditDormerInformationForm();" action="editdormerinformation.php" method="post">
			<?php
				$dormer = $manager->searchDormer($_SESSION['username']);
				$manager->printEditInfoForm('dormer', $dormer[0], -1);
			?>
		</form>
		<br />
		<a href="viewdormerinformation.php" title="Back to Personal Information">Back to Personal Information</a>
	</body>
</html>