function resetPicture(element)
{
	src = element.src.split('/');
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "mvc/controller/ajax.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	if (src[src.length - 1] === "img_avatar.png")
	{
		element.src = "public/img/img_avatar2.png";
		xmlhttp.send("changepp=public/img/img_avatar2.png");
	}
	else if (src[length - 1] === "img_avatar2.png")
	{
		element.src = "public/img/img_avatar.png";
		xmlhttp.send("changepp=public/img/img_avatar.png");
	}
	else
	{
		element.src = "public/img/img_avatar.png";
		xmlhttp.send("changepp=public/img/img_avatar.png");
	}
}

function showname()
{
	input = document.getElementById('name');
	if (input.style.display === 'none')
		input.style.display = 'block';
	else if (input.style.display === 'block')
		input.style.display = 'none';
}

function showemail()
{
	input = document.getElementById('email');
	if (input.style.display === 'none')
		input.style.display = 'block';
	else if (input.style.display === 'block')
		input.style.display = 'none';
}

function showpass()
{
	input = document.getElementById('pass');
	if (input.style.display === 'none')
		input.style.display = 'block';
	else if (input.style.display === 'block')
		input.style.display = 'none';
}

function changeNotify(element)
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "mvc/controller/ajax.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	if (element.checked === true)
		xmlhttp.send("changenotify=1");
	if (element.checked === false)
		xmlhttp.send("changenotify=2");
}
