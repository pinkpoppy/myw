<?php
	require_once("../common/connect_database.php");

	session_start();
	$seller_id = $_SESSION['uid'];
	
	$sql = "SELECT * FROM web_offline_shop
			WHERE seller_id='$seller_id';";
	$offlines = $conn->query($sql);
	$resArr = array();
	while ($row = $offlines->fetch_assoc()) {
		array_push($resArr, $row);
	}
	echo json_encode($resArr,JSON_UNESCAPED_UNICODE);
?>
