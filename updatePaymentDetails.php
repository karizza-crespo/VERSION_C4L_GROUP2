<?php 
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;
session_start();
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
					if ($_SESSION['searchFlag']==1)
						$records = $manager->searchRecords($_SESSION['username']);
					else
						$records=$manager->retrieveAllRecords();
					for($i=0; $i<count($records); $i++)
					{
						if(isset($_POST["record$i"]))
							$manager->printEditForm($records[$i]);
					}
					if(isset($_POST['editentry']))
					{
						$entry = $manager->updatePaymentRecords($_POST['dateofpayment'], $_POST['paymentnumber'], $_POST['username'], $_POST['month'], $_POST['amount'], $_POST['oldmonth']);
						if($entry==1)
							header('Location: updatepayment.php');
						else if ($entry==2)
							echo "<span style='color:red'><br /><center>Month already paid.</center></span><br />";
						else if ($entry==3)
							echo "<span style='color:red'><br /><center>Username does not exist.</center></span><br />";
						else if ($entry==4)
							echo "<span style='color:red'><br /><center>Amount is invalid.</center></span><br />";
						else
							echo "<span style='color:red'><br /><center>Failed to update Payment Record.</center></span><br />";
					}
				?>
			</form>
			<br />
			<a href="updatepayment.php" title="back to list of payment records">Back to List of Payment Records</a>
		</table>
	</body>
</html>