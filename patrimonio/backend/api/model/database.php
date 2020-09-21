<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, X-Auth-Token, Accept");
header ("Access-Control-Allow-Headers: *");

define('DB_HOST', 'localhost');
define('DB_NAME', 'db_patrimonio');
define('DB_USER', 'postgres');
define('DB_PASS', '1234'); 


function connect(){	
	$connect = pg_connect('host=' . DB_HOST . ' dbname=' . DB_NAME . ' user=' . DB_USER . ' password=' . DB_PASS . '')  or die('Nao foi possivel conectar: ' . pg_last_error());

	return $connect;
}

$conn = connect();
?>