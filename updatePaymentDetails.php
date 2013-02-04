<?php 
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;
?>

<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<table>
			<form name="update" action="updatePaymentDetails.php" method="post">
				<?php
					$records=$manager->retrieveAllRecords();
					for($i=0; $i<count($records); $i++)
					{
						if(isset($_POST["record$i"]))
							$manager->printEditForm($records[$i]);
					}
				?>
			</form>
		</table>
	</body>
</html>