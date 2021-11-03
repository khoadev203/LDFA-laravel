<?php
	DEFINE('HOST', 'localhost');
	DEFINE('USER', 'ldfa_admin');
	DEFINE('PASS', 'sgy&}0sPRUcj');
	DEFINE('DB', 'ldfa_admin');
	$ConClass = mysqli_connect(HOST, USER, PASS, DB);
	if(!$ConClass){
		echo "<script>alert('DATABASE CONNECTION ERROR')</script>";
	}
?>