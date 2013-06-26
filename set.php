<?php
error_reporting(E_ERROR);

require_once('include/mysqli.php');
$db = new MySQL('localhost', 'clickndrink', 'buuusn', 'clickndrink');

// var_dump($_POST);

if($_POST['s']!=null)
{

// 	$ingredients = $db->GetData($q);
	 
	$q = 'UPDATE c_has_i SET amount=? WHERE c_id=? AND i_id=?';

	foreach($_POST['ing'] as $ing)
	{
// 		$tmp = array((integer)$ing['amount'], (integer)$_POST['id'], (integer)$ing['id']);
// 		var_dump($tmp);
// 		$db->PushData($q, 'iii',$tmp);
		$command = $db->mysql->prepare($q)
                or die('Konnte MySQL-Befehl nicht ausführen!<br /><br /><hr />Fehler: ' . $this->mysql->error);

		$command->bind_param('iii',$ing['amount'], $_POST['id'], $ing['id']);
		$command->execute();
	}

// echo json_encode($data);
//     var_dump($data);
}
