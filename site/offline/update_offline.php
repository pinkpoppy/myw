<?php

	require_once("../common/connect_database.php");

	$id = $_POST['id'];
	$shop = $_POST['shop'];
	$city = $_POST['city'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$create_time = $_POST['create_time'];
	$state = -1;
	// $id = 3;
	// $shop = "1";
	// $city = "1";
	// $address = "1";
	// $phone = "1";
	// $create_time = "0000-00-10 00:00:00";

	$sql = "UPDATE web_offline_shop 
			SET shop='$shop', city='$city', address='$address', phone='$phone', create_time = '$create_time',state_id='$state'
			WHERE id='$id';";

	$conn->query($sql);
?>
