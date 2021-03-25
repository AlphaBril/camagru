var finalimg;
var finalfilter;
(function() {

	var streaming = false,
	filters		= document.getElementsByClassName('filters_img');
	video		= document.getElementById('video');
	canvas		= document.getElementById('canvas');
	smile		= document.getElementById('smile');
	filter		= document.getElementById('filter');
	conf		= document.getElementById('conf');
	del			= document.getElementById('del');
	upload		= document.getElementById('upload');
	uploadview	= document.getElementById('uploadview');
	uploaded 	= 0;
	filterselected = 0;
	filtselect	= filters[0];
	img 		= new Image();

	function takepicture()
	{
		diffx = parseInt(getComputedStyle(video).width, 10) - parseInt(getComputedStyle(canvas).width, 10);
		diffy = parseInt(getComputedStyle(video).height, 10) - parseInt(getComputedStyle(canvas).height, 10);
		sx = ((diffx / 2) / parseInt(getComputedStyle(video).width, 10)) * video.videoWidth;
		sy = ((diffy / 2) / parseInt(getComputedStyle(video).height, 10)) * video.videoHeight;
		swidth = (parseInt(getComputedStyle(canvas).width, 10)
				/ parseInt(getComputedStyle(video).width, 10)) * video.videoWidth;
		sheight = (parseInt(getComputedStyle(canvas).height, 10)
				/ parseInt(getComputedStyle(video).height, 10)) * video.videoHeight;
		canvas.width = swidth;
		canvas.height = sheight;
		canvas.getContext('2d').drawImage(video, sx, sy, swidth, sheight, 0, 0, swidth, sheight);
		finalimg = canvas.toDataURL('image/png');
		canvas.getContext('2d').drawImage(filtselect, 0, 0);
		confirmPicture();
	}

	upload.addEventListener('change', function ()
	{
		canvas.width = parseInt(getComputedStyle(canvas).width, 10);
		canvas.height = parseInt(getComputedStyle(canvas).height, 10);
		var reader = new FileReader();
		canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
		reader.readAsDataURL(upload.files[0]);
		reader.onload = function(evt)
		{
			if (evt.target.readyState == FileReader.DONE)
			{
				img.src = evt.target.result;
				img.onload = () => canvas.getContext('2d').drawImage(img, 0, 0);
				finalimg = canvas.toDataURL('image/png');
				video.style.display = 'none';
			}
		}
		upload.value = '';
		uploaded = 1;
	});

	function confirmPicture()
	{
		video.style.display = 'none';
		smile.style.display = 'none';
		filter.style.display = 'none';
		uploadview.style.display = 'none';
		conf.style.display = 'block';
		del.style.display = 'block';
		uploaded = 0;
	}

	for (var i = 0; i < filters.length; i++)
	{
		filters[i].addEventListener('click', function(ev)
		{
			if (ev.target.style.border != "none" && ev.target.style.border != "medium none")
			{
				ev.target.style.border = "none";
				canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
				if (uploaded == 1)
					canvas.getContext('2d').drawImage(img, 0, 0);
				filterselected = 0;
				smile.style.display = 'none';
			}
			else
			{
				for (var i = 0; i < filters.length; i++)
					filters[i].style.border = "none";
				ev.target.style.border = "blue solid 1px";
				canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
				if (uploaded == 1)
					canvas.getContext('2d').drawImage(img, 0, 0);
				else
				{
					diffx = parseInt(getComputedStyle(video).width, 10) - parseInt(getComputedStyle(canvas).width, 10);
					diffy = parseInt(getComputedStyle(video).height, 10) - parseInt(getComputedStyle(canvas).height, 10);
					sx = ((diffx / 2) / parseInt(getComputedStyle(video).width, 10)) * video.videoWidth;
					sy = ((diffy / 2) / parseInt(getComputedStyle(video).height, 10)) * video.videoHeight;
					swidth = (parseInt(getComputedStyle(canvas).width, 10)
							/ parseInt(getComputedStyle(video).width, 10)) * video.videoWidth;
					sheight = (parseInt(getComputedStyle(canvas).height, 10)
							/ parseInt(getComputedStyle(video).height, 10)) * video.videoHeight;
					canvas.width = swidth;
					canvas.height = sheight;
				}
				canvas.getContext('2d').drawImage(ev.target, 0, 0);
				finalfilter = canvas.toDataURL('image/png');
				filtselect = ev.target;
				filterselected = 1;
				smile.style.display = 'block';
			}
			ev.preventDefault();
		}, false)
	}

	smile.addEventListener('click', function(ev)
			{
				filter = document.getElementById('filter');
				if (filterselected == 1)
				{
					if (uploaded == 0)
						takepicture();
					else
						confirmPicture();
					ev.preventDefault();
				}
			}, false);

	navigator.mediaDevices.getUserMedia({video: true, audio:false})
		.then(function(mediaStream)
		{
			video.srcObject = mediaStream;
			video.onloadedmetadata = function(e)
			{
				video.play();
			};
		})

})();

function resetPicture()
{
	video		= document.getElementById('video');
	canvas		= document.getElementById('canvas');
	smile		= document.getElementById('smile');
	filter		= document.getElementById('filter');
	conf		= document.getElementById('conf');
	del			= document.getElementById('del');

	canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
	video.style.display = 'block';
	video.style.zIndex = '1';
	filter.style.display = 'flex';
	conf.style.display = 'none';
	del.style.display = 'none';
	uploadview.style.display = 'block';
}

function sendPicture()
{
	video		= document.getElementById('video');
	canvas		= document.getElementById('canvas');
	smile		= document.getElementById('smile');
	filter		= document.getElementById('filter');
	conf		= document.getElementById('conf');
	del			= document.getElementById('del');

	var xmlhttp = new XMLHttpRequest();

	xmlhttp.open("POST", "mvc/controller/ajax.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("img=" + finalimg + "&filter=" + finalfilter);

	canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
	video.style.display = 'block';
	filter.style.display = 'flex';
	conf.style.display = 'none';
	del.style.display = 'none';
	uploadview.style.display = 'block';
}
