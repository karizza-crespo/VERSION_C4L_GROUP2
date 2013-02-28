<?php
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']!='staff')
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
			if(isset($_POST["editstaffinfo"]))
			{
				$success=$manager->editStaffInformation($_SESSION['username'],
						$_POST["name"], $_POST["address"], $_POST["contactnumber"]);

				if($success==1)
					echo "<h2>Information successfully edited.</h2><br/>";
				else
					echo "<span style='color:red'>Failed to edit information.</span><br /><br />";
			}
		?>
		<form name="editStaffInformation" onsubmit="return validateEditStaffInformationForm();" action="editstaffinformation.php" method="post">
			<?php
				$staff = $manager->searchStaffByUname($_SESSION['username']);
				$manager->printEditInfoForm('staff', $staff[0], -1);
			?>
		</form>
		<a href="viewstaffinformation.php" title="Back to Personal Information">Back to Personal Information</a>
	</body>
</html>