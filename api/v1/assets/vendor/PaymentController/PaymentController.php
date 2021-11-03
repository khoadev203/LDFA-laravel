<?php
	include "../Auth/AuthController.php";
	$font = "'Exo 2'";
	$username = $_POST['username'];
	$password = $_POST['password'];
	$tokenAPI = $_POST['token'];
	$PlanID = $_POST['PlanID'];
	$price = $_POST['productCost'];
	if(empty($username)){
		echo "
			<style>
			.error_api {
				font-family: 'Exo 2', sans-serif;
			}
			</style>
			<div class='error_api' style='text-transform: uppercase;font-size: 12px;color: black;background: #ff000040;padding: 5px;font-weight: bold;box-shadow: inset 0px 0px 3px #f91313;margin-bottom: 10px;border-radius: 3px;'>please enter username</div>";
	}elseif(empty($password)){
		echo "
			<style>
			.error_api {
				font-family: 'Exo 2', sans-serif;
			}
			</style>
			<div class='error_api' style='text-transform: uppercase;font-size: 12px;color: black;background: #ff000040;padding: 5px;font-weight: bold;box-shadow: inset 0px 0px 3px #f91313;margin-bottom: 10px;border-radius: 3px;'>please enter password</div>";
	}else{
		$CheckUsername = mysqli_query($ConClass, "SELECT * FROM `users` WHERE `email`='$username'");
		$chkU = mysqli_num_rows($CheckUsername);
		if($chkU == 0){
			echo "
			<style>
			.error_api {
				font-family: 'Exo 2', sans-serif;
			}
			</style>
			<div class='error_api' style='text-transform: uppercase;font-size: 12px;color: black;background: #ff000040;padding: 5px;font-weight: bold;box-shadow: inset 0px 0px 3px #f91313;margin-bottom: 10px;border-radius: 3px;'>Username or email is invalid.</div>";
		}else{
			$gPassword = mysqli_fetch_assoc($CheckUsername);
			$hash = $gPassword['password'];
			$UserId = $gPassword['id'];
			if (password_verify($password, $hash)) {
				session_start();
				$_SESSION['UserId'] = $UserId;
				$_SESSION['ProductAmount'] = $price;
				$_SESSION['Token'] = $tokenAPI;
				$_SESSION['PlanID'] = $PlanID;
				$_SESSION['tranID'] = $_POST['transID'];
				$_SESSION['transType'] = $_POST['transType'];
				echo "<script>location.href='purchase.php?token=$tokenAPI&em=12'</script>";
			} else {
				echo "
				<style>
				.error_api {
					font-family: 'Exo 2', sans-serif;
				}
				</style>
				<div class='error_api' style='text-transform: uppercase;font-size: 12px;color: black;background: #ff000040;padding: 5px;font-weight: bold;box-shadow: inset 0px 0px 3px #f91313;margin-bottom: 10px;border-radius: 3px;'>Password is invalid.</div>";
			}
			
		}
	}
?>
