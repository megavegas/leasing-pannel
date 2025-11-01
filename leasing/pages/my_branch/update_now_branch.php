<?php 

global $wpdb ; 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');

$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
$table = $wpdb -> prefix .'users' ; 

$user_meta = array(
	'user_id_number'						=> $data->user_id_number,
	'user_state'							=> $data->user_state,
	'user_city'								=> $data->user_city,
	'user_address'							=> $data->user_address,
	'user_mobile'							=> $data -> user_mobile ,
	'first_name'							=> $data -> first_name ,
	'last_name'								=> $data -> last_name , 
	'zip_postal_code'						=> $data -> zip_postal_code ,
	'branch_serial_number'					=> $data -> branch_serial_number , 
	'branch_contract_serial'				=> $data -> branch_contract_serial , 
	'show_admin_bar_front'					=> $data -> show_admin_bar_front , 
	'branch_edited_by' 						=> get_current_user_id()
);

$user_data= array(
	'user_login' => $data -> user_mobile,
	'display_name' => $data -> first_name .' '.$data -> last_name
);

$where = ['ID' => $data->branch_id];

$user_id = $wpdb->update( $wpdb->prefix . 'users', $user_data, $where );

if ($user_id){
	echo 'yes';
	foreach($user_meta as $key => $value){
		update_user_meta($data->branch_id , $key , $value);
	}
}else{
	echo 'no';
}



