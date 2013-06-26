<?php
// 	<cocktail id="2" name="Cuba Libre">
// 		<ingredient id="2" name="Rum" amount="15"/>
// 		<ingredient id="4" name="Cola" amount="25"/>
// 		<description>
// 			A classical Cuba Libre
// 		</description>
// 	</cocktail>
error_reporting(E_ALL);
require_once('include/mysqli.php');
$db = new MySQL('localhost', 'clickndrink', 'buuusn', 'clickndrink');

$xml = new SimpleXMLElement('<cocktails/>');

$ingredients = $db->GetData('SELECT c.id AS id, c.name AS cocktail, i.pos AS pos, chi.amount AS amount, i.name AS ingredient FROM cocktail AS c 
INNER JOIN c_has_i AS chi ON chi.c_id=c.id 
INNER JOIN ingredient AS i ON chi.i_id=i.id ORDER BY c.name ASC');
					$helper = -1;
					$cocktail = null;
					foreach($ingredients as $ing)
					{
						if($helper!=$ing->id)
						{
							$cocktail =  $xml->addChild('cocktail');
							$cocktail->addAttribute('id', $ing->id);
							$cocktail->addAttribute('name', $ing->cocktail);							
							$cocktail->addChild('description', 'new todo');
							$helper=$ing->id;
						}
						$ingredient =  $cocktail->addChild('ingredient');
						$ingredient->addAttribute('pos', $ing->pos);
						$ingredient->addAttribute('name', $ing->ingredient);
						$ingredient->addAttribute('amount', $ing->amount);
					}

Header('Content-type: text/xml; charset=utf-8');
print( $xml->asXML());

?>
