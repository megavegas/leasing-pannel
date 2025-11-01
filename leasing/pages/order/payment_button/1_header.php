<?php 

	$order_status = $order->get_status();
	$html = '' ;

	if (isset($payment_method['value'])){ 
		
		// if payment is sadad and bmi
		if ($payment_method['value'] == 1){
			$pay_function = 'pay_order_bmi';
			$payment_name = 'پرداخت با درگاه بانک ملی';
			add_action( 'wp_enqueue_scripts', 'mega_bmi_payment_scripts' );
			$btn_name = 'bmi_paymet_button';
		}
		elseif($payment_method['value'] == 2){
			$pay_function = 'pay_order_saderat';
			$payment_name = 'پرداخت با درگاه بانک صادرات';
		}
		elseif($payment_method['value'] == 3){
			$pay_function = 'pay_order_mehr';
			$payment_name = 'پرداخت با درگاه بانک مهر';	
			add_action( 'wp_enqueue_scripts', 'mega_bmi_payment_scripts' );
		}
		elseif($payment_method['value'] == 4){
			$pay_function = 'pay_order_tejarat';
			$payment_name = 'پرداخت با درگاه بانک تجارت';
		}
		elseif($payment_method['value'] == 5){
			$pay_function = 'pay_order_maskan';
			$payment_name = 'پرداخت با درگاه بانک مسکن';
		}
		elseif($payment_method['value'] == 6){
			$pay_function = 'pay_order_eghtesad_novin';
			$payment_name = 'پرداخت با درگاه بانک اقتصاد نوین';
		}
		elseif($payment_method['value'] == 7){
			$pay_function = 'pay_order_pasargad';
			$payment_name = 'پرداخت با درگاه بانک پاسارگاد';
		}
		elseif($payment_method['value'] == 8){
			$pay_function = 'pay_order_refah';
			$payment_name = 'پرداخت با درگاه بانک رفاه';
		}
		elseif($payment_method['value'] == 9){
			$pay_function = 'pay_order_ayande';
			$payment_name = 'پرداخت با درگاه بانک آینده';
		}
		elseif($payment_method['value'] == 10){
			$payment_name = 'پرداخت با درگاه بانک سینا';
			$pay_function = 'sina_pay_order';
		}
		elseif($payment_method['value'] == 12){
			$payment_name = 'باجت ( وام کالانو بانک تجارت )';
			$pay_function = 'bajet_tejarat_payment';
		}
		elseif($payment_method['value'] == 17){
			$payment_name = 'جت وام';
			$pay_function = 'bjetvam_payment';
		}
		elseif($payment_method['value'] == 18){
			$payment_name = 'از کی وام';
			$pay_function = 'azki_payment';
		}
		elseif($payment_method['value'] == 19){
			$payment_name = 'پرداخت تارا';
			$pay_function = 'tara_payment';
		}
        elseif($payment_method['value'] == 20){
            $payment_name = 'پرداخت تاپ';
            $pay_function = 'top_payment';
        }
		else{
			
		}
	}

	if ($pey_ == $ftotal){
		$pay_total =  $ftotal ;
	}elseif($ftotal > $pey_){
		$pay_total =  $pey_ ;
	}else{
		$pay_total =  $pey_ ;
	}


	$payed_part = get_post_meta($order->get_id() , 'payed_part' , true );

	if ($payed_part > 0){
		$pay_total = $pay_total - $payed_part ; 
	}

	$left_pay =  0 ;

	$payed_in_cash = payed_values_for_order($order_id);
	$mablaghe_pardakht = $mablaghe_pardakht - $payed_in_cash;
	$count_of_payments = count_of_payed_values_for_order($order_id);