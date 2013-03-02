<?php
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

//if the account type is not admin, return to sign in page
if($_SESSION['accountType']!='admin')
{
	header('Location: signin.php');
	die;
}

//set the searchUsername session to none
$_SESSION['searchUsername']='none';
?>

<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<form name="searchSpecificDormer" action="searchresults.php" method="post">
			<table>
				<tr>
					<td>Search Dormer By Username: </td>
					<td>
						<input type="text" id="viewDormerInfo" name="viewDormerInfo" />
					</td>
					<td>
						<input type="submit" value="Search" name="searchDormerByUsername"/>
					</td>
				</tr>
			</table>
		</form>
		<form name="searchSpecificStaff" action="searchresults.php" method="post">
			<table>
				<tr>
					<td>Search Staff by Staff Number: </td>
					<td>
						<input type="number" id="viewStaffInfo" name="viewStaffInfo" min='1'/>
					</td>
					<td>
						<input type="submit" value="Search" name="searchStaffByNumber"/>
					</td>
				</tr>
			</table>
		</form>

		<form name="retrieveAll" action="editinfobyadmin.php" method="post">
			<?php
				$dormers = $manager->retrieveAllDormers();

				if($dormers!=null)
				{
					echo "<br />DORMERS: <br /><br />";
					$manager->printViewInfoByAdmin($dormers, 'dormer');
				}
				else
					echo "<span style='color:red'>Dormer Table is Empty.</span><br />";

				echo "<br />";

				$staff = $manager->retrieveAllStaff();

				if($staff!=null)
				{
					echo "<br />STAFF: <br /><br />";
					$manager->printViewInfoByAdmin($staff, 'staff');
				}
				else
					echo "<span style='color:red'>Staff Table is Empty.</span><br />";
			?>
		</form>
		<br />
		<a href="admin_db.php" title="Back to Admin Home Page">Back to Admin Home Page</a>
	</body>
</html>