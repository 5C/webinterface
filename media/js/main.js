var ing_data;
function showOverview(id)
{
	draw();
	
	$.getJSON('get.php', { "get_ingredients": "true", "id": id }, function(data)
	{
// 		alert(data);
		ing_data = data;
		data_clone = jQuery.extend(true, {}, data);
		var items = [], sliders = [];
		$.each(data.ing, function(key, val)
		{
// 			items.push('<li>' + val.amount +'cl '+ val.name +'</li>');
			sliders.push('<div class="slider-description">'+
			'<div>'+val.name+'<span id="amount-'+val.id+'"></span></div>'+
			'<div class="amount-sliders" id="slider-'+val.id+'"></div>'+
			'</div>');
		});
// 		$.each(data, function() {
// 			$.each(this, function(name, value) {
// 				/// do stuff
// 				items.push('<li>' + name + '=' + value+'</li>');
// 			});
// 		});
		fillGlass(data);
		$('#send').off('click');
		$("#send").button().click(function( event )
		{
			sendString(data.s);
		});
// 		$( "#ing_list").html('<ul>'+items.join('')+'</ul>')
		$("#sliders").html(sliders.join(""));
		$(".amount-sliders").slider({
			orientation: "horizontal",
			range: "min",
			min: 1,
			max: 30,
			value: 30,
			animate: true,
			disabled: true
		});
		var summe = 0;
		$.each(data_clone.ing, function(key, val)
		{
			$("#slider-"+val.id+" .ui-slider-range").css("background", "rgba("+val.color+")");
			$("#slider-"+val.id+" .ui-slider-handle").css("border-color", "black");
			$("#slider-"+val.id).slider("value", val.amount );
			$("#slider-"+val.id).removeClass('ui-state-disabled');
			$("#amount-"+val.id).text(val.amount+'cl');
			summe += val.amount;
		});
		$("#amount_sum").text('Total: '+summe+'cl');
		$( "#cocktail-overview").dialog("open");
	});
}
function sendString(s)
{
// 	alert(s);
	$.post('sock.php', { "s" : s }, function(data)
	{
		if(data=='granted')
			$("#send_state").text('Cocktail on the way').css('color','green');
		else
			$("#send_state").text('Error while Sending').css('color','red');
		
		setTimeout(function(){$("#send_state").text('')},5000);
// 		alert(data);
	});
}

$("#cocktail-overview").dialog({
	width: 900,
	height: 640,
	autoOpen: false,
	modal: true,
	draggable: false
});

