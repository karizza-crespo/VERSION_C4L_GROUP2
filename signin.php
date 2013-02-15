<?php
include("functions.php");
session_start();

<<<<<<< HEAD:login.php
$_SESSION['username']='none';
$_SESSION['accountType']='notLoggedIn';
=======
//------------------------------check kung may initial value  na yung account type-----------------------------------
if(empty($_SESSION['accountType']))
{
	//kapag wala pa, initialize yung account type to notLoggedIn and yung username to none
	$_SESSION['accountType']='notLoggedIn';
	$_SESSION['username']='none';
}
//otherwise..punta sa homepage ng kung anu mang type yung user
else
{
	if($_SESSION['accountType']=='dormer')
		header("Location:dormer_db.php");
	else if ($_SESSION['accountType']=='staff')
		header("Location:staff_db.php");
	else if ($_SESSION['accountType']=='admin')
		header("Location:admin_db.php");
}
>>>>>>> fd5935510e3342ff30b9960f409296519d5e59a2:signin.php

if(isset($_POST['login'])){
	//get the username
	$username = $_POST['username'];  
	//get the password
	$password = $_POST['password'];
	
	//check if admin
	if(($username=='postgres') && ($password =='password')){
			$_SESSION['username'] = 'postgres';
			$_SESSION['accountType']='admin';
			header('Location: admin_db.php');
			die;
		}
	else {
		$stmt="SELECT count(*) FROM dormer WHERE username='$username' and password='$password';";
		$count=pg_fetch_array(pg_query($stmt));
		
		
		if($count[0]!=0 ){	
			$_SESSION['username'] = $username;
			$_SESSION['accountType']='dormer';
			header('Location: dormer_db.php');
			die;
		}
		else if ($count[0]==0)
		{
			$stmt="SELECT count(*) FROM staff WHERE username='$username' and password='$password';";
			$anotherCount=pg_fetch_array(pg_query($stmt));
			if($anotherCount[0]!=0 ){	
				$_SESSION['username'] = $username;
				$_SESSION['accountType']='staff';
				header('Location: staff_db.php');
				die;
			}else if ($anotherCount[0]==0){
				echo 'invalid Username/Password';
			}
		}
	}
}
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<LINK HREF="welcome.css" rel="stylesheet" TYPE="text/css">
<title>.::Dormitory Management System::.</title>
</head>

<body>

<div id ="MainContainer">



<h1>Welcome!</h1>
<p></p>



<div id="login">
	<form method="post" action="">
			<table><tr> <td>Username: </td><td> <input type="text" name="username" size="15" /></td></tr>
			<tr><td>Password:</td><td> <input type="password" name="password" size="15" /></td><tr></table><br/>		
			<input type="submit" value="SIGN IN" class="login" name="login" /></center>
		</form>
</div>


</body>
</html>
