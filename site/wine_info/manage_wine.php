<?php
	require_once("../common/connect_database.php");
	session_start();
	$uid = $_SESSION['uid'];
?>
<!DOCTYPE html>
<html>

<head>
	<title>酒款管理</title>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="../css/reset.css">
	<link rel="stylesheet" href="../css/layout.css">
</head>

<body class="inner_body">
	<div class="wine_info_wrap">
		<div class="choose_state">
			<select id="state_select">
				<option value="all" data-id="-1" >全部</option>
				<option value="succeed" data-id="0">审核通过</option>
				<option value="proceeding" data-id="1">审核中</option>
				<option value="failed" data-id="2">审核未通过</option>
			</select>
			<div class="operate">
				<span class="cup"></span> 
				<a id="add_wine" class="operate_button" href="wine_info.php">新增酒款</a>
			</div>
		</div>
		<table id="wine_infos">
			<thead>
				<tr class="level2">
					<th>
						<img src="../icon/common/delete.png" id="delete_wine_infos">
					</th>
					<th>单号</th>
					<th>酒款中文名</th>
					<th>酒款英文名</th>
					<th>年份</th>
					<th>参考价</th>
					<th>操作</th>
					<th>状态</th>
					<th>更新时间</th>
				</tr>
			</thead>
			<tbody id="wine_infos_body">
			</tbody>  
		</table>
		<div class="page_wrap">
			<span id="prev_page">上一页</span><span>
				<input style="width:30px;" id="current_page" type="text" name="large_page" value="1">
			</span>
			<span> / </span>
			<span id="page_num">x</span>

			<span id="goto_page">go</span>

			<span id="next_page">下一页</span>
		</div>
	</div>
	
	
	<script src="../third_party/jquery-1.11.3.min.js"></script>
	<script src="../common/common.js"></script>
	<script src="manage_wine.js"></script>
	<script>
		var seller_id = '<?php echo $uid; ?>';
	</script>
</body>
</html>
