<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');
global $wpdb;
// print_r($_POST);

// print_r($_POST['oid']);

if (isset($_POST['oid'])){
	if (isset($_POST['plan'])){
		$table = $wpdb -> prefix . 'branch_customers';
		$where =array(
			'order_id' => $_POST['oid'],
		);
		$data = array(
			'plan_id'=> $_POST['plan'],
		);

		$value = $wpdb ->update($table , $data , $where);
		echo $value;
	}else{
		echo '02' ; 
	}
}else{
	echo '01' ; 
}