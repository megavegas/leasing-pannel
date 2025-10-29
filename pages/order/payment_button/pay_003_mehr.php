<?php 
// echo  '<br><br><br><br><br><br><br>';
// print_r($plan_id);

// echo  '<br><br><br><br><br><br><br>';
if ($plan_id == '99101'){

	print_r('red');
	if (get_current_user_id() =="66061"){
		$pre_pay_amount 	= 0;
		$pay_amount 		= $mablaghe_pardakht - $pre_pay_amount;
	}else{
		$pre_pay_amount 	= (($mablaghe_pardakht * 25)/100);
		$pay_amount 		= $mablaghe_pardakht - (($mablaghe_pardakht * 25)/100);
	}
	
	
}else{
	$pay_amount 		= $mablaghe_pardakht ;
	$pre_pay_amount 	= 0;
}


$html .= '<div class="mega_sim_payed col-12 mb-4">';

	$html .= '<div>';
		$html .= '<span>مشتری تا به حال مبلغ </span>';
		$html .= '<strong style="color:red;">'. number_format($payed_in_cash).'</strong>';
		$html .= '<span>را به صورت نقدی و در تعداد </span>';
		$html .= '<strong style="color:red;">'.$count_of_payments.'</strong>';
		$html .= '<span> نوبت پرداخت کرده است.</span>';
	$html .='</div>';

	$html .= '<div class="mega_sim_total col-12 mb-4">';
		$html .= '<span>مبلغ اصلی سفارش مشتری عبارت است از :  </span>';
		$html .= '<strong style="color:red;">'. number_format($mablaghe_pardakht).'</strong>';
		$html .= '<span>ریال </span>';
	$html .='</div>';
$html .= '</div>';
$html .='<a href="'.get_site_url().'/my-account/?test=mehr_payment&order_id='.$order->get_id().'&amount='.$pay_amount.'">پرداخت '.number_format($pay_amount).'</a>';

if ($pre_pay_amount){
	$html  .= form_of_section_payment_by_bmi_gateway($order_id , $customer_id , $pre_pay_amount );
}else{
	$html  .= form_of_section_payment_by_bmi_gateway($order_id , $customer_id , $pre_pay_amount );
}
