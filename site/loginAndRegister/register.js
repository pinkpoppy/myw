
var name = false;
var password1 = false;
var password2 = false;
var company = false;
var person = false;
var phone = false;
var mail = false;
var address = false;

function check_login_name_length(login_name) {
	return login_name.length >= 5 && login_name.length<=15;
}

function check_login_name_existed(login_name) {
	$.ajax({
		url: 'check_loginname_existed.php',
		type: 'POST',
		dataType: 'JSON',
		data: {name: login_name},
		success:function(response) {
			if (response=="VALID") {
				$('#login_feedback').text("恭喜!登录名可用!");
				name = true;
			} else {
				$('#login_feedback').text("! 用户名已存在,请更换用户名.");
				name = false;
			}
		}
	})
	.done(function() {
	})
	.fail(function() {
	})
	.always(function() {
	});
}

function check_login_name_valid(text) {
	var reg = new RegExp(/^\w+$/);
	return reg.test(text);
}

function check_password_length(password) {
	return password.length>=6 && password.length<=15;
}

function check_password_same(password1,passowrd2) {
	return password1==passowrd2;
}

function check_mail_valid(mail) {
	// var reg = new RegExp(/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/);
	// return reg.test(mail);
	return true;
}	

function check_phone_valid(phone) {
	var reg = new RegExp(/1((3\d)|(4[57])|(5[01256789])|(8\d))\d{8}/);
	return reg.test(phone);
}

$(document).ready(function() {


	$('#l_name').on('blur',function() {
		var point = $('#l_name');
		if (!check_login_name_length(point.val()) ||
			!check_login_name_valid(point.val())) {
			$('#login_feedback').text("请输入合法的用户名，且不得少于5个字符");
			name = false;
		} else {
			var login_name = point.val();
			$('#login_feedback').text("正在检查用户名是否可用...");
			check_login_name_existed(login_name);
		} 
	});

	$('#l_p').on('blur',function() {
		var point = $('#l_p');
		if (!check_password_length(point.val())) {
			$('#password_feedback').text("! 密码不得少于6个字符");
			password1 = false;
		} else {
			$('#password_feedback').text("密码合法");
			password1 = true;
		}
	});

	$('#l_c_p').on('blur',function() {
		var p1 = $('#l_p');
		var p2 = $('#l_c_p');
		if (!check_password_same(p1.val(),p2.val())) {
			$('#confirm_feedback').text("! 两次输入密码不一致");
			password2 = false;
		} else {
			$('#confirm_feedback').text("两次输入密码一致");
			password2 = true;
			// $('#password_feedback').hide();
			// $('#confirm_feedback').hide();
			// $('#password_ok').show();
			// $('#confirm_ok').show();
		}
	});

	$('#company_name').on('blur',function() {
		var point = $('#company_name');
		if (point.val().length!=0) {
			company = true;
			// $('#company_span').hide();
			// $('#company_ok').show();
		} else {
			company = false;
		}
	});

	$('#contact_person').on('blur',function() {
		var point = $('#contact_person');
		if (point.val().length!=0) {
			person = true;
			// $('#person_span').hide();
			// $('#person_ok').show();
		} else {
			person = false;
		}
	});

	$('#contact_mail').on('blur',function() {
		var point = $('#contact_mail');
		if (!check_mail_valid(point.val())) {
			$('#mail_span').text("! 请输入正确的邮件地址");
			mail = false;
		} else {
			// $('#mail_span').hide();
			// $('mail_ok').show();
			mail = true;
		}
	});

	$('#contact_address').on('blur',function() {
		var point = $('#contact_address');
		if (point.val().length!=0) {
			address = true;
			// $('#address_span').hide();
			// $('#address_ok').show();
		} else {
			address = false;
		}
	});

	$('#contact_phone').on('blur',function() {
		var point = $('#contact_phone');
		if (!check_phone_valid(point.val())) {
			$('#phone_span').text("! 手机号码不正确");
			phone = false;
		} else {
			// $('#phone_span').hide();
			// $('#phone_ok').show();
			phone = true;
		}
	});

	$('#reg_submit').click(function() {

		if (name && 
			password1 &&
			password2 &&
			company &&
			mail &&
			person &&
			phone &&
			address) {
				register.submit(function(event) {	
			});
		}	
	});

});
