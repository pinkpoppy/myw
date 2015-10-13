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
	</div>

	<script src="../third_party/jquery-1.11.3.min.js"></script>
</body>
</html>