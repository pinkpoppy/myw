<?php
	require_once("../common/connect_database.php");
	require_once("../common/debug_utils.php");
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		session_start();
		$uid = $_SESSION['uid'];

		//要存储的目录位置
		$wine_pic_dir = "../../wine_pic/";
		
	    //存储图片,并返回文件路径
        $winePicURL = "";
        $hasImgFile = true;
		if ($_FILES['file']['name'] !== "") {
			$winePicURL = save_file($_FILES['file']['name'],$wine_pic_dir,$_FILES['file']['tmp_name']);
		} else {
			$hasImgFile = false;
			$winePicURL = "";
		}

		// update wine info
		$info_arr = get_wine_basic_info($winePicURL, $uid);
		$wine_id = update_table($conn,$info_arr,$hasImgFile);
		// update wine to online
		$onlineArr = get_online_info($_POST['online_channels'], $_POST['online_links'], $_POST['wine_to_online_ids']);
		update_online($onlineArr,$wine_id,$conn);

		// update wine to offline
		$offlineArr = get_offline_info($_POST['offline_ids'], $_POST['shops'], $_POST['cities'],$_POST['addresses'],$_POST['phones'], $uid);
		update_offline($offlineArr,$wine_id,$conn);

		header("location: manage_wine.php"); 
	}
	function update_table($conn,$info_arr,$hasImgFile) {
		if ($_POST['wine_id'] != "") {
			// update
            if ($hasImgFile==true) {
				$sql = "UPDATE web_wine 
					SET zh_wine_name='{$info_arr['zh_wine_name']}',
					en_wine_name='{$info_arr['en_wine_name']}',
					zh_country='{$info_arr['zh_country_name']}',
					zh_place='{$info_arr['zh_place_name']}',
					en_place='{$info_arr['en_place_name']}',
					zh_chateau='{$info_arr['zh_chateau_name']}',
					en_chateau='{$info_arr['en_chateau_name']}',
					zh_wine_type='{$info_arr['zh_wine_type_name']}',
					en_wine_type='{$info_arr['en_wine_type_name']}',
					zh_grape_type='{$info_arr['zh_grape_name']}',
					en_grape_type='{$info_arr['en_grape_name']}',
					volume = '{$info_arr['volume']}',
					year='{$info_arr['wine_year']}',
					price='{$info_arr['wine_price']}',
					seller_id='{$info_arr['seller_id']}',
					image_name='{$info_arr['image_link']}',
					create_time='{$info_arr['add_time']}'
					WHERE id='{$_POST['wine_id']}'
					;";
			} else {
				$sql = "UPDATE web_wine 
					SET zh_wine_name='{$info_arr['zh_wine_name']}',
					en_wine_name='{$info_arr['en_wine_name']}',
					zh_country='{$info_arr['zh_country_name']}',
					zh_place='{$info_arr['zh_place_name']}',
					en_place='{$info_arr['en_place_name']}',
					zh_chateau='{$info_arr['zh_chateau_name']}',
					en_chateau='{$info_arr['en_chateau_name']}',
					zh_wine_type='{$info_arr['zh_wine_type_name']}',
					en_wine_type='{$info_arr['en_wine_type_name']}',
					zh_grape_type='{$info_arr['zh_grape_name']}',
					en_grape_type='{$info_arr['en_grape_name']}',
					volume = '{$info_arr['volume']}',
					year='{$info_arr['wine_year']}',
					price='{$info_arr['wine_price']}',
					seller_id='{$info_arr['seller_id']}',
					create_time='{$info_arr['add_time']}'
					WHERE id='{$_POST['wine_id']}'
					;";
			}

            if ($conn->query($sql)===TRUE){
				$wine_id = $conn->insert_id;
				return $_POST['wine_id'];
			}
		} else {
			// insert
			$wine_id = 0;
			$sql = "INSERT INTO web_wine (
								zh_wine_name,
								en_wine_name,
								zh_country,
								zh_place,
								en_place,
								zh_chateau,
								en_chateau,
								zh_wine_type,
								en_wine_type,
								zh_grape_type,
								en_grape_type,
								volume,
								year,
								price,
								seller_id,
								image_name,
								create_time)
					VALUES(
					'{$info_arr['zh_wine_name']}',
					'{$info_arr['en_wine_name']}',
					'{$info_arr['zh_country_name']}',
					'{$info_arr['zh_place_name']}',
					'{$info_arr['en_place_name']}',
					'{$info_arr['zh_chateau_name']}',
					'{$info_arr['en_chateau_name']}',
					'{$info_arr['zh_wine_type_name']}',
					'{$info_arr['en_wine_type_name']}',
					'{$info_arr['zh_grape_name']}',
					'{$info_arr['en_grape_name']}',
					'{$info_arr['volume']}',
					'{$info_arr['wine_year']}',
					'{$info_arr['wine_price']}',
					'{$info_arr['seller_id']}',
					'{$info_arr['image_link']}',
					'{$info_arr['add_time']}'
					);";
			if ($conn->query($sql)===TRUE) {
				$wine_id = $conn->insert_id;
				return $wine_id;
			}
		}
	}
	function get_wine_basic_info($winePicURL, $uid) {
		$wine_info_array = array();
		$wine_info_array['zh_wine_name'] = $_POST['zh_wine_name'];
		$wine_info_array['en_wine_name'] = $_POST['en_wine_name'];
		$wine_info_array['zh_country_name'] = $_POST['zh_country_name'];
		$wine_info_array['zh_place_name'] = $_POST['zh_place_name'];
		$wine_info_array['en_place_name'] = $_POST['en_place_name'];
		$wine_info_array['zh_chateau_name'] = $_POST['zh_chateau_name'];
		$wine_info_array['en_chateau_name'] = $_POST['en_chateau_name'];
		$wine_info_array['zh_wine_type_name'] = $_POST['zh_wine_type_name'];
		$wine_info_array['en_wine_type_name'] = $_POST['en_wine_type_name'];
		$wine_info_array['zh_grape_name'] = $_POST['zh_grape_name'];
		$wine_info_array['en_grape_name'] = $_POST['en_grape_name'];
		$wine_info_array['volume'] = $_POST['wine_volume'];
		$wine_info_array['wine_year'] = $_POST['wine_year'];
		$wine_info_array['wine_price'] = $_POST['wine_price'];
		$wine_info_array['seller_id'] = $uid;
		if ($winePicURL !== "") {
			$wine_info_array['image_link'] = $winePicURL;
		}
		date_default_timezone_set("Asia/Shanghai");
		$wine_info_array['add_time'] = date("Y-m-d H:i");
		return $wine_info_array;
	}



	function get_online_info($onlineCompany, $onlineLinks, $wine_to_online_ids) {
		$onlineArr = array();
		// The info with $wine_to_online_ids already in database, so we don't need add them again.
		for ($i = 0; $i < count($onlineCompany) - count($wine_to_online_ids); $i++) {
			$tempArr = array();
			$tempArr['onlineCompany'] = $onlineCompany[$i];
			$tempArr['onlineLinks'] = $onlineLinks[$i];
			$onlineArr[$i] = $tempArr;
		}
		return $onlineArr;
	}

	function get_offline_info($offline_ids, $shops,$cities,$addresses,$phones, $seller_id) {
		$offlineArr = array();
		for ($i=0; $i < count($offline_ids); $i++) { 
			$tempArr = array();
			$tempArr['offline_id'] = $offline_ids[$i];
			$tempArr['shop'] = $shops[$i];
			$tempArr['city'] = $cities[$i];
			$tempArr['address'] = $addresses[$i];
			$tempArr['phone'] = $phones[$i];
			$tempArr['seller_id'] = $seller_id;
			$offlineArr[$i] = $tempArr;
		}

		return $offlineArr;
	}

	function test_input($input) {
		return $input;
	}

	//获取文件名后缀
	function file_exten($filename) {
		return substr(strrchr($filename, '.'), 1);
	}

	//生成uuid标识作为文件名
	function create_uuid($prefix="") {
		$str = md5(uniqid(mt_rand(),true));
		$uuid = substr($str,0,8).'-';
		$uuid.= substr($str, 8,4).'-';
		$uuid.= substr($str, 12,4).'-';
		$uuid.= substr($str, 16,4).'-';
		$uuid.= substr($str, 20,12);
		return $prefix.$uuid;
	}

	//判断文件类型是否合法
	function is_required_type($extension) {
		$type_arr = array("jpg","jpeg","png");
		if (!in_array(strtolower($extension), $type_arr)) {
			return false;
		} else {
			return true;
		}
	}

	//拼凑文件名
	function save_file($filename,$desdir,$tmpfile) {
		if (is_required_type(file_exten($filename))) {
			do {
				$upload_file = create_uuid("");
				$upload_file .= "." . file_exten($filename);
				$new_file_name = $upload_file;
				$upload_file = $desdir . $upload_file;
			} while(file_exists($upload_file));
			if (move_uploaded_file($tmpfile, $upload_file)) {
				return $new_file_name;
			}
		}
	}

	function update_online($onlineArr,$wineId,$conn) {
		foreach ($onlineArr as $index => $tempArr) {
			$ebusiness = $tempArr['onlineCompany'];
			$link = $tempArr['onlineLinks'];
			$sql = "INSERT INTO web_wine_to_online(
								wine_id,
								company,
								link)
						VALUES ('$wineId',
								'$ebusiness',
								'$link');";
			if ($conn->query($sql)===TRUE) {
			} else {
			}
		}
	}

	function update_offline($offlineArr,$wineId,$conn) {
		date_default_timezone_set("Asia/Shanghai");
		foreach ($offlineArr as $index => $tempArr) {
			$offlineId = $tempArr['offline_id'];
			if ($offlineId == '-1') {
				$shop = $tempArr['shop'];
				$city = $tempArr['city'];
				$address = $tempArr['address'];
				$phone = $tempArr['phone'];
				$seller_id = $tempArr['seller_id'];
				$create_time = date("Y-m-d H:i");
				
				$sql = "INSERT INTO web_offline_shop(
									shop,
									city,
									address,
									phone,
									state_id,
									seller_id,
									create_time)
							VALUES(
							'$shop',
							'$city',
							'$address',
							'$phone',
							'-1',
							'$seller_id',
							'$create_time');";
				$conn->query($sql);
				$offlineId = $conn->insert_id;
			}

			$sql = "INSERT INTO web_wine_to_offline(
								wine_id,
								offline_id)
						VALUES(
						'$wineId',
						'$offlineId');";
			$conn->query($sql);
		}
	}
?>
