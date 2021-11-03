<?php
	DEFINE('HOST', 'localhost');
	DEFINE('DB_TABLE', 'ldfa_admin');
	DEFINE('DB_USER', 'ldfa_admin');
	DEFINE('DB_PASSWORD', 'sgy&}0sPRUcj');
	$ConClass = mysqli_connect(HOST, DB_USER, DB_PASSWORD, DB_TABLE);
	if(!$ConClass){
		echo "<script>alert('DATABASE CONNECTION ERROR')</script>";
	}
?>