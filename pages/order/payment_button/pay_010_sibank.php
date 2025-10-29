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
// $html .='<a href="'.get_site_url().'/my-account/?test=sibank_payment&order_id='.$order->get_id().'">پرداخت '.number_format($pay_total).'</a>';
$html .='<a href="'.get_site_url().'/my-account/?test=sibank_payment&order_id='.$order->get_id().'&amount='.$mablaghe_pardakht.'&payment_link=pre" style="background: green;padding: 20px;color: #fff;border-radius: 10px;0">  پرداخت '.number_format($mablaghe_pardakht).'</a>';
$html  .= form_of_section_payment_by_bmi_gateway($order_id , $customer_id );