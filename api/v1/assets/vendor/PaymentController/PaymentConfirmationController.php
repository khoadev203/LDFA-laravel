<?php
	session_start();
	include "../Auth/AuthController.php";
	include "../PaymentConfig/ApiSessions.php";
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php
	
	$UserId = $_POST['UserId'];
	$ProductCost = $_POST['productCost'];
	$fee = 1.5;
	$NetCost = $ProductCost + $fee;
	$CurrencyID = $_POST['CurrencyID'];
	$Balance_USD = $_POST['Balance_USD']; 
	$Remaining = $Balance_USD - $NetCost;
	$ActualBalance = $Remaining/$_SESSION['Exchange_USD'];
	$UserId = strval($_SESSION['UserId']);
	$GetTokenDetails = mysqli_query($ConClass, "SELECT * FROM `merchants` WHERE `APP_ID`='$Token'");
	$GTD = mysqli_fetch_assoc($GetTokenDetails);
	$MerchentID = $GTD['user_id'];
	$Merchent = $GTD['id'];
	$SiteURL = $GTD['site_url'];
	$SellerSiteSuccess = $GTD['success_link'];
	$Description = "Transaction For ".$SiteURL;
	$GetMerchenDetails = mysqli_query($ConClass, "SELECT * FROM `users` WHERE `id`='$MerchentID'");
	$GMD = mysqli_fetch_assoc($GetMerchenDetails);
	$GetUserDetails = mysqli_query($ConClass, "SELECT * FROM `users` WHERE `id`='$UserId'");
	$GUD = mysqli_fetch_assoc($GetUserDetails);
	$Buyername = $GUD['name'];
	$MerchentBalance = $GMD['balance'];
	$Merchentname = $GMD['name'];
	$ChkMerchentBalance = $GMD['balance'] * $_SESSION['Exchange_USD'];
	$NewMerchentBalance = $ChkMerchentBalance + $NetCost;
	$FinalBalance = $NewMerchentBalance/$_SESSION['Exchange_USD'];
	$transaction_state_id = uniqid();
	$sale_id = uniqid();
	$date = date("Y-m-d h:i:s A");
    $CreatePayment = mysqli_query($ConClass, "UPDATE `users` SET `balance`='$ActualBalance' WHERE `id`='$UserId'");
    if($CreatePayment){
    	$UpdateMerchentBalance = mysqli_query($ConClass, "UPDATE `users` SET `balance`='$FinalBalance' WHERE `id`='$MerchentID'");
    	if($UpdateMerchentBalance){
    		$AddSale = mysqli_query($ConClass, "INSERT INTO `api_purchase`(`user_id`, `marchent_id`, `type`, `amount`, `description`, `available`) VALUES ('$MerchentID', '$Merchent', 'Subscription', '$ProductCost', '$Description', '$date')");
    	    	if($AddSale){
?>

		<style>
	/* -------------------------------------
    GLOBAL
    A very basic CSS reset
------------------------------------- */
* {
    margin: 0;
    padding: 0;
    font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
    box-sizing: border-box;
    font-size: 14px;
}

img {
    max-width: 100%;
}

body {
    -webkit-font-smoothing: antialiased;
    -webkit-text-size-adjust: none;
    width: 100% !important;
    height: 100%;
    line-height: 1.6;
}

/* Let's make sure all tables have defaults */
table td {
    vertical-align: top;
}

/* -------------------------------------
    BODY & CONTAINER
------------------------------------- */
body {
    background-color: #f6f6f6;
}

.body-wrap {
    background-color: #f6f6f6;
    width: 100%;
}

.container {
    display: block !important;
    max-width: 600px !important;
    margin: 0 auto !important;
    /* makes it centered */
    clear: both !important;
}

.content {
    max-width: 600px;
    margin: 0 auto;
    display: block;
    padding: 20px;
}

/* -------------------------------------
    HEADER, FOOTER, MAIN
------------------------------------- */
.main {
    background: #fff;
    border: 1px solid #e9e9e9;
    border-radius: 3px;
}

.content-wrap {
    padding: 20px;
}

.content-block {
    padding: 0 0 20px;
}

.header {
    width: 100%;
    margin-bottom: 20px;
}

.footer {
    width: 100%;
    clear: both;
    color: #999;
    padding: 20px;
}
.footer a {
    color: #999;
}
.footer p, .footer a, .footer unsubscribe, .footer td {
    font-size: 12px;
}

/* -------------------------------------
    TYPOGRAPHY
------------------------------------- */
h1, h2, h3 {
    font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
    color: #000;
    margin: 40px 0 0;
    line-height: 1.2;
    font-weight: 400;
}

h1 {
    font-size: 32px;
    font-weight: 500;
}

h2 {
    font-size: 24px;
}

h3 {
    font-size: 18px;
}

h4 {
    font-size: 14px;
    font-weight: 600;
}

p, ul, ol {
    margin-bottom: 10px;
    font-weight: normal;
}
p li, ul li, ol li {
    margin-left: 5px;
    list-style-position: inside;
}

/* -------------------------------------
    LINKS & BUTTONS
------------------------------------- */
a {
    color: #1ab394;
    text-decoration: underline;
}

.btn-primary {
    text-decoration: none;
    color: #FFF;
    background-color: #1ab394;
    border: solid #1ab394;
    border-width: 5px 10px;
    line-height: 2;
    font-weight: bold;
    text-align: center;
    cursor: pointer;
    display: inline-block;
    border-radius: 5px;
    text-transform: capitalize;
}

/* -------------------------------------
    OTHER STYLES THAT MIGHT BE USEFUL
------------------------------------- */
.last {
    margin-bottom: 0;
}

.first {
    margin-top: 0;
}

.aligncenter {
    text-align: center;
}

.alignright {
    text-align: right;
}

.alignleft {
    text-align: left;
}

.clear {
    clear: both;
}

/* -------------------------------------
    ALERTS
    Change the class depending on warning email, good email or bad email
------------------------------------- */
.alert {
    font-size: 16px;
    color: #fff;
    font-weight: 500;
    padding: 20px;
    text-align: center;
    border-radius: 3px 3px 0 0;
}
.alert a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
}
.alert.alert-warning {
    background: #f8ac59;
}
.alert.alert-bad {
    background: #ed5565;
}
.alert.alert-good {
    background: #1ab394;
}

/* -------------------------------------
    INVOICE
    Styles for the billing table
------------------------------------- */
.invoice {
    margin: 40px auto;
    text-align: left;
    width: 80%;
}
.invoice td {
    padding: 5px 0;
}
.invoice .invoice-items {
    width: 100%;
}
.invoice .invoice-items td {
    border-top: #eee 1px solid;
}
.invoice .invoice-items .total td {
    border-top: 2px solid #333;
    border-bottom: 2px solid #333;
    font-weight: 700;
}

/* -------------------------------------
    RESPONSIVE AND MOBILE FRIENDLY STYLES
------------------------------------- */
@media only screen and (max-width: 640px) {
    h1, h2, h3, h4 {
        font-weight: 600 !important;
        margin: 20px 0 5px !important;
    }

    h1 {
        font-size: 22px !important;
    }

    h2 {
        font-size: 18px !important;
    }

    h3 {
        font-size: 16px !important;
    }

    .container {
        width: 100% !important;
    }

    .content, .content-wrap {
        padding: 10px !important;
    }

    .invoice {
        width: 100% !important;
    }
}
</style>
<table class="body-wrap">
    <tbody><tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td class="content-wrap aligncenter">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td class="content-block">
                                        <h2>Thanks for using our app</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <table class="invoice">
                                            <tbody><tr>
                                                <td><?php echo $Token ?><br><br />Invoice #<?php echo $sale_id ?><br><br /><?php echo $date ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                        <tbody><tr>
                                                            <td>Plan Price</td>
                                                            <td class="alignright">$ <?php echo $ProductCost; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Transaction Fee</td>
                                                            <td class="alignright">$ <?php echo $fee; ?></td>
                                                        </tr>
                                                     
                                                        <tr class="total">
                                                            <td class="alignright" width="80%">Total</td>
                                                            <td class="alignright">$ <?php echo $ProductCost + $fee; ?></td>
                                                        </tr>
                                                    </tbody></table>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <div style="color: red;">Your transaction is successfully completed. Please wait you will be redirect back automatically.</div>
										
									</td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        Product Purchased From <a href="<?php echo $SellerSite ?>"><?php echo $SellerSite ?></a>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
                <div class="footer">
                    <table width="100%">
                        <tbody><tr>
						<input type='button' value='Submit' style='display: none;' id='submit' onclick='pageRedirect();'> <br/>
 
						<!-- Message -->
						<div id="message"></div>
                            <td class="aligncenter content-block">Go Back <a href="<?php echo $SellerSiteSuccess; ?>" id="redirect"><?php echo $SellerSite; ?></a></td>
                        </tr>
                    </tbody></table>
                </div></div>
        </td>
        <td></td>
    </tr>
</tbody></table>
<script>
	$(document).ready(function(){
		//setInterval(function(){
		//	$("#submit").click();
		//}, 3000);
		setTimeout($("#submit").click(), 3000);
	});
	function pageRedirect(){
		window.location = "<?php echo $SellerSiteSuccess; ?>&id=<?php echo $_SESSION['tranID']; ?>&type_r=<?php echo $_SESSION['transType']; ?>";
	}
</script>

<?php
		}else{
			echo "Payment Error";	
		}
		}else{
			echo "ERROR IN UPDATION";
		}
	}else{
		echo "ERROR IN DEDUCATION";
	}
	
	
	
	
?>