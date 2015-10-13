<?php

?>
<!DOCTYPE html>
<html>

<head>
	<title>注册</title>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="../css/reset.css">
	<link rel="stylesheet" href="../css/layout.css">
</head>

<body id="register_body">
	<div class="reg_logo">
		<img src="../icon/loginAndRegister/logo.png">
	</div>

	<div class="reg_wrap">
		<div class="reg_content">
			<div class="reg_tip">注册</div>
			<form name="register" method="POST" id="register" action="receive_register.php">

				<div class="reg_item first">
					<span class="login_name icon"></span>
					<input name="login_name" id="l_name" placeholder="用于登陆的用户名/" type="text" required>
					<label class="reg_notice login_input"></label>
					<span class="login_feedback right_span" id="login_feedback">*必填/由数字.字母以及下划线组成/不少于5个字符/注册后不能更改</span>
					<!-- <span class="ok" id="name_ok"></span> -->
				</div>
				
				<div class="reg_item">
					<span class="password icon"></span>
					<input name="login_password" id="l_p" placeholder="设置登录密码" type="password" required>
					<span class="reg_notice password_input right_span" id="password_feedback">*必填</span>
					<!-- <span class="ok" id="password_ok"></span> -->
				</div>

				<div class="reg_item">
					<span class="confirm_password icon"></span>
					<input name="confirm_password" id="l_c_p" placeholder="确认密码" type="password" required>
					<span class="reg_notice confirm_password_input right_span" id="confirm_feedback">*必填</span>
					<!-- <span class="ok" id="confirm_ok"></span> -->
				</div>

				<div class="reg_item">
					<span class="company_name icon"></span>
					<input name="company_name" id="company_name" placeholder="商户名称/请与企业营业执照一致" type="text" required>
					<span class="reg_notice company_input right_span" id="company_span">*必填</span>
					<!-- <span class="ok" id="company_ok"></span> -->
				</div>

				<div class="reg_item">
					<span class="contact_person icon"></span>
					<input name="contact_person" id="contact_person" placeholder="企业联系人" type="text" required>
					<span class="reg_notice person_input right_span" id="person_span">*必填</span>
					<!-- <span class="ok" id="person_ok"></span> -->
				</div>

				<div class="reg_item">
					<span class="contact_phone icon"></span>
					<input name="contact_phone" id="contact_phone" placeholder="联系人移动电话" type="text" required>
					<span class="reg_notice phone_input right_span" id="phone_span">*必填</span>
					<!-- <span class="ok" id="phone_ok"></span> -->
				</div>

				<div class="reg_item">
					<span class="contact_mail icon"></span>
					<input name="contact_mail" id="contact_mail" placeholder="邮箱/用于业务联系以及找回密码" type="text" required>
					<span class="reg_notice mail_input right_span" id="mail_span">*必填</span>
					<!-- <span class="ok" id="mail_ok"></span> -->
				</div>

				<div class="reg_item">
					<span class="contact_address icon"></span>
					<input name="contact_address" id="contact_address"  placeholder="请填写办公地址" type="text" required>
					<span class="reg_notice address_input right_span" id="address_span">*必填</span>
					<!-- <span class="ok" id="address_ok"></span> -->
				</div>

				<div class="reg_item">
					<button type="button" class="reg_submit" id="reg_submit">提交</button>
					<a href="./login.php" id="reg_login" class="reg_login">已有账号,立即登录</a>
				</div>
			</form>
		</div>
	</div>

	<script src="../third_party/jquery-1.11.3.min.js"></script>
	<script src="register.js"></script>
</body>
</html>