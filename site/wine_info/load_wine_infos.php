<?php
	require_once("../common/connect_database.php");


	$currentPage = $_POST['currentPage'];
	$state = $_POST['state'];
	$seller_id = $_POST['seller_id'];

	query_database($currentPage * 20,$currentPage * 20 + 20,$seller_id,$state,$conn);

	function get_page_data($start,$end,$results){
		$wineInfo = array();
		$wineResults = array();
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
			$row['state'] = show_state($row['state']);
			array_push($wineInfo, $row);
		}
		
		$wineResults['wineInfos'] = $wineInfo;
		$wineResults['pageNumber'] = ceil($results->num_rows * 1.0 / 20);

		return json_encode($wineResults, JSON_UNESCAPED_UNICODE);
	}

	function query_database($start,$end,$seller_id,$state,$conn) {
		$sql = "SELECT * FROM web_wine
				WHERE seller_id = '$seller_id'
				AND state = '$state'
				ORDER BY create_time DESC;";
		if ($state==-1) {
			$sql = "SELECT * FROM web_wine
					WHERE seller_id = '$seller_id'
					ORDER BY create_time DESC;";
		}
		$results = $conn->query($sql);
		echo get_page_data($start, $start + 20, $results);
	}

	function show_state($state) {
		if ($state==0) {
			return "审核通过";
		} else if ($state==1) {
			return "审核中";
		} else if ($state==2) {
			return "未通过";
		} 
	}
?>

