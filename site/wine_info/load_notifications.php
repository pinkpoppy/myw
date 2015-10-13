<?php
	require_once("../common/connect_database.php");


	$currentPage = $_POST['currentPage'];

	session_start();
	$uid = $_SESSION['uid']; 
	$seller_id = $uid;

	query_database($currentPage * 20,$currentPage * 20 + 20,$seller_id,$conn);

	function get_page_data($start,$end,$results){
		$resArr= array();
		$notificationsArr = array();
		$cnt = 0;
		while ($row = $results->fetch_assoc()) {
			if ($cnt < $start) {
				$cnt ++;
				continue;
			}

			if ($cnt==$end) {
				break;
			}

			$cnt ++;
			array_push($notificationsArr, $row);
		}
		
		$resArr['notificationsArr'] = $notificationsArr;
		$resArr['pageNumber'] = ceil($results->num_rows * 1.0 / 20);

		return json_encode($resArr, JSON_UNESCAPED_UNICODE);
	}

	function query_database($start,$end,$seller_id,$conn) {
		$sql = "SELECT * FROM web_notification
				WHERE uid = '$seller_id'
				ORDER BY create_time DESC;";

		$results = $conn->query($sql);
		echo get_page_data($start, $start + 20, $results);
	}
?>

