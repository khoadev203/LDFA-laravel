<?php
	include "../auth/auth.config.php";
	$UserID = $_POST['userid'];
	$country = $_POST['country'];
	$address = $_POST['address'];
	$addresstwo = $_POST['addresstwo'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$bussiness_type = $_POST['bussiness_type'];
	$date = date("Y-m-d H:i:s A");
	$status = "0";
	
	$AddActivation = mysqli_query($ConClass, "INSERT INTO `activation_requests`(`user_id`, `country`, `address_temporary`, `address_permanent`, `city`, `state`, `zip`, `business_type`, `available_on`, `status`) VALUES ('$UserID', '$country', '$address', '$addresstwo', '$city', '$state', '$zip', '$bussiness_type', '$date', '$status')");
	
	if($AddActivation){
		echo "
			<style>
			.error_api {
				font-family: 'Exo 2', sans-serif;
			}
			</style>
			<div class='error_api' style='text-transform: uppercase;font-size: 12px;color: black;background: #3da20a40;padding: 5px;font-weight: bold;box-shadow: inset 0px 0px 3px #3da20a40;margin-bottom: 10px;border-radius: 3px;'>Activation Request is Submit Successfully.</div>";
	}else{
			echo "
				<style>
				.error_api {
					font-family: 'Exo 2', sans-serif;
				}
				</style>
				<div class='error_api' style='text-transform: uppercase;font-size: 12px;color: black;background: #ff000040;padding: 5px;font-weight: bold;box-shadow: inset 0px 0px 3px #f91313;margin-bottom: 10px;border-radius: 3px;'>Activation Request is Not Submited.</div>";
	}
?>