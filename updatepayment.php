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

$_SESSION['searchFlag']=0;
$_SESSION['searchUsername']='none';
?>
<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="js/toast/resources/css/jquery.toastmessage.css" />
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/toast/javascript/jquery.toastmessage.js"></script>
		<script src="js/script.js"></script>
	</head>
	<body>
		<br />
		<form name="searchSpecific" action="updatepayment.php" method="post">
			<table class='search'>
				<tr>
					<td><label for="recordUsername">Search By Username:</label></td>
					<td>
						<input type="text" id="recordUsername" name="recordUsername" />
					</td>
					<td>
						<input type="submit" value="Search" name="searchByUsername"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
			if(isset($_POST['searchByUsername']))
			{
				$_SESSION['searchFlag']=1;
				$_SESSION['searchUsername']=$_POST['recordUsername'];
				echo "<form name='updateDetails' action='updatePaymentDetails.php' method='post'>";
				$record = $manager->searchRecords($_POST['recordUsername']);
				if($record!=null)
					$manager->printEdit($record);
				else
					echo "<br /><span style='color:red; font-size:1.35em; font-weight:bold;'><center>".$_SESSION['searchUsername']." is not in the Payment Records Table.</center></span><br />";
				echo "</form>";
			}
			else
			{
				$_SESSION['searchFlag']=0;
				echo "<form name='updateDetails' action='updatePaymentDetails.php' method='post'>";
				$record = $manager->retrieveAllRecords();
				if($record!=null)
					$manager->printEdit($record);
				else
					echo "<br /><span style='color:red; font-size:1.35em; font-weight:bold;'><center>Payment Records Table is Empty.</center></span><br />";
				echo "</form>";
			}
		?>
	</body>
</html>