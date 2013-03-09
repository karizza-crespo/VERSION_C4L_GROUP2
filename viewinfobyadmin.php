<?php
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']=='staff')
{
	$stmt="SELECT type from staff WHERE username='".$_SESSION['username']."';";
	$result=pg_fetch_array(pg_query($stmt));
	
	if($result[0]!='Dorm Manager')
		header('Location: signin.php');
}
else if($_SESSION['accountType']!='admin')
{
	header('Location: signin.php');
	die;
}

//set the searchUsername session to none
$_SESSION['searchUsername']='none';
$_SESSION['infoSearchFlagDormer']=0;
$_SESSION['infoSearchFlagStaff']=0;
?>

<html>
	<head>
		<title>.::Dormitory Management System::.</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="js/toast/resources/css/jquery.toastmessage.css" />
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/toast/javascript/jquery.toastmessage.js"></script>
		<script src="js/script.js"></script>
		<script>
			$().ready(function(){
				$("div.listOfDormers").hide();
				$("div.listOfStaff").hide();
				$(".dormerList").click(function(){
					$("div.listOfDormers").slideToggle();
				});
				$(".staffList").click(function(){
					$("div.listOfStaff").slideToggle();
				});
			});
		</script>
	</head>
	<body>
		<br />
		<form name="searchSpecificDormer" action="searchresults.php" method="post">
			<table class='search'>
				<tr>
					<td><label for='viewDormerInfo'>Search Dormer By Username: </label></td>
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
			<table class='search'>
				<tr>
					<td><label for='viewStaffInfo'>Search Staff by Staff Number:</label></td>
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
					echo "<br /><center><div class='dormerList' title='List of Dormers'><h2>LIST OF DORMERS</h2></div></center>";
					echo "<div class='listOfDormers'>";
					$manager->printViewInfoByAdmin($dormers, 'dormer');
					echo "</div>";
				}
				else
					echo "<br /><span style='color:red; font-size:1.35em; font-weight:bold;'><center>Dormer Table is Empty.</center></span><br /><br />";

				$staff = $manager->retrieveAllStaff();
				if($staff!=null)
				{
					echo "<center><div class='staffList' title='List of Staff'><h2>LIST OF STAFF</h2></div></center>";
					echo "<div class='listOfStaff'>";
					$manager->printViewInfoByAdmin($staff, 'staff');
					echo "</div>";
				}
				else
					echo "<br /><span style='color:red; font-size:1.35em; font-weight:bold;'><center>Staff Table is Empty.</center></span><br /><br />";
			?>
		</form>
		<br />
		<br />
	</body>
</html>