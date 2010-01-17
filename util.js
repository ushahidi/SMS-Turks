var clearInputValue = Array();
var origInputValue = Array();

function clearInput(thisObj)
{
	if(/password/.test(thisObj.className))
	{
		thisObj.type = "password";
		thisObj.style.color = "black";
		clearInputValue[thisObj.name] = true;
		if(!origInputValue[thisObj.name])
			origInputValue[thisObj.name] = thisObj.value;
		if (thisObj.value == origInputValue[thisObj.name])
			thisObj.value = "";
	}
	else if(!clearInputValue[thisObj.name])
	{
		clearInputValue[thisObj.name] = true;
		if(!origInputValue[thisObj.name])
			origInputValue[thisObj.name] = thisObj.value;
		thisObj.style.color = "black";
		if(thisObj.value == origInputValue[thisObj.name])
			thisObj.value = "";
	}
}

function replaceInput(thisObj)
{
	if(/password/.test(thisObj.className) && clearInputValue[thisObj.name])
	{
		if (thisObj.value == "")
		{
			clearInputValue[thisObj.name] = false;
			thisObj.style.color = "#ccc";
			thisObj.value = origInputValue[thisObj.name];
			thisObj.type = "input";
		}
	}
	else if(thisObj.value == "" || thisObj.value == origInputValue[thisObj.name])
	{
		thisObj.style.color = "#ccc";
		thisObj.value = origInputValue[thisObj.name];
		clearInputValue[thisObj.name] = false;
	}
}