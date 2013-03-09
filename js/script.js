//function for selecting all the checkboxes
function checkall()
{
	var target=document.getElementsByTagName('input');
	for(i=0; i<target.length; i++)
	{
		if(target[i].type=='checkbox')
			target[i].checked='checked';
	}
}

//function for unselecting all the checkboxes
function uncheckall()
{
	var target=document.getElementsByTagName('input');
	for(i=0; i<target.length; i++)
	{
		if(target[i].type=='checkbox')
				target[i].checked='';
	}
}

//function for validating the update payment form
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
			//if it encountered a box without a value, an alert box would appear informing the user
			if(!box.value)
			{
				alert('You haven\'t filled in the '+box.name+'.');
				box.focus();
				return false;
			}
		}
	}
	//return true if the form is complete
	return true;
}

//function for validating the add payment form
function validateAddPaymentForm()
{
	var box, i;
	var form = document.addPayment;
	
	for(i=0; i<4; i++)
	{
		box=form.elements[i];
		//if it encountered a box without a value, an alert box would appear informing the user
		if(!box.value)
		{
			alert('You haven\'t filled in the '+box.name+'.');
			box.focus();
			return false;
		}
	}
	//if the form is complete, a confirm box would appear asking the user if he/she wants to continue
	var confirmAdd = confirm("Continue Addition of Payment Entry?");
	
	//return the answer of the user (true or false)
	return confirmAdd;
}

//function for showing a confirm box for delete
function areYouSureDelete()
{
	var confirmDelete = confirm("Continue Delete?");
	
	return confirmDelete;
}

//functions for disabling and enabling the whereabouts text field (filllogs)
function option1() 
{
	document.myform.elements[2].disabled=1; 
}

function option2() 
{
	document.myform.elements[2].disabled=0;
}

//function for checking if there is a value in the whereabouts textfield if log out is selected
function addWhereabouts()
{
	var box, i;
	var form = document.myform;
	
	if(form.elements[1].checked)
	{
		box=form.elements[2];
		//return false if there is no value in the whereabouts text field
		if(!box.value)
		{
			$().toastmessage({position:'middle-center'});
			$().toastmessage('showErrorToast', "You haven't filled in the whereabouts.");
			box.focus();
			return false;
		}
	}
	return true;
}

//function for showing and hiding information on register
function showhide()
{
	dormer=document.getElementById('dormer');
	//if the dormer option is selected, display the fields for student number and room number and hide the field for staff type
	if(dormer.checked)
	{
		document.getElementById('studentnumber').style.display = 'block';
		document.getElementById('studentnumberlabel').style.display = 'block';
		document.getElementById('roomnumber').style.display = 'block';
		document.getElementById('roomnumberlabel').style.display = 'block';
		document.getElementById('stafftype').style.display = 'none';
		document.getElementById('stafftypelabel').style.display = 'none';
	}
	//if the staff option is selected, show the field for staff type and hide the fields for student number and room number
	else
	{
		document.getElementById('studentnumber').style.display = 'none';
		document.getElementById('studentnumberlabel').style.display = 'none';
		document.getElementById('roomnumber').style.display = 'none';
		document.getElementById('roomnumberlabel').style.display = 'none';
		document.getElementById('stafftype').style.display = 'block';
		document.getElementById('stafftypelabel').style.display = 'block';
	}
}

//function for validating the edit dormer information form
function validateEditDormerInformationForm()
{
	var box, i;
	var form = document.editDormerInformation;
	
	for(i=0; i<9; i++)
	{
		box=form.elements[i];
		//if it encountered a box without a value, an alert box would appear informing the user
		if(!box.value)
		{
			alert('You haven\'t filled in the '+box.name+'.');
			box.focus();
			return false;
		}
	}
	//return true if the form is complete
	return true;
}

//function for validating the edit staff information form
function validateEditStaffInformationForm()
{
	var box, i;
	var form = document.editStaffInformation;
	
	for(i=0; i<3; i++)
	{
		box=form.elements[i];
		//if it encountered a box without a value, an alert box would appear informing the user
		if(!box.value)
		{
			alert('You haven\'t filled in the '+box.name+'.');
			box.focus();
			return false;
		}
	}
	//return true if the form is complete
	return true;
}

//function for validating the register form
function validateRegister()
{
	var box, i;
	var form = document.registerForm;
	
	//if the staff option is checked, skip checking the fields for student number and room number
	if(form.elements[4].checked)
	{
		for(i=0; i<8; i++)
		{
			box=form.elements[i];
			if(i==5 || i==7)
				continue;
			else
			{
				//if it encountered a box without a value, an alert box would appear informing the user
				if(!box.value)
				{
					alert('You haven\'t filled in the '+box.name+'.');
					box.focus();
					return false;
				}
			}
		}
	}
	//if the dormer option is checked, check the fields
	else
	{
		for(i=0; i<8; i++)
		{
			box=form.elements[i];
			//if it encountered a box without a value, an alert box would appear informing the user
			if(!box.value)
			{
				alert('You haven\'t filled in the '+box.name+'.');
				box.focus();
				return false;
			}
		}
	}
	//return true if the form is complete
	return true;
}

//function for validating edit dormer information by admin
function validateEditInfoByAdminDormer()
{
	var box, i;
	var form=document.editInfoDormer;
	
	for(i=0; i<7; i++)
	{
		box=form.elements[i];
		//if it encountered a box without a value, an alert box would appear informing the user
		if(!box.value)
		{
			alert('You haven\'t filled in the '+box.name+'.');
			box.focus();
			return false;
		}
	}
	//return true if the form is complete
	return true;
}

//function for validating edit staff information by admin
function validateEditInfoByAdminStaff()
{
	var box, i;
	var form=document.editInfoStaff;
	
	for(i=0; i<3; i++)
	{
		box=form.elements[i];
		//if it encountered a box without a value, an alert box would appear informing the user
		if(!box.value)
		{
			alert('You haven\'t filled in the '+box.name+'.');
			box.focus();
			return false;
		}
	}
	//return true if the form is complete
	return true;
}