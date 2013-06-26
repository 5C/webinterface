<?php
error_reporting(E_ALL);
if(!(isset($_POST['s']) && $_POST['s']!=''))
	die();
$s = $_POST['s'];
$service_port = 1025;
// $address = "192.168.0.199";
$address = "127.0.0.1";

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false)
{
    echo "socket_create() failed: Reason: " . socket_strerror(socket_last_error()) . "\n";
}

$result = socket_connect($socket, $address, $service_port);
if ($result === false)
{
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
}

$pass = 'clickNdrink';
socket_write($socket, $pass, strlen($pass));

$out = socket_read($socket, 7, PHP_NORMAL_READ);
echo $out;

$s .= "\n";

socket_write($socket, $s, strlen($s));

socket_close($socket);
?>