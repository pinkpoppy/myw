<?php
	require_once("../common/connect_database.php");
	$ids = $_POST['wine_to_online_ids'];
	$sqls = "";
	foreach ($ids as $value) {
		$sqls .= "DELETE FROM web_wine_to_online
				WHERE id = '$value';";
	}

	if (!$conn->multi_query($sqls)) {
	//    echo "Multi query failed: (" . $conn->errno . ") " . $conn->error;
	}
?>