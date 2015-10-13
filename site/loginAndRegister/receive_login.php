<?php
	require_once("../common/connect_database.php");
	session_start();

	if ($_SERVER['REQUEST_METHOD']=="POST") {
		if (isset($_POST['user_name']) && 
			isset($_POST['user_password']) &&
			isset($_POST['remember_checked']) ) {

			$username=$_POST['user_name'];
			$userpassword=$_POST['user_password'];
			$remember = $_POST['remember_checked'];

			$sql = "SELECT seller_login_name,seller_login_password,id FROM web_seller
					WHERE seller_login_name='$username'
					AND seller_login_password='$userpassword';";

			
			$result=$conn->query($sql);
			if ($result->num_rows==1) {	
				$user_info = $result->fetch_assoc();
				
				$_SESSION['uid'] = $user_info['id'];

				if ($remember==1) { //设置 cookie
					$cookie_value = $username;
					$cookie_password_value = $userpassword;
					setcookie("name",$cookie_value,time() + (86400 * 30),"/");
					$_COOKIE["name"] = $username;
					setcookie("password",$cookie_password_value,time() + (86400 * 30),"/");
					$_COOKIE["password"] = $userpassword;
				}

				session_write_close();
				echo json_encode("SUCCESS");
				exit(0);		
			}else {
				echo json_encode("FAIL");
			}
		}	
	}

?>
