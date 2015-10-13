<?php
	require_once("../common/connect_database.php");
	if ($_SERVER['REQUEST_METHOD']=="POST" && $_POST['message_id']) {
		$notification_id = $_POST['message_id'];
		$sql = "SELECT id,is_read FROM web_notification
				WHERE id='$notification_id';";
		$result = $conn->query($sql);
		if ($result->num_rows==1) {
			$row = $result->fetch_assoc();
			if ($row['is_read']==1) {
				$update = "UPDATE web_notification
							SET is_read='0'
							WHERE id = '$notification_id';";
				$conn->query($update);
			}
		}
	}
?>