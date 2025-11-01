<?php 
	$path = preg_replace('/wp-content.*$/','',__DIR__);
	include($path.'wp-load.php');

	global $wpdb ; 

	$request_body = file_get_contents('php://input');
	$data = json_decode($request_body);


	$args_update = [
		"cusomer_id" 			=> $data -> customer_id ,
		"first_name" 			=> $data -> firstName ,
		"last_name" 			=> $data -> lastName ,
		"father_name" 			=> $data -> fatherName ,
		"user_id_number" 		=> $data -> nationalCode ,
		"identity_number" 		=> $data -> identityNumber ,
		"issue_place" 			=> $data -> issuePlace ,
		"mobile" 				=> $data -> mobile ,
		"birth_date" 			=> $data -> birthDate,
		"address" 				=> $data -> address ,
		"zip_postal_code" 		=> $data -> postalCode ,
		"email" 				=> $data -> email ,
		"sex" 					=> $data -> sex ,
		"birth_place" 			=> $data -> birthPlace 
	];
	// update user basic data
	foreach($args_update as $key => $value){
		if ($key != 'customer_id'){
			update_user_meta ($data -> customer_id , $key  , $value);
		}
	}

	$body = '
		{
			"firstName"						: "'.$data -> firstName .'",
			"lastName"						: "'.$data -> lastName.'",
			"fatherName"					: "'.$data -> fatherName.'",
			"nationalCode"					: "'.$data -> nationalCode.'",
			"identityNumber"				: "'.$data -> identityNumber.'",
			"issuePlace"					: "'.$data -> issuePlace.'",
			"mobile"						: "'.$data -> mobile.'",
			"birthDate"						: "'.$data -> birthDate.'",
			"address"						: "'.$data -> address.'",
			"postalCode"					: "'.$data -> postalCode.'",
			"email"							: "'.$data -> email.'",
			"sex"							: "'.$data -> sex.'",
			"birthPlace"					: "'.$data -> birthPlace.'",
			"contractNumber"				: "'.$data -> contractNumber.'",
			"loanAmount"					: "'.$data -> loanAmount.'",
			"installmentsCount"				: "'.$data -> installmentsCount.'"
		}
	';

	$url = 'https://fct-api.stts.ir/api/v1/facilities/requests';
	$ch = curl_init($url); 
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type' => 'application/json-patch+json',]);
	$result = curl_exec($ch);
	curl_close($ch);
	print_r ($result);

	// $jj = json_decode($output);
	
	// if ($jj->isError == 1){
	// 	if ($jj->status == 401 || $jj->status == 403 || $jj->status == 422){
	// 		echo  $jj->status;
	// 	}
	// }else{
	// 	if ($jj -> message = 'Successful'){
	// 		echo  $jj -> result->balance;
	// 	} 
	// }
	// print_r(json_decode($response));