<?php 
	global $wpdb;
	global $mega_admin;
	global $woocommerce;
	
	require_once('order/001_date.php');
	require_once('order/002_promotion_header.php');

	require_once('order/003_plan_consts.php');
	
	
	
	

	if ($order){
		$html ='';
		$html .= '<div class="col-12">';
			$html .= '<div class="page_title_account"><div class="d-flex "><h3>پیش فاکتور مشتری</h3><h2>'.$customer->data->display_name.'</h2></div></div>';
		$html .= '</div>';
		
		$html .= '<div id="printarea" style="display: block !important;width: 100% !important; font-size:12px;" >';
			require_once('order/004_table_header.php');
			require_once('order/005_table_sheet.php');	
			require_once('order/006_table_footer.php');
		$html .='</div>';


		

		
	}

	echo $html;


echo '<div class="buttom_of_branch_order d-flex flex-wrap">';
	echo '<div class="mega_print_invoice">';
		echo '<button onclick="print_area_of(\'printarea\')">چاپ فاکتور</a>';
	echo '</div>';

	$payment_method = get_field('payment_methooood' , $plan_id);
	$ostatus= $order->get_status();
	if (isset($_GET['user_id'])){
		$national_id = get_user_meta($_GET['user_id'] , 'user_id_number' , true) ;
	}else {
		$national_id = '0000000000';
	}
	
	if (!empty($payment_method) & $ostatus != 'processing' ){
		require_once('order/payement_button.php');
	}
echo '</div>';