<?php
	include "AuthController.php";
	header("Content-Type: application/json");
	if(isset($_POST['api_code'])){
		$SENDED = "DONE";
		echo json_encode(['status'=>true, 'data'=>'Balance is not Update', 'result'=>'created', 'error_code'=>'1007']);
	}
?>