<?php
//sessions --pakiayos na lang
session_start();
if($_SESSION['username']!=$_SESSION['username']){
	header('Location: login.php');
	die;
}

// connect to database
$host = "localhost"; 
$user = "postgres"; 
$pass = "password"; 
$db = "postgres";
 
 
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
or die ("Could not connect to server\n");


$current_user = $_SESSION['username'];
$log_type = $_POST['button'];
$whereabouts = $_POST['whereabouts']; 
$default_char = 'dorm';
$login = 'logged in';
$logout = 'logged out';
$default_int = 10;
$default_date= '2013-02-07';
$date =  sprintf("%04d-%02d-%02d",$year,$month,$day);
$default_time = '12:00:00.00';




if ($log_type==1){
			//insert values into the table named logs
			$stmt="INSERT INTO log (log_date, log_time, type, whereabouts) VALUES (current_date,current_time,'$login','$default_char');";
			$success=pg_query($con, $stmt) or die("Cannot execute query: $query\n");
			//echo $stmt;
		}
	
	
if ($log_type ==2){
			//insert values into the table named logs
			$stmt="INSERT INTO log (log_date, log_time, type, whereabouts) VALUES (current_date,current_time,'$logout','$whereabouts');";
			//$success=pg_query($stmt);
			$success=pg_query($con, $stmt) or die("Cannot execute query: $query\n");
			//echo $stmt;
		
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<LINK HREF="welcome.css" rel="stylesheet" TYPE="text/css">
<title>Welcome</title>

<script> function option1() {document.myform.whereabouts.disabled=1; }
		function option2() {document.myform.whereabouts.disabled=0;} 
</script> 

</head>

<body>

<h1>Welcome, Dormer: <?php echo $current_user ?> 	!!!</h1>

	
<form method="post" action="" name="myform" enctype=”multipart/form-data”>
		
	<input type="radio" name="button" value="1" onclick = option1()>IN</br>
    <input type="radio" name="button" value="2" onclick = option2()>OUT</br>
		
		
		Whereabouts:<br />
		<textarea rows = "6" cols ="20" name="whereabouts" id="whereabouts" disabled=1>
		Hey! Where are you going?
		</textarea><br />
	
		
	
	<input type="submit" value="Submit" />
</form>	
		
		

 <a href="logout.php">Log Out </a></br>


</body>
</html>