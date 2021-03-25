setInterval(swapd, 5000);
function swapd()
{
	d1 = document.getElementById('display1');
	d2 = document.getElementById('display2');
	d3 = document.getElementById('display3');
	if (d1.style.display == 'block')
	{
		d1.style.display = 'none';
		d2.style.display = 'block';
	}
	else if (d2.style.display == 'block')
	{
		d2.style.display = 'none';
		d3.style.display = 'block';
	}
	else if (d3.style.display == 'block')
	{
		d3.style.display = 'none';
		d1.style.display = 'block';
	}
}
