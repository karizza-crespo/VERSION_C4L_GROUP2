$().ready(function(){
	//when the welcome label is clicked the page would go to the staff home page
	$('.refreshpage').click(function(){
		$('body').load('staff_db.php');
	});
	//when buttons are clicked, a specific page would be shown, the button clicked would have a different opacity than the rest of the buttons
	$('.displaypersonalinfo').click(function(){
		$('#staffBodyContainer').html('<iframe src="viewstaffinformation.php" width="99.5%" height="99%"></iframe>');
		$('.personalinfo').addClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.personalinfo').click(function(){
		$('#staffBodyContainer').html('<iframe src="viewstaffinformation.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.personalinfolist').click(function(){
		$('#staffBodyContainer').html('<iframe src="viewinfobyadmin.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.personalinfo').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.addpayment').click(function(){
		$('#staffBodyContainer').html('<iframe src="addpayment.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.personalinfo').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.updatepayment').click(function(){
		$('#staffBodyContainer').html('<iframe src="updatepayment.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.personalinfo').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.viewlogs').click(function(){
		$('#staffBodyContainer').html('<iframe src="viewlogs.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.personalinfo').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.roomavailability').click(function(){
		$('#staffBodyContainer').html('<iframe src="roomavailability.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.personalinfo').removeClass('opaquebutton');
		$('.staffschedule').removeClass('opaquebutton');
	});
	$('.staffschedule').click(function(){
		$('#staffBodyContainer').html('<iframe src="sched.php" width="99.5%" height="99%"></iframe>');
		$(this).addClass('opaquebutton');
		$('.personalinfolist').removeClass('opaquebutton');
		$('.addpayment').removeClass('opaquebutton');
		$('.updatepayment').removeClass('opaquebutton');
		$('.viewlogs').removeClass('opaquebutton');
		$('.roomavailability').removeClass('opaquebutton');
		$('.personalinfo').removeClass('opaquebutton');
	});
});