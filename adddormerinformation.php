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
	</head>
	<body>
		<?php
			if(isset($_POST["adddormerinfo"]))
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
			}
		?>
		<form name="addDormerInformation" action="adddormerinformation.php" method="post">
			<?php
				$manager->printAddInfoForm('dormer');
			?>
		</form>
		<br />
		<a href="dormer_db.php" title="Back to Dormer Home Page">Back to Dormer Home Page</a>
	</body>
</html>