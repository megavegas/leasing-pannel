<?php

function branch_external_check_balance_by_km(){
	echo '<div class="pg-bg-dark">';
		echo '<div class="container">';
			echo '<div class="col-12 p-5">';
				if (isset($_POST['km'])) {
					$km = isset($_POST['km']) ? sanitize_text_field($_POST['km']) : '';
					
					if ($km) {
						$customer_id = 1;
						$response = bajet_wallet_balance_branch( $_POST['km'] );
						$response = json_decode(json_encode($response['res']) , true);
						if ($response['status'] > 200 ){
							echo '<div class="pg-clip bg-danger text-white p-4  mb-3">';
								echo 'نتیجه : '.$response['detail'].'<br>';
								echo 'موجودی : 0 <br>';
							echo '</div>';
						}elseif($response['message'] == 'GET Request successful.'){
							echo '<div class="pg-clip bg-success text-white p-4  mb-3">';
								echo 'نتیجه : موفقیت آمیز<br>';
								echo 'موجودی : '.$response['result']['balance'].'<br>';
							echo '</div>';
						}


						
					}
				}
				$html  = '<form method="post" class="col-12 pg-clip p-5 bg-white">
						<label>کد ملی</label>
						<input type="text" name="km" placeholder="کد ملی را وارد کنید" class="form-control">
						
						<hr>
						<button type="submit" name="apply_coupon" class="btn btn-warning">بررسی</button>
					</form>';
				echo $html ;
			echo '</div>';
		echo '</div>';
	echo '</div>';
}

function bajet_wallet_token_branch(){
	$curl = curl_init();

	curl_setopt_array($curl, [
		CURLOPT_URL => "https://smq.stts.ir/token",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => http_build_query([
			'grant_type' => 'password',
			'client_id' => 'kalanoservice',
			'client_secret' => '2c6182b1-3ddd-48f5-851b-ed651c12cff9',
			'username' => 'belanton',
			'password' => 'b#l@NT@nnKal'
		]),
		CURLOPT_HTTPHEADER => [
			"Content-Type: application/x-www-form-urlencoded",
			"ReferenceNumber: d4c756ce-ba89-4e18-a618-036165cd46bd",
			"traceNumber: dsfsdff",
			"deviceId: 3453453",
			"Cookie: cookiesession1=678A8C7F97A8EF5919AF973E556D9780"
		],
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	$res_decode = json_decode($response);
	
	if ($err) {
		return "cURL Error #:" . $err;
	} else {
		$token = json_decode($response)->access_token;		
		return $token;
	}
	
}

function bajet_wallet_balance_branch( $national_id ){	
				
	$token = bajet_wallet_token_branch();
	
	$curl = curl_init();
	$url 	= "https://smq.stts.ir/facilitycustomer/api/v1/customers/".$national_id."/balance" ;
	curl_setopt_array(
		$curl, 
		[
			CURLOPT_URL => "https://smq.stts.ir/facilitycustomer/api/v1/customers/".$national_id."/balance",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => [
				"Authorization: Bearer " .$token,
			],
			
		]
	);
	$response = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	// return $response ; 
	$suc_res = json_decode($response);

	// save method
	$a_return = array();
	if($suc_res->status != 200){
		$a_return = [
			'message'=>'faild',
			'etebar'=>'0',
			'res'=>$suc_res,
			'token'=>$token
		];
		return $a_return ; 
	}
	
	if ($suc_res->result->balance >0){
		$a_return = [
			'message'=>'faild',
			'etebar'=>'0',
			'res'=>$suc_res,
			'token'=>$token
		];
		return $a_return ; 
		
	}else{
		$a_return = [
			'message'=>'faild',
			'etebar'=>'0',
			'res'=>$suc_res,
			'token'=>$token
		];
		return $a_return ;
		
	}	
	
}

branch_external_check_balance_by_km()  ;