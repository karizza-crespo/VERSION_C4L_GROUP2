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

function option1() 
{
	document.myform.elements[2].disabled=1; 
}

function option2() 
{
	document.myform.elements[2].disabled=0;
} 

function addWhereabouts()
{
	var box, i;
	var form = document.myform;
	
	if(form.elements[1].checked)
	{
		box=form.elements[2];
		if(!box.value)
		{
			alert('You haven\'t filled in the '+box.name+'.');
			box.focus();
			return false;
		}
	}
	return true;
}

function showhide(id1, id2)
{
	document.getElementById(id1).style.display = 'block';
	document.getElementById(id1+'label').style.display = 'block';
	document.getElementById(id2).style.display = 'none';
	document.getElementById(id2+'label').style.display = 'none';
}