
function submitform(f1)
{
	if(document.f1.apipath.value=="")
	{	
		alert("Please enter api path");
		document.f1.apipath.focus();
		return false;
	}
	if(document.f1.domainname.value=="")
	{	
		alert("Please enter domain name");
		document.f1.domainname.focus();
		return false;
	}
	if(document.f1.username.value=="")
	{	
		alert("Please enter username");
		document.f1.username.focus();
		return false;
	}
	if(document.f1.password.value=="")
	{	
		alert("Please enter password");
		document.f1.password.focus();
		return false;
	}
}
