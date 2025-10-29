<?php 
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
	if ($mablaghe_pardakht > 2000000000 & $mablaghe_pardakht < 3000000000){
		$t1  	= 1000000000 ;  
		$t2 	= 1000000000 ; 
		$t3 	= $mablaghe_pardakht - 2000000000 ;
		$i = 3 ; 

		$html .= '<button name="'.$btn_name.'" onclick="'.$pay_function.'(\''.$order->get_id().'\' , \''.$t1.'\' , \''.$user_id.'\' , \''.$branch_id.'\')" >';
			$html .= '3-1' .'پرداخت '.number_format($t1);
		$html .= '</button>';

		$html .= '<button name="'.$btn_name.'" onclick="'.$pay_function.'(\''.$order->get_id().'\' , \''.$t2.'\' , \''.$user_id.'\' , \''.$branch_id.'\')" >';
			$html .= '3-2' .'پرداخت '.number_format($t2) ; 
		$html .= '</button>';

		$html .= '<button name="'.$btn_name.'" onclick="'.$pay_function.'(\''.$order->get_id().'\' , \''.$t3.'\' , \''.$user_id.'\' , \''.$branch_id.'\')" >';
			$html .= '3-3' .'پرداخت '.number_format($t3);
		$html .= '</button>';

	}elseif ($mablaghe_pardakht < 2000000000 & $mablaghe_pardakht > 1000000000){

		$t1 = 1000000000 ; 
		$t2 = $mablaghe_pardakht - 1000000000 ;
		$i = 2 ; 
		$html .= '<button name="'.$btn_name.'" onclick="'.$pay_function.'(\''.$order->get_id().'\' , \''.$t1.'\' , \''.$user_id.'\' , \''.$branch_id.'\')" >';
			$html .= '1-2' . 'پرداخت '.number_format($t1);
		$html .= '</button>';

		$html .= '<button name="'.$btn_name.'" onclick="'.$pay_function.'(\''.$order->get_id().'\' , \''.$t2.'\' , \''.$user_id.'\' , \''.$branch_id.'\')" >';
			$html .= '2-2'  . 'پرداخت '.number_format($t2);
		$html .= '</button>';
	}else{
		$t1 = $mablaghe_pardakht ; 
		$i = 2 ; 
		$html .= '<button name="'.$btn_name.'" onclick="'.$pay_function.'(\''.$order->get_id().'\' , \''.$t1.'\' , \''.$user_id.'\' , \''.$branch_id.'\')" >';
			$html .= '1   ' . 'پرداخت '.number_format($t1);
		$html .= '</button>';
	}


	update_post_meta($order->get_id() , '_pay_able_part' , $pay_total);
	$html  .= form_of_section_payment_by_bmi_gateway($order_id , $customer_id );