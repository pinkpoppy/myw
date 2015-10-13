<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="../css/reset.css">
	<link rel="stylesheet" href="../css/layout.css">
</head>

<body id="login_body">
	<div class='logo'>
		<a href="http://www.pai9.com.cn">
			<img src="../icon/loginAndRegister/logo.png" id="brand">
		</a>
	</div>

	<div class='content'>
		<div class='login_box'>
			<p class='login_title'>
				登录
			</p>
			<span id="error_msg" class="errormsg"></span>

			<div class="login_main">
				<div class='login_item'>
					<span id='login_n' class="login_bg"></span>
					<input name="login_name" id="login_name" class="user_input" placeholder="请输入您的登录名" type="text" required>
				</div>
				<div class='login_item'>
					<span id='login_p' class="login_bg"></span>
					<input name="login_password" id="login_password" class="user_input" placeholder="请输入您的密码" type="password" required>
				</div>
			</div>

			<div class="login_action">
				<div class="checkbox">
					<input type="checkbox" id="remember">
					<span class="remember_p" id="remember_p">记住密码</span>
					<a class="forget_p" id="forget_p" href="javascript:void(0);">忘记密码?</a>
					<span class="reset_p">请用注册邮箱联系zhuchao@yunshitu.cn重置密码</span>
				</div>	
				<input class="login_now" id="login_now" type="submit" value="登录">
				<a href="register.php" id="login_r">还无账号？立即注册</a>
			</div>
		</div>
	</div>
	<script src="../third_party/jquery-1.11.3.min.js"></script>
	<script src="../common/common.js"></script>
	<script src="login.js"></script>
</body>
</html>
