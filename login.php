<?php

// connect to database
$host = "localhost"; 
$user = "postgres"; 
$pass = "password"; 
$db = "postgres";
 
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
or die ("Could not connect to server\n"); 	
	
		
if(isset($_POST['login'])){
	//get the username
	$username = preg_replace('/[^A-Za-z]/', '', $_POST['username']);  
	//get the password
	$password = $_POST['password'];
	
	//check if admin
	if(($username=='postgres') && ($password =='password')){
			session_start();
			$_SESSION['username'] = 'postgres';
			header('Location: admin_db.php');
			die;
		}
	else {
		$stmt="SELECT count(*) FROM dormer WHERE username='$username' and password='$password';";
		$count=pg_fetch_array(pg_query($stmt));
		
		
		if($count[0]!=0 ){	
			session_start();
			$_SESSION['username'] = $username;
			header('Location: dormer_db.php');
			die;
		}
		else if ($count[0]==0)
			{
			$stmt="SELECT count(*) FROM staff WHERE username='$username' and password='$password';";
			$count=pg_fetch_array(pg_query($stmt));
			if($count[0]!=0 ){	
				session_start();
				$_SESSION['username'] = $username;
				header('Location: staff_db.php');
				die;
			}else if ($count[0]==0){
			echo 'invalid Username/Password';
			}
	}}}
	 	
		
	
	

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<LINK HREF="welcome.css" rel="stylesheet" TYPE="text/css">
<title><center>Welcome</center></title>

</head>

<body>

<div id ="MainContainer">



<h1>Welcome!</h1>
<p></p>


<a href="register.php" >Register</a>



<div id="login">
<?php
			if($error){
				echo '<p><center>Invalid username and/or password</center></p>';
			}
			?>
			
<form method="post" action="">
			<table><tr> <td>Username: </td><td> <input type="text" name="username" size="15" /></td></tr>
			<tr><td>Password:</td><td> <input type="password" name="password" size="15" /></td><tr></table><br/>
			<?php
			if($error){
				echo '<p><center>Invalid username and/or password</center></p>';
			}
			?>
			
			<input type="submit" value="LOGIN" class="login" name="login" /></center>
		</form>
</div>


</body>
</html>
