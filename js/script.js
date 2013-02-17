//javascript! 
function checkall()
{
	var target=document.getElementsByTagName('input');
	for(i=0; i<target.length; i++)
	{
		if(target[i].type=='checkbox')
			target[i].checked='checked';
	}
}

function uncheckall()
{
	var target=document.getElementsByTagName('input');
	for(i=0; i<target.length; i++)
	{
		if(target[i].type=='checkbox')
				target[i].checked='';
	}
}

function validateUpdatePaymentForm()
{
	var box, i;
	var form = document.update;
	
	for(i=2; i<7; i++)
	{
		if(i==4 || i==5)
			continue;
		else
		{
			box=form.elements[i];
			if(!box.value)
			{
				alert('You haven\'t filled in the '+box.name+'.');
				box.focus();
				return false;
			}
		}
	}
	return true;
}

function validateAddPaymentForm()
{
	var box, i;
	var form = document.addPayment;
	
	for(i=0; i<4; i++)
	{
		box=form.elements[i];
		if(!box.value)
		{
			alert('You haven\'t filled in the '+box.name+'.');
			box.focus();
			return false;
		}
	}
	return true;
}

function areYouSureDelete()
{
	var confirmDelete = confirm("Continue Delete?");
	
	return confirmDelete;
}