<?php 
$path = preg_replace('/wp-content.*$/','',__DIR__);
include($path.'wp-load.php');
global $wpdb;

$meta_key = $wpdb->prefix.'capabilities';
$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
print_r($data);

if (update_user_meta($data->user_id,$meta_key,'a:1:{s:6:"branch";b:1;}')){
	echo 'ارتقاء با موفقیت انام شد';
}else{
	echo 'ارتقاء ناموفق';
}
// $userIDing = wp_delete_user(( $data->user_id ) ;
// print_r($userIDing);