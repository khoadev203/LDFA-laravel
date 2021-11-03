<?php
	include "assets/vendor/PaymentConfig/ApiSessions.php";
	$AuthController = $_GET['APP-60a6afd4bd122'];
	$GetTokenDetails = mysqli_query($ConClass, "SELECT * FROM `merchants` WHERE `APP_ID`='$AuthController'");
    $chk = mysqli_num_rows($GetTokenDetails);
    $GetUDATA = mysqli_fetch_assoc($GetTokenDetails);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Exo+2&family=Girassol&display=swap" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Proccess Payments | LDFA</title>
</head>
<body>
    <section>
        <div class="container">
            <div class="loginSection">
                <div class="apilogo">
                    <img src="assets/img/logo.png" class="toplogo" alt="LDFA Logo" />
                </div>
                <div class="apiloginheading">
                    Pay With LDFA 
                </div>
                <div class="apilogintext">
                    With a LDFA account, you're eligible for free return shipping, Purchase Protection, and more. Email or mobile number
                </div>
				<div style="height: 30px;"></div>
				<div class="loggedin" style="text-align: left;">
					<span style="font-size: 16px;
                        text-transform: uppercase;
                        font-weight: bold;
                        font-family: 'Exo 2';" class="Username">Welcome Back Mr/Mrs </span>
                    <span style="font-size: 16px;
                        text-transform: uppercase;
                        font-weight: bold;
                        font-family: 'Exo 2';
                        color: red;"><?php echo $LoggedIn_Username; ?></span>
				</div>
				<br />
                <div class="product_details">
                    <div class="accountblnce">
                        <span class="blnc">Available Balance: </span><span class="blncval">
						<?php
							if($Currency == 1){
								echo "$".round(Balance_USD, 2);
							}elseif($Currency == 2){
								echo "€".round(Balance_EUR, 2);
							}else{
								echo "$".round(Balance_USD, 2);
							}
						?>
						</span>
                    </div>
                </div>
                <div class="product_details">
                    <span class="blnc">Product Cost: </span><span class="blncval">$<?php echo $ProductAmount; ?></span>
                </div>
                <div style="height: 10px;"></div>
                <div class="apilogintext" style="font-size: 11px;">
                    After clicking on the "Pay Now" button this product will amount will be deducted from your balance and you will be redirected back to seller's website.
                </div>
                <div style="height: 20px;"></div>
                <div class="form-row">
					<form method="post" action="assets/vendor/PaymentController/PaymentConfirmationController.php">
						<div class="form-group">
							<input type="hidden" name="UserId" value="<?php echo $UserId; ?>">
							<input type="hidden" name="productCost" value="<?php echo $ProductAmount; ?>">
							<input type="hidden" name="CurrencyID" value="<?php echo $Currency; ?>">
							<input type="hidden" name="Balance_USD" value="<?php echo Balance_USD; ?>">
							<input type="hidden" name="Balance_EUR" value="<?php echo Balance_EUR; ?>">
							<button class="btn btn-ldfa" type="submit"> PAY NOW </button>
						</div>
					</form>
                </div>
                <div class="backtext">
                    Click to redirect back to your website without Purchase. <a href="<?php echo $GetUDATA['fail_link']; ?>"><?php echo $GetUDATA['site_url']; ?></a>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
    </section>
    <!--<section class="container-fluid">
        <div class="row">
        <div class="footer">
            <footer class="lgft">
                &copy; 2020 LDFA PVT LMTD. All right reserved.
            </footer>
        </div>
        </div>
    </section>-->
</body>
</html>