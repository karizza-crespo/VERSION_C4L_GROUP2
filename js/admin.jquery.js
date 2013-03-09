$().ready(function(){
	//when the welcome label is clicked the page would go to the admin home page
	$('.refreshpage').click(function(){
		$('body').load('admin_db.php');
	});
	//when buttons are clicked, a specific page would be shown, the button clicked would have a different opacity than the rest of the buttons
	$('.registeruser').click(function(){
		$('#adminBodyContainer').html('<iframe src="register.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.deleteaccount').removeClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.deleteaccount').click(function(){
		$('#adminBodyContainer').html('<iframe src="deleteaccount.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.registeruser').removeClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.personalinfolist').click(function(){
		$('#adminBodyContainer').html('<iframe src="viewinfobyadmin.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.deleteaccount').removeClass('opaquebutton');
		$('.registeruser').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.addpayment').click(function(){
		$('#adminBodyContainer').html('<iframe src="addpayment.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.deleteaccount').removeClass('opaquebutton');
		$('.registeruser').removeClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.updatepayment').click(function(){
		$('#adminBodyContainer').html('<iframe src="updatepayment.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.deleteaccount').removeClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.registeruser').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.viewlogs').click(function(){
		$('#adminBodyContainer').html('<iframe src="viewlogs.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.deleteaccount').removeClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.registeruser').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.roomavailability').click(function(){
		$('#adminBodyContainer').html('<iframe src="roomavailability.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.deleteaccount').removeClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
		$('.registeruser').removeClass('opaquebutton');
	});
	$('.staffschedule').click(function(){
		$('#adminBodyContainer').html('<iframe src="sched.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.deleteaccount').removeClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.registeruser').removeClass('opaquebutton');
	});
});