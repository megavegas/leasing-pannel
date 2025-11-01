<?php 
	
	require_once('payment_button/1_header.php');

$payment_condition = true;
$out_of_stock = array();
foreach ( $order->get_items() as $item_id => $item ) {
	$product_id = $item->get_product_id();

	$product = $item->get_product(); // see link above to get $product info

	$quantity = $product->get_stock_quantity();
	if ($quantity<=0){
		$payment_condition = false;
		$out_of_stock[]=$product_id;
	}
}

if ( in_array(get_current_user_id(),array('22037','24667','15996' ,'743' ,'14773' , '17190'))){
	$branch_type = 'master';
	$payment_condition = true;
}


if (($order_status == 'pending' || $order_status == 'half_payed_bmi' ) & $payment_condition ){
	$html .= '<div class="col-12 d-flex flex-wrap">';

		// درگاه ملی
		if ($payment_method['value'] == 1){
			require_once('payment_button/pay_001_bmi.php');
		}
		
		// درگاه مهر
		elseif($payment_method['value'] == 3){
			require_once('payment_button/pay_003_mehr.php');
		}
		
		// درگاه سیبانک
		elseif ($payment_method['value'] == 10){
			require_once('payment_button/pay_010_sibank.php');
		}

		// درگاه باجت
		elseif ($payment_method['value'] == 12){
			require_once('payment_button/pay_012_bajet.php');
		}
		
		// درگاه جت وام
		elseif ($payment_method['value'] == 17){
			require_once('payment_button/pay_017_jetvam.php');
		}

		// درگاه ازکی وام
		elseif ($payment_method['value'] == 18){
			require_once('payment_button/pay_018_azkivam.php');
		}

		// درگاه تارا
		elseif ($payment_method['value'] == 19){
			require_once('payment_button/pay_019_tara.php');
		}
        // درگاه تاپ
        elseif ($payment_method['value'] == 20){
            require_once('payment_button/pay_020_top.php');
        }
        // درگاه داریک
        elseif ($payment_method['value'] == 21){
            require_once('payment_button/pay_021_darik.php');
        }
		// پرداخت نقدی برای رفاه کالا
		elseif ($payment_method['value'] == 8){
			$html  .= form_of_section_payment_by_bmi_gateway($order_id , $customer_id );
		}

		// نمایش نوشته های پایین پیش فاکتور
		require_once('payment_button/2_end.php');



	$html .= '</div>';
}else{
	if ($payment_condition == false){
		if ($out_of_stock){
			foreach($out_of_stock as $pitem){
				$html .='<div class="mb-2 mt-3">محصول '.get_the_title($pitem).' ناموجود است و امکان پرداخت سفارش وجود ندارد .</div>';
			}
		}
	}else{
		if ($branch_type="master"){
			if ($out_of_stock){
				foreach($out_of_stock as $pitem){
					$html .='<div class="mb-2 mt-3">محصول '.get_the_title($pitem).' ناموجود است و امکان پرداخت سفارش وجود ندارد .</div>';
				}
			}
		}
	}
	// نمایش نوشته های پایین فاکتور 
	require_once('payment_button/3_footer.php');
}
		
echo $html ;