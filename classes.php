<?php
/*etong mga classes ginawa ko para pag nagretrieve tayo sa table, itetreat natin yun as object*/
/*constructor, setters and getters*/

class Dormer
{
	private $username;
	private $password;
	private $name;
	private $student_number;
	private $home_address;
	private $contact_number;
	private $birthdate;
	private $age;
	private $course;
	private $contact_person;
	private $contact_person_number;
	private $room_number;
	
	function __construct($username, $password, $name, $student_number, $home_address, $contact_number, $birthdate, $age, $course, $contact_person, $contact_person_number, $room_number)
	{
		$this->username=$username;
		$this->password=$password;
		$this->name=$name;
		$this->student_number=$student_number;
		$this->home_address=$home_address;
		$this->contact_number=$contact_number;
		$this->birthdate=$birthdate;
		$this->age=$age;
		$this->course=$course;
		$this->contact_person=$contact_person;
		$this->contact_person_number=$contact_person_number;
		$this->room_number=$room_number;
	}
	
	public function setUsername($username)
	{
		$this->username=$username;
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function setPassword($password)
	{
		$this->password=$password;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function setName($name)
	{
		$this->name=$name;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function setStudentNumber($student_number)
	{
		$this->student_number=$student_number;
	}
	
	public function getStudentNumber()
	{
		return $this->student_number;
	}
	
	public function setHomeAddress($home_address)
	{
		$this->home_address=$home_address;
	}
	
	public function getHomeAddress()
	{
		return $this->home_address;
	}
	
	public function setContactNumber($contact_number)
	{
		$this->contact_number=$contact_number;
	}
	
	public function getContactNumber()
	{
		return $this->contact_number;
	}
	
	public function setBirthdate($birthdate)
	{
		$this->birthdate=$birthdate;
	}
	
	public function getBirthdate()
	{
		return $this->birthdate;
	}
	
	public function setAge($age)
	{
		$this->age=$age;
	}
	
	public function getAge()
	{
		return $this->age;
	}
	
	public function setCourse($course)
	{
		$this->course=$course;
	}
	
	public function getCourse()
	{
		return $this->course;
	}
	
	public function setContactPerson($contact_person)
	{
		$this->contact_person=$contact_person;
	}
	
	public function getContactPerson()
	{
		return $this->contact_person;
	}
	
	public function setContactPersonNumber($contact_person_number)
	{
		$this->contact_person_number=$contact_person_number;
	}
	
	public function getContactPersonNumber()
	{
		return $this->contact_person_number;
	}
	
	public function setRoomNumber($room_number)
	{
		$this->room_number=$room_number;
	}
	
	public function getRoomNumber()
	{
		return $this->room_number;
	}
}

class Log
{
	private $log_id;
	private $log_date;
	private $log_time;
	private $log_type;
	private $whereabouts;
	
	function __construct($log_id, $log_date, $log_time, $log_type, $whereabouts)
	{
		$this->log_id=$log_id;
		$this->log_date=$log_date;
		$this->log_time=$log_time;
		$this->log_type=$log_type;
		$this->whereabouts=$whereabouts;
	}
	
	function setLogId($log_id)
	{
		$this->log_id=$log_id;
	}
	
	function getLogId()
	{
		return $this->log_id;
	}
	
	function setLogDate($log_date)
	{
		$this->log_date=$log_date;
	}
	
	function getLogDate()
	{
		return $this->log_date;
	}
	
	function setLogTime($log_time)
	{
		$this->log_time=$log_time;
	}
	
	function getLogTime()
	{
		return $this->log_time;
	}
	
	function setLogType($log_type)
	{
		$this->log_type=$log_type;
	}
	
	function getLogType()
	{
		return $this->log_type;
	}
	
	function setWhereabouts($whereabouts)
	{
		$this->whereabouts=$whereabouts;
	}
	
	function getWhereabouts()
	{
		return $this->whereabouts;
	}
}

class Staff
{
	private $staff_number;
	private $staff_name;
	private $address;
	private $contact_num;
	private $staff_type;
	private $staff_username;
	private $staff_password;
	
	function __construct($staff_number, $staff_name, $address, $contact_num, $staff_type, $staff_username, $staff_password)
	{
		$this->staff_number=$staff_number;
		$this->staff_name=$staff_name;
		$this->address=$address;
		$this->contact_num=$contact_num;
		$this->staff_type=$staff_type;
		$this->staff_username=$staff_password;
	}
	
	function setStaffNumber($staff_number)
	{
		$this->staff_number=$staff_number;
	}
	
	function getStaffNumber()
	{
		return $this->staff_number;
	}
	
	function setStaffName($staff_name)
	{
		$this->staff_name=$staff_name;
	}
	
	function getStaffName()
	{
		return $this->staff_name;
	}
	
	function setAddress($address)
	{
		$this->address=$address;
	}
	
	function getAdress()
	{
		return $this->address;
	}
	
	function setContactNum($contact_num)
	{
		$this->contact_num=$contact_num;
	}
	
	function getContactNum()
	{
		return $this->contact_num;
	}
	
	function setStaffType($staff_type)
	{
		$this->staff_type=$staff_type;
	}
	
	function getStaffType()
	{
		return $this->staff_type;
	}
	
	function setStaffUsername($staff_username)
	{
		$this->staff_username=$staff_username;
	}
	
	function getStaffUsername()
	{
		return $sthis->staff_username;
	}
	
	function setStaffPassword($staff_password)
	{
		$this->staff_password=$staff_password;
	}
	
	function getStaffPassword()
	{
		return $this->staff_password;
	}
}

class Schedule
{
	private $schedule_id;
	private $day;
	private $time;
	private $location;
	
	function __contruct($schedule_id, $day, $time, $location)
	{
		$this->schedule_id=$schedule_id;
		$this->day=$day;
		$this->time=$time;
		$this->location=$location;
	}
	
	function setScheduleId($schedule_id)
	{
		$this->schedule_id=$schedule_id;
	}
	
	function getScheduleId()
	{
		return $this->schedule_id;
	}
	
	function setDay($day)
	{
		$this->day=$day;
	}
	
	function getDay()
	{
		return $this->day;
	}
	
	function setTime($time)
	{
		$this->time=$time;
	}
	
	function getTime()
	{
		return $this->time;
	}
	
	function setLocation($location)
	{
		$this->location=$location;
	}
	
	function getLocation()
	{
		return $this->location;
	}
}

class PaymentRecord
{
	private $payment_number;
	private $dormer_name;
	private $month;
	private $dormer_username;
	private $amount;
	private $date_of_payment;
	
	function __construct($payment_number, $dormer_name, $month, $dormer_username, $amount, $date_of_payment)
	{
		$this->payment_number=$payment_number;
		$this->dormer_name=$dormer_name;
		$this->month=$month;
		$this->dormer_username=$dormer_username;
		$this->amount=$amount;
		$this->date_of_payment=$date_of_payment;
	}
	
	function setPaymentNumber($payment_number)
	{
		$this->payment_number=$payment_number;
	}
	
	function getPaymentNumber()
	{
		return $this->payment_number;
	}
	
	function setDormerName($dormer_name)
	{
		$this->dormer_name=$dormer_name;
	}
	
	function getDormerName()
	{
		return $this->dormer_name;
	}
	
	function setMonth($month)
	{
		$this->month=$month;
	}
	
	function getMonth()
	{
		return $this->month;
	}
	
	function setDormerUsername($dormer_username)
	{
		$this->dormer_username=$dormer_username;
	}
	
	function getDormerUsername()
	{
		return $this->dormer_username;
	}
	
	function setAmount($amount)
	{
		$this->amount=$amount;
	}
	
	function getAmount()
	{
		return $this->amount;
	}
	
	function setDOP($date_of_payment)
	{
		$this->date_of_payment=$date_of_payment;
	}
	
	function getDOP()
	{
		return $this->date_of_payment;
	}
}
?>