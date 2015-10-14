<?php
	require_once("../common/connect_database.php");
	session_start();
	$uid = $_SESSION['uid'];
	$cont = "";
  	if ($_SERVER['REQUEST_METHOD']=="GET") {
  		$notification_id = $_GET['id'];
  		$sql = "SELECT id,content FROM web_notification
  				WHERE id='$notification_id';";
  		$result = $conn->query($sql);
  		if ($result->num_rows==1) {
  			$row = $result->fetch_assoc();
  			$cont = json_encode($row['content'],JSON_UNESCAPED_UNICODE);
  		}
  	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>通知中心</title>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="../css/reset.css">
	<link rel="stylesheet" href="../css/layout.css">
	<style>
	div{background-color: #ffffff;height: 400px;padding: 5px;text-indent: 15px;}
	</style>
</head>	

<body class="inner_body">
	<div><?php echo $cont;?></div>
	<script src="../third_party/jquery-1.11.3.min.js"></script>
</body>
</html>