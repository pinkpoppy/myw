<?php
	require_once("../common/connect_database.php");
	$ids = $_POST['ids'];
	$sqls = "";
	foreach ($ids as $value) {
		//TODO delete image
		$sqls .= "DELETE FROM web_wine_to_online
				WHERE wine_id = '$value';";
		$sqls .= "DELETE FROM web_wine_to_offline
				WHERE wine_id = '$value';";
		$sqls .= "DELETE FROM web_wine
				WHERE id = '$value';";
	}

	if (!$conn->multi_query($sqls)) {
	//    echo "Multi query failed: (" . $conn->errno . ") " . $conn->error;
	}
?>