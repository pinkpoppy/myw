<?php
	require_once("../common/connect_database.php");
	$login_name = $_POST['login_name'];
	$login_password = $_POST['login_password'];
	$company_name = $_POST['company_name'];
	$contact_person = $_POST['contact_person'];
	$contact_phone = $_POST['contact_phone'];
	$contact_mail = $_POST['contact_mail'];
	$contact_address = $_POST['contact_address'];
	
	//邮箱名是唯一的，如果后来用户使用了之前用户的邮箱，注册会失败
	// $login_name ="xxxxxxxxxx" ;
	// $login_password ="123456" ;
	// $company_name = "tuhao company";
	// $contact_person ="wangsicong" ;
	// $contact_phone = "11158114130" ;
	// $contact_mail ="562322987@qq.com" ;
	// $contact_address ="晴川街" ;

	date_default_timezone_set("Asia/Shanghai");
	$reg_time = date("Y-m-d h:i");
	$sql = "INSERT INTO web_seller(seller_login_name,
									seller_login_password,
									seller_mail,
									seller_name,
									seller_contact_person,
				 					seller_contact_phone,
									seller_address,
									reg_time,
									last_count)
			VALUES( '$login_name',
					'$login_password',
					'$contact_mail',
					'$company_name',
					'$contact_person',
					'$contact_phone',
					'$contact_address',
					'$reg_time',
					'0');";

	if ($conn->query($sql)===TRUE) {
		header('location:login.php');
	}
	
?>


