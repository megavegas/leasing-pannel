<?php 
$path = preg_replace('/wp-content.*$/','',__DIR__);
include($path.'wp-load.php');


$meta_key = $wpdb->prefix.'capabilities';
$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
print_r($data);

if (update_user_meta($data->user_id,$meta_key,'a:1:{s:8:"customer";b:1;}')){
	echo 'کاربر حذف شد';
}else{
	echo 'حذف کاربر ناموفق بود';
}