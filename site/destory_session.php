<?php

	require_once("./common/connect_database.php");
	
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		session_unset();
	}	
?>