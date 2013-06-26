var ctx;
var img;
var canvas;
function draw()
{
	/*
	 * 
	 * Start x: 22 	End x: 275
	 * Start y: 107 	End y: 517
	 *
	 * width:	253
	 * height:	400
	 */
	canvas = document.getElementById('cocktail_canvas');
	if (canvas.getContext)
	{
		ctx = canvas.getContext('2d');
		ctx.mozImageSmoothingEnabled = false;
		img = new Image();
		img.onload = function()
		{
			ctx.drawImage(img,0,0);
		};
		img.src = 'media/img/glass_even_400.png';
	}
	else window.alert('Your Browser doesn\'t Support the Canvas Element. That\'s sad');
}
function doSomething(i)
{
	if(i==0)
	{
		ctx.fillStyle = "rgba(255, 145, 0, 0.7)";
		ctx.fillRect (22, 117, 253, 280);
	}
	else
	{
		ctx.fillStyle = "rgba(250, 250, 250, 0.3)";
		ctx.fillRect (22, 397, 253, 120);
	}
}
function fillGlass(data)
{
	clear();
	ctx.drawImage(img,0,0);
	y=517;
	
	ctx.lineWidth = 1;
	ctx.strokeStyle = 'rgba(0,0,0, 0.7)';
	
	$.each(data.ing, function(key, val)
	{
		ctx.fillStyle = "rgba("+val.color+")";
		ctx.fillRect (22, y-val.amount*10, 253, val.amount*10);

		if(val.amount==1)
			ctx.font = "10pt futura bold";
		else
			ctx.font = "18pt futura bold";
		ctx.fillStyle = 'white';
		ctx.fillText(val.name, 25, y-1);
		ctx.strokeText(val.name, 25, y-1);
		y -= val.amount*10;
	});
}
function clear()
{
	ctx.clearRect(0, 0, canvas.width, canvas.height);
}
