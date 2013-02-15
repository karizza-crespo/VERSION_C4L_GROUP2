<?php
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']!='admin')
{
<<<<<<< HEAD
	header('Location: login.php');
=======
	header('Location: signin.php');
>>>>>>> fd5935510e3342ff30b9960f409296519d5e59a2
	die;
}

$_SESSION['searchUsername']='none';
?>

<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<form name="searchSpecificDormer" action="addsearchresults.php" method="post">
			<table>
				<tr>
					<td>Search Dormer By Username: </td>
					<td>
						<select id="addInfoDormer" name="addInfoDormer"><?php $manager->printUsername();?></select>
					</td>
					<td>
						<input type="submit" value="Search" name="searchDormerByUsername"/>
					</td>
				</tr>
			</table>
		</form>
		<form name="searchSpecificStaff" action="addsearchresults.php" method="post">
			<table>
				<tr>
					<td>Search Staff by Staff Number: </td>
					<td>
						<select id="addInfoStaff" name="addInfoStaff"><?php $manager->printStaffNumber();?></select>
					</td>
					<td>
						<input type="submit" value="Search" name="searchStaffByNumber"/>
					</td>
				</tr>
			</table>
		</form>

		<form name="retrieveAll" action="addinfobyadminspecific.php" method="post">
			<?php
				$dormers = $manager->retrieveAllDormers();

				if($dormers!=null)
				{
					echo "<br />DORMERS: <br /><br />";
					$manager->printAddInfo($dormers, 'dormer');
				}
				else
					echo "<span style='color:red'>Dormer Table is Empty.</span><br />";

				echo "<br />";

				$staff = $manager->retrieveAllStaff();

				if($staff!=null)
				{
					echo "<br />STAFF: <br /><br />";
					$manager->printAddInfo($staff, 'staff');
				}
				else
					echo "<span style='color:red'>Staff Table is Empty.</span><br />";
			?>
		</form>
		<br />
		<a href="admin_db.php" title="Back to Admin Home Page">Back to Admin Home Page</a>
	</body>
</html>