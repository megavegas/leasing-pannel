<?php 
$path = preg_replace('/wp-content.*$/','',__DIR__);
include($path.'wp-load.php');

print_r($_POST);
$request_body = file_get_contents('php://input');
$data = json_decode($request_body);

// print_r($data);

$user_data = array(
	'ID'			=>$data->user_id,
	"user_login" 	=>$data->user_login,
);
$userIDing = wp_update_user( $user_data ) ;

if( !is_wp_error( $userIDing )){
	echo 'بروز رسانی با موفقیت انجام شد';
}else{
	print_r($user_data);
}

$update_data = array(
	"branch_serial" =>$data->branch_serial,
	"billing_phone" =>$data->billing_phone,
	"first_name" 	=>$data->first_name,
	"last_name" 	=>$data->last_name,
);
foreach($update_data as $key => $value){
	if(update_user_meta($data->user_id , $key , $value)){
		echo $value." : updated:\n";
	};
}
