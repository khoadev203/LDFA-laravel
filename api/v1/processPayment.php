<?php
    include "assets/vendor/Auth/AuthController.php";
    $AuthController = $_GET['transaction'];
    $GetTokenDetails = mysqli_query($ConClass, "SELECT * FROM `merchants` WHERE `APP_ID`='$AuthController'");
    $chk = mysqli_num_rows($GetTokenDetails);
    $GetUDATA = mysqli_fetch_assoc($GetTokenDetails);
	if(empty($_GET['transaction']) OR ($chk == 0)){
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
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>PAY WITH LDFA | API</title>
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
                    <div style="color: red;"><strong>Unauthrized Integration...!</strong> Please Check your Keys and APP ID.
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</body>
</html>
<?php
	}else{
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>PAY WITH LDFA | API</title>
    <style>
        .price-badge {
            position: absolute;
            right: -45px;
            width: 124px;
            background: #2196f3;
            font-size: 15px;
            width: 90px;
            height: 90px;
            top: -45px;
            font-weight: bold;
            font-family: 'Exo 2';
            color: #f7f7f7;
            line-height: 90px;
            border-radius: 65px;
        }
        .cart{
            margin-right: 6px;
        }
        #loader{
            height: 100vh;
            position: absolute;
            z-index: 999999;
            background: #fffefac4;
            top: 0;
            bottom: 0%;
            left: 0;
            right: 0%;
            z-index: 99;
        }
        #loader img{
            left: 46%;
            position: relative;
            top: 33%;
            width: 10%;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <div id="loader" style="display: none;"><img src="assets/img/loading.gif"></div>
            <div class="loginSection">
                <div class="apilogo">
                    <img src="assets/img/logo.png" class="toplogo" alt="LDFA Logo" />
                </div>
                <div class="price-badge"><span class="cart"><i class="fa fa-shopping-cart"></i></span>USD <?php echo $_POST['productAmount']; ?></div>
                <div class="apiloginheading">
                    Pay With LDFA
                </div>
                <div class="apilogintext">
                    The Liberty Dollar--Private Money For Private Business
                </div>
                <div class="login-form-api">
					<div id="show_msg"></div>
                    <form id="APIAuth">
                        <div class="form-row">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="Username / Email" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password" />
                                <input type="hidden" class="form-control" name="token" value="<?php echo $_GET['transaction']; ?>" />
                                <input type="hidden" class="form-control" name="PlanID" value="<?php echo $_POST['item_number']; ?>" />
                                <input type="hidden" class="form-control" name="productCost" value="<?php echo $_POST['productAmount']; ?>" />
                                <input type="hidden" class="form-control" name="transID" value="<?php echo $_POST['item_id']; ?>" />
                                <input type="hidden" class="form-control" name="transType" value="<?php echo $_POST['item_type']; ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group radiologin">
                                <input class="inp-cbx" id="cbx" type="checkbox" style="display: none"/>
                                <label class="cbx" for="cbx"><span>
                                    <svg width="12px" height="9px" viewbox="0 0 12 9">
                                    <polyline points="1 5 4 8 11 1"></polyline>
                                    </svg></span><span>Keep me logged in</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <button type="submit" class="btn btn-ldfa"> Login and Pay</button>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <div class="loginSignUpSeparator "><span class="textInSeparator">or</span></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <div class="btn btn-ldfa-light" style="line-height: 42px;"> PAY AS GUEST</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
	<script>
		$(document).ready(function(){
			$("#APIAuth").submit(function(e){
			    $("#loader").show();
				e.preventDefault();
					$.ajax({
						url: "assets/vendor/PaymentController/PaymentController.php",
						method: "post",
						data: $("#APIAuth").serialize(),
						dataType: "html",
						success: function(strMessage){
						    
						    $("#show_msg").html(strMessage);
						    $("#loader").hide();
						}
		    	});
			});
	    });
	</script>
</body>
</html>
<?php } ?>
