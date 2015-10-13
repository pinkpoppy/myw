<?php
	require_once("../common/connect_database.php");
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		$name = $_POST['name'];
		$sql = "SELECT id
				FROM web_seller
				WHERE seller_login_name='$name';";
		$res = $conn->query($sql);
		if ($res->num_rows==0) {
			echo json_encode("VALID");
		} else {
			echo json_encode("NOT_VALID");
		}
	}
?>