<?php

// connect to database
$host = "localhost"; 
$user = "postgres"; 
$pass = "password"; 
$db = "postgres";
 
 
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
or die ("Could not connect to server\n");

$errors = array(); /*list array of errors*/
$default_char = 'none';
$default_int = 0;
$default_date= '2013-02-07';

if(isset($_POST['register'])){ /* get the name of the button that is inside the same php file*/
	$username = preg_replace('/[^A-Za-z]/', '', $_POST['username']);
	//$email = $_POST['email'];
	$password = $_POST['password'];
	$c_password = $_POST['c_password'];
	$type = $_POST['type'];
	
	//add to postgres case when username entered already exists 	
	
	
	if($username == ''){
		$errors[] = 'Username is blank';
	}
	
	$stmt="SELECT count(*) FROM dormer WHERE username='$username';";
	$count=pg_fetch_array(pg_query($stmt));
	
	if($count[0]!=0){
		$errors[] = 'username already exists';
	}else{	
		$stmt="SELECT count(*) FROM staff WHERE username='$username';";
		$count=pg_fetch_array(pg_query($stmt));
		
		if($count[0]!=0)
		$errors[] = 'username already exists';
	}	
	
	//if($email == ''){
	//	$errors[] = 'Email is blank';
	//}
	
	if($password == '' || $c_password == ''){
		$errors[] = 'Passwords are blank';
	}
	if($password != $c_password){
		$errors[] = 'Passwords do not match';
	}
		
	if(count($errors) == 0){
		
		
			//echo $type;
	
		 if ($type == 1){
			//insert values into the table named payment_record
			$stmt="INSERT INTO dormer VALUES ('$username', '$password','$default_char','$default_char','$default_char','$default_char','$default_date','$default_int','$default_char','$default_char','$default_char','$default_int');";
			echo $stmt;
			$success=pg_query($stmt);
		}
	
	
		if ($type == 2){
			//insert values into the table named payment_record
			$stmt="INSERT INTO staff VALUES ('$default_int','$default_char','$default_char','$default_char','$default_char','$username','$password');";
			echo $stmt;
			$success=pg_query($stmt);
			if($success)
				echo "sucess";
			else
				echo "fail";
		}
			
		
	}

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<LINK HREF="welcome.css" rel="stylesheet" TYPE="text/css">
<title>Welcome</title>
<SCRIPT language="JavaScript" SRC="swap.js"></SCRIPT>
</head>

<body>

<h1>REGISTRATION FORM</h1>

<form method="post" action="">
		<?php
		if(count($errors) > 0){ //print list of errors
			echo '<ul>';
			foreach($errors as $e){
				echo '<li>' . $e . '</li>';
			}
			echo '</ul>';
		
		} 
	

		?>
		<table><tr>
		<td>Username</td><td> <input type="text" name="username" size="20" /></td></tr>
		<tr><td>Password </td><td><input type="password" name="password" size="20" /></td></tr>
		<tr><td>Confirm Password </td><td><input type="password" name="c_password" size="20" /></td></tr>
		<tr><td>Type of Account</td><td><select id="type" name="type">
							<option value="1">Dormer</option>
							<option value="2">Staff</option>
				</select></tr></td>
		
		<tr><td colspan="2"><center><br/><input type="submit" name="register" class = "register" value="REGISTER" /></td></tr>
		</table>
	</form>

