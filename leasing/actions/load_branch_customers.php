<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');

global $wpdb ; 


$branch_id = $_POST['branch_id'];

$sql = "SELECT user_id  FROM `edu_usermeta` WHERE `meta_key`= 'maker_branch_id' AND `meta_value` = '{$branch_id}'";
$customers = $wpdb->get_results($sql);

$h = '';
foreach($customers as $cus){
	$user_name = get_user_meta($cus->user_id , 'first_name' , true). ' ' .get_user_meta($cus->user_id , 'last_name' , true); 
	$h .= '<option value="'.$cus->user_id.'">'.$user_name.'</option>';
}
echo $h ; 