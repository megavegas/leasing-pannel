<?php 
	if (isset($_GET['order_id'])){
		$order = wc_get_order($_GET['order_id']);
		$order_id = $_GET['order_id'] ; 

		$order_meta = get_post_meta($order_id);

		$sql_bc_order = "SELECT DISTINCT * FROM `edu_branch_customers` WHERE `order_id` = '{$_GET['order_id']}'";
		$bc_order = $wpdb ->get_results($sql_bc_order)[0];
		
		if (!empty($bc_order)){
			$order_id	 	= $bc_order ->order_id ;
			$plan_id 		= $bc_order -> plan_id ; 
			$customer_id 	= $bc_order -> customer_id ; 
			$branch_id 		= $bc_order -> branch_id ; 
		}

		// get order stuffs
		$order = wc_get_order($order_id);
		
		$order_date = $order->get_date_created();
		$now = new DateTime($order->get_date_created());
		$formatter = new IntlDateFormatter(
					"fa_IR@calendar=persian", 
					IntlDateFormatter::FULL, 
						IntlDateFormatter::FULL, 
					'Asia/Tehran', 
					IntlDateFormatter::TRADITIONAL, 
					"yyyy/MM/dd");
	}else{
		die('شماره سفارش ست نشده است ');
	}
