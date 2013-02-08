<?php

session_start();
if($_SESSION['username']!='postgres'){
	header('Location: login.php');
	die;
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

<h1>Welcome, Administrator!</h1>

 <a href="logout.php">Logout </a></br>
 <a href="register.php">Register </a>




</body>
</html>