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
else
{
	$stmt="SELECT type from staff WHERE username='".$_SESSION['username']."';";
	$result=pg_fetch_array(pg_query($stmt));
	
	if($result[0]!='Dorm Manager')
		header('Location: login.php');
}

$_SESSION['searchFlag']=0;
$_SESSION['searchUsername']='none';
?>
<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<br />
		<form name="searchSpecific" action="updatepayment.php" method="post">
			<table>
				<tr>
					<td>Search By Username: </td>
					<td>
						<select id="recordUsername" name="recordUsername"><?php $manager->printUsername();?></select>
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
				{
					echo "<br />PAYMENT RECORDS: <br /><br />";
					$manager->printEdit($record);
				}
				else
					echo "<span style='color:red'>Username is not in the Payment Records Table.</span><br />";
				echo "</form>";
			}
			else
			{
				$_SESSION['searchFlag']=0;
				echo "<form name='updateDetails' action='updatePaymentDetails.php' method='post'>";
				$record = $manager->retrieveAllRecords();
				if($record!=null)
				{
					echo "<br />PAYMENT RECORDS: <br /><br />";
					$manager->printEdit($record);
				}
				else
					echo "<span style='color:red'>Payment Records Table is Empty.</span><br />";
				echo "</form>";
			}
			
		?>
		<a href='staff_db.php' title='Back to Staff Home Page'>Back to Staff Home Page</a>
	</body>
</html>