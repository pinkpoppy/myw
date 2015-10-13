
$(document).ready(function() {
	$('.reset_p').hide();
	var myCookies = loadCookie();
	$('#login_name').val(myCookies['name']);
	$('#login_password').val(myCookies['password']);

	$("#login_password").keypress(function(event){
		var keycode = (event.keycode ? event.keycode : event.which);
		if (keycode == '13') {
			enterLogin();
		}
	});
});

var checked;

function check_input_empty(item){
	if (item.length!=0)
		return true;
}

function is_remember_checked() {
	if (document.getElementById('remember').checked) 
		return true;
	return false;
}

$('#forget_p').click(function(event) {
	$('.reset_p').show();
});

$('#login_now').click(function(event) {
	checkLogin();
});

function enterLogin() {
	checkLogin();
}


function checkLogin() {
	var user_name = $('#login_name').val();
	var user_password = $('#login_password').val();
	var res = is_remember_checked();
	if (res) 
		checked = 1;
	else 
		checked = 0;

	if (check_input_empty(user_name) && 
		check_input_empty(user_password)) {
		var remember_checked = checked;

		$.ajax({
			url: 'receive_login.php',
			type: 'POST',
			dataType: 'json',
			data: {
				user_name: user_name,
				user_password:user_password,
				remember_checked:remember_checked
			},
			success:function(feedback) {
				if (feedback=="SUCCESS") {
					var url = "../homePage.php?type=login";
					location.href=url;
				} else {
					console.log("用户名/密码错误");
					$('#error_msg').text("用户名/密码错误");
				}
			}
		})
		.done(function() {
			console.log(" login success");

		})
		.fail(function() {
			console.log("login error");
		})
		.always(function() {
			console.log("login completed");
		});	
	} else {
		alert("用户名和密码不能为空");
	}
}


