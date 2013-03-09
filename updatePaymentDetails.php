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
		<script src="js/script.js"></script>
	</head>
	<body>
		<br />
		<form name="update" onsubmit="return validateUpdatePaymentForm();" action="updatePaymentDetails.php" method="post">
			<?php
				if ($_SESSION['searchFlag']==1)
					$records = $manager->searchRecords($_SESSION['searchUsername']);
				else
					$records=$manager->retrieveAllRecords();
				for($i=0; $i<count($records); $i++)
				{
					if(isset($_POST["record$i"]))
						$manager->printEditForm($records[$i]);
				}
				if(isset($_POST['editentry']))
				{
					$entry = $manager->updatePaymentRecords($_POST['dateofpayment'], $_POST['paymentnumber'], $_POST['username'], $_POST['month'], $_POST['amount']);
					if($entry==1)
						header('Location: updatepayment.php');
					else if ($entry==2)
						echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Month already paid.</center></span><br />";
					else if ($entry==3)
						echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>".$_POST['username']." is not in the Dormers Table.</center></span><br />";
					else if ($entry==4)
						echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Amount is invalid.</center></span><br />";
					else if ($entry==5)
						echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Date is invalid.</center></span><br />";
					else
						echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Failed to update Payment Record.</center></span><br />";
			}
			?>
		</form>
		<br />
		<a class="back" href="updatepayment.php" title="back to list of payment records">Back to List of Payment Records</a>
	</body>
</html>