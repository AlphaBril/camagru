function changeChat(element)
{
	data = element.childNodes[1].innerHTML;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "mvc/controller/ajax.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("changechat=" + data);
	setTimeout(reload, 100);
}

function clean()
{
	document.getElementById('bigchat').style.display = 'none';
	document.getElementById('friend').style.display = 'none';
	document.getElementById('notification').style.display = 'none';
	document.getElementById('friendbutton').style.backgroundColor = '#4CAF50';
	document.getElementById('chatbutton').style.backgroundColor = '#4CAF50';
	document.getElementById('notifbutton').style.backgroundColor = '#4CAF50';
}

function swapFollow(element)
{
	clean();
	element.style.backgroundColor = 'lightblue';
	document.getElementById('friend').style.display = 'flex';
}

function swapChat(element)
{
	clean();
	element.style.backgroundColor = 'lightblue';
	document.getElementById('bigchat').style.display = 'flex';
}

function swapNotif(element)
{
	clean();
	element.style.backgroundColor = 'lightblue';
	document.getElementById('notification').style.display = 'flex';
}

function Saw(element)
{
	data = element.getAttribute('name');
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "mvc/controller/ajax.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("notifsaw=" + data);
	setTimeout(reload, 100);
}

function reload()
{
	window.location = window.location.href;
}

window.onload=function ()
{
	var objDiv = document.getElementById("chat");
	objDiv.scrollTop = objDiv.scrollHeight;
}
