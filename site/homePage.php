<?php
	
	if (!isset($_COOKIE["name"]) && !$_GET["type"]) {
		header("Location:loginAndRegister/login.php");
		return;
	}

	session_start();
	require_once("./common/connect_database.php");
	$id = $_SESSION['uid'];
	$sql = "SELECT seller_name 
			FROM web_seller
			WHERE id='$id';";
	$res = $conn->query($sql);
	$row = $res->fetch_assoc();
	$uname = $row['seller_name'];

	$notify = 0;
	// 检查是否有新消息
	$sql = "SELECT COUNT(id) as count FROM web_notification 
			WHERE uid='$id';";
	$res = $conn->query($sql);
	$current_notifications_count = 0;
	if ($res->num_rows==1) {
		$row = $res->fetch_assoc();
		$current_notifications_count = $row['count'];
	}

	$sql = "SELECT last_count FROM web_seller
			WHERE id='$id';";

	$res = $conn->query($sql);
	$last_notifications_count = 0;
	if ($res->num_rows==1) {
		$row = $res->fetch_assoc();
		$last_notifications_count = $row['last_count'];
		if ($current_notifications_count > $last_notifications_count) {
			$notify = 1;
			$sql = "UPDATE web_seller 
					SET last_count='$current_notifications_count'
					WHERE id='$id';";
			$conn->query($sql);
		}
	}
?>

<!DOCTYPE html>
<head>
	<title>用户主页</title>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="./css/reset.css">
	<link rel="stylesheet" href="./css/layout.css">
</head>	

<body class="homepage">
	<aside id="left_panel" class="left_panel">
		<div class="back_home">
			<a href="http://www.pai9.com.cn">
				<img class="brand_logo" src="icon/homePage/brandlogo.png">
				<span class="barnd_title">拍酒酒商后台</span>
			</a>
		</div>
		<nav class="nivigatior_panel">
			<ul>
				<li class="li_items active">
					<a href="javascript:void(0);" title="酒款管理" class="current_link" data-href="./wine_info/manage_wine.php">
						<div class="item">
							<img class="nav_icon" src="./icon/homePage/wine_manage.png">
							<span>酒款管理</span>
						</div>
					</a>
				</li>

				<li class="li_items">
					<a href="javascript:void(0);" title="消息中心" class="current_link" data-href="./wine_info/notification.php">
						<div class="item">
							<img class="nav_icon" src="./icon/homePage/info_center.png">
							<span>消息中心</span>
							<span id="notify"></span>
						</div>
					</a>
				</li> 

				<li class="li_items">
					<a href="javascript:void(0);" title="线下地址" class="current_link" data-href="./offline/manage_offline.php">
						<div class="item">
							<img class="nav_icon" src="./icon/homePage/offline_channel.png">
							<span>线下地址</span>
						</div>
					</a>
				</li>
			</ul>
		</nav>
	</aside>


	<div class="main" id="main">
		<!-- <div class='header_wrap'> -->
			<div class="header" id="header">
				<div class="left">
					<span class="welcome">欢迎您！<?php echo $uname;?></span>
				</div>
				<div class="right" id="logout">
					<!-- <img src="./icon/web_icon/logout.png" class="logout"> -->
					<span>退出登录</button>
				</div>
			</div>
		<!-- </div> -->
		

		<div class="content" id="content">
			<!-- 内嵌页面 开始-->
			<iframe class="add_wine_frame" id="add_wine_frame" src="./wine_info/manage_wine.php">
			</iframe> 
			<!-- 内嵌页面 结束-->
		</div>
	</div>

	<div class="bottom">
		<p>友情链接：云识图</p>
		<p>&copy2015 All Rights Reserved by yunshitu 闽ICP备14016348</p>
	</div>

	<script src="./third_party/jquery-1.11.3.min.js"></script>
	<script src="./common/common.js"></script>
	<script>

		$(document).ready(function() {
		//	$("body").height($(window).height());
			$("#left_panel").height($(window).height() - 44);
			$("#main").height($(window).height() - 44);
			$("#content").height($(window).height() - 44 - 60);
			$('.current_link').click(function(event) {
				var current_link = $(this).data('href');
				//var current_link = './seller/seller_business/manage_offline.php';
				$('#add_wine_frame').attr('src',current_link);
			});

			var is_notify = '<?php echo $notify;?>';
			if (is_notify==1) {
				$('#notify').show();
			}
		});

		$('#logout').click(function(event) {
			//清理Cookie

			deleteCookie("name");
			deleteCookie("password");
			
			$.ajax({
				url: 'destory_session.php',
				type: 'POST',
				success:function() {
					location.href="loginAndRegister/login.php";
				}
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		});

	</script>
</body>




