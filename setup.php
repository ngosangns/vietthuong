<?php
	// connect database
	$db_host = "localhost";
	$db_user = "kshinedo_logka";
	$db_pass = "jikmli";
	$db_connect = mysqli_connect($db_host, $db_user, $db_pass) or die ("error connect");
	// tạo cơ sở dữ liệu
	$db_name = "kshinedo_logka";
	$db_query = "CREATE DATABASE IF NOT EXISTS ".$db_name." CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';";
	mysqli_query($db_connect, $db_query) or die("create database error");
	mysqli_select_db($db_connect, $db_name) or die("select database error");
	// tạo bảng member
	$db_table = "user";
	$db_query = "CREATE TABLE IF NOT EXISTS ".$db_table."(id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, username VARCHAR(255) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL) ENGINE = InnoDB;";
	mysqli_query($db_connect, $db_query) or die("create table error : user");
	//tạo bảng sản phẩm
	$db_table_2 = "product";
	$db_query= "CREATE TABLE IF NOT EXISTS ".$db_table_2."(id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, code VARCHAR(255) NOT NULL , name VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, price INT, image VARCHAR(255) DEFAULT 'image/notfound.jpg', comment VARCHAR(2048)) ENGINE = InnoDB;";
	mysqli_query($db_connect, $db_query) or die("create table error : product");
	//tạo bảng bài viết
	$db_table_3 = "post";
<<<<<<< HEAD
	$db_query= "CREATE TABLE IF NOT EXISTS ".$db_table_3."(id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL, dangdienra TINYINT(1) NOT NULL DEFAULT 0, displaytt TINYINT(1) NOT NULL DEFAULT 1, descr mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci, comment longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci, category VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT 'image/notfound.jpg') ENGINE = InnoDB;";
=======
	$db_query= "CREATE TABLE IF NOT EXISTS ".$db_table_3."(id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL, descr mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci, comment longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci, category VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT 'image/notfound.jpg') ENGINE = InnoDB;";
>>>>>>> f0a8d7431e8a1b412b28dd1a223db265fe0bbc6f
	mysqli_query($db_connect, $db_query) or die("create table error : post");
	// tạo tk admin: tk admin mk admin
	$db_query = "INSERT INTO `user`(`username`, `password`)
			 VALUES('admin', 'admin')";
	mysqli_query($db_connect, $db_query) or die("setup admin error");
	echo "setup successfully";
?>