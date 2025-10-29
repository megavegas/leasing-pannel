<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');
global $wpdb;

if (isset($_POST['oid'])){
	if (isset($_POST['status'])){
		$order = wc_get_order($_POST['oid']);
		if ($order){
			$order->update_status($_POST['status']);
			echo $order->get_status();
			$order->save(); 
		}
	}else{
		echo '02' ; 
	}
}else{
	echo '01' ; 
}