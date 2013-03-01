<?php
include("classes.php");

//connect to the database
$db=pg_connect("host=localhost port=5432 dbname=cmsc128project user=postgres password=cmsc127");

class databaseManager
{	
	//function for adding payment record entry
	public function addPaymentEntry($dop, $username, $month, $amount)
	{
		//check first if the dormer is in the database
		$stmt="SELECT count(*) FROM dormer WHERE username='$username';";
		$count=pg_fetch_array(pg_query($stmt));
		
		if($count[0]!=0)
		{
			//if the amount entered by the dorm manager is 0, return 4
			if($amount==0)
				return 4;
				
			//check if the dormer already paid for that month
			$stmt="SELECT count(*) FROM payment_record WHERE username='$username' AND month='$month';";
			$count=pg_fetch_array(pg_query($stmt));
			
			if($count[0]==0)
			{
				$stmt="SELECT name FROM dormer WHERE username='$username';";
				$name=pg_fetch_array(pg_query($stmt));
				
				//insert values into the table named payment_record
				$stmt="INSERT INTO payment_record (name, month, username, amount, date_of_payment) VALUES ('$name[0]', '$month', '$username', '$amount', '$dop');";
				$success=pg_query($stmt);
				//return 1 if entry is successfully inserted, 0 if not
				if($success)
					return 1;
				return 0;
			}
			//return 3 if dormer already paid for that month
			else
				return 3;
		}
		//if the username does not exist, return 5
		return 5;
	}
	
	//function for retrieving all entries in the payment_records table
	public function retrieveAllRecords()
	{
		$allRecords = array();
		
		$stmt="SELECT * FROM payment_record;";
		$result=pg_query($stmt);
		
		//create an instance of each payment record and add it to the array
		while($row=pg_fetch_assoc($result))
			$allRecords[] = new PaymentRecord($row['payment_number'], $row['name'], $row['month'], $row['username'], $row['amount'], $row['date_of_payment']);
		//return the array of all payment records
		return $allRecords;
	}
	
	//function for printing the list of all records in a table form
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
	
	//function for searching the payment_record table
	public function searchRecords($username)
	{
		$records = array();
		
		//select all the entries of the user
		$stmt="SELECT * FROM payment_record WHERE username='$username';";
		$result=pg_query($stmt);
		
		//create an instance of the payment record entries and add it to the array
		while($row=pg_fetch_assoc($result))
			$records[] = new PaymentRecord($row['payment_number'], $row['name'], $row['month'], $row['username'], $row['amount'], $row['date_of_payment']);
		//return the array of record entries
		return $records;
	}
	
	//function for printing the edit form
	public function printEditForm($recordDetails)
	{
		echo "<table>
				<tr>
					<td><label for='paymentnumber'>Payment Number:</label></td>
					<td><input type='number' id='paymentnumber' name='paymentnumber' disabled='disabled' value='".$recordDetails->getPaymentNumber()."'/></td>
					<td><input type='hidden' name='paymentnumber' value='".$recordDetails->getPaymentNumber()."' /></td>
				</tr>
				<tr>
					<td><label for='dateofpayment'>Date: </label></td>
					<td><input type='date' id='dateofpayment' name='dateofpayment' value='".$recordDetails->getDOP()."'/></td>
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
								echo "<option value='December'>December</option>";
						echo "</select>
					</td>
					<td><input type='hidden' name='oldmonth' value='".$recordDetails->getMonth()."'/></td>
				</tr>
				<tr>
					<td><label for='amount'>Amount:</label></td>
					<td><input type='number' id='amount' name='amount' value='".$recordDetails->getAmount()."' min='0'/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type='submit' name='editentry' value='Edit Entry'/></td>
				</tr>
			</table>
		</form>";
	}
	
	//function for updating the entry in the payment records table
	public function updatePaymentRecords($dateofpayment, $paymentnumber, $username, $month, $amount, $oldmonth)
	{
		//check first if the username is in the dormer table
		$stmt="SELECT count(*) FROM dormer WHERE username='$username';";
		$count=pg_fetch_array(pg_query($stmt));
		
		if($count[0]!=0)
		{
			//check if there is an entry in the payment record table that has the username and month specified 
			$stmt="SELECT count(*) FROM payment_record WHERE username='$username' AND month='$month';";
			$count=pg_fetch_array(pg_query($stmt));
			
			//if there is none, or the old month is equal to the new month
			if($count[0]==0 || $oldmonth==$month)
			{
				//if amount is equal to 0 return 4
				if($amount==0)
					return 4;

				//update entry in the database
				$stmt="UPDATE payment_record set date_of_payment='$dateofpayment', username='$username', month='$month', amount='$amount' WHERE payment_number='$paymentnumber';";
				$success=pg_query($stmt);
				
				if($success)
					return 1;
				else
					return 0;	
			}
			//if there is already the same month and username in the database, return 2
			else
				return 2;
		}
		//if not, return 3
		return 3;
	}
	
	//function for retrieving all dormers from the dormer table
	public function retrieveAllDormers()
	{
		$allDormers = array();
		

		$stmt="SELECT * FROM dormer ORDER BY username;";
		$result=pg_query($stmt);
		
		//create an instance for every dormer and add it to the array
		while($row=pg_fetch_assoc($result))
			$allDormers[] = new Dormer($row['username'], $row['password'], $row['name'], $row['student_number'], $row['home_address'], $row['contact_number'], $row['birthdate'], $row['age'], $row['course'], $row['contact_person'], $row['contact_person_number'], $row['room_number']);
		//return the array of dormers
		return $allDormers;
	}
	
	//function for retrieving all staff from the staff table
	public function retrieveAllStaff()
	{
		$allStaff = array();
		
		$stmt="SELECT * FROM staff ORDER BY staff_number;";
		$result=pg_query($stmt);
		
		//create an instance for every staff and add it to the array
		while($row=pg_fetch_assoc($result))
			$allStaff[] = new Staff($row['staff_number'], $row['name'], $row['address'], $row['contact_number'], $row['type'], $row['username'], $row['password']);
		//return the array of staff
		return $allStaff;
	}
	
	public function printDelete($details, $type)
	{
		echo "<table border='1'>";
		if($type=='dormer')
		{
			echo "<tr>
				<th></th>
				<th>Username</th>
				<th>Name</th>
				<th>Student Number</th>
				<th>Home Address</th>
				<th>Contact Number</th>
				<th>Birthdate</th>
				<th>Age</th>
				<th>Course</th>
				<th>Contact Person</th>
				<th>Contact Person Number</th>
				<th>Room Number</th>
			</tr>";
			echo "<input type='hidden' value='0' name='dormer' />";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
					<td><input type='checkbox' value='".$details[$ctr]->getUsername()."' name='dormer[]' id='dormer".$ctr."' /></td>
					<td><label for='dormer".$ctr."'>".$details[$ctr]->getUsername()."</label></td>
					<td>".$details[$ctr]->getName()."</td>
					<td>".$details[$ctr]->getStudentNumber()."</td>
					<td>".$details[$ctr]->getHomeAddress()."</td>
					<td>".$details[$ctr]->getContactNumber()."</td>
					<td>".$details[$ctr]->getBirthdate()."</td>
					<td>".$details[$ctr]->getAge()."</td>
					<td>".$details[$ctr]->getCourse()."</td>
					<td>".$details[$ctr]->getContactPerson()."</td>
					<td>".$details[$ctr]->getContactPersonNumber()."</td>
					<td>".$details[$ctr]->getRoomNumber()."</td>
				</tr>";
			}
		}
		else if ($type=='staff')
		{
			echo "<tr>
				<th></th>
				<th>Staff Number</th>
				<th>Username</th>
				<th>Name</th>
				<th>Address</th>
				<th>Contact Number</th>
				<th>Type</th>
			</tr>";
			echo "<input type='hidden' value='0' name='staff' />";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
					<td><input type='checkbox' value='".$details[$ctr]->getStaffNumber()."' name='staff[]' id='staff".$ctr."'/></td>
					<td><label for='staff".$ctr."'>".$details[$ctr]->getStaffNumber()."</label></td>
					<td>".$details[$ctr]->getStaffUsername()."</td>
					<td>".$details[$ctr]->getStaffName()."</td>
					<td>".$details[$ctr]->getAddress()."</td>
					<td>".$details[$ctr]->getContactNum()."</td>
					<td>".$details[$ctr]->getStaffType()."</td>
				</tr>";
			}
		}
		echo "</table>";
	}
	
	//function for deleting accounts from the database
	public function deleteAccounts($deleteDormers, $deleteStaff)
	{
		for($ctr=0; $ctr<count($deleteDormers); $ctr++)
		{
			//before you delete the dormer, delete first all the entries of the dormer in the payment_record and log table
			$stmt="DELETE FROM payment_record WHERE username='$deleteDormers[$ctr]';";
			pg_query($stmt);
			$stmt="DELETE FROM log WHERE username='$deleteDormers[$ctr]';";
			pg_query($stmt);
			$stmt="DELETE FROM dormer WHERE username='$deleteDormers[$ctr]';";
			pg_query($stmt);
		}
		for($ctr=0; $ctr<count($deleteStaff); $ctr++)
		{
			//before you delete the staff, delete first all the entries of the staff in the staff_schedule
			$stmt="DELETE FROM staff_schedule WHERE staff_number='$deleteStaff[$ctr]';";
			pg_query($stmt);
			$stmt="DELETE FROM staff WHERE staff_number='$deleteStaff[$ctr]';";
			pg_query($stmt);
		}
	}
	
	//function for searching a specific dormer
	public function searchDormer($username)
	{
		$dormers = array();
		
		$stmt="SELECT * FROM dormer WHERE username='$username';";
		$result=pg_query($stmt);
			
		//create an instance for every dormer and add it to the array
		while($row=pg_fetch_assoc($result))
			$dormers[] = new Dormer($row['username'], $row['password'], $row['name'], $row['student_number'], $row['home_address'], $row['contact_number'], $row['birthdate'], $row['age'], $row['course'], $row['contact_person'], $row['contact_person_number'], $row['room_number']);
		//return the array of dormers
		return $dormers;
		
	}
	
	//function for searching a specific staff by staff_number
	public function searchStaff($number)
	{
		$staff = array();
		
		$stmt="SELECT * FROM staff WHERE staff_number='$number';";
		$result=pg_query($stmt);
			
		//create and instance for every staff and add it to the array
		while($row=pg_fetch_assoc($result))
			$staff[] = new Staff($row['staff_number'], $row['name'], $row['address'], $row['contact_number'], $row['type'], $row['username'], $row['password']);
		//return the array of staff
		return $staff;
	}

	//function for searching a specific staff by username
	public function searchStaffByUname($username)
	{
		$staff = array();
		
		$stmt="SELECT * FROM staff WHERE username='$username';";
		$result=pg_query($stmt);
		
		//create and instance for every staff and add it to the array
		while($row=pg_fetch_assoc($result))
			$staff[] = new Staff($row['staff_number'], $row['name'], $row['address'], $row['contact_number'], $row['type'], $row['username'], $row['password']);
		//return the array of staff
		return $staff;
	}
	
	//function for printing the edit info form
	public function printEditInfoForm($type, $username)
	{
		echo "<table>";
		if($type=='dormer')
		{
			echo "<tr>
				<td><label for='name'>Name: </label></td>";
				if(isset($_POST["viewdormerinfo"]))
					echo "<td><input type='text' id='name' name='name' pattern='[A-za-z\s.]{1,80}' value='".$username->getName()."'></td>";
				else
					echo "<td><input type='text' id='name' name='name' pattern='[A-za-z\s.]{1,80}' value='".$_POST['name']."'></td>";
			echo" </tr>
			<tr>
				<td><label for='studentnumber'>Student Number: </label></td>";
				if(isset($_POST["viewdormerinfo"]))
					echo "<td><input type='text' id='studentnumber' name='studentnumber' pattern='[0-9]{4}[-][0-9]{5}' value='".$username->getStudentNumber()."'></td>";
				else
					echo "<td><input type='text' id='studentnumber' name='studentnumber' pattern='[0-9]{4}[-][0-9]{5}' value='".$_POST['studentnumber']."'></td>";
			echo "</tr>
			<tr>
				<td><label for='course'>Course: </label></td>";
				if(isset($_POST["viewdormerinfo"]))
					echo "<td><input type='text' id='course' name='course' pattern='[A-Za-z\s]{3,40}' value='".$username->getCourse()."'></td>";
				else
					echo "<td><input type='text' id='course' name='course' pattern='[A-Za-z\s]{3,40}' value='".$_POST['course']."'></td>";
			echo "</tr>
			<tr>
				<td><label for='birthdate'>Birthdate: </label></td>";
				if(isset($_POST["viewdormerinfo"]))
					echo "<td><input type='date' id='birthdate' name='birthdate' value='".$username->getBirthdate()."'></td>";
				else
					echo "<td><input type='date' id='birthdate' name='birthdate' value='".$_POST['birthdate']."'></td>";
			echo "</tr>
			<tr>
				<td><label for='age'>Age: </label></td>";
				if(isset($_POST["viewdormerinfo"]))
					echo "<td><input type='text' id='age' name='age' pattern='[0-9]{1,3}' value='".$username->getAge()."'></td>";
				else
					echo "<td><input type='text' id='age' name='age' pattern='[0-9]{1,3}' value='".$_POST['age']."'></td>";
			echo "</tr>
			<tr>
				<td><label for='homeaddress'>Home Address: </label></td>";
				if(isset($_POST["viewdormerinfo"]))
					echo "<td><input type='text' id='homeaddress' name='homeaddress' pattern='[A-za-z0-9\s,.]{1,150}' value='".$username->getHomeAddress()."'></td>";
				else
					echo "<td><input type='text' id='homeaddress' name='homeaddress' pattern='[A-za-z0-9\s,.]{1,150}' value='".$_POST['homeaddress']."'></td>";
			echo "</tr>
			<tr>
				<td><label for='contactnumber'>Contact Number: </label></td>";
				if(isset($_POST["viewdormerinfo"]))
					echo "<td><input type='text' id='contactnumber' name='contactnumber' pattern='[0-9]{11}' value='".$username->getContactNumber()."'></td>";
				else
					echo "<td><input type='text' id='contactnumber' name='contactnumber' pattern='[0-9]{11}' value='".$_POST['contactnumber']."'></td>";
			echo "</tr>
			<tr>
				<td><label for='contactperson'>Contact Person: </label></td>";
				if(isset($_POST["viewdormerinfo"]))
					echo "<td><input type='text' id='contactperson' name='contactperson' pattern='[A-za-z\s.]{1,80}' value='".$username->getContactPerson()."'></td>";
				else
					echo "<td><input type='text' id='contactperson' name='contactperson' pattern='[A-za-z\s.]{1,80}' value='".$_POST['contactperson']."'></td>";
			echo "</tr>
			<tr>
				<td><label for='contactpersonnumber'>Contact Person Number: </label></td>";
				if(isset($_POST["viewdormerinfo"]))
					echo "<td><input type='text' id='contactpersonnumber' name='contactpersonnumber' pattern='[0-9]{11}' value='".$username->getContactPersonNumber()."'></td>";
				else
					echo "<td><input type='text' id='contactpersonnumber' name='contactpersonnumber' pattern='[0-9]{11}' value='".$_POST['contactpersonnumber']."'></td>";
			echo "</tr>
			<tr>
				<td></td>
				<td><input type='submit' id='editdormerinfo' name='editdormerinfo' value='Submit'></td>
			</tr>
			</table>";
		} else if ($type=='staff')
		{
			echo "<tr>
				<td><label for='name'>Name: </label></td>";
				if(isset($_POST["viewstaffinfo"]))
					echo "<td><input type='text' id='name' name='name' pattern='[A-za-z\s.]{1,80}' value='".$username->getStaffName()."'></td>";
				else
					echo "<td><input type='text' id='name' name='name' pattern='[A-za-z\s.]{1,80}' value='".$_POST['name']."'></td>";
			echo "</tr>
			<tr>
				<td><label for='homeaddress'>Address: </label></td>";
				if(isset($_POST["viewstaffinfo"]))
					echo "<td><input type='text' id='address' name='address' pattern='[A-za-z0-9\s,.]{1,150}' value='".$username->getAddress()."'></td>";
				else
					echo "<td><input type='text' id='address' name='address' pattern='[A-za-z0-9\s,.]{1,150}' value='".$_POST['address']."'></td>";
			echo "</tr>
			<tr>
				<td><label for='contactnumber'>Contact Number: </label></td>";
				if(isset($_POST["viewstaffinfo"]))
					echo "<td><input type='text' id='contactnumber' name='contactnumber' pattern='[0-9]{11}' value='".$username->getContactNum()."'></td>";
				else
					echo "<td><input type='text' id='contactnumber' name='contactnumber' pattern='[0-9]{11}' value='".$_POST['contactnumber']."'></td>";
			echo "</tr>
			<tr>
				<td></td>
				<td><input type='submit' id='editstaffinfo' name='editstaffinfo' value='Submit'></td>
			</tr>
			</table>";
		}
	}
	
	//function for printing the view info
   public function printViewInfo($user, $type)
	{
		echo "<table>";
		if($type=='dormer')
		{
			echo "<tr>
				<td><label for='name'>Name: </label></td>
				<td>".$user[0]->getName()."</td>
			</tr>
			<tr>
				<td><label for='studentnumber'>Student Number: </label></td>
				<td>".$user[0]->getStudentNumber()."</td>
			</tr>
			<tr>
				<td><label for='course'>Course: </label></td>
				<td>".$user[0]->getCourse()."</td>
			</tr>
			<tr>
				<td><label for='birthdate'>Birthdate: </label></td>
				<td>".$user[0]->getBirthdate()."</td>
			</tr>
			<tr>
				<td><label for='age'>Age: </label></td>
				<td>".$user[0]->getAge()."</td>
			</tr>
			<tr>
				<td><label for='homeaddress'>Home Address: </label></td>
				<td>".$user[0]->getHomeAddress()."</td>
			</tr>
			<tr>
				<td><label for='contactnumber'>Contact Number: </label></td>
				<td>".$user[0]->getContactNumber()."</td>
			</tr>
			<tr>
				<td><label for='contactperson'>Contact Person: </label></td>
				<td>".$user[0]->getContactPerson()."</td>
			</tr>
			<tr>
				<td><label for='contactpersonnumber'>Contact Person Number: </label></td>
				<td>".$user[0]->getContactPersonNumber()."</td>
			</tr>
			<tr>
				<td></td>
				<td><input type='submit' id='viewdormerinfo' name='viewdormerinfo' value='Edit'/></td>
			</tr>
			</table>";
		} else if ($type=='staff')
		{
			echo "<tr>
				<td><label for='name'>Name: </label></td>
				<td>".$user[0]->getStaffName()."</td>
			</tr>
			<tr>
				<td><label for='homeaddress'>Address: </label></td>
				<td>".$user[0]->getAddress()."</td>
			</tr>
			<tr>
				<td><label for='contactnumber'>Contact Number: </label></td>
				<td>".$user[0]->getContactNum()."</td>
			</tr>
			<tr>
				<td></td>
				<td><input type='submit' id='viewstaffinfo' name='viewstaffinfo' value='Edit'/></td>
			</tr>
			</table>";
		}
	}
	
	//function for printing all the accounts in a table
	public function printViewInfoByAdmin($details, $type)
	{
		echo "<table border='1'>";
		if($type=='dormer')
		{
			echo "<tr>
				<th>Username</th>
				<th>Name</th>
				<th>Student Number</th>
				<th>Home Address</th>
				<th>Contact Number</th>
				<th>Birthdate</th>
				<th>Age</th>
				<th>Course</th>
				<th>Contact Person</th>
				<th>Contact Person Number</th>
				<th>Room Number</th>";
				//<th></th>
			echo "</tr>";
			echo "<input type='hidden' value='0' name='dormer' />";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
					<td><label for='dormer".$ctr."'>".$details[$ctr]->getUsername()."</label></td>
					<td>".$details[$ctr]->getName()."</td>
					<td>".$details[$ctr]->getStudentNumber()."</td>
					<td>".$details[$ctr]->getHomeAddress()."</td>
					<td>".$details[$ctr]->getContactNumber()."</td>
					<td>".$details[$ctr]->getBirthdate()."</td>
					<td>".$details[$ctr]->getAge()."</td>
					<td>".$details[$ctr]->getCourse()."</td>
					<td>".$details[$ctr]->getContactPerson()."</td>
					<td>".$details[$ctr]->getContactPersonNumber()."</td>
					<td>".$details[$ctr]->getRoomNumber()."</td>";
					//<td><input type='submit' id='editdormerinfobyadmin$ctr' name='editdormerinfobyadmin$ctr' value='Edit'/></td>
				echo "</tr>
				</tr>";
			}
		}
		else if ($type=='staff')
		{
			echo "<tr>
				<th>Staff Number</th>
				<th>Username</th>
				<th>Name</th>
				<th>Address</th>
				<th>Contact Number</th>
				<th>Type</th>";
				//<th></th>
			echo "</tr>";
			echo "<input type='hidden' value='0' name='staff' />";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
					<td><label for='staff".$ctr."'>".$details[$ctr]->getStaffNumber()."</label></td>
					<td>".$details[$ctr]->getStaffUsername()."</td>
					<td>".$details[$ctr]->getStaffName()."</td>
					<td>".$details[$ctr]->getAddress()."</td>
					<td>".$details[$ctr]->getContactNum()."</td>
					<td>".$details[$ctr]->getStaffType()."</td>";
					//<td><input type='submit' id='editstaffinfobyadmin$ctr' name='editstaffinfobyadmin$ctr' value='Edit'/></td>
				echo "</tr>";
			}
		}
		echo "</table>";
	}
	
	//function for editing dormer information
	public function editDormerInformation($username, $name, $studentnumber, $course, $birthdate,	$age, $homeaddress, $contactnumber,	$contactperson, $contactpersonnumber)
	{
		//check first the if the student number entered by the user is already in the database
		$stmt="SELECT count(*) FROM dormer WHERE student_number='$studentnumber' AND username!='$username';";
		$count=pg_fetch_array(pg_query($stmt));
		
		if($count[0]==0)
		{
			//if not yet in the database, add all the information of the dormer to the table
			$stmt="UPDATE DORMER SET name='$name', student_number='$studentnumber', course='$course',";
			$stmt.=" birthdate='$birthdate', age='$age', home_address='$homeaddress',";
			$stmt.=" contact_number='$contactnumber', contact_person='$contactperson',";
			$stmt.=" contact_person_number='$contactpersonnumber' WHERE username='$username';";
			$success=pg_query($stmt);
		
			if($success)
				return 1;
			else
				return 0;
		}
		else
			return 3;
	}
	
	//function for editing staff information
	public function editStaffInformation($username, $name, $address, $contactnumber)
	{
		//add all the information of the staff to the database
		$stmt="UPDATE STAFF SET name='$name', address='$address', contact_number='$contactnumber'";
		$stmt.=" WHERE username='$username';";
		$success=pg_query($stmt);
	
		if($success)
			return 1;
		else
			return 0;
	}
	//Ian's functions
	//-----------------------------------------------------------------------------------------------------
	public function printSchedule($day)
	{
		
		echo "<tr>";
			
			echo "<th colspan=5>";
				$stmt="SELECT to_char(current_date + $day, 'Day'), current_date+$day;";
				$result=pg_query($stmt);
				$day = pg_fetch_array($result);
				echo $day[0];
			echo "</th>";
			
		echo "</tr>";
		echo "<tr>";
			echo "<th colspan=5>";
				echo $day[1];
			echo "</th>";
		echo "</tr>";
			
	}
	
	public function retrieveStaff($staffType)
	{
		$i=0;
		$staff = array();
		$stmt="SELECT name from staff where type like '$staffType';";
		$result= pg_query($stmt);
		
		while($a = pg_fetch_array($result))
			$staff[$i++]=$a[0];
		
		return $staff;
	}
	
	public function retrieveStafffromSched($location,$day,$time)
	{
		$stmt="SELECT name from staff
		where
		staff_number = (select staff_number from schedule
		where date = ( select current_date + $day)
		and time = '$time' and location like '$location'
		);";
		$result= pg_query($stmt);
		$a = pg_fetch_array($result);
		$staff=$a[0];
		return $staff;
	}
	
	public function addScheduleEntry($schedid,$day,$time,$location,$staffno)
	{
	
		$stmt = "INSERT into schedule values($schedid,current_date + $day,'$time','$location',$staffno);";
		$result= pg_query($stmt);
		if($result)
			return 1;
		else return 0;

	}
	
	public function isThereisStaff($location,$day,$time){
		$stmt = "SELECT staff_number from schedule where 
			day = (select current_date + $day) and
			location like '$location' and 
			time = '$time';";
		$result= pg_query($stmt);
		
		if($result)
			return 1;
		else return 0;
	}
	public function countSchedEntry(){
		$stmt = "SELECT count(*) from schedule;";
		$result= pg_query($stmt);
		$a = pg_fetch_array($result);

		return $a[0];
	}
	//------------------------------------------------------------------------------------------------------
	
	//function for viewing all log entries
	public function viewAllLogs()
	{
		$allLogs = array();
		
		$stmt="SELECT * FROM log;";
		$result=pg_query($stmt);
		
		//create an instance for every log entry and add it to the array
		while($row=pg_fetch_assoc($result))
			$allLogs[] = new Log($row['log_id'], $row['log_date'], $row['log_time'], $row['type'], $row['whereabouts'], $row['username']);
		//return the array of all log entries
		return $allLogs;
	}
	
	//function for searching the log entries of a specific user
	public function searchSpecificLog($username)
	{
		$specificLogs = array();
		
		$stmt="SELECT * FROM log WHERE username='$username';";
		$result=pg_query($stmt);
		
		//create an instance for every log entry of the dormer and add it to the array
		while($row=pg_fetch_assoc($result))
			$specificLogs[] = new Log($row['log_id'], $row['log_date'], $row['log_time'], $row['type'], $row['whereabouts'], $row['username']);
		//return the array of log entries
		return $specificLogs;
	}
	
	//function for printing all log entries
	public function printAllLogs($logs)
	{
		echo "<table border='1'>
			<tr>
				<th>Log ID</th>
				<th>Username</th>
				<th>Log Date</th>
				<th>Log Time</th>
				<th>Log Type</th>
				<th>Whereabouts</th>
			</tr>";
		for($i=0; $i<count($logs); $i++)
		{
			echo "<tr>
				<td>".$logs[$i]->getLogId()."</td>
				<td>".$logs[$i]->getUsername()."</td>
				<td>".$logs[$i]->getLogDate()."</td>
				<td>".$logs[$i]->getLogTime()."</td>
				<td>".$logs[$i]->getLogType()."</td>
				<td>".$logs[$i]->getWhereabouts()."</td>
			</tr>";
		}
		echo "</table>";
	}
	
	public function viewRoomAvailability()
	{	
		$room = array();
		
		$stmt="SELECT * FROM room ORDER BY room_number";
		$result=pg_query($stmt);
		$ctr=0;
		
		while($row=pg_fetch_assoc($result))
		{
			$room[$ctr][0]=$row['room_number'];
			$room[$ctr][1]=$row['slots'];
			$room[$ctr][2]=0;	//number of dormers currently residing in the room number
			$room[$ctr][3]=0;	
			$ctr++;
		}
		
		$stmt="SELECT room_number, count(room_number) from dormer GROUP BY room_number;";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
		{
			for($ctr=0; $ctr<count($room); $ctr++)
			{
				if($room[$ctr][0]==$row['room_number'])
					$room[$ctr][2]=$row['count'];
			}
		}
		
		for($ctr=0; $ctr<count($room); $ctr++)
		{
			if($room[$ctr][3]==0)
				$room[$ctr][3]=$room[$ctr][1]-$room[$ctr][2];
		}
		return $room;
	}
	
	public function printRoomAvailability($room)
	{
		echo "<table border='1'>
			<tr>
				<th>Room Number</th>
				<th>Capacity</th>
				<th>Residents</th>
				<th>Available Slots</th>
			</tr>";
		for($ctr=0; $ctr<count($room); $ctr++)
		{
			echo "<tr>
				<td>".$room[$ctr][0]."</td>
				<td>".$room[$ctr][1]."</td>
				<td>".$room[$ctr][2]."</td>
				<td>".$room[$ctr][3]."</td>
			</tr>";
		}
		echo "</table>";
	}
}
?>
