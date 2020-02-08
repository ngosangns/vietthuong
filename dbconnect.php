<?php
	// connect database
	$db_host = "localhost";
	$db_user = "root";
	$db_pass = "";
	$db_name = "kshinedo_logka";
	$GLOBALS['db_connect'] = mysqli_connect($db_host, $db_user, $db_pass, $db_name) or die ("error connect");
	$db_connect = $GLOBALS['db_connect'];
	mysqli_query($db_connect, "SET NAMES utf8");
?>