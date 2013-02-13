<?php
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']!='staff')
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
			if(isset($_POST["addstaffinfo"]))
			{
				$success=$manager->addStaffInformation($_SESSION['username'],
						$_POST["name"], $_POST["address"], $_POST["contactnumber"], $_POST['stafftype']);

				if($success==1)
					echo "<h2>Information successfully added.</h2><br/>";
				else
					echo "<span style='color:red'>Failed to add information.</span><br /><br />";
			}
		?>
		<form name="addStaffInformation" action="addstaffinformation.php" method="post">
			<?php
				$manager->printAddInfoForm('staff');
			?>
		</form>
		<a href="staff_db.php" title="Back to Staff Home Page">Back to Staff Home Page</a>
	</body>
</html>