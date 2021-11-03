<?php
	include "assets/vendor/Auth/AuthController.php";
	session_start();
	if(empty($_SESSION['UserId'])){
		echo "<script>location.href='https://www.ldfa.nl/api'</script>";
	}
	$UserId = $_SESSION['UserId'];
	$ProductAmount = $_SESSION['ProductAmount'];
	$SellerSite = $_SESSION['SellerSite'];
	$Token = $_SESSION['Token'];
	$GetUD = mysqli_query($ConClass, "SELECT * FROM `users` WHERE `id`='$UserId'");
	$GD = mysqli_fetch_assoc($GetUD);
	$Balance = $GD['balance'];
	$Currency = $GD['currency_id'];
	$balance_usd = $Balance * 26.324518462326;
	$eur_balance = $Balance * 21.947536791145;
	DEFINE('Balance_USD', $balance_usd);
	DEFINE('Balance_EUR', $eur_balance);
	$_SESSION['Exchange_USD'] = 26.324518462326;
	$_SESSION['Exchange_EUR'] = 21.947536791145;
	$_SESSION['Balance_USD'] = Balance_USD;
	$_SESSION['Balance_EUR'] = Balance_EUR;
	$LoggedIn_Username = $GD['name'];
?>