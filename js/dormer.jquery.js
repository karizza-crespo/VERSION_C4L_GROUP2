$().ready(function(){
	//when the welcome label is clicked the page would go to the dormer home page
	$('.refreshpage').click(function(){
		$('body').load('dormer_db.php');
	});
	//when buttons are clicked, a specific page would be shown, the button clicked would have a different opacity than the rest of the buttons
	$('.staffschedule').click(function(){
		$('#dormerBodyContainer').html('<iframe src="sched.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.viewdormerinfo').removeClass('opaquebutton');
		$('.filluplogs').removeClass('opaquebutton');
	});
	$('.viewlogs').click(function(){
		$('#dormerBodyContainer').html('<iframe src="viewlogs.php" width="99.5%" height="99%" overflow="auto"></iframe>');
		$(this).addClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
		$('.viewdormerinfo').removeClass('opaquebutton');
		$('.filluplogs').removeClass('opaquebutton');
	});
	$('.displaypersonalinfo').click(function(){
		$('#dormerBodyContainer').html('<iframe src="viewdormerinformation.php" width="99.5%" height="99%"></iframe>');
		$('.viewdormerinfo').addClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
		$('.filluplogs').removeClass('opaquebutton');
	});
	$('.viewdormerinfo').click(function(){
		$('#dormerBodyContainer').html('<iframe src="viewdormerinformation.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
		$('.filluplogs').removeClass('opaquebutton');
	});
	$('.filluplogs').click(function(){
		$('#dormerBodyContainer').html('<iframe src="filllogs.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.viewdormerinfo').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
});