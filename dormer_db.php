<?php
$remove = "'";
include("functions.php");

session_start();

if($_SESSION['accountType']!='dormer'){
	header('Location: signin.php');
	die;
}

$current_user = $_SESSION['username'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>.::Dormitory Management System::.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="js/script.js"></script>
	</head>
<body>
	<h1>Welcome, Dormer: <?php echo $current_user ?> 	!!!</h1>

	<?php
	$current='none';
	
	//selects all the entries of the user
	$stmt="SELECT type FROM log WHERE username='$current_user';";
	$result=pg_query($stmt);

	//looks for the last entry of the user
	while($row=pg_fetch_assoc($result))
		$current=$row['type'];

	if(isset($_POST['filluplogs']))
	{	
		$default_char = 'dorm';
		$log_type=$_POST['button'];
		$login = 'logged in';
		$logout = 'logged out';
		
		//if the user selects log in and the user's current status is not logged in, insert to logs
		if ($log_type==1){
			if($current!="logged in")
			{
				//insert values into the table named logs
				$stmt="INSERT INTO log (log_date, log_time, type, whereabouts, username) VALUES (current_date,current_time,'$login','$default_char', '$current_user');";
				$success=pg_query($stmt);
			}
			else
				echo "<span style='color:blue'>You are currently Logged In.</span><br /><br />";
		}
			
		//if the user selects log out and the user's current status is not logged out, insert to logs
		if ($log_type ==2){
			if($current!="logged out")
			{
				$whereabouts = str_replace($remove,"",$_POST['whereabouts']); 
				//insert values into the table named logs
				$stmt="INSERT INTO log (log_date, log_time, type, whereabouts, username) VALUES (current_date,current_time,'$logout','$whereabouts', '$current_user');";
				$success=pg_query($stmt);
			}
			else
				echo "<span style='color:blue'>You are currently Logged Out.</span><br /><br />";
		}
	}
	?>

	Logs: 
		
	<form name="myform" onsubmit="return addWhereabouts();" method="post" action="dormer_db.php">
		<input type="radio" name="button" id="in" value="1" onclick = option1() checked="checked"><label for="in">LOG IN</label>
	    <input type="radio" name="button" id="out" value="2" onclick = option2()><label for="out">LOG OUT</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="whereabouts">Whereabouts:</label><input type="text" name="whereabouts" id="whereabouts" disabled=1>
		<br /><br/>
		
		<input type="submit" name="filluplogs" value="Submit" />
	</form>	
	<br />
	<br />
	
	<a href="viewdormerinformation.php" title="Personal Information">Personal Information</a><br /><br />
	<a href="viewlogs.php" title="View Logs">View Logs</a><br /><br />
	<?php
		echo "<form name='sched' action='sched.php' method='post'>
				<input type='submit' value='Staff Schedule' name='viewSched' />
			</form>";
	?>
	<br />
	 <a href="signout.php">Sign Out </a></br>


</body>
</html>