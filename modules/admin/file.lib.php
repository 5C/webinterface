<?php
error_reporting(E_ERROR);
session_start();

if($_SESSION['logged_in']!=true)
	exit('Acces denied!');

if($_GET['browser'])
{
	$data = array();
	$data['dir'] = array();
	$data['file'] = array();
	if(isset($_GET['dir']) && $_GET['dir'] != '')
    {
        $dir = $_GET['dir'];
    }
	if(!is_dir($dir))
		exit($dir.' isn\'t a Directory!');
	$data['realdir'] = realpath($dir);
    $handle = opendir($dir);
	$i=0;
    while (false !== ($file = readdir($handle)))
    {
         if ($file != '.')
         {
             if(is_file($dir.'/'.$file))
             {
				$data['file'][] = $file;
             }
             elseif(is_dir($dir.'/'.$file))
             {
				$data['dir'][] = $file;
             }
        }
    }
    fclose($handle);
    echo json_encode($data);
}
else if($_GET['open'])
{
	$data = array();
	if(isset($_GET['file']) && $_GET['file'] != '')
    {
        $file = $_GET['file'];
    }
	if(!is_file($file))
		exit($file.' isn\'t a File!');
    $handle = fopen($file, "r");
	$data['content'] = fread($handle, filesize($file));
	$data['mime'] = handleMime($file);
    fclose($handle);
    echo json_encode($data);
//     var_dump($data);
}

function handleMime($file)
{
	if(preg_match("/\.(html|htm)$/",$file))
		return 'html';
	else if(preg_match("/\.css$/",$file))
		return 'css';
	else if(preg_match("/\.js$/",$file))
		return 'javascript';
	else if(preg_match("/\.php$/",$file))
		return 'php';
	else if(preg_match("/\.xml$/",$file))
		return 'xml';
	else
		return 'text';
}
?>