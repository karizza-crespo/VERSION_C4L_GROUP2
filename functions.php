<?php
include("classes.php");

//connect to the database
/*palitan nio nalang yung dbname, user, password kung anu man yung sa inio :) */
$db=pg_connect("host=localhost port=5432 dbname=cmsc128project user=postgres password=cmsc127");

class databaseManager
{
	//dito nalang natin ilagay lahat ng functions natin para isang file nalang 
	
	//function for adding payment record entry
	public function addPaymentEntry($dop, $payment_number, $username, $month, $amount)
	{
		//check first if the dormer is in the database
		$stmt="SELECT count(*) FROM dormer WHERE username='$username';";
		$count=pg_fetch_array(pg_query($stmt));
		
		if($count[0]!=0)
		{
			//check if the dormer already paid for that month
			$stmt="SELECT count(*) FROM payment_record WHERE username='$username' AND month='$month';";
			$count=pg_fetch_array(pg_query($stmt));
			
			if($count[0]==0)
			{
				$stmt="SELECT name FROM dormer WHERE username='$username';";
				$name=pg_fetch_array(pg_query($stmt));
				
				//insert values into the table named payment_record
				$stmt="INSERT INTO payment_record VALUES ('$payment_number', '$name[0]', '$month', '$username', '$amount', '$dop');";
				$success=pg_query($stmt);
				//return 1 if entry is successfully inserted, 0 if not
				if($success)
					return 1;
				else
					return 0;
			}
			//return 3 if dormer already paid for that month
			else
				return 3;
		}
		//return 2 if dormer does not exist
		else
			return 2;
	}
	
	public function retrieveAllRecords()
	{
		$allRecords = array();
		
		$stmt="SELECT * FROM payment_record;";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			$allRecords[] = new PaymentRecord($row['payment_number'], $row['name'], $row['month'], $row['username'], $row['amount'], $row['date_of_payment']);
		return $allRecords;
	}
	
	public function printEdit($recordDetails)
	{
		echo "<table border='1'>";
			echo "<tr>
				<th>Payment Number</th>
				<th>Username</th>
				<th>Name</th>
				<th>Date of Payment</th>
				<th>Month</th>
				<th>Amount</th>
			</tr>";
			for($ctr=0; $ctr<count($recordDetails); $ctr++)
			{
				echo "<tr>
				<td>".$recordDetails[$ctr]->getPaymentNumber()."</td>
				<td>".$recordDetails[$ctr]->getDormerUsername()."</td>
				<td>".$recordDetails[$ctr]->getDormerName()."</td>
				<td>".$recordDetails[$ctr]->getDOP()."</td>
				<td>".$recordDetails[$ctr]->getMonth()."</td>
				<td>".$recordDetails[$ctr]->getAmount()."</td>
				<td><input type='submit' value='Edit' name='record$ctr' /></td>
				</tr>";
			}
		echo "</table>";
	}
	
	public function printUsername()
	{
		$stmt="SELECT DISTINCT username FROM payment_record;";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			echo "<option value='".$row['username']."'>".$row['username']."</option>";
	}
	
	public function searchRecords($username)
	{
		$records = array();
		
		$stmt="SELECT * FROM payment_record WHERE username='$username';";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			$records[] = new PaymentRecord($row['payment_number'], $row['name'], $row['month'], $row['username'], $row['amount'], $row['date_of_payment']);
		return $records;
	}
	
	public function printEditForm($recordDetails)
	{
		echo "<table>
				<tr>
					<td><label for='dateofpayment'>Date: </label></td>
					<td><input type='date' id='dateofpayment' name='dateofpayment' value='".$recordDetails->getDOP()."'/></td>
				</tr>
				<tr>
					<td><label for='paymentnumber'>Payment Number:</label></td>
					<td><input type='number' id='paymentnumber' name='paymentnumber' disabled='disabled' value='".$recordDetails->getPaymentNumber()."'/></td>
				</tr>
				<tr>
					<td><label for='username'>Username:</label></td>
					<td><input type='text' id='username' name='username' value='".$recordDetails->getDormerUsername()."'/></td>
				</tr>
				<tr>
					<td><label for='month'>Month:</label></td>
					<td>
						<select id='month' name='month'>";
							if($recordDetails->getMonth()=="January")
								echo "<option value='January' selected='true'>January</option>";
							else
								echo "<option value='January'>January</option>";
							if($recordDetails->getMonth()=="February")
								echo "<option value='February' selected='true'>February</option>";
							else
								echo "<option value='February'>February</option>";
							if($recordDetails->getMonth()=="March")
								echo "<option value='March' selected='true'>March</option>";
							else
								echo "<option value='March'>March</option>";
							if($recordDetails->getMonth()=="April")
								echo "<option value='April' selected='true'>April</option>";
							else
								echo "<option value='April'>April</option>";
							if($recordDetails->getMonth()=="May")
								echo "<option value='May' selected='true'>May</option>";
							else
								echo "<option value='May'>May</option>";
							if($recordDetails->getMonth()=="June")
								echo "<option value='June' selected='true'>June</option>";
							else
								echo "<option value='June'>June</option>";
							if($recordDetails->getMonth()=="July")
								echo "<option value='July' selected='true'>July</option>";
							else
								echo "<option value='July'>July</option>";
							if($recordDetails->getMonth()=="August")
								echo "<option value='August' selected='true'>August</option>";
							else
								echo "<option value='August'>August</option>";
							if($recordDetails->getMonth()=="September")
								echo "<option value='September' selected='true'>September</option>";
							else
								echo "<option value='September'>September</option>";
							if($recordDetails->getMonth()=="October")
								echo "<option value='October' selected='true'>October</option>";
							else
								echo "<option value='October'>October</option>";
							if($recordDetails->getMonth()=="November")
								echo "<option value='November' selected='true'>November</option>";
							else
								echo "<option value='November'>November</option>";
							if($recordDetails->getMonth()=="December")
								echo "<option value='December' selected='true'>December</option>";
							else
								echo "<option value='December'>December</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for='amount'>Amount:</label></td>
					<td><input type='number' id='amount' name='amount' value='".$recordDetails->getAmount()."'/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type='submit' name='editentry' value='Edit Entry'/></td>
				</tr>
			</table>
		</form>";
	}
}
?>