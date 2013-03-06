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
	var confirmAdd = confirm("Continue Addition of Payment Entry?");
	
	return confirmAdd;
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

function showhide()
{
	dormer=document.getElementById('dormer');
	if(dormer.checked)
	{
		document.getElementById('studentnumber').style.display = 'block';
		document.getElementById('studentnumberlabel').style.display = 'block';
		document.getElementById('roomnumber').style.display = 'block';
		document.getElementById('roomnumberlabel').style.display = 'block';
		document.getElementById('stafftype').style.display = 'none';
		document.getElementById('stafftypelabel').style.display = 'none';
	} else
	{
		document.getElementById('studentnumber').style.display = 'none';
		document.getElementById('studentnumberlabel').style.display = 'none';
		document.getElementById('roomnumber').style.display = 'none';
		document.getElementById('roomnumberlabel').style.display = 'none';
		document.getElementById('stafftype').style.display = 'block';
		document.getElementById('stafftypelabel').style.display = 'block';
	}
}

function validateEditDormerInformationForm()
{
	var box, i;
	var form = document.editDormerInformation;
	
	for(i=0; i<7; i++)
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

function validateEditStaffInformationForm()
{
	var box, i;
	var form = document.editStaffInformation;
	
	for(i=0; i<3; i++)
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

function validateRegister()
{
	var box, i;
	var form = document.registerForm;
	
	if(form.elements[4].checked)
	{
		for(i=0; i<7; i++)
		{
			box=form.elements[i];
			if(i==3 || i==4 || i==5)
				continue;
			else
			{
				if(!box.value)
				{
					alert('You haven\'t filled in the '+box.name+'.');
					box.focus();
					return false;
				}
			}
		}
	}
	else
	{
		for(i=0; i<8; i++)
		{
			box=form.elements[i];
			if(i==3 || i==4 || i==6)
				continue;
			else
			{
				if(!box.value)
				{
					alert('You haven\'t filled in the '+box.name+'.');
					box.focus();
					return false;
				}
			}
		}
	}
	return true;
}

function validateEditInfoByAdmin(type)
{
	var box, i;
	var form = document.editInfo;
	
	//dormer
	if(type=='dormer')
	{
		for(i=0; i<7; i++)
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
	//staff
	else if(type=='staff')
	{
		for(i=0; i<3; i++)
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