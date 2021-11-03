<?php 
	include "Auth/AuthController.php";
	$SQL = "	
	CREATE TABLE `api_purchase` (
	  `id` int(23) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	  `user_id` varchar(255) CHARACTER SET latin1 NOT NULL,
	  `marchent_id` varchar(255) CHARACTER SET latin1 NOT NULL,
	  `type` varchar(255) CHARACTER SET latin1 NOT NULL,
	  `amount` varchar(255) CHARACTER SET latin1 NOT NULL,
	  `description` varchar(255) CHARACTER SET latin1 NOT NULL,
	  `available` varchar(255) CHARACTER SET latin1 NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
	";
	if(mysqli_query($ConClass, $SQL)){
		echo "Table Created";
	}else{
		echo "Unexpected Error";
	}
?>