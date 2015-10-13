<?php
	require_once("../common/connect_database.php");

	$isGet = $_SERVER['REQUEST_METHOD']=="GET";

	$image_path = "../../wine_pic/";
	if (isset($_GET['wine_id'])) {
	    $isEditing = $isGet && $_GET['wine_id'];
	} else {
	    $isEditing = false;
	}
	
	if ($isEditing) {
		$wine_id = $_GET['wine_id'];

		// Get wine basic info.
		$sql = "SELECT * FROM web_wine
				WHERE id='$wine_id';";
		$wine_info = $conn->query($sql)->fetch_assoc();

		// Get online info.
		$sql = "SELECT * FROM web_wine_to_online
				WHERE wine_id='$wine_id'";
		$query_result = $conn->query($sql);
		$wine_to_online = array();
		while ($row = $query_result->fetch_assoc()) {
			array_push($wine_to_online, $row);
		}

		// Get offline info.
		$sql = "SELECT * FROM web_wine_to_offline
				WHERE wine_id='$wine_id'";

		//get all offline_ids for the specific wine_id
		$query_result = $conn->query($sql);

		//specifies all wine_to_offlines for the specific wine_id
		$wine_to_offlines = array();

		while ($row = $query_result->fetch_assoc()) {
			array_push($wine_to_offlines, $row);
		}
		$wineYear = $wine_info['year'];
	} else {
		$wineYear = 0;
	}

	
?>

<!DOCTYPE html>
<html>
<head>
	<title>添加酒款</title>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="../css/reset.css">
	<link rel="stylesheet" href="../css/layout.css">
</head>	

<body class="inner_body">
	<!-- 添加酒款 开始-->
	<div class="add_wine_wrap" id="add_wine_wrap">
		<div class="form_wrap">
			<form name="wine_info" id="wine_info" method="post" action="wine_utils.php" enctype="multipart/form-data" style="position:relative;">

				<!-- 上传酒标 开始 -->
				<div class="photo_wrap">
					<div class="wrap_header">
						<span class="photo_tips title">酒标(正面)</span>
						<span class="size_tip title">图片要求:宽375高500,jpg/png/jpeg</span>
					</div> 
					<div class="wrap_cont">
						<div class="left">
							<img id="thumb" src="
								<?php 
									if ($isEditing) {
										echo $image_path.$wine_info['image_name'];
									} 
									// else {
									// 	echo $image_path.$default_pic;
									// }
								?>"
								style="height:120px;">
						</div>
						<div class="right">
							<input type="hidden" name="MAX_FILE_SIZE" value="2000000">

							<div class="cover_file_input">
								<span class="button_icon"></span>
								<div class="input_title">选择图片</div>
								<input type="file"  title="添加图片" id="upload" name="file" onchange="previewFile()">
							</div>

							<span id="result">
								<?php
									if ($isEditing) {
										echo '已选择';
									} else {
										echo '图片未添加';
									}
								?>
								
							</span>
						</div>
					</div>
				</div>
				<!-- 上传酒标 结束 -->


				<input name='wine_id' type='hidden' value='<?php if ($isEditing) echo $wine_info['id'];?>'>



				<!-- 酒款基本信息 开始 -->
				<table id="wine_table">
					<thead>
						<tr class="level1">
							<th colspan="2">
								<div class="basic_info">
									<span class="wine_info_icon section_icon"></span>
									<span class="info">基本信息</span>
								</div>
							</th>
						</tr>
					</thead>

					<tbody>
						<!-- 酒款基本信息 开始 -->
						<tr>
							<td class="title">酒款中文名</td>
							<td class="title_content channel">
								<input  class="input_content" type="text" name="zh_wine_name" id="zh_wine_name" value="<?php if ($isEditing) echo $wine_info["zh_wine_name"];?>">
							</td>
						</tr>

						<tr>
							<td class="title">酒款英文名</td>
							<td class="title_content">
								<input class="input_content " type="text" name="en_wine_name" value="<?php if ($isEditing) echo $wine_info["en_wine_name"];?>" id="en_wine_name">
							</td>
						</tr>

						<tr>
							<td class="title">国家中文名</td>
							<td class="title_content">
								<input class="input_content" type="text" name="zh_country_name" value="<?php if ($isEditing) echo $wine_info["zh_country"];?>" id="zh_country_name">
							</td>
						</tr>

						<tr>
							<td class="title">产地中文名</td>
							<td class="title_content">
								<input class="input_content " type="text" name="zh_place_name" value="<?php if ($isEditing) echo $wine_info["zh_place"];?>" id="zh_place_name">
							</td>
						</tr>

						<tr>
							<td class="title">产地英文名</td>
							<td class="title_content">
								<input class="input_content " type="text" name="en_place_name" value="<?php if ($isEditing) echo $wine_info["en_place"];?>" id="en_place_name">
							</td>
						</tr>

						<tr>
							<td class="title">酒庄中文名</td>
							<td class="title_content">
								<input class="input_content " type="text" name="zh_chateau_name" value="<?php if ($isEditing) echo $wine_info["zh_chateau"];?>" id="zh_chateau_name">
							</td>
						</tr>

						<tr>
							<td class="title">酒庄英文名</td>
							<td class="title_content">
								<input class="input_content " type="text" name="en_chateau_name" value="<?php if ($isEditing) echo $wine_info["en_chateau"];?>" id="en_chateau_name">
							</td>
						</tr>

						<tr>
							<td class="title">酒类型中文名</td>
							<td class="title_content">
								<input class="input_content " type="text" name="zh_wine_type_name" value="<?php if ($isEditing) echo $wine_info["zh_wine_type"];?>" id="zh_wine_type_name">
							</td>
						</tr>

						<tr>
							<td class="title">酒类型英文名</td>
							<td class="title_content">
								<input class="input_content "  type="text" name="en_wine_type_name" value="<?php if ($isEditing) echo $wine_info["en_wine_type"];?>" id="en_wine_type_name">
							</td>
						</tr>

						<tr>
							<td class="title">葡萄品种中文</td>
							<td class="title_content">
								<input class="input_content " type="text" name="zh_grape_name" placeholder="混酿填写举例:赤霞珠，梅洛，品丽珠" value="<?php if ($isEditing) echo $wine_info["zh_grape_type"];?>" id="zh_grape_name">
							</td>
						</tr>

						<tr>
							<td class="title">葡萄品种英文</td>
							<td class="title_content">
								<input class="input_content " type="text" name="en_grape_name" placeholder="单酿填写举例：Shiraz" value="<?php if ($isEditing) echo $wine_info["en_grape_type"];?>" id="en_grape_name" >
							</td>
						</tr>

						<tr>
							<td class="title">净含量(ml/毫升)</td>
							<td class="title_content">
								<input class="input_content " value="<?php if ($isEditing) echo $wine_info["volume"];?>" type="text" name="wine_volume" id="wine_volume" >
							</td>
						</tr>

						<tr>
							<td class="title">酒年份</td>
							<td class="title_content" id="select-year">
							</td>
						</tr>

						<tr>
							<td class="title">售卖价(￥)</td>
							<td class="title_content">
								<input class="input_content " value="<?php if ($isEditing) echo $wine_info["price"];?>" type="text" name="wine_price" id="wine_price">
							</td>
						</tr>
						<!-- 酒款基本信息 结束 -->
					</tbody>
				</table>
				<!-- 酒款基本信息 结束 -->

				<!-- 线上渠道 table 开始 -->
				<table id="online_website_table">
					<thead>
						<tr class="level1">
							<th colspan="3">
								
								<div class="chanel">
									<span class="online_icon section_icon"></span>
									<span class="offline_title">线上渠道</span>
								</div>	
								

								<div class="button_wrap far_left">
									<span class="operate_icon add_icon"></span>
									<input value="添加渠道" class="inner_button" type="button" id="add_online_chanel">
								</div>	
								
								<div class="button_wrap not_left">
									<span class="operate_icon delete_icon"></span>
									<input value="删除渠道" class="inner_button" type="button" id="delete_online_chanel">
								</div>
							</th>
						</tr>
						<tr class="level2">
							<th colspan="2">电商名称</th>
							<th>购买链接</th>
						</tr>
					</thead>						
					<tbody id="online">

						<?php
							if ($isEditing){
							foreach ($wine_to_online as $online) {
						?>

						<tr>
							<td class="online_data_td delete">
								<input type="checkbox" class="online_checkbox">
							</td>
							<td class="ebusiness_name_td">
								<input class="ebusiness_name_input" type="text" name="online_channels[]" value="<?php echo $online['company'];?>" >
							</td>
							<td class="buy_link_td">
								<input class="buy_link_input" type="text" name="online_links[]" value="<?php echo $online['link'];?>">
							</td>
							<input class="hidden_wine_to_online_ids" name='wine_to_online_ids[]' type='hidden' value='<?php echo $online['id'];?>'>
						</tr>
						<?php
							}}
						?>

					</tbody>
				</table>
				<!-- 线上渠道 table 结束 -->

				<!-- 线下渠道 table 开始 -->
				<table id="offline_seller_address">
					<thead>
						<tr class="level1">
							<th colspan="5">	
								<div class="chanel">
									<span class="offline_icon section_icon"></span>
									<span class="offline_title">线下渠道</span>
								</div>	
								
								<div class="inline_button far_left">
									<span class="operate_icon choose_icon"></span>
									<input type="button" value="选择渠道" class="inner_button" id="get_offline_chanel">
								</div>

								<div class="inline_button not_left">
									<span class="operate_icon add_icon"></span>
									<input type="button" value="新增渠道" class="inner_button" id="add_offline_chanel">
								</div>

								<div class="inline_button not_left">
									<span class="operate_icon delete_icon"></span>
									<input type="button" value="删除渠道" class="inner_button" id="delete_offline_chanel">
								</div>
							</th>
						</tr>

						<tr class="level2">
							<td colspan="2">店铺名称</td>
							<td>所在城市</td>						
							<td>电话</td>
							<td>详细地址</td>
						</tr>
					</thead>
					<tbody id="offline">

						<?php
							if ($isEditing) {
							foreach ($wine_to_offlines as $wine_to_offline) {
								$offline_id = $wine_to_offline['offline_id'];
								$sql = "SELECT * FROM web_offline_shop
										WHERE id='$offline_id'";
								$offline_shop_info = $conn->query($sql)->fetch_assoc();
						?>
						
						<tr>
							<td class="offline_data_td delete">
								<input type="checkbox" class="offline_checkbox">
							</td>

							<td class="shop">
								<input class='offline_shop_input' name="shops[]" type="text" value="<?php echo $offline_shop_info['shop'];?>" disabled>
							</td>
							<td class="city">
								<input class='offline_city_input' name="cities[]" type="text" value="<?php echo $offline_shop_info['city'];?>" disabled>
							</td>
							<td class="phone">
								<input class='offline_phone_input' name="phones[]" type="text" value="<?php echo $offline_shop_info['phone'];?>" disabled>
							</td>
							
							<td class="address">
								<input class='offline_address_input' name="addresses[]" type="text" value="<?php echo $offline_shop_info['address'];?>" disabled>
							</td>
							<input class="hidden_wine_to_offline_ids" name='wine_to_offline_ids[]' type='hidden' value='<?php echo $wine_to_offline['id'];?>'>
						</tr>
						<?php
							}}
						?>
					</tbody>		



				</table>
				<!-- 线下渠道 table 结束 -->
				<!-- 选择线下渠道 开始 -->
				<div class="address_wrap">
					<table class="table">
						<tbody id="choose_offline_address">
						</tbody>
					</table>
					
					<div class="button_wrap submit">
						<input type="button" value="确定" class="add_wine_button" id="choose_offline">
					</div>

					<div class="button_wrap cancle">
						<input type="button" value="取消" class="add_wine_button" id="cancle_choose">
					</div>
					
				</div>
				<!-- 勾选线下渠道 结束 -->	

				<!-- 操作按钮 开始 -->
				<div class="add_wine_footer">
					<div class="button_wrap submit">
						<span class="button_l_icon submit_icon"></span>
						<input type="button" class="add_wine_button " id="submit_all_wines" value="提交">
					</div>
					
					<div class="button_wrap cancle">
						<span class="button_l_icon cancle_icon"></span>
						<input type="button" class="add_wine_button" id="cancle_add" value="取消">
					</div>
					
				</div>
				<!-- 操作按钮 结束 -->

			</form>	
		</div>
	</div>
	<!-- 添加酒款 结束-->	

	<script src="../third_party/jquery-1.11.3.min.js"></script>
	<script src="wine_utils.js"></script>
	<script>
		var wineYear = '<?php echo $wineYear; ?>';
		function previewFile() {
			var input = $('#upload');
			var file = document.querySelector('input[type=file]').files[0];
			var reader = new FileReader();
			var preview = document.querySelector('#thumb');
			reader.onloadend = function() {
				preview.src = reader.result;
				$('#result').text('已选择');
			}
			if (file) {
				reader.readAsDataURL(file);
			} else {
				preview.src = "../icon/default.jpg";
			}
		}

	</script>	
</body>
</html>
