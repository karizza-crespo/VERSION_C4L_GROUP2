<?php 
include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;

session_start();

if($_SESSION['accountType']!='admin')
{
	header('Location: signin.php');
	die;
}
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
				$(".upDormer").hide();
				$(".upStaff").hide();
				$(".dormerList").click(function(){
					$("div.listOfDormers").slideToggle();
					$(".upDormer").toggle();
					$(".downDormer").toggle();
				});
				$(".staffList").click(function(){
					$("div.listOfStaff").slideToggle();
					$(".upStaff").toggle();
					$(".downStaff").toggle();
				});
				$(".isSelected").change(function() {
				    if($(this).is(':checked')) 
				        $(this).parent().parent().addClass('toBeDeleted');
					else 
				      $(this).parent().parent().removeClass('toBeDeleted');
				});
				$('.checkAllUsers').click(function(){
					$(".deleteUsers tr").each(function(i){
						if($(this).hasClass('listOfUsers'))
							$(this).addClass('toBeDeleted');
					});
				});
				$('.uncheckAllUsers').click(function(){
					$(".deleteUsers tr").each(function(i){
						if($(this).hasClass('listOfUsers'))
							$(this).removeClass('toBeDeleted');
					});
				});
			});
		</script>
	</head>
	<body>
		<br />
		<form name="searchSpecificDormer" action="deleteAccountSpecific.php" method="post">
			<table class='search'>
				<tr>
					<td><label for="deleteDormer">Search Dormer By Username: </label></td>
					<td>
						<input type="text" id="deleteDormer" name="deleteDormer" />
					</td>
					<td>
						<input type="submit" value="Search" name="searchDormerByUsername"/>
					</td>
				</tr>
			</table>
		</form>
		<form name="searchSpecificStaff" action="deleteAccountSpecific.php" method="post">
			<table class='search'>
				<tr>
					<td><label for="deleteStaff">Search Staff by Staff Number: </label></td>
					<td>
						<input type="number" id="deleteStaff" name="deleteStaff" />
					</td>
					<td>
						<input type="submit" value="Search" name="searchStaffByNumber"/>
					</td>
				</tr>
			</table>
		</form>
		<br />
		<form name="retrieveAll" onsubmit="return areYouSureDelete()" action="deleteaccount.php" method="post">
			<center>
				<input class='checkAllUsers' type="button" value="Check All" name="check" onclick="checkall();"/>
				<input class='uncheckAllUsers' type="button" value="Uncheck All" name="uncheck" onclick="uncheckall();"/>
				<input class='deleteButtons' type="submit" value="Delete" name="delete" />
			</center>
			<br />
			<?php
				$dormers = $manager->retrieveAllDormers();
					
				if($dormers!=null)
				{
					echo "<br /><center><div class='dormerList' title='List of Dormers'><h2><a class='downDormer'>&darr;</a><a class='upDormer'>&uarr;</a> LIST OF DORMERS <a class='upDormer'>&uarr;</a><a class='downDormer'>&darr;</a></h2></span></center>";
					echo "<div class='listOfDormers'>";
					$manager->printDelete($dormers, 'dormer');
					echo "</div>";
				}
				else
					echo "<br /><span style='color:red; font-size:1.35em; font-weight:bold;'><center>Dormer Table is Empty.</center></span><br /><br />";
					
				$staff = $manager->retrieveAllStaff();
				
				if($staff!=null)
				{
					echo "<center><div class='staffList' title='List of Staff'><h2><a class='downStaff'>&darr;</a><a class='upStaff'>&uarr;</a> LIST OF STAFF <a class='upStaff'>&uarr;</a><a class='downStaff'>&darr;</a></h2></span></center>";
					echo "<div class='listOfStaff'>";
					$manager->printDelete($staff, 'staff');
					echo "</div>";
				}
				else
					echo "<br /><span style='color:red; font-size:1.35em; font-weight:bold;'><center>Staff Table is Empty.</center></span><br /><br />";
				
				if(isset($_POST['delete']))
				{
					$deleteDormers=$_POST['dormer'];
					$deleteStaff=$_POST['staff'];
					$manager->deleteAccounts($deleteDormers, $deleteStaff);
					header('Location: deleteaccount.php');
				}
			?>
		</form>
		<br />
		<br />
	</body>
</html>