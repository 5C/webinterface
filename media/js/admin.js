var dir = '..';
var ing_data;
$("#navi").height(Math.max(/*$("#content").height()*/0,  Math.max($("#navi").height() , $(window).height() )));
// $("#editor").height(Math.max($("#content").height(),  Math.max($("#navi").height() , $(window).height() )));

$("#cocktail-overview").dialog({
	width: 900,
	height: 640,
	autoOpen: false,
	modal: true,
	draggable: false
});

$( "#dialog-modal").dialog({
	width: 800,
	height: 640,
	autoOpen: false,
	modal: true,
	draggable: false
});
function openFile(file)
{
	$.getJSON('modules/admin/file.lib.php', { "open": "true", "file": file }, function(data)
	{
		$( "#dialog-modal").dialog( "close" );
		editor.setValue(data.content);
		editor.getSession().setMode("ace/mode/"+data.mime);
	});
}

function browser(dir)
{
	$.getJSON('modules/admin/file.lib.php', { "browser": "true", "dir": dir }, function(data)
	{
		var items = [];
		$.each(data.dir, function(key, val) {
			items.push('<a class="dir" href="#"><span class="ui-icon ui-icon-folder-collapsed" style="display:inline-block"></span>' + val + '</a><br />');
		});
		items.sort();
		$.each(data.file, function(key, val) {
			items.push('<a class="file" href="#"><span class="ui-icon ui-icon-document" style="display:inline-block"></span>' + val + '</a><br />');
		});
		
		$( "#dialog-modal").html('<ul>'+items.join('')+'</ul>');
		$( "#dialog-modal").dialog( "open" );
		$(".dir").click(function( event )
		{
			src = $(this);
			dir = data.realdir+'/'+src.text();
			browser(dir);
		});
		$(".file").click(function( event )
		{
			src = $(this);
			file = data.realdir+'/'+src.text();
			openFile(file);
		});
	});
}

$("#load").button({
	icons: {
		primary: "ui-icon-folder-open"
	},
	text: false
}).click(function( event ) {
		browser('..');
});
$("#save").button({
	icons: {
		primary: "ui-icon-disk"
	},
	text: false
}).click(function( event )
{
	alert('TODO');
});

function showAdminOverview(id)
{
	draw();
	first = true;
	var data_clone;
	$.getJSON('get.php', { "get_ingredients": "true", "id": id }, function(data)
	{
		// 		alert(data);
		ing_data = data;
		data_clone = jQuery.extend(true, {}, data);
		var items = [], sliders = [];
		$.each(data.ing, function(key, val)
		{
			items.push('<li>' + val.amount +'cl '+ val.name +'</li>');
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
			update(data);
		});
// 		$("#ing_list").html('<ul>'+items.join('')+'</ul>');
		$("#sliders").html(sliders.join(""));
		$(".amount-sliders").slider({
			orientation: "horizontal",
			range: "min",
			min: 1,
			max: 30,
			value: 30,
			animate: true,
			slide: refreshAmount,
			change: refreshAmount
		});
		$.each(data_clone.ing, function(key, val)
		{
			$("#slider-"+val.id+" .ui-slider-range").css("background", "rgba("+val.color+")");
			$("#slider-"+val.id+" .ui-slider-handle").css("border-color", "black");
			$("#slider-"+val.id).slider("value", val.amount );
			$("#amount-"+val.id).text(val.amount+'cl');
		});
		$("#cocktail-overview").dialog( "open" );
	});
}

function update(data)
{
	$.post('set.php', data, function(data)
	{
		console.log(data);
	});
}
function refreshAmount()
{
	var sum = 0;
	$.each(ing_data.ing, function(key, val)
	{
// 		if($("#slider-"+val.id)==ui.handle)
// 		{
			amount_val = $("#slider-"+val.id).slider( "value" ); // ui.value;
// 			console.log(amount_val);
			$("#amount-"+val.id).text(amount_val+'cl');
			
			val.amount = amount_val;
			sum += amount_val;
// 		}
	});
	$("#amount_sum").text('Summe: '+sum+'cl');
	fillGlass(ing_data);
}