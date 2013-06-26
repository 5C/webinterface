<?php
error_reporting(E_ERROR);

require_once('include/mysqli.php');
$db = new MySQL('localhost', 'clickndrink', 'buuusn', 'clickndrink');

if($_GET['get_ingredients'])
{
	header('Content-Type: application/javascript; charset=utf-8');
	$data = array();
// 	$data['ingredients'] = array();
// 	$data['color'] = array();
// 	$data['amount'] = array();
	
	if(isset($_GET['id']) && $_GET['id'] != '')
    {
        $id = $_GET['id'];
    }
    $q = 'SELECT i.name AS name, i.color AS color, chi.amount AS amount, i.pos AS pos, i.id AS id FROM cocktail AS c 
INNER JOIN c_has_i AS chi ON chi.c_id=c.id 
INNER JOIN ingredient AS i ON chi.i_id=i.id WHERE c.id ='.$id.' ORDER BY pos ASC';
	$ingredients = $db->GetData($q);

// 	foreach($ingredients as $ing)
// 	{
// 		$data['ingredients'][] = $ing->name;
// 		$data['color'][] = $ing->color;
// 		$data['amount'][] = $ing->amount;
// 	}
	$data['id'] =  $id;
	$data['ing'] = array();
	$i=0;
	foreach($ingredients as $ing)
	{
		$data['ing'][$i]['color'] 	= $ing->color;
		$data['ing'][$i]['amount'] 	= $ing->amount;
		$data['ing'][$i]['id']		= $ing->id;
		$data['ing'][$i++]['name'] 	= $ing->name;
		$data['s'] .= $ing->pos .':'. $ing->amount.';';
	}

echo json_encode($data);
//     var_dump($data);
}
