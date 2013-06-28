<?php 
error_reporting(E_ALL);
require_once('include/mysqli.php');
$db = new MySQL('localhost', 'clickndrink', 'buuusn', 'clickndrink');

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Click 'n Drink</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="media/css/main.css">
		<link rel="stylesheet" href="media/css/jqueryui/jquery-ui-1.10.3.custom.min.css">

		<script src="media/js/vendor/modernizr-2.6.2.min.js"></script>
</head>
<body>
	<!--[if lt IE 7]>
		<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
	<![endif]-->
	<!-- Content Starts/ -->
	<div id="cocktail-overview" title="Overview">
		<canvas id="cocktail_canvas" width="297" height="540" style="margin-top: 20px;">
			<img src="media/img/glass_even_400.png" id="glass" />
		</canvas>
		<div id="over-container">
			<div id="ing_list"></div>
			<div id="sliders"></div>
			<span id="send_state"></span>
			<span id="amount_sum"></span>
			<button id="send" name="send">Send Cocktail</button>
		</div>
	</div>
	<a id="back" href=".">← back</a>
	<div class="5grid">
	<?php
	$ingredients = $db->GetData('SELECT c.id AS id, c.name AS cocktail FROM cocktail AS c ORDER BY c.name ASC');
// var_dump($ingredients);
	$strings = array();
	$helper = -1;
	$grid_h = 0;
	$row_h = true;
	foreach($ingredients as $ing)
	{
		
		if($helper!=$ing->id)
		{
			if($grid_h==0)
			{ // onclick
				echo '<div class="row">
					<div class="'.(($row_h)?3:5).'u naviElement" onClick="javascript:showOverview('.$ing->id.')">
						<span class="el-ingredient selector">'.$ing->cocktail.'</span>
					</div>';
			}
			else if($grid_h==1)
			{
				echo '<div class="4u naviElement" onClick="javascript:showOverview('.$ing->id.')">
					<span class="el-ingredient selector">'.$ing->cocktail.'</span>
				</div>';
			}
			else
			{
				echo '<div class="'.(($row_h)?5:3).'u naviElement" onClick="javascript:showOverview('.$ing->id.')">
					<span class="el-ingredient selector">'.$ing->cocktail.'</span>
				</div>
			</div>';
			}
			$helper = $ing->id;
			$grid_h = ($grid_h+1)%3;
			$row_h 	= !$row_h;
		}
// 			$strings[$helper] .= $ing->pos.':'. $ing->amount .';';
	}
// 	sort($strings);
// 	echo '<!-- 
// 	';
// 	var_dump($strings);
// 	echo ' -->
// 	';
?>
	</div>
	<!-- /Content End -->
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="media/js/vendor/jquery-1.8.3.min.js"><\/script>')</script>-->
	<script src="media/js/vendor/jquery-1.8.3.min.js"></script>
	<script src="media/5grid/init.js"></script>
	<script src="media/js/plugins.js"></script>
	<script src="media/js/main.js"></script>
	<script src="media/js/cnvs.js"></script>
</body>
</html>