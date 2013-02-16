<?php
include("classes.php");

//connect to the database
$db=pg_connect("host=localhost port=5432 dbname=cmsc128project user=postgres password=cmsc127");

class databaseManager
{	
	//function for adding payment record entry
	public function addPaymentEntry($dop, $payment_number, $username, $month, $amount)
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
			
			$stmt="SELECT count(*) FROM payment_record WHERE payment_number='$payment_number';";
			$anotherCount=pg_fetch_array(pg_query($stmt));
			if($count[0]==0 && $anotherCount[0]==0)
			{
				$stmt="SELECT name FROM dormer WHERE username='$username';";
				$name=pg_fetch_array(pg_query($stmt));
				
				//insert values into the table named payment_record
				$stmt="INSERT INTO payment_record VALUES ('$payment_number', '$name[0]', '$month', '$username', '$amount', '$dop');";
				$success=pg_query($stmt);
				//return 1 if entry is successfully inserted, 0 if not
				if($success)
					return 1;
				return 0;
			}
			//return 3 if dormer already paid for that month
			else
			{
				//return 2 if payment number already exists
				if($anotherCount[0]!=0)
					return 2;
				return 3;
			}
		}
	}
	
	//function for retrieving all entries in the payment_records table
	public function retrieveAllRecords()
	{
		$allRecords = array();
		
		$stmt="SELECT * FROM payment_record;";
		$result=pg_query($stmt);
		
		//insert into the array every payment record entry
		while($row=pg_fetch_assoc($result))
			$allRecords[] = new PaymentRecord($row['payment_number'], $row['name'], $row['month'], $row['username'], $row['amount'], $row['date_of_payment']);
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
	
	//function for printing username in the select tag
	public function printUsername()
	{
		$stmt="SELECT DISTINCT username FROM dormer;";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			echo "<option value='".$row['username']."'>".$row['username']."</option>";
	}
	
	//function for printing the stagg 
	public function printStaffNumber()
	{
		$stmt="SELECT DISTINCT staff_number FROM staff;";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			echo "<option value='".$row['staff_number']."'>".$row['staff_number']."</option>";
	}
	
	//function for searching the payment_record table
	public function searchRecords($username)
	{
		$records = array();
		
		//select all the entries of the user
		$stmt="SELECT * FROM payment_record WHERE username='$username';";
		$result=pg_query($stmt);
		
		//insert all the entries of user in an array
		while($row=pg_fetch_assoc($result))
			$records[] = new PaymentRecord($row['payment_number'], $row['name'], $row['month'], $row['username'], $row['amount'], $row['date_of_payment']);
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
	
	public function updatePaymentRecords($dateofpayment, $paymentnumber, $username, $month, $amount, $oldmonth)
	{
		$stmt="SELECT count(*) FROM dormer WHERE username='$username';";
		$count=pg_fetch_array(pg_query($stmt));
		
		if($count[0]!=0)
		{
			$stmt="SELECT count(*) FROM payment_record WHERE username='$username' AND month='$month';";
			$count=pg_fetch_array(pg_query($stmt));
			
			if($count[0]==0 || $oldmonth==$month)
			{
				if($amount==0)
					return 4;

				$stmt="UPDATE payment_record set date_of_payment='$dateofpayment', username='$username', month='$month', amount='$amount' WHERE payment_number='$paymentnumber';";
				$success=pg_query($stmt);
				
				if($success)
					return 1;
				else
					return 0;	
			}
			else
				return 2;
		}
		return 3;
	}
	
	public function retrieveAllDormers()
	{
		$allDormers = array();
		
		$stmt="SELECT * FROM dormer;";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			$allDormers[] = new Dormer($row['username'], $row['password'], $row['name'], $row['student_number'], $row['home_address'], $row['contact_number'], $row['birthdate'], $row['age'], $row['course'], $row['contact_person'], $row['contact_person_number'], $row['room_number']);
		return $allDormers;
	}
	
	public function retrieveAllStaff()
	{
		$allStaff = array();
		
		$stmt="SELECT * FROM staff;";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			$allStaff[] = new Staff($row['staff_number'], $row['name'], $row['address'], $row['contact_number'], $row['type'], $row['username'], $row['password']);
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
	
	public function deleteAccounts($deleteDormers, $deleteStaff)
	{
		for($ctr=0; $ctr<count($deleteDormers); $ctr++)
		{
			//kapag dormer, idelete mo siya sa payment_record, dormer_log, and dormer
			$stmt="DELETE FROM payment_record WHERE username='$deleteDormers[$ctr]';";
			pg_query($stmt);
			$stmt="DELETE FROM dormer_log WHERE username='$deleteDormers[$ctr]';";
			pg_query($stmt);
			$stmt="DELETE FROM dormer WHERE username='$deleteDormers[$ctr]';";
			pg_query($stmt);
		}
		for($ctr=0; $ctr<count($deleteStaff); $ctr++)
		{
			//kapag staff, delete mo siya sa staff_schedule and sa staff
			$stmt="DELETE FROM staff_schedule WHERE staff_number='$deleteStaff[$ctr]';";
			pg_query($stmt);
			$stmt="DELETE FROM staff WHERE staff_number='$deleteStaff[$ctr]';";
			pg_query($stmt);
		}
	}
	
	public function searchDormer($username)
	{
		$dormers = array();
		
		$stmt="SELECT * FROM dormer WHERE username='$username';";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			$dormers[] = new Dormer($row['username'], $row['password'], $row['name'], $row['student_number'], $row['home_address'], $row['contact_number'], $row['birthdate'], $row['age'], $row['course'], $row['contact_person'], $row['contact_person_number'], $row['room_number']);
		return $dormers;
	}
	
	public function searchStaff($number)
	{
		$staff = array();
		
		$stmt="SELECT * FROM staff WHERE staff_number='$number';";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			$staff[] = new Staff($row['staff_number'], $row['name'], $row['address'], $row['contact_number'], $row['type'], $row['username'], $row['password']);
		return $staff;
	}

	public function printAddInfo($details, $type)
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
				<th>Room Number</th>
				<th></th>
			</tr>";
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
					<td>".$details[$ctr]->getRoomNumber()."</td>
					<td><input type='submit' id='adddormerinfobyadmin$ctr' name='adddormerinfobyadmin$ctr' value='Add Information'/></td>
				</tr>
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
				<th>Type</th>
				<th></th>
			</tr>";
			echo "<input type='hidden' value='0' name='staff' />";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
					<td><label for='staff".$ctr."'>".$details[$ctr]->getStaffNumber()."</label></td>
					<td>".$details[$ctr]->getStaffUsername()."</td>
					<td>".$details[$ctr]->getStaffName()."</td>
					<td>".$details[$ctr]->getAddress()."</td>
					<td>".$details[$ctr]->getContactNum()."</td>
					<td>".$details[$ctr]->getStaffType()."</td>
					<td><input type='submit' id='addstaffinfobyadmin$ctr' name='addstaffinfobyadmin$ctr' value='Add Information'/></td>
				</tr>";
			}
		}
		echo "</table>";
	}
	
	public function printAddInfoForm($type)
	{
		echo "<table border='1'>";
		if($type=='dormer')
		{
			echo "<tr>
				<td><label for='name'>Name: </label></td>
				<td><input type='text' id='name' name='name' maxlength='80'></td>
			</tr>
			<tr>
				<td><label for='studentnumber'>Student Number: </label></td>
				<td><input type='text' id='studentnumber' name='studentnumber' pattern='[0-9]{4}[-][0-9]{5}'></td>
			</tr>
			<tr>
				<td><label for='course'>Course: </label></td>
				<td><input type='text' id='course' name='course' pattern='[A-Za-z]{3,20}'></td>
			</tr>
			<tr>
				<td><label for='birthdate'>Birthdate: </label></td>
				<td><input type='date' id='birthdate' name='birthdate'></td>
			</tr>
			<tr>
				<td><label for='age'>Age: </label></td>
				<td><input type='text' id='age' name='age' pattern='[0-9]{1,3}'></td>
			</tr>
			<tr>
				<td><label for='homeaddress'>Home Address: </label></td>
				<td><input type='text' id='homeaddress' name='homeaddress' maxlength='80'></td>
			</tr>
			<tr>
				<td><label for='contactnumber'>Contact Number: </label></td>
				<td><input type='text' id='contactnumber' name='contactnumber' pattern='[0-9]{11}'></td>
			</tr>
			<tr>
				<td><label for='contactperson'>Contact Person: </label></td>
				<td><input type='text' id='contactperson' name='contactperson' maxlength='80'></td>
			</tr>
			<tr>
				<td><label for='contactpersonnumber'>Contact Person Number: </label></td>
				<td><input type='text' id='contactpersonnumber' name='contactpersonnumber' pattern='[0-9]{11}'></td>
			</tr>
			</table>
			<br />
			<input type='submit' id='adddormerinfo' name='adddormerinfo' value='Add Information'>";
		} else if ($type=='staff')
		{
			echo "<tr>
				<td><label for='name'>Name: </label></td>
				<td><input type='text' id='name' name='name' maxlength='80'></td>
			</tr>
			<tr>
				<td><label for='homeaddress'>Address: </label></td>
				<td><input type='text' id='address' name='address' maxlength='80'></td>
			</tr>
			<tr>
				<td><label for='contactnumber'>Contact Number: </label></td>
				<td><input type='text' id='contactnumber' name='contactnumber' pattern='[0-9]{11}'></td>
			</tr>
			<tr>
				<td><label for='stafftype'>Type: </label></td>
				<td>
					<select id='stafftype' name='stafftype'>
						<option value='Dorm Manager'>Dorm Manager</option>
						<option value='Maintenance'>Maintenance</option>
						<option value='Guard'>Guard</option>
					</select>
				</td>
			</tr>
			</table>
			<br />
			<input type='submit' id='addstaffinfo' name='addstaffinfo' value='Add Information'>";
		}
	}
	
	public function addDormerInformation($username, $name, $studentnumber, $course, $birthdate,	$age, $homeaddress, $contactnumber,	$contactperson, $contactpersonnumber)
	{
		$stmt="SELECT count(*) FROM dormer WHERE student_number='$studentnumber';";
		$count=pg_fetch_array(pg_query($stmt));
		
		if($count[0]==0)
		{
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
	
	public function addStaffInformation($username, $name, $address, $contactnumber, $stafftype)
	{
		$stmt="UPDATE STAFF SET name='$name', address='$address', contact_number='$contactnumber', type='$stafftype'";
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
}
?>
