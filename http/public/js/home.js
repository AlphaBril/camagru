function showEverything()
{
	var comments = document.getElementsByClassName('storycomments');
	var button = document.getElementsByClassName('buttons');
	for (i = 0; i < button.length; i++)
	{
		if (button[i].innerHTML == "Show More")
			button[i].innerHTML = "Show Less";
		else if (button[i].innerHTML == "Show Less")
			button[i].innerHTML = "Show More";
	}
	for (i = 4; i < comments.length; i++)
	{
		if (comments[i].style.display == "none")
			comments[i].style.display = "flex";
		else if (comments[i].style.display == "flex")
			comments[i].style.display = "none";
	}
}

function copy(element)
{
	text = document.getElementById('copy' + element.getAttribute('name'));
	span = document.getElementById('copyspan' + element.getAttribute('name'));
	linkSplited = element.src.split('/');
	link = linkSplited[0] + '/' + linkSplited[1] + '/' + linkSplited[2] + '/index.php?page=home#' + element.getAttribute('name');
	text.style.display = 'block';
	text.value = link;
	text.select();
	text.setSelectionRange(0, 99999);
	document.execCommand("copy");
	text.style.display = 'none';
	span.style.display = 'block';
}

function liked(element)
{
	src = element.src.split('/');
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "mvc/controller/ajax.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	if (src[src.length - 1] === "like.png")
	{
		xmlhttp.send("like=" + element.getAttribute('name'));
		element.src = src[0] + '//' + src[2] + '/' + src[3] + '/' + src[4] + '/' + 'liked.png';
	}
	else if (src[src.length - 1] === "liked.png")
	{
		xmlhttp.send("liked=" + element.getAttribute('name'));
		element.src = src[0] + '//' + src[2] + '/' + src[3] + '/' + src[4] + '/' + 'like.png';
	}
}

function reload()
{
	document.location.reload(true);
}
