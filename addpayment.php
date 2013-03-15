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
		<link rel="stylesheet" type="text/css" href="js/toast/resources/css/jquery.toastmessage.css" />
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/toast/javascript/jquery.toastmessage.js"></script>
		<script src="js/script.js"></script>
	</head>
	<body>
		<br />
		<br />
		<?php
			if(isset($_POST["addentry"]))
			{
				$payment=$manager->addPaymentEntry($_POST["dateofpayment"], $_POST["username"], $_POST["month"], $_POST["amount"]);
				if($payment==1)
					echo "<span style='color:cyan; font-size:1.35em; font-weight:bold;'><center>Payment Entry Added.</center></span><br />";
				else if ($payment==2)
					echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Payment Number already in the record.</center></span><br />";
				else if ($payment==3)
					echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Month already paid.</center></span><br />";
				else if ($payment==4)
					echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Amount is invalid.</center></span><br />";
				else if ($payment==5)
					echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>".$_POST['username']." is not in the Dormers Table.</center></span><br />";
				else if ($payment==6)
					echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Date is invalid.</center></span><br />";
				else
					echo "<span style='color:red; font-size:1.35em; font-weight:bold;'><center>Failed to add payment entry.</center></span><br />";
				echo "<br />";
			}
		?>
		<form name="addPayment" onsubmit="return validateAddPaymentForm()" action="addpayment.php" method="post">
			<table class='addPaymentForm'>
				<tr>
					<td><label for="dateofpayment">Date: </label></td>
					<td><input type="date" id="dateofpayment" name="dateofpayment"/></td>
				</tr>
				<tr>
					<td><label for="username">Username:</label></td>
					<td>
						<input type="text" id="username" name="username" />
					</td>
				</tr>
				<tr>
					<td><label for="month">Month:</label></td>
					<td>
						<select id="month" name="month">
							<option value="January">January</option>
							<option value="February">February</option>
							<option value="March">March</option>
							<option value="April">April</option>
							<option value="May">May</option>
							<option value="June">June</option>
							<option value="July">July</option>
							<option value="August">August</option>
							<option value="September">September</option>
							<option value="October">October</option>
							<option value="November">November</option>
							<option value="December">December</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="amount">Amount:</label></td>
					<td><input type="number" id="amount" name="amount" min="1"/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="addentry" value="Add Entry"/></td>
				</tr>
			</table>
		</form>
	</body>
</html>