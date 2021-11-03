<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Artisan::call('storage:link');

Route::get('/lang/{lang}', function ($locale){
    Session::put('locale', $locale);
       return redirect('/');
});

Route::get('/authorizenet_pay','AuthorizenetController@pay')->name('authorizenet.pay');
Route::post('/authorizenet_dopay', 'AuthorizenetController@handleonlinepay')->name('authorizenet.dopay');
Route::get('/authorizenet_logs', 'AuthorizenetController@index')->name('authorizenet.logs');


Route::get('/api/users', function () {
    return response()->json(\App\User::paginate(20));
});

Route::get('/wallet/{id}','HomeController@wallet')->middleware('auth');    

Route::get('*', function() {
    App::setLocale(session()->get('locale'));
});

Route::get('/', 'Controller@landing');

Route::get('landingtest', 'Controller@landingtest');

Route::get('/mail', 'SignUpController@TestMail');
Route::post('/support_email', 'SignUpController@supportEmail')->name('support_email');
Route::get('/paysi', 'SignUpController@paysy');

Route::get('/account_status/{User}', 'HomeController@accountStatus')->middleware('auth');
Route::get('/resendotp', 'HomeController@resendOtp')->name(
    'resendotp')->middleware('auth');

//Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'SignUpController@showRegistrationForm')->name('register');
Route::post('register', 'SignUpController@register');


// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//Account Activation Routes...
Route::get('register/{email}/{token}', 'SignUpController@verifyEmail');
Route::get('resend/activationlink', 'SignUpController@resendActivactionLink')->middleware('auth');
Route::get('otp', 'SignUpController@OTP')->middleware('auth');
Route::post('otp', 'SignUpController@postOtp')->middleware('auth');

//Impersonation routes
Route::get('impersonate/user/{user_id}', 'ProfileController@impersonateUser')->middleware('auth');
Route::impersonate();

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

// SEND MONEY ROUTES 
Route::get('/sendmoney', 'MoneyTransferController@sendMoneyForm')->name('sendMoneyForm')->middleware('auth');
Route::post('/sendmoney', 'MoneyTransferController@sendMoney')->name('sendMoney')->middleware('auth');

Route::post('/sendMoneyConfirm', 'MoneyTransferController@sendMoneyConfirm')->name('sendMoneyConfirm')->middleware('auth');
Route::post('/sendMoneyDelete', 'MoneyTransferController@sendMoneyCancel')->name('sendMoneyDelete')->middleware('auth');

Route::any('/billchecks', 'BillController@index')->name('billchecks.index')->middleware('auth');
Route::get('/paybill', 'BillController@createCheckForm')->name('paybill')->middleware('auth');
Route::post('/paybill', 'BillController@create')->name('paybill')->middleware('auth');
Route::any('/viewcheck/{id}', 'BillController@viewcheck')->name('viewcheck')->middleware('auth');
Route::any('/voidcheck/{id}', 'BillController@voidcheck')->name('voidcheck')->middleware('auth');

Route::get('/deposit/echeck', 'BillController@deposit')->name('deposit.echeck')->middleware('auth');
Route::post('/deposit/echeck', 'BillController@requestEcheckDeposit')->name('deposit.echeck.request')->middleware('auth');
Route::get('/deposit/echeck/confirm/{id}', 'BillController@confirmEcheckDeposit')->name('deposit.echeck.confirm')->middleware('auth');
Route::get('/echeck/{id}', 'BillController@showPdfFile')->name('deposit.echeck.showpdf')->middleware('auth');


//REQUEST MONEY ROUTES
Route::get('/requestmoney', 'MoneyTransferController@requestMoneyForm')->name('requestMoneyForm')->middleware('auth');
Route::post('/requestmoney', 'MoneyTransferController@requestMoney')->name('requestMoney')->middleware('auth');
// Route::post('/requestMoneyConfirm', 'MoneyTransferController@requestMoneyConfirm')->name('requestMoneyConfirm')->middleware('auth');
// Route::post('/requestMoneyDelete', 'MoneyTransferController@requestMoneyCancel')->name('requestMoneyDelete')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');


/*  MERCHANT ROUTES */

Route::get('/merchant/storefront/{ref}', 'MerchantController@getStoreFront')->name('storefront');
Route::get('/merchant/{merchant}/docs', 'MerchantController@integration')->middleware('auth');
Route::get('/mymerchants', 'MerchantController@index')->name('mymerchants')->middleware('auth');

Route::get('/merchant/new', 'MerchantController@new')->name('merchant.new')->middleware('auth');
Route::post('/merchant/add','MerchantController@add')->name('merchant.add')->middleware('auth');


/*  IPN ROUTES  */
Route::post('/purchase/link', 'RequestController@storeRequest')->name('purchase_link');
Route::post('/request/status', 'RequestController@requestStatus')->name('purchase_status');
Route::post('/purchase/confirm', 'IPNController@purchaseConfirmation')->name('purchaseConfirm')->middleware('auth');
Route::post('/purchase/delete', 'IPNController@purchaseCancelation')->name('purchaseDelete')->middleware('auth');
Route::post('/ipn/payment', 'IPNController@pay')->name('pay')->middleware('auth');
Route::post('/ipn/payment/guest', 'IPNController@logandpay')->name('logandpay');

/*  ADD CREDIT ROUTES   */ 
Route::get('/addcredit/{method_id?}', 'AddCreditController@addCreditForm')->name('add.credit')->middleware(['auth','activeUser']);
Route::get('/deposit', 'AddCreditController@depositMethods')->name('deposit.credit')->middleware('auth');
Route::post('/addcredit', 'AddCreditController@depositRequest')->name('post.credit')->middleware('auth');
Route::get('/depositFormDownload', 'AddCreditController@downloadPdfForm')->name('deposit.downloadfile')->middleware('auth');


/*  DEPOSITS ROUTES */
Route::get('/mydeposits','DepositController@myDeposits')->name('mydeposits')->middleware('auth');
Route::put('/confirm/deposit','DepositController@confirmDeposit')->name('confirm.deposit')->middleware('auth');
Route::get('deposit/pdftest', 'BillController@testpdfview');

/* WITHDRAWAL ROUTES */

route::get('/withdrawal/request/{method_id?}', 'WithdrawalController@getWithdrawalRequestForm')->name('withdrawal.form')->middleware(['auth','activeUser']);
route::post('/withdrawal/request', 'WithdrawalController@makeRequest')->name('post.withdrawal')->middleware('auth');
route::get('/withdrawals', 'WithdrawalController@index')->name('withdrawal.index')->middleware('auth');

Route::post('/confirm/withdrawal','WithdrawalController@confirmWithdrawal')->name('confirm.withdrawal')->middleware('auth');
route::get('/cancel/withdrawal/{id}', 'WithdrawalController@cancel')->name('cancel.withdrawal')->middleware(['auth']);


/* REPORT ROUTES */
Route::any('/report','ReportController@create')->name('create.reports')->middleware('auth');
Route::get('/view_report','ReportController@index')->name('view_report')->middleware('auth');
Route::get('/download_csv/{id}','ReportController@download_csv')->name('download_csv')->middleware('auth');

/* EXCHANGE ROUTES */
route::get('/exchange/first/{first_id?}/second/{second_id?}', 'ExchangeController@getExchangeRequestForm')->name('exchange.form')->middleware('auth');
route::post('/exchange/', 'ExchangeController@exchange')->name('post.exchange')->middleware('auth');

route::post('/update_rates','ExchangeController@updateRate')->middleware('auth');
route::get('/update_rates','ExchangeController@updateRateForm')->middleware('auth');

route::get('new_ticket', 'TicketsController@create')->name('support');
route::post('new_ticket', 'TicketsController@store')->name('support');
route::get('my_tickets', 'TicketsController@userTickets')->name('support');
Route::get('tickets/{ticket_id}', 'TicketsController@show')->name('support');
Route::post('comment', 'TicketCommentsController@postTicketComment')->name('support');

Route::group(['prefix' => 'ticketadmin', 'middleware' => 'ticketadmin'], function() {
    Route::get('tickets', 'TicketsController@index')->name('support');
    Route::post('close_ticket/{ticket_id}', 'TicketsController@close')->name('support');
});

route::get('profile/info', 'ProfileController@personalInfo')->name('profile.info')->middleware('auth');
route::post('profile/info', 'ProfileController@storePersonalInfo')->name('profile.info.store')->middleware('auth');

route::get('profile/identity', 'ProfileController@profileIdentity')->name('profile.identity')->middleware('auth');
route::post('profile/identity', 'ProfileController@storeProfileIdentity')->name('profile.identity.store')->middleware('auth');

route::get('profile/newpassword', 'ProfileController@newpasswordInfo')->name('profile.newpassword')->middleware('auth');
route::post('profile/newpassword', 'ProfileController@storeNewpasswordInfo')->name('profile.newpassword.store')->middleware('auth');

route::get('profile/creditcard', 'ProfileController@creditCardInfo')->name('profile.creditcard')->middleware('auth');
route::post('profile/creditcard', 'ProfileController@storeCreditCardInfo')->name('profile.creditcard.store')->middleware('auth');

route::get('profile/bankinfo', 'ProfileController@bankInfo')->name('profile.bankinfo')->middleware('auth');
route::post('profile/bankinfo', 'ProfileController@storeBankInfo')->name('profile.bankinfo.store')->middleware('auth');


//PAGES ROUTES
route::get('page/{id}', "HomeController@getPage");


//VOUCHERS ROUTES
route::get('my_vouchers', 'VoucherController@getVouchers')->name('my_vouchers')->middleware('auth');
route::post('my_vouchers', 'VoucherController@createVoucher')->name('create_my_voucher')->middleware('auth');
route::post('load_my_voucher', 'VoucherController@loadVoucher')->name('load_my_voucher')->middleware('auth');
route::post('load_voucher_to_user', 'VoucherController@loadVoucherToUser')->name('load_voucher_to_user')->middleware('auth');
route::get('makevouchers', 'VoucherController@generateVoucher')->name('makeVouchers')->middleware('auth');
route::post('generateVoucher', 'VoucherController@postGenerateVoucher')->name('generateVoucher')->middleware('auth');
route::get('buyvoucher', 'VoucherController@buyvouchermethod')->middleware('auth');

//PAYPAL VOUCHER ROUTES
route::get('buyvoucher/paypal', 'PayPalController@buyvoucher')->middleware('auth');
route::post('buyvoucher/paypal', 'PayPalController@sendRequestToPaypal')->middleware('auth');
route::get('pay/voucher/paypal/success', 'PayPalController@paySuccess')->middleware('auth');
Route::post('/merchant/storefront/paypal/{ref}', 'PayPalController@postStoreFront')->name('paypalstorefront');
Route::get('/merchant/storefront/paypal/success', 'PayPalController@postStoreFrontSuccess');
Route::get('/merchant/storefront/paypal/cancel', 'PayPalController@postStoreFrontCancel');
Route::post('paypal/paybutton_success', 'PayPalController@payButtonSuccess')->name('paypal_button_success')->middleware('auth');

//PAYSTACK VOUCHER ROUTES
route::get('buyvoucher/paystack', 'PaystackController@buyvoucher')->middleware('auth');
route::post('buyvoucher/paystack', 'PaystackController@sendRequestToPayStack')->middleware('auth');
route::get('pay/voucher/paystack/success', 'PaystackController@payVoucherPayStackSuccess')->middleware('auth');
Route::post('/merchant/storefront/paystack/{ref}', 'PaystackController@postStoreFront')->name('paystackstorefront');
Route::get('/merchant/storefront/paystack/success', 'PaystackController@postStoreFrontSuccess');

//STRIPE VOUCHER ROUTES
route::get('buyvoucher/stripe', 'StripeController@buyvoucher')->middleware('auth');
route::post('buyvoucher/stripe', 'StripeController@sendRequestToStripe')->middleware('auth');

/* BUTTON ROUTES */
//pay from buttons
route::get('pay','ButtonController@paypage')->middleware('auth');
route::get('paymoney/{id}','ButtonController@paymoney')->name('paymoney')->middleware('auth');
route::get('paybycrypto/{id}/{method_id?}','ButtonController@paybycrypto')->name('paybycrypto')->middleware('auth');

Route::get('/buttons', 'ButtonController@index')->name('button.index')->middleware('auth');
Route::get('/view', 'ButtonController@view')->name('button.view')->middleware('auth');
Route::any('/create/{type}', 'ButtonController@createbutton')->name('button.createbutton')->middleware('auth');
Route::any('/add/{type}', 'ButtonController@addbutton')->name('button.addbutton')->middleware('auth');
Route::get('button-delete/{id}', 'ButtonController@deleteButton')->name('button.delete')->middleware('auth');
route::get('purchasehistory', 'ButtonController@purchaseHistory')->name('purchasehistory')->middleware('auth');

route::get('subscribe', 'ButtonController@showSubscribeForm')->name('subscriptionForm')->middleware('auth');
route::post('add_subscription', 'ButtonController@subscribe')->name('add_subscription')->middleware('auth');
route::get('subscriptions', 'ButtonController@subscriptions')->name('subscriptions')->middleware('auth');

route::get('donate', 'ButtonController@showDonateForm')->name('donateForm')->middleware('auth');
route::post('donate', 'ButtonController@donate')->name('donate')->middleware('auth');
route::get('donations', 'ButtonController@donations')->name('donations')->middleware('auth');

//route::get('pay/voucher/paystack/success', 'PaystackController@payVoucherPayStackSuccess')->middleware('auth');

//SEAMLESSCHEX VOUCHER ROUTES
route::get('buyvoucher/seamless', 'SeamlessController@buyvoucher')->middleware('auth');
route::post('buyvoucher/seamless', 'SeamlessController@sendRequestToSeamless')->middleware('auth');

//Square VOUCHER ROUTES
route::get('buyvoucher/square', 'SquareController@buyvoucher')->middleware('auth');
route::post('buyvoucher/square', 'SquareController@sendRequestToSquare')->middleware('auth');

//2CHECKOUT VOUCHER ROUTES
route::get('buyvoucher/2checkout', 'TwoCheckoutController@buyvoucher')->middleware('auth');
route::post('buyvoucher/2checkout', 'TwoCheckoutController@sendRequestToStripe')->middleware('auth');
//route::get('pay/voucher/paystack/success', 'PaystackController@payVoucherPayStackSuccess')->middleware('auth');

//TUTORIAL ROUTES


route::get('blog', 'BlogController@index' )->name('blog');
route::get('blog/{post_excerpt}/{post_id}', 'BlogController@singlePost' )->name('post');

//TRANSACTIOINS ROUTES
route::post('transaction/remove', 'TransactionController@deleteMapper')->middleware('auth');
route::any('buy_certificate', 'TransactionController@buy_certificate')->name('buy_certificate')->middleware('auth');
route::get('my_cert_orders', 'TransactionController@my_cert_orders')->name('my_cert_orders')->middleware('auth');
route::any('redeem', 'TransactionController@redeem')->name('redeem')->middleware('auth');
route::any('confirm_certificate/{id}', 'TransactionController@confirm_certificate')->name('confirm_certificate')->middleware('auth');
route::any('reject_certificate/{id}', 'TransactionController@reject_certificate')->name('reject_certificate')->middleware('auth');
route::any('confirm_redeem/{id}', 'TransactionController@confirm_redeem')->name('confirm_redeem')->middleware('auth');
route::any('reject_redeem/{id}', 'TransactionController@reject_redeem')->name('reject_redeem')->middleware('auth');
route::any('confirm_transactions/{id}', 'TransactionController@confirm_transactions')->name('confirm_transactions')->middleware('auth');

//ESCROW ROUTES

route::get('escrow', 'EscrowController@sendForm')->name('escrow')->middleware('auth');
route::post('escrow', 'EscrowController@store')->middleware('auth');
route::post('/escrow/refund','EscrowController@refund')->middleware('auth');
route::post('/escrow/release','EscrowController@release')->middleware('auth');
route::get('/escrow/{eid}', 'EscrowController@agreement')->middleware('auth');

//AFFILIATE ROUTES
route::get('downlines', 'AffiliateController@showDownlines')->name('downlines')->middleware('auth');
route::get('banners', 'AffiliateController@showBanners')->name('banners')->middleware('auth');
route::get('getdownlines', 'AffiliateController@getDownlines')->name('getdownlines')->middleware('auth');
route::get('affiliatedetails', 'AffiliateController@index')->name('affiliatedetails')->middleware('auth');

//TD ACCOUNT ROUTES
route::get('tdaccounts/{tid}', 'TdaccountController@index')->name('tdaccounts')->middleware('auth');
route::post('tdaccounts/deposit', 'TdaccountController@deposit')->name('tdaccounts.deposit')->middleware('auth');
route::post('tdaccounts/withdraw', 'TdaccountController@withdraw')->name('tdaccounts.withdraw')->middleware('auth');
route::get('mytdaccs', 'TdaccountController@overview')->name('mytdaccs')->middleware('auth');
route::get('tdaccounts_checkmonthlyinterest', 'TdaccountController@checkMonthlyInterest');
route::post('send_loan_application', 'TdaccountController@sendLoanApplication')->name('applyLoan')->middleware('auth');


//ADMINISTRATION ROUTES

route::get('users/all', 'ProfileController@getUsers')->middleware('auth');
route::get('suspenduser/{uid}', 'ProfileController@suspendUser')->name('suspenduser')->middleware('auth');
route::get('recoveruser/{uid}', 'ProfileController@recoverUser')->name('recoveruser')->middleware('auth');
route::get('verifyuser/{uid}', 'ProfileController@verifyUser')->name('verifyuser')->middleware('auth');
//DEMO ROUTES

route::get('demo/index', 'DemoController@index')->middleware('guest');
route::get('demo/user', 'DemoController@user')->name('demouser')->middleware('guest');
route::get('demo/admin', 'DemoController@admin')->name('demoadmin')->middleware('guest');

route::get('/me/{user_name}', 'ProfileController@me');

Route::get('/cookie', function () {
    return Cookie::get('referral');
});

Route::get('/download/{file}', function ($file='') {
    ob_end_clean();
    // if($file == 'ldfa.apk') {
    //     $headers = array(
    //       'Content-Type: application/vnd.android.package-archive',
    //     );
    //     // return response()->download(storage_path('app/public/'.$file), $file);
    //     return Storage::download($file ,$file, $headers);
    // } else {

        return Storage::download($file);
    // }
})->name('download');

Route::get('/calculator', 'CalculatorController@index')->name('calculator');

Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index'])->middleware('auth');
    Route::get('unread', ['as'  =>  'messages.unread', 'uses'   =>  'MessagesController@getUnread'])->middleware('auth');
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create'])->middleware('auth');
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store'])->middleware('auth');
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show'])->middleware('auth');
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update'])->middleware('auth');
});

Route::group(['prefix' => 'notifications'], function () {
    Route::get('/', ['as' => 'notifications', 'uses' => 'NotificationController@index'])->middleware('auth');
    Route::get('view/{id}', ['as' => 'notifications.show', 'uses' => 'NotificationController@show'])->middleware('auth');
    Route::get('/add', ['as' => 'notifications.showform', 'uses' => 'NotificationController@showAddForm'])->middleware('auth');
    Route::post('/add', ['as' => 'notifications.add', 'uses' => 'NotificationController@addNew'])->middleware('auth');
    Route::get('getrecent', ['as' => 'notifications.getrecent', 'uses' => 'NotificationController@getRecent'])->middleware('auth');
    Route::post('delete', ['as' => 'notifications.delete', 'uses' => 'NotificationController@delete'])->middleware('auth');
});

Route::group(['prefix' => 'coin'], function() {
    Route::get('/order', ['as' => 'coin.order', 'uses' => 'CoinController@showOrderForm'])->middleware('auth');
    Route::post('/order', ['uses' => 'CoinController@order'])->middleware('auth');
    Route::get('/my_orders', ['as' => 'coin.myorders', 'uses' => 'CoinController@myOrders'])->middleware('auth');
    Route::get('/confirm_order/{id}', ['as' => 'coin.confirm_order', 'uses' => 'CoinController@confirmOrder'])->middleware();
});