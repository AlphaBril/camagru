function modalImg(element)
{
	var img = document.getElementById("modalimg");
	var modal = document.getElementById("myModal");
	modal.style.display = "flex";
	img.src = element.src;
}

function changeprofilepic()
{
	name = document.getElementById('modalimg').src;
	clean = name.split('/');
	cleaned = clean[3] + '/' + clean[4] + '/' + clean[5] + '/' + clean[6] + '/' + clean[7];
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "mvc/controller/ajax.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("changepp=" + cleaned);
	setTimeout(reload, 100);
}

function closeModal()
{
	var modal = document.getElementById("myModal");
	modal.style.display = "none";
}

function subscribe(element)
{
	name = element.name;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "mvc/controller/ajax.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	if (element.innerHTML == "Press to follow")
		xmlhttp.send("follow=" + name);
	else
		xmlhttp.send("unfollow=" + name);
	setTimeout(reload, 100);
}

function delPic(element)
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "mvc/controller/ajax.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("delpic=" + element.value);
	setTimeout(reload, 100);
}

function reload()
{
	document.location.reload(true);
}
