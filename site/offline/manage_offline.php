<?php
	require_once("../common/connect_database.php");

	session_start();
	$uid = $_SESSION['uid'];
	$seller_id = $uid;

	$offline_htmls = json_encode(produce_offline($conn, $seller_id),JSON_UNESCAPED_UNICODE);


	function produce_offline($conn, $seller_id) {
		$res = array();
		$offline_arr = get_offline_infos($conn, $seller_id);
		foreach ($offline_arr as $key => $value) {
			array_push($res, put_html($value));
		}
		return $res;
	}
				
	function put_html($data) {
		$state;
		if ($data['state_id'] == -1) {
			$state = "待审核";
		} else if($data['state_id']==0){
			$state = "审核通过";
		} else {
			$state = "审核失败";
		}
		$row=
		"<tr data-id='". $data['id'] ."''>
			<td class='checkbox_td'>
				<input type='checkbox'>
			</td>
			<td class='shop_td'>
				<input type='text' disabled value=". $data['shop'].">
			</td>
			<td class='city_td'>
				<input type='text' disabled value=". $data['city'].">
			</td>
			<td class='address_td'>
				<input type='text' disabled value=". $data['address'].">
			</td>
			<td class='phone_td'>
				<input type='text' disabled value=". $data['phone'].">
			</td>
			<td class='wine_num_td'>".
				$data['wine_num'].
			"</td>
			<td class='time_td'>".
				$data['create_time'].
			"</td>
			<td class='operate_td'>
				<input type='button' value='编辑' class='offline_edit'>
			</td>
			<td class='state_td'>".
				$state.
			"</td>
		</tr>";
		return $row;
	}

	function get_offline_infos($conn, $seller_id) {
		$offline_infos = array();

		$sql = "SELECT * FROM web_offline_shop 
		WHERE seller_id='$seller_id'
		ORDER BY create_time DESC;";
		
		$results = $conn->query($sql);
		if ($results->num_rows > 0) {
			while ($row = $results->fetch_assoc()) {
				$offline_id = $row['id'];
				$cnt = get_wines_num($offline_id,$conn);
				$row['wine_num'] = $cnt;
				array_push($offline_infos, $row);
			}	
		}
		return $offline_infos;
	}


	function get_wines_num($offline_id,$conn) {
		$sql = "SELECT * FROM web_wine_to_offline
				WHERE offline_id=$offline_id;";
		$results = $conn->query($sql);
		$cnt = $results->num_rows;
		return $cnt;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>管理线下地址</title>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="../css/reset.css">
	<link rel="stylesheet" href="../css/layout.css">
</head>

<body class="inner_body">
	<div class="manage_offline_wrap">
		<div class="offline_wrap">
			<div class="add_offline">
				<span></span>
				<button id="add_offline">新增地址</button>
			</div>
			<table id="offline_infos">
				<thead>
					<tr class="level2">
						<!-- <th class="checkbox_td">
							<input type='chechbox'>
						</th> -->
						<th id="delete_op">删除</th>
						<th>店铺名称</th>
						<th>所在城市</th>
						<th>详细地址</th>
						<th>电话</th>
						<th>在售酒款数</th>
						<th>创建时间</th>
						<th>操作</th>
						<th>状态</th>
					</tr>
				</thead>
				<tbody id="offline_infos_body">	
				</tbody>
			</table>

		</div>
	</div>

	<script src="../third_party/jquery-1.11.3.min.js"></script>
	<script src="manage_offline.js"></script>
	<script src="../common/common.js"></script>
	<script>
		$(document).ready(function() {
			var htmls = <?php echo $offline_htmls;?>;
			for (var i = 0; i < htmls.length; i++) {
				$('#offline_infos_body').append(htmls[i]);
			}

			$('.offline_edit').click(function(event) {
				update_offline($(this));
			});

			$('#delete_op').click(function(event) {
				var offline_infos_body = $('#offline_infos_body');
				var checked = $('#offline_infos_body').find(':checked').parents('tr');
				var ids = [];
				for (var i = 0; i < checked.length; ++i) {
					if (checked.find(".wine_num_td").text() != 0) {
						alert("无法删除还有在售酒款的地址");
						return;
					}
					ids.push(checked[i].dataset["id"]);
				}
				$.ajax({
					url: 'delete_offline.php',
					type: 'POST',
					dataType: 'json',
					timeout:20000,
					data: {
						ids: ids
					},
					success:function(response) {
					}
				})
				.done(function() {
				})
				.fail(function() {
				})
				.always(function() {
					checked.remove();
				});
			});
		});
	</script>
</body>
</html>
