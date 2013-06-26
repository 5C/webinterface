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
			<link rel="stylesheet" href="css/main.css">
			
			<script src="media/js/vendor/modernizr-2.6.2.min.js"></script>
			<script src="media/5grid/jquery.js"></script>
			<script src="media/5grid/init.js"></script>
			<script type="text/javascript">
				var ctx;
				var img;
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
					var canvas = document.getElementById('cocktail_canvas');
					if (canvas.getContext)
					{
						ctx = canvas.getContext('2d');
						img = new Image();
						img.onload = function()
						{
							ctx.drawImage(img,0,0);
						};
						img.src = 'img/glass_even_400.png';
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
    </script>
	</head>
	<body onload="draw()">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
			<!-- Content Starts/ -->
			<div class="5grid">
				<!--<div class="row">
					<div class="5u">
						<div class="naviElement pulse-bg">
							Back
						</div>
					</div>
				</div> -->

			<!-- Row 2 -->
				<div class="row">
					<div class="9u"> <!-- Ingredients -->
						<div class="5grid" style="margin-left:15px; margin-top:15px;">
<!-- <pre> -->
					<?php
					$ingredients = $db->GetData('SELECT c.id AS id, c.name AS cocktail, i.pos AS pos, chi.amount AS amount FROM cocktail AS c 
INNER JOIN c_has_i AS chi ON chi.c_id=c.id 
INNER JOIN ingredient AS i ON chi.i_id=i.id ORDER BY c.name ASC');
// var_dump($ingredients);
					$strings = array();
					$helper = -1;
					$grid_helper = true;
					foreach($ingredients as $ing)
					{
						
						if($helper!=$ing->id)
						{
							if($grid_helper)
							{
								echo '<div class="row">
									<div class="7u naviElement" onclick="doSomething('.$ing->id.')"><span class="el-ingredient">'.$ing->cocktail.'</span>
									</div>';
							}
							else
							{
								echo '<div class="4u naviElement" onclick="doSomething('.$ing->id.')"><span class="el-ingredient">'.$ing->cocktail.'</span>
								</div>';
							}
							$helper=$ing->id;
							$grid_helper = !$grid_helper;
						}
						 $strings[$helper] .= $ing->pos.':'. $ing->amount .';';
					}
					sort($strings);
					echo '<!-- 
					';
					var_dump($strings);
					echo ' -->
					';
  ?>
<!-- </pre> -->
<!--							<div class="row"> 
								<div class="7u naviElement" onclick="doSomething(1)"><span class="el-ingredient">Vodka</span></div>
								<div class="4u naviElement" onclick="doSomething(0)"><span class="el-ingredient">RedBull</span></div>
							</div>
							<div class="row"> 
								<div class="4u naviElement"><span class="el-ingredient">Gin</span></div>
								<div class="7u naviElement"><span class="el-ingredient">Tonic</span></div>
							</div>-->
						</div>
					</div>
					<div class="3u"><!-- Glass Canvas -->
						<canvas id="cocktail_canvas" width="297" height="540" style="margin-top: 20px;">
							<img src="img/glass_even.png" id="glass" />
						</canvas>
<!-- 						<img src="img/glass_even.png" id="glass" /> -->
					</div>
				</div>
			</div>
		<!-- /Content End -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="media/js/vendor/jquery-1.8.3.min.js"><\/script>')</script>
        <script src="media/js/plugins.js"></script>
        <script src="media/js/main.js"></script>
    </body>
</html>
 
