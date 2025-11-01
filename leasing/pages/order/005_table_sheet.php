<?php 

$promotion = 0 ; 
$promotion = get_post_meta($order->get_id() , '_order_promotion' , true);
$pro_perc = 0 ;
$pro_perc = get_post_meta($order->get_id() , 'discount_percentage' , true);

if ($pro_perc >0  & $promotion == 0){
	$promotion = $order->get_total() * $pro_perc /100; 
	update_post_meta($order->get_id(), '_order_promotion' , $promotion);
}

$status = $order->get_status();

if ($status == 'never_ever'){
	$price_situation = 'live';
}else{
	$price_situation = 'fixed';
}
echo $plan_id;
$html .='<table class="mega_invoice_table">';
	$html .='<thead class="mega_invoice_thead">';
		$html .='<tr class="mega_invoice_th_tr">';
			$html .='<th class="mega_invoice_th_tr_td"  style="padding: 5px;font-size: 13px;">ردیف</th>';
			$html .='<th class="mega_invoice_th_tr_td" style="padding: 5px;font-size: 13px;">عنوان</th>';
			$html .='<th class="mega_invoice_th_tr_td" style="padding: 5px;font-size: 13px;">تعداد</th>';
			$html .='<th class="mega_invoice_th_tr_td" style="padding: 5px;font-size: 13px;">مبلغ تک</th>';
			$html .='<th class="mega_invoice_th_tr_td" style="padding: 5px;font-size: 13px;">جمع</th>';
		$html .='</tr>';
	$html .='</thead>';
	$html .='<tbody class="mega_invoice_tbody">';
	$i = 1;

	$mboty = 0 ;

	if ($price_situation == 'fixed'){
		foreach ( $order->get_items() as $item_id => $item  ) {
			$bm = json_decode($item);
			$product_id = $bm->product_id;

			$product = wc_get_product($bm->product_id);
			// print_r($product);
			
			$html .='<tr class="mega_invoice_tb_tr">';
				$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;">'.$i.'</td>';


				// $product_sub_price = item_price_sub_totla($ir , $product_id , $order_id);
				$product_sub_price = $item->get_subtotal()/$item->get_quantity();
				// $product_price = item_price_totla($ir , $product_id , $order_id);
				$product_price = $item->get_total()  ;
				$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;">'.get_the_title($bm->product_id).'</td>';
				$html .='<td class="mega_invoice_tb_tr_td mtn_quantity" style="font-size: 13px;padding: 2px;"><div><input type="number" name="mtn_qty" min="1" max="5" value="'.$item->get_quantity().'" style="border:none;margin:none"></div></td>';

				
				// $product_price = gpop( $plan_id, $bm->product_id);
				// $product_price = irprice($ir ,  $product_id) * $bm->quantity;
				
				$html .='<td class="mega_invoice_tb_tr_td mtn_price" style="font-size: 13px;padding: 2px;">'.number_format($product_sub_price).'</td>';
				$mboty = $mboty + $product_price ;
				$html .='<td class="mega_invoice_tb_tr_td mtn_total" style="font-size: 13px;padding: 2px;">'.number_format($product_price).'</td>';
			$html .='</tr>';
			$i++;
		}
		$k = 0;
	}else{
		foreach ( $order->get_items() as $item_id => $item  ) {
			$bm = json_decode($item);
			$product_id = $bm->product_id;

			$product = wc_get_product($bm->product_id);
			// print_r($product);
			
			$html .='<tr class="mega_invoice_tb_tr">';
				$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;">'.$i.'</td>';


				// $product_sub_price = item_price_sub_totla($ir , $product_id , $order_id);
				$product_sub_price = $product->get_price();
				// $product_price = item_price_totla($ir , $product_id , $order_id);
				$product_price = $product_sub_price ;
				$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;">'.get_the_title($bm->product_id).'</td>';
				$html .='<td class="mega_invoice_tb_tr_td mtn_quantity" style="font-size: 13px;padding: 2px;"><div><input type="number" name="mtn_qty" min="1" max="5" value="'.$item->get_quantity().'" style="border:none;margin:none"></div></td>';

				
				// $product_price = gpop( $plan_id, $bm->product_id);
				// $product_price = irprice($ir ,  $product_id) * $bm->quantity;
				
				$html .='<td class="mega_invoice_tb_tr_td mtn_price" style="font-size: 13px;padding: 2px;">'.number_format($product_sub_price).'</td>';
				$mboty = $mboty + $product_price ;
				$html .='<td class="mega_invoice_tb_tr_td mtn_total" style="font-size: 13px;padding: 2px;">'.number_format($product_price).'</td>';
			$html .='</tr>';
			$i++;
		}
		$k = 0;
	}
	
	

	
	$ft =0;
	foreach ( $order->get_fees() as $fee_id => $fee ) {
		$mboty = $mboty + $fee->get_total();
		
		$ft =  $ft +$fee->get_total();
		$html .='<tr class="mega_invoice_tb_tr">';
			$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;">'.$i.'</td>';
			$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;">'.$fee->get_name().'</td>';
			$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;"></td>';
			$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;"></td>';
			$html .='<td class="mega_invoice_tb_tr_td mtn_total" style="font-size: 13px;padding: 2px;">'.number_format($fee->get_total()).'</td>';
		$html .='</tr>';
		
		$i++;
    }

	
	global $woocommerce ; 
	global $wpdb ; 
	$order->set_total($mboty);
	$order->save();
	$pay_in_cash = payed_values_for_order($order_id);
	$order = wc_get_order($order_id);
	$coup_val = 0 ;
	$coupons = $order->get_coupon_codes();
	if (!empty($coupons)) {
        foreach ($coupons as $coupon_code) {
			
			$sql = "SELECT * FROM `edu_posts` WHERE `post_title` LIKE '{$coupon_code}';";
			$coup = $wpdb->get_results($sql); 
			$coup_id = $coup[0]->ID;
			$sql = "SELECT * FROM `edu_wc_order_coupon_lookup` WHERE `coupon_id` = '{$coup_id}'";
			$coup_val0 = $wpdb->get_results($sql); 
			$coup_val = $coup_val + (-$coup_val0[0]->discount_amount);
			$coup_name = 'تخفیف';

			// $discount_amount = $order->get_coupon_discount_amount($coupon_code, $order->get_prices_include_tax());
    		// $coupon = new WC_Coupon($coupon_code);
    		// $discount_amount = $order->get_coupon_discount_amount($coupon_code, $order->get_prices_include_tax());

            $html .='<tr class="mega_invoice_tb_tr">';
				$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;">'.$i.'</td>';
				$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;">'.$coup_name.'</td>';
				$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;"></td>';
				$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;direction:ltr;">'.number_format($coup_val).'</td>';
				$html .='<td class="mega_invoice_tb_tr_td mtn_total" style="font-size: 13px;padding: 2px;"></td>';
			$html .='</tr>';
			$i++;
        }
        
    }

	$html .='</tbody>';
	
	// echo '<script>alert(" مبلغ کل  :'.number_format($mboty).' \n مبالغ : '.number_format($ft ).' \n کوپن ها : '.number_format($coup_val).'")</script>';


	if ($discount > 0){
		$discount_of_order = (($mboty)*($discount/100)) ;
		$ftotal = $mboty - $discount_of_order ; 

		$html .='<table class="mega_invoice_tfooter">';
			$html .='<tbody>';
				// $html .='<tr class="mega_invoice_tf_tr">';
				// 	$html .='<th class="mega_invoice_tf_tr_td"><span>تخفیف '.get_the_title($plan_id).' </span></th>';
				// 	$html .='<td class="mega_invoice_tf_tr_td all_total_price" disord="'.$discount_of_order.'"><strong>'.number_format($discount_of_order).'<strong></td>';
				// $html .='</tr>';

				$html .='<tr class="mega_invoice_tf_tr">';
					$html .='<th class="mega_invoice_tf_tr_td"><span>مبلغ بدون احتساب تخفیف</span></th>';
					
					$html .='<td class="mega_invoice_tf_tr_td all_total_price" all_total_price="'.$mboty.'"><strong>'.number_format($mboty).'<strong></td>';
				$html .='</tr>';
				
				$html .='<tr class="mega_invoice_tf_tr">';
					$html .='<th class="mega_invoice_tf_tr_td"><span>مبلغ قابل پرداخت</span></th>';
					$pay_able = $mboty - $promotion ; 

					update_post_meta($order->get_id() , '_pay_able_part' , $ftotal);
					// update_post_meta($order->get_id() , '_order_total' , $ftotal);

					update_post_meta($order->get_id() , '_order_total' , $mboty);
					update_post_meta($order->get_id() , '_customer_user' , $cuid);
					
					$html .='<td class="mega_invoice_tf_tr_td all_total_price" all_total_price="'.$mboty.'"><strong>'.number_format($ftotal).'<strong></td>';
				$html .='</tr>';
			$html .='</tbody>';
		$html .='</table>';
		$mablaghe_pardakht = $ftotal + $coup_val ;
	}else{


		$ftotal = $mboty ; 
		$html .='<table class="mega_invoice_tfooter">';
			$html .='<tbody>';
				if ($plan_id != '54679' ){
					if (intval($promotion)>0){
						$html .='<tr class="mega_invoice_tf_tr">';
							$html .='<th class="mega_invoice_tf_tr_td"><span>پروموشن فروش</span></th>';
							
							$html .='<td class="mega_invoice_tf_tr_td all_total_price" all_total_price="'.$mboty.'"><strong>'.number_format($promotion).'<strong></td>';
						$html .='</tr>';
						$html .='<tr class="mega_invoice_tf_tr">';
							$html .='<th class="mega_invoice_tf_tr_td"><span>مبلغ قابل پرداخت</span></th>';
							$pay_able = 0 ; 
							$pay_able = $mboty - $promotion ; 
							
							update_post_meta($order->get_id() , '_order_total' , $pay_able);
							update_post_meta($order->get_id() , '_customer_user' , $cuid);
							
							$html .='<td class="mega_invoice_tf_tr_td all_total_price" all_total_price="'.$mboty.'"><strong>'.number_format($pay_able).'<strong></td>';
						$html .='</tr>';
						$mablaghe_pardakht = $pay_able ;
					}else{
						$order_row = get_branch_customer_order_row($order_id);
						// print_r($order_row[0]->organization);
						if (intval($order_row[0]->organization)>0){
							$org_discount = intval(get_post_meta($order_row[0]->organization , 'hamtaloans_org_discount' , true)); 
						}else{
							$org_discount = 0 ;
						}

						// echo '<script>alert("تخفیف سازمانی  : '.$org_discount.'")</script>';

						if ($org_discount){
							$html .='<tr class="mega_invoice_tf_tr">';
								$html .='<th class="mega_invoice_tf_tr_td"><span>مبلغ کل فاکتور</span></th>';
								$html .='<td class="mega_invoice_tf_tr_td all_total_price"><strong>'.number_format($mboty).'<strong></td>';
							$html .='</tr>';
							$incash = payed_values_for_order($order_id);
							echo $incash ; 
							if ($incash){
								$minus_cash = $mboty - $incash;
								$html .='<tr class="mega_invoice_tf_tr">';
									$html .='<th class="mega_invoice_tf_tr_td"><span>پرداخت شده نقدی</span></th>';
									$html .='<td class="mega_invoice_tf_tr_td all_total_price"><strong>'.number_format($incash).'<strong></td>';
								$html .='</tr>';
								$html .='<tr class="mega_invoice_tf_tr">';
									$html .='<th class="mega_invoice_tf_tr_td"><span>مبلغ تسهیلات</span></th>';
									$html .='<td class="mega_invoice_tf_tr_td all_total_price"><strong>'.number_format($minus_cash).'<strong></td>';
								$html .='</tr>';
							}
							$html .='<tr class="mega_invoice_tf_tr">';
								$org_discount_amount= ($mboty * $org_discount)/100;
								$mboty = $mboty - $org_discount_amount ; 
								if ($org_discount_amount){
									$html .='<th class="mega_invoice_tf_tr_td"><span>تخفیف خرید سازمانی</span></th>';
									$html .='<td class="mega_invoice_tf_tr_td all_total_price"><strong>'.number_format($org_discount_amount).'<strong></td>';
								}
							$html .='</tr>';
						}
						$html .='<tr class="mega_invoice_tf_tr">';
							$html .='<th class="mega_invoice_tf_tr_td"><span>مبلغ</span></th>';
							
							$html .='<td class="mega_invoice_tf_tr_td all_total_price" all_total_price="'.$mboty.'"><strong>'.number_format($mboty).'<strong></td>';
						$html .='</tr>';
						$incash = payed_values_for_order($order_id);
						echo $incash ; 
						if ($incash){
							$minus_cash = $mboty - $incash;
							$html .='<tr class="mega_invoice_tf_tr">';
								$html .='<th class="mega_invoice_tf_tr_td"><span>پرداخت شده نقدی</span></th>';
								$html .='<td class="mega_invoice_tf_tr_td all_total_price"><strong>'.number_format($incash).'<strong></td>';
							$html .='</tr>';
							$html .='<tr class="mega_invoice_tf_tr">';
								$html .='<th class="mega_invoice_tf_tr_td"><span>مبلغ تسهیلات</span></th>';
								$html .='<td class="mega_invoice_tf_tr_td all_total_price"><strong>'.number_format($minus_cash).'<strong></td>';
							$html .='</tr>';
						}
						// $mablaghe_pardakht = $mboty + $coup_val;

						$mablaghe_pardakht = $mboty;
					}
				}else{


				}
				
			$html .='</tbody>';
		$html .='</table>';
	}
	

$html .='</table>';


