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
		<?php
			if(isset($_POST["addentry"]))
			{
				$payment=$manager->addPaymentEntry($_POST["dateofpayment"], $_POST["paymentnumber"], $_POST["username"], $_POST["month"], $_POST["amount"]);
				if($payment==1)
					echo "Payment Entry Added.<br />";
				else if ($payment==2)
					echo "<span style='color:red'>Payment Number already in the record.</span><br />";
				else if ($payment==3)
					echo "<span style='color:red'>Month already paid.</span><br />";
				else if ($payment==4)
					echo "<span style='color:red'>Amount is invalid.</span><br />";
				else
					echo "<span style='color:red'>Failed to add payment entry.</span><br />";
			}
		?>
		<form name="addPayment" action="addpayment.php" method="post">
			<table>
				<tr>
					<td><label for="dateofpayment">Date: </label></td>
					<td><input type="date" id="dateofpayment" name="dateofpayment"/></td>
				</tr>
				<tr>
					<td><label for="paymentnumber">Payment Number:</label></td>
					<td><input type="number" id="paymentnumber" name="paymentnumber" min="0" value='0'/></td>
				</tr>
				<tr>
					<td><label for="username">Username:</label></td>
					<td>
						<select id="username" name="username"><?php $manager->printUsername();?></select>
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
					<td><input type="number" id="amount" name="amount" min="1" value="1"/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="addentry" value="Add Entry"/></td>
				</tr>
			</table>
		</form>
		
		<a href='staff_db.php' title='Back to Staff Home Page'>Back to Staff Home Page</a>
	</body>
</html>