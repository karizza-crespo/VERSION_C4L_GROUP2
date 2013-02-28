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
	</head>
	<body>
		<br />
		<form name="searchSpecific" action="updatepayment.php" method="post">
			<table>
				<tr>
					<td>Search By Username: </td>
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
			
		//link lang to pabalik sa dormer_db, staff_db or admin_db
			echo "<a href='".$_SESSION['accountType']."_db.php' Title='Back to ".$_SESSION['accountType']." Home Page'>Back to ".$_SESSION['accountType']." Home Page</a>";
		?>
	</body>
</html>