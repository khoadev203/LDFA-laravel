<?php
	include "../auth/auth.config.php";
	$userid = mysqli_real_escape_string($ConClass, $_POST['userid']);
	$app_name = mysqli_real_escape_string($ConClass, $_POST['app_name']);
	$site_url = mysqli_real_escape_string($ConClass, $_POST['site_url']);
	$success_link = mysqli_real_escape_string($ConClass, $_POST['success_link']);
	$fail_link = mysqli_real_escape_string($ConClass, $_POST['fail_link']);
	$logo_url = mysqli_real_escape_string($ConClass, $_POST['logo_url']);
	$thumb = mysqli_real_escape_string($ConClass, $_POST['thumb']);
	$currency = mysqli_real_escape_string($ConClass, $_POST['currency']);
	$description = mysqli_real_escape_string($ConClass, $_POST['description']);
	$date = date("Y-m-d H:i:s");
	$app_id = mysqli_real_escape_string($ConClass, "APP-".uniqid());
	$n = 20;
	$publish_key = mysqli_real_escape_string($ConClass, "publish_".bin2hex(random_bytes($n)));
	$merchent_key = mysqli_real_escape_string($ConClass, "ldfa_".bin2hex(random_bytes($n)));
	
	$AddApplication = mysqli_query($ConClass, "INSERT INTO `merchants`(`user_id`, `merchant_key`, `site_url`, `success_link`, `fail_link`, `logo`, `name`, `description`, `json_data`, `currency_id`, `thumb`, `created_at`, `ipn_url`, `APP_ID`, `Publish_Key`) VALUES ('$userid', '$merchent_key', '$site_url', '$success_link', '$fail_link', '$logo_url', '$app_name', '$description', '', '$currency', '$thumb', '$date', '', '$app_id', '$publish_key')");
	
	if($AddApplication){
		echo "
			<style>
			.error_api {
				font-family: 'Exo 2', sans-serif;
			}
			</style>
			<div class='error_api' style='text-transform: uppercase;font-size: 12px;color: black;background: #3da20a40;padding: 5px;font-weight: bold;box-shadow: inset 0px 0px 3px #3da20a40;margin-bottom: 10px;border-radius: 3px;'>Your Application is Created Successfully</div>";
	}else{
		echo "
				<style>
				.error_api {
					font-family: 'Exo 2', sans-serif;
				}
				</style>
				<div class='error_api' style='text-transform: uppercase;font-size: 12px;color: black;background: #ff000040;padding: 5px;font-weight: bold;box-shadow: inset 0px 0px 3px #f91313;margin-bottom: 10px;border-radius: 3px;'>Something Went Wrong. Please Try Again</div>";
	}
?>	