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
		<script src="js/script.js"></script>
		<script src="js/jquery-1.7.2.min.js"></script>
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
		<form name="retrieveAll" onsubmit="return areYouSureDelete()" action="deleteaccount.php" method="post">
			<br />
			<center>
				<input class='checkAllUsers' type="button" value="Check All" name="check" onclick="checkall();"/>
				<input class='uncheckAllUsers' type="button" value="Uncheck All" name="uncheck" onclick="uncheckall();"/>
				<input class='deleteButtons' type="submit" value="Delete" name="delete" />
			</center>
			<br />
			<?php
				if(isset($_POST['searchDormerByUsername']))
				{
					$dormers = $manager->searchDormer($_POST['deleteDormer']);
					
					if($dormers!=null)
					{
						echo "<br /><center><h2>DORMER:</h2></center>";
						$manager->printDelete($dormers, 'dormer');
					}
					else if (count($dormers)==0)
						echo "<br /><span style='color:red; font-size:1.35em; font-weight:bold;'><center>".$_POST['deleteDormer']." is not in the Database.</center></span><br />";
					else
						echo "<br /><span style='color:red; font-size:1.35em; font-weight:bold;'><center>Dormer Table is Empty.</center></span><br />";
						
					echo "<br />";
				}
				if(isset($_POST['searchStaffByNumber']))
				{
					$staff = $manager->searchStaff($_POST['deleteStaff']);
				
					if($staff!=null)
					{
						echo "<br /><center><h2>STAFF:</h2></center>";
						$manager->printDelete($staff, 'staff');
					}
					else if (count($staff)==0)
						echo "<br /><span style='color:red; font-size:1.35em; font-weight:bold;'><center>".$_POST['deleteStaff']." is not in the Database.</center></span><br />";
					else
						echo "<br /><span style='color:red; font-size:1.35em; font-weight:bold;'><center>Staff Table is Empty.</center></span><br />";
				}
				if(isset($_POST['delete']))
				{
					$deleteDormers=$_POST['dormer'];
					$deleteStaff=$_POST['staff'];
					$manager->deleteAccounts($deleteDormers, $deleteStaff);
					header('Location: deleteaccount.php');
				}
			?>
		</form>
		<a class="back" href="deleteaccount.php" title="back to list of accounts">Back to List of Accounts</a>
	</body>
</html>