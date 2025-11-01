<?php 
	if (isset($_GET['customer_id'])){
		if ($_GET['customer_id'] > 0 ){
			
			$customer_id = $_GET['customer_id'] ; 
			$bajet = new bajet_calss();
			$token = '';

			$resp = $bajet -> bajet_token($customer_id);
			$balance = $bajet ->bajet_get_customer_balance ($customer_id , get_user_meta($customer_id ,'user_id_number' ,true) , $resp) ;
			print_r($balance);
		}
	}
	