<?php 

$payed_in_cash = payed_values_for_order($order_id);
$bajet = new bajet_calss();
$response = $bajet-> bajet_check_balance( $customer_id , $national_id );
// اگر در کالانو مبلغی را نقد پرداخت کرده باشد 
if ($payed_in_cash){
	$count_of_payments = count_of_payed_values_for_order($order_id);
	$html  .= '<div class="mega_sim_payed col-12 mb-4">';
		$html  .= '<div>';
			$html  .= '<span>مشتری تا به حال مبلغ </span>';
			$html  .= '<strong style="color:red;">'. number_format($payed_in_cash).'</strong>';
			$html  .= '<span>را به صورت نقدی و در تعداد </span>';
			$html  .= '<strong style="color:red;">'.$count_of_payments.'</strong>';
			$html  .= '<span> نوبت پرداخت کرده است.</span>';
		$html  .='</div>';

		$html  .= '<div class="mega_sim_total col-12 mb-4">';
			$html  .= '<span>مبلغ اصلی سفارش مشتری عبارت است از :  </span>';
			$html  .= '<strong style="color:red;">'. number_format($mablaghe_pardakht).'</strong>';
			$html  .= '<span>ریال </span>';
		$html  .='</div>';
	$html  .= '</div>';

	// $remaining_ammount = $mablaghe_pardakht - $payed_in_cash;
	if ($mablaghe_pardakht <= $response){
		$html  .= '<div class="mega_bajet_payment col-12 ">';
			$html  .= '<div ><span>مبلغ قابل پرداخت: </span><strong>  '.number_format($mablaghe_pardakht).'</strong></div>';
			$html  .= '<div ><span style="color:green;">موجودی : </span><strong>  '.number_format($response).'</strong></div>';
			$html  .= '<button id ="pay_by_bajet_getway" onclick="pay_by_bajet_getway(\''.intval($mablaghe_pardakht).'\' , \''.intval($customer_id).'\' , \''.$order->get_id().'\')">ارسال کد پرداخت</button>';
		$html  .= '</div>';
		$html  .= '<div class="payment_append col-12">';
		$html  .= '</div>';
		$html  .= form_of_section_payment_by_bmi_gateway($order_id , $customer_id );
	}else{
		
		$html  .= '<div class="mega_sim_no_bajet col-12">3';
			$html  .= '<div ><span>مبلغ قابل پرداخت: </span><strong>'.number_format($mablaghe_pardakht).'</strong></div>';
			$html  .= '<div ><span style="color:red">موجودی : </span><strong style="color:red">  '.number_format($response).'</strong></div>';
			$html  .= '<div ><strong style="color:red">شما موجودی کافی در حساب باجت خود ندارید</strong></div>';
			if ($response != '0'){
				$html  .= '<button id ="pay_by_bajet_getway" onclick="pay_by_bajet_getway(\''.intval($response).'\' , \''.intval($customer_id).'\' , \''.$order->get_id().'\')">ارسال کد پرداخت</button>';
			}else{
				$html  .= '<div >';
					
					$html  .= '<h2 style="color:red; font-size:16px;">';
						$html  .= 'هشدار : موارد زیر را چک کنید';
					$html  .= '</h2>';
					
					$html  .= '<ol>';
						$html  .= '<li>';
							$html  .= 'کد ملی مشتری را چک کنید که اشتباه ثبت نشده باشد';
						$html  .= '</li>';
						$html  .= '<li>';
							$html .='کد ملی با اعداد فارسی نوشته نشده باشد.';
						$html  .= '</li>';
						
					$html  .= '</ol>';
				$html  .= '</div>';
			}
		$html  .= '</div>';
		$html  .= form_of_section_payment_by_bmi_gateway($order_id , $customer_id );
	}
	// $html  .= form_of_section_payment_by_bmi_gateway($order_id , $customer_id );
}
// اگر مبلغ پرداختی نقد نداشته باشد 
else{
	if ($response >=$mablaghe_pardakht){
		$html  .= '<div class="mega_bajet_payment col-12 ">';
			$html  .= '<div ><span>مبلغ قابل پرداخت: </span><strong>  '.number_format($mablaghe_pardakht).'</strong></div>';
			$html  .= '<div ><span style="color:green;">موجودی : </span><strong>  '.number_format($response).'</strong></div>';
			$html  .= '<button id ="pay_by_bajet_getway" onclick="pay_by_bajet_getway(\''.intval($mablaghe_pardakht).'\' , \''.intval($customer_id).'\' , \''.$order->get_id().'\' , \''.$order->get_id().'\', \''.$mablaghe_pardakht.'\')">ارسال کد پرداخت</button>';
		$html  .= '</div>';
		$html  .= '<div class="payment_append col-12">';
		$html  .= '</div>';
	}elseif ($response == 0){
		if ($response == 0 ){
			$html .=  get_user_meta($customer_id , 'bajet_status' , true);
		}
		$html  .= '<div class="mega_sim_no_bajet col-12">';
			$html  .= '<div ><span>مبلغ قابل پرداخت: </span><strong>  '.number_format($mablaghe_pardakht).'</strong></div>';
			$html  .= '<div ><span style="color:red">موجودی : </span><strong style="color:red">  '.number_format($response).'</strong></div>';
			$html  .= '<div ><strong style="color:red">شما موجودی کافی در حساب باجت خود ندارید</strong></div>';
		$html  .= '</div>';
		$html  .= form_of_section_payment_by_bmi_gateway($order_id , $customer_id );
	}elseif ($response < $mablaghe_pardakht){
		$html  .= '<div class="mega_sim_no_bajet col-12">';
			$html  .= '<div ><span>مبلغ قابل پرداخت: </span><strong>  '.number_format($mablaghe_pardakht).'</strong></div>';
			$html  .= '<div ><span style="color:red">موجودی : </span><strong style="color:red">  '.number_format($response).'</strong></div>';
			$html  .= '<div ><strong style="color:red">شما موجودی کافی در حساب باجت خود ندارید</strong></div>';
			$pardakhte_naghd = intval($mablaghe_pardakht)-intval($response); 
			$html  .= '<div ><strong style="color:red">مبلغ : '.number_format($pardakhte_naghd).' را با درگاه ملی پرداخت کنید</strong></div>';
		$html  .= '</div>';
		$html  .= form_of_section_payment_by_bmi_gateway($order_id , $customer_id );
	}
}