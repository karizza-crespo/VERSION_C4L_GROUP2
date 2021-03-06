<?php
include("functions.php");
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>.::DMS::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<style>
			body
			{
				overflow:hidden;
				background-image:url('pics/1.jpg');
			}
		</style>
		<link rel="stylesheet" type="text/css" href="js/toast/resources/css/jquery.toastmessage.css" />
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/toast/javascript/jquery.toastmessage.js"></script>
		<script src="js/script.js"></script>
		<script>
			$().ready(function(){
				$("#systemName").hide();
				$("#systemName").fadeIn(3500);
			});
		</script>
	</head>
	<body>
		<div id="largeContainer">
			<img src="css/pics/1.jpg" />
		</div>
		<div id="systemName">
			<div id="titleDorm">
				<br/>
				<a class="DMS" href="signin.php">Dormitory Management System</a>
			</div>
			
			<br/>
			<br/><br/>
			<hr />
			
			<div id="signIn">
				<?php
				//check if the session accountType already has an initial value
				if(empty($_SESSION['accountType']))
				{
					//if false, initialize the account type to notLoggedIn and the username to none
					$_SESSION['accountType']='notLoggedIn';
					$_SESSION['username']='none';
				}
				//otherwise, go to the home page of whatever the account type of the user is
				else
				{
					if($_SESSION['accountType']=='dormer')
						header("Location:dormer_db.php");
					else if ($_SESSION['accountType']=='staff')
						header("Location:staff_db.php");
					else if ($_SESSION['accountType']=='admin')
						header("Location:admin_db.php");
				}

				if(isset($_POST['login'])){
					//get the username
					$username = $_POST['username'];  
					//get the password
					$password = $_POST['password'];

					$stmt="SELECT count(*) FROM admin WHERE username='$username' and password='$password';";
					$count=pg_fetch_array(pg_query($stmt));
					
					//check if the user is an administrator
					if($count[0]!=0){
							$_SESSION['username'] = $username;
							$_SESSION['accountType']='admin';
							header('Location: admin_db.php');
							die;
					}
					else {
						$stmt="SELECT count(*) FROM dormer WHERE username='$username' and password='$password';";
						$count=pg_fetch_array(pg_query($stmt));

						//check if the user is a dormer
						if($count[0]!=0 ){	
							$_SESSION['username'] = $username;
							$_SESSION['accountType']='dormer';
							header('Location: dormer_db.php');
							die;
						}
						//check if the user is a staff
						else if ($count[0]==0)
						{
							$stmt="SELECT count(*) FROM staff WHERE username='$username' and password='$password';";
							$anotherCount=pg_fetch_array(pg_query($stmt));
							if($anotherCount[0]!=0 ){	
								$_SESSION['username'] = $username;
								$_SESSION['accountType']='staff';
								header('Location: staff_db.php');
								die;
							}
							//if user is not in any of the tables, print invalid username and/or password
							else if ($anotherCount[0]==0){
								echo '<span style="color:red"> Invalid Username and/or Password</span>';
							}
						}
					}
				}
				?>
				<!--sign in form-->
				<form method="post" action="">
					<table class='signInTable'>
						<tr>
							<td><label for="username">Username: </label></td>
						</tr>
						<tr>
							<td colspan='2'> <input class='inputSignIn' type="text" name="username" id="username" /></td>
						</tr>
						<tr>
							<td><label for="password">Password: </label></td>
						</tr>
						<tr>
							<td colspan='2'> <input class='inputSignIn' type="password" name="password" id="password" /></td>
						<tr>
						<tr>
							<td><input class='inputSignIn' type="submit" value="Sign In" class="login" name="login" /></td>
						</tr>
					</table>
				</form>
			</div>
			<hr />
			<br/><br/><br/><br/>
			<div id='footer'>
				Copyright &copy;2013. CMSC 128 C-4L Group 2. All rights reserved.
			</div>
		</div>
	</body>
</html>
