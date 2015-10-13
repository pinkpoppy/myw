<?php
	require_once("../common/connect_database.php");
	require_once("../common/debug_utils.php");
	$ids = $_POST['wine_to_offline_ids'];
	$sqls = "";
	foreach ($ids as $value) {
		$sqls .= "DELETE FROM web_wine_to_offline
				WHERE id = '$value';";
	}
	debug_to_console($sqls);
	if (!$conn->multi_query($sqls)) {
	//    echo "Multi query failed: (" . $conn->errno . ") " . $conn->error;
	}
?>