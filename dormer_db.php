<?php
include("functions.php");
session_start();
if($_SESSION['username']=='none'){
	header('Location: login.php');
	die;
}
/*
// connect to database
$host = "localhost"; 
$user = "postgres"; 
$pass = "password"; 
$db = "postgres";
 
 
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
or die ("Could not connect to server\n");

*/

$current_user = $_SESSION['username'];
$default_char = 'none';
$login = 'logged in';
$logout = 'logged out';
$default_int = 10;
$default_date= '2013-02-07';
$date =  sprintf("%04d-%02d-%02d",$year,$month,$day);
$default_time = '12:00:00.00';


if ($log_type==1){
			//insert values into the table named logs
			$stmt="INSERT INTO log VALUES ('$default_int',current_date,current_time,'$login','$default_char');";
			$success=pg_query($stmt);
			//echo $stmt;
		}
	
	
if ($log_type ==2){
			//insert values into the table named logs
			$stmt="INSERT INTO log VALUES ('$default_int',current_date,current_time,'$logout','$default_char');";
			$success=pg_query($stmt);
			//echo $stmt;
		
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<LINK HREF="welcome.css" rel="stylesheet" TYPE="text/css">
<title>Welcome</title>

</head>

<body>

<h1>Welcome, Dormer: <?php echo $current_user ?> 	!!!</h1>

	
<form method="post" action="">
		
		<input type="hidden" name="own" value="" id="own">

            <button value="1" input type="submit" name="button" >IN</button>
            <button value="2" input type="submit" name="button" >OUT</button>
			
		</form>

 <a href="logout.php">Log Out </a></br>


</body>
</html>