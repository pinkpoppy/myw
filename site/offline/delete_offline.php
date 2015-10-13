<?php
	require_once("../common/connect_database.php");
	$ids = $_POST['ids'];
	$sqls = "";
	foreach ($ids as $value) {
		$sqls .= "DELETE FROM web_offline_shop
				WHERE id = '$value';";
	}

	if (!$conn->multi_query($sqls)) {
	//    echo "Multi query failed: (" . $conn->errno . ") " . $conn->error;
	}
?>