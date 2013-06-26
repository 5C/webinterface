<?php
defined('MODE') or die('<strong>Access denied!</strong>');
?>
<div id="cocktail-overview" title="Overview">
	<canvas id="cocktail_canvas" width="297" height="540" style="margin-top: 20px;">
		<img src="media/img/glass_even_400.png" id="glass" />
	</canvas>
	<div id="over-container">
		<div id="ing_list"></div>
		<div id="sliders"></div>
		<span id="amount_sum"></span>
		<button id="send" name="send">Update Cocktail</button>
	</div>
</div>
<div class="5grid">
<?php
	$ingredients = $db->GetData('SELECT c.id AS id, c.name AS cocktail FROM cocktail AS c ORDER BY c.name ASC');

	$grid_h = 0;
	foreach($ingredients as $ing)
	{
		if($grid_h==0)
		{
			echo '<div class="row">
			';
		}
		echo '<div class="3u naviElement" onClick="javascript:showAdminOverview('.$ing->id.')">
				<span class="el-ingredient selector">'.$ing->cocktail.'</span>
			</div>
			';
		if($grid_h==3)
		{
		echo '
		</div>
		';
		}
		$grid_h = ($grid_h+1)%4;
	}
?>
</div>
<script src="media/js/cnvs.js" type="text/javascript" charset="utf-8"></script>