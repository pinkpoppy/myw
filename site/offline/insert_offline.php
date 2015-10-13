<?php

	require_once("../common/connect_database.php");
	session_start();
	$uid = $_SESSION['uid'];
	$shop = $_POST['shop'];
	$city = $_POST['city'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$create_time = $_POST['create_time'];
	$state = -1;

	$sql = "INSERT INTO web_offline_shop 
			(shop, city,phone, address,state_id,create_time,seller_id)
			VALUES ('$shop', '$city','$phone', '$address','$state','$create_time','$uid');";

	$conn->query($sql);

	echo $conn->insert_id;
?>
