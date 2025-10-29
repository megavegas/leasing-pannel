<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');
global $wpdb ;

$customer_id 	= intval($_POST['order_items']['customer']);
$branch_id 		= intval($_POST['order_items']['branch']);
$plan_id 		= intval($_POST['order_items']['plan']);
$product_list 	= $_POST['order_items']['products'];



if ($product_list){

	$order = wc_create_order();

	foreach($product_list as $item){
		$order->add_product(
			wc_get_product($item['pro']),
			$item['qty']
		);
	}

	foreach ( $order->get_items() as $item_id => $item ) {
		foreach($product_list as $product){
			if ( $item->get_product_id() == $product['pro'] ) {
				$item->set_subtotal($product['price']*$item['qty']);
				$item->set_total($product['price']*$item['qty']);				
				$item->save();
			}
		}
	}

	$km = get_user_meta($customer_id ,'user_id_number' , true ) ; 
	$order->update_meta_data('user_id_number', $km);

	$order->set_address( array(
		'first_name' => get_user_meta($customer_id , 'first_name' , true),
		'last_name'  => get_user_meta($customer_id , 'last_name' , true),
		'phone'      => get_user_meta($customer_id , 'user_mobile' , true),
		'address_1'  => get_user_meta($customer_id , 'user_address' , true),
		'postcode'   => get_user_meta($customer_id , 'zip_postal_code' , true),
	), 'billing' );

	$order->set_address( array(
		'first_name' => get_user_meta($customer_id , 'first_name' , true),
		'last_name'  => get_user_meta($customer_id , 'last_name' , true),
		'phone'      => get_user_meta($customer_id , 'user_mobile' , true),
		'address_1'  => get_user_meta($customer_id , 'user_address' , true),
		'postcode'   => get_user_meta($customer_id , 'zip_postal_code' , true),
	), 'shipping' );

	$order->update_meta_data('year_order', get_option('this_year'));
	$order->update_meta_data('month_order', get_option('this_month'));
	$order->update_meta_data('day_order', get_option('this_day'));
	$order->set_created_via( 'branch' ); // تنظیم اینکه سفارش از طریق کد ایجاد شده
	$order->set_customer_id( apply_filters( 'woocommerce_checkout_customer_id', $customer_id ));
	$order->set_currency( get_woocommerce_currency() );
	$order->calculate_totals(); // محاسبه جمع کل سفارش
	$order->set_status('proforma-invoice', 'سفارش پرداخت نشده است و بوسیله نمایندگی ساخته شده است ');
	$branch_user 	= get_user_by('ID' , $branch_id);
	$customer 		= get_user_by('ID' , $customer_id);
	$order->add_order_note('سفارش توسط نمایندگی : '.$branch_user->display_name.' برای مشتری ایشان به نام : ' .$customer->display_name.' تهیه شده است');
	$order->add_order_note('سازنده سفارش : ' . get_current_user_id() . ' ' .get_user_meta(get_current_user_id() , 'first_name' , true) . ' ' .get_user_meta(get_current_user_id() , 'last_name' , true) );	
	$order->set_billing_first_name(get_user_meta($customer_id , 'first_name' , true));
	$order->set_billing_last_name(get_user_meta($customer_id , 'last_name' , true));
	$order->set_billing_address_1(get_user_meta($customer_id , 'user_address' , true));
	$order->set_billing_postcode(get_user_meta($customer_id , 'zip_postal_code' , true));
	$order->set_billing_phone(get_user_meta($customer_id , 'user_mobile' , true));
	$order->set_shipping_first_name(get_user_meta($customer_id , 'first_name' , true));
	$order->set_shipping_last_name(get_user_meta($customer_id , 'last_name' , true));
	$order->set_shipping_address_1(get_user_meta($customer_id , 'user_address' , true));
	$order->set_shipping_postcode(get_user_meta($customer_id , 'zip_postal_code' , true));
	$order->set_shipping_phone(get_user_meta($customer_id , 'user_mobile' , true));

	$order_id = $order->save();

	$order->add_order_note('طرح سفارش  : '.$plan_id . '| '. get_the_title($plan_id) .' |');

	$user_id = get_current_user_id();  // شناسه کاربر فعال
	$current_time = current_time('mysql');  // زمان جاری

	$decrase_cond = get_post_meta($plan_id, 'reduce_quantity' , true);

	if ( $decrase_cond == "2" ){
		wc_reduce_stock_levels($order_id);
	}
	 
	if (isset($product_list)){
		$data = [
			'branch_id'			=> $branch_id , 
			'customer_id'		=> $customer_id,
			'plan_id'			=> $plan_id , 
			'order_id' 			=> $order_id ,
			'date'				=> date('Y-m-d'),
			'order_status'		=> 'pending',
			'km'				=> $km ,
			'organization'		=> 0,
			'org_credit'		=> 0
		];
		$where = [ 'id' => $items['bc_products'] ]; // NULL value in WHERE clause.
		$test = $wpdb->insert( $wpdb->prefix . 'branch_customers', $data);
	}
	if ($test){
		if ($order_id){
			echo 'yes_'.$order_id;
		}
	}

	// echo $order_id;
}else{
	if (empty($product_list)){
		echo 'هیچ محصولی انتخاب نشده است';
	}elseif(!$customer_id){
		echo "مشتری برای سفارش انتخاب نشده است ";
	}elseif(!$plan_id){
		echo "هیچ طرحی برای سفارش انتخاب نشده است";
	}elseif(!$branch_id){
		echo 'نمایندگی صادر کننده سفارش را انختخاب کنید';
	}else{
		echo 'error happend'."\n";
	}
}

