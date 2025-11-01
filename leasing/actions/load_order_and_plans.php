<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');
global $wpdb;
if ($_POST['item_search']){
	$order_d 			= $order_results[0]->order_id;
	$sql_order_record 	= "SELECT * FROM `edu_branch_customers` WHERE `order_id` LIKE '{$_POST['item_search']}' ;";
	$sql_plan_recors 	= "SELECT ID FROM `edu_posts` WHERE `post_status` LIKE 'publish' AND `post_type` LIKE 'leasing_plans';";
	$order_results 		= $wpdb -> get_results($sql_order_record);
	$plan_results 		= $wpdb -> get_results($sql_plan_recors);

	$customer_id 		= $order_results[0]->customer_id;
	$customer_name		= get_user_meta($customer_id , 'first_name' , true );
	$customer_fami 		= get_user_meta($customer_id , 'last_name' , true );
	$customer_name 		= $customer_name . ' ' . $customer_fami;

	$branch_id 			= $order_results[0]->branch_id ; 
	$branch_name 		= get_user_meta($branch_id , 'first_name' , true );
	$branch_fami 		= get_user_meta($branch_id , 'last_name' , true );
	$branch_name 		= $branch_name . ' ' .$branch_fami;

	$leasing_id 		= get_user_meta($branch_id , 'branch_leasing_employee_id' , true ) ; 
	$leasing_name 		= get_user_meta($leasing_id , 'branch_leasing_employee_id' , true );
	$leasing_fami 		= get_user_meta($leasing_id , 'last_name' , true );
	$leasing_name 		= $leasing_id . ' ' .$leasing_fami;
	
	$h ='<div class="d-flex flex-wrap col-12 border round p-4 bg_light mb-2">';
		$h .='<div class="col-3">';
			$h .='<strong>شماره سفارش</strong>';
			$h .=$_POST['item_search'];
		$h .='</div>';
		$h .='<div class="col-3">';
			$h .='<strong>مشتری :</strong>';
			$h .=$customer_name;
		$h .='</div>';
		$h .='<div class="col-3">';
			$h .='<strong>نماینده :</strong>';
			$h .=$branch_name;
		$h .='</div>';
		$h .='<div class="col-3">';
			$h .='<strong>کارشناس :</strong>';
			$h .=$leasing_name;
		$h .='</div>';
		$h .='<div class="col-12">';
			$h .='<strong>طرح :</strong>';
			$h .=get_the_title($order_results[0]->plan_id);
		$h .='</div>';
	$h .='</div>';

	$h .='<div class="leasing_change_order_plan_box d-flex flex-wrap col-12 border round p-4 mb-2">';
		$h .='<h2 class="col-12">تغییر طرح</h2>';
		$h .='<div class="col-6">';
			$h .='<span>طرح فعلی : </span>';
			$h .='<strong>'.get_the_title($order_results[0]->plan_id).'</strong>';
		$h .='</div>';
		$h .='<div class="col-6">';
			$h .='<span>طرح جدید</span>';
			$h .='<select name="order_plan"><strong>'.get_the_title($order_results[0]->plan_id).'</strong>';
				$h .='<option value>طرح مورد نظر</option>';
				$h .='<option value="60804">همتا 36</option>';
				foreach($plan_results as $plan){
					$h .='<option value="'.$plan->ID.'">';
						$h .=get_the_title($plan->ID);
					$h .='</optiin>';
				}
			$h .='</select>';
		$h .='</div>';
		
		$h .='<div class="col-12">';
			$h .='<button onclick="leasing_change_order_plan(\''.$order_results[0]->order_id.'\')">ذخیره</button>';
		$h .='</div>';

	$h .='</div>';
	$order = wc_get_order($order_results[0]->order_id);
	$order_status = $order->get_status();

	$h .='<div class="leasing_change_order_status_box d-flex flex-wrap col-12 border round p-4">';
		$h .='<h2 class="col-12">تغییر وضعیت</h2>';
		$h .='<div class="col-6">';
			$h .='<span>وضع فعلی : </span>';
			$h .='<strong>'.$order_status.'</strong>';
		$h .='</div>';
		$h .='<div class="col-6">';
			$h .='<span>وضعیت جدید</span>';
			$h .='<select name="order_status"><strong>'.get_the_title($order_results[0]->plan_id).'</strong>';
				$h .='<option value>وضعیت مورد نظر</option>';
				$h .='<option value="cancelled">لغو شده</option>';
				$h .='<option value="pending">در انتظار پرداخت</option>';
			$h .='</select>';
		$h .='</div>';
		$h .='<div class="col-12">';
			$h .='<button onclick="leasing_change_order_status(\''.$order_results[0]->order_id.'\')">ذخیره</button>';
		$h .='</div>';

	$h .='</div>';
	echo $h ;
	// print_r($order_results);
	// echo '<hr style="width:100%;">';
	// print_r($plan_results) ; 
	
}
