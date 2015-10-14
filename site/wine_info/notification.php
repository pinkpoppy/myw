<?php
	require_once("../common/connect_database.php");
	session_start();
	$uid = $_SESSION['uid'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>通知中心</title>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="../css/reset.css">
	<link rel="stylesheet" href="../css/layout.css">
</head>	

<body class="inner_body">
	<div>
		<table>
			<tbody id="notifications_tbody">

			</tbody>
		</table>

		<div class="page_wrap">
			<span id="prev_page">上一页</span><span>
				<input id="current_page" type="text" name="large_page" value="1">
			</span>
			<span> / </span>
			<span id="page_num">x</span>
			<span id="goto_page">go</span>
			<span id="next_page">下一页</span>
		</div>

	</div>

	<script src="../third_party/jquery-1.11.3.min.js"></script>
	<script src="../common/common.js"></script>
	<script src="notification.js"></script>
</body>
</html>