<?php
	global $woocommerce ; 
	$order = wc_get_order($_GET['order_id']);

	$plan_id = get_post_meta($order->get_id() , 'order_plan_id' , true);

	if ($plan_id == '' || $plan_id == false || $plan_id = null){
		// echo 'ding';
		$order_details = get_plan_id_from_order($_GET['order_id']);
		$plan_id = $order_details[0]->plan_id;
	}

	$iq 		= get_post_meta($plan_id , 'installments_quantiy' , true);// iq = installments_quantiy
	$ir 		= get_post_meta($plan_id , 'Interest_rate' , true);// Interest_rate
	
	$discount 	= get_field('discount_of_payment' , $plan_id);

	// get user data from user 
	if (isset($_GET['user_id'])){
		$user_id = $_GET['user_id'] ; 
		$customer = get_user_by('ID' , $user_id);
	}