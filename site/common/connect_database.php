<?php
	header('Content-Type: text/html; charset=utf-8');
	$servername = "127.0.0.1"; 
	$username = "root";	

	// $password = "73YX0DtF";
	// $password = "000000";
	// $password = "";
	// $port = 3307;
	// $password = "1qaz2wsx";

	$password = "fQHvxT6ytETyAa9R";
	$db = "winesite";
	// $conn = new mysqli($servername, $username, $password, $db,$port);
	$conn = new mysqli($servername, $username, $password, $db);
	if ($conn->connect_error) {
		die("出现了一点问题,刷新试试..");
	} 
	$conn->query("set names 'utf8mb4'");
?>
