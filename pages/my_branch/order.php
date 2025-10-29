<?php
$order_totall = 0;
global $wpdb;
global $mega_admin;
$html = '';


$plan_id = $_SESSION['plan_id'];
$iq = get_post_meta($plan_id , 'installments_quantiy' , true);
$ir = get_post_meta($plan_id , 'Interest_rate' , true);



if (isset($_GET)){
	if (isset($_GET['leasing'])){
		if ($_GET['leasing'] == 'order'){
			$order = wc_get_order($_GET['order_id']);
			$oit = get_order_items_by_id($_GET['order_id']);

			if ($oit['plan_id']){
				$plan_id = $oit['plan_id'];
				$iq = get_post_meta($plan_id , 'installments_quantiy' , true);
				$ir = get_post_meta($plan_id , 'Interest_rate' , true);
				$palan_precent 		= get_post_meta($_GET['plan_id'] , 'Interest_rate' , true);
				$banck_account 		= get_post_meta($_GET['plan_id'] , 'bank_account' ,true);
				$shaba_account 		= get_post_meta($_GET['plan_id'] , 'shaba_account' ,true);
				$banck_branch_code 	= get_post_meta($_GET['plan_id'] , 'banck_branch_code' ,true);
				$bank_name 			= get_post_meta($_GET['plan_id'] , 'bank_name' ,true);
				$min_cash_pay 		= get_post_meta($_GET['plan_id'] , 'min_cash_pay' , true);
			}
			
			$now = new DateTime($order->get_date_created());
			$formatter = new IntlDateFormatter(
							"en_EN@calendar=persian", 
							IntlDateFormatter::FULL, 
								IntlDateFormatter::FULL, 
							'Asia/Tehran', 
							IntlDateFormatter::TRADITIONAL, 
							"yyyy/MM/dd");

			$html .= '<div id="printarea" style="display: block !important;width: 100% !important; font-size:12px;" >';
				$html .='<div class="container mb-5 mt-5">';
					$html .='<table style="margin: 0px 0px 5px 0px ; width:100%">';
						$html .='<tr style="border:none;">';
							$html .='<td style="text-align: center;vertical-align: middle;padding: 0px; border: none;">';
								$html .='<h2 style="margin: 0px;">پیش فاکتور</h2>';
							$html .='</td>';
							$html .='<td style="text-align: center;vertical-align: middle;padding: 0px; border: none;">';
								$html .='<span>وب سایت  : '.get_site_url() .'</span>';
							$html .='</td>';
							$html .='<td style="text-align: center;vertical-align: middle;padding: 0px; border: none;">';
							$html .='<div>';
								$html .='<div><span>تاریخ : '.$formatter->format($now).'</span></div>';
								$html .= '<div><span>شماره : '.$_GET['order_id'].'</span></div>';
							$html .='</div>';
							$html .='</td>';
						$html .='</tr>';
					$html .='</table>';
					
					$html .='<div class="shop_informaition d-flex flex-wrap">';
						$html .='<div class="col-4">';
							$html .='<span><strong>نام فروشگاه : </strong></span><span>همتا صنعت ویرا</span>';
						$html .='</div>';
						$html .='<div  class="col-3">';
							$html .='<span><strong>تلفن : </strong></span><span>۰۲۱۷۳۶۷۱۹۱۹</span>';
						$html .='</div>';
						$html .='<div  class="col-3">';
							$html .='<span><strong>ایمیل : </strong></span><span>info@hamtaloans.com</span>';
						$html .='</div>';

						$html .='<div  class="col-12">';
							$html .='<span><strong>آدرس فروشگاه : </strong></span><span>تهران - خیابان شریعتی - قلهک - مجتمع تجاری قلهک - طبقه نهم .</span>';
						$html .='</div>';
						$html .='<div  class="col-12">';
							if ($bank_name != ''){$html .='<span><strong>نام بانک : </strong></span><span>'.$bank_name.'</span> ';}
							if ($banck_account != ''){$html .='<span><strong>شماره حساب : </strong></span><span>'.$banck_account.'</span> ';}
							if ($banck_branch_code != ''){$html .='<span><strong>کد شعبه : </strong></span><span>'.$banck_branch_code.'</span> ';}
							
						$html .='</div>';
					$html .='</div>';

					$html .='<div class="customer_informaition d-flex flex-wrap">';
						$html .='<div class="cust_infor_title col-12">';
							$html .='اطلاعات مشتری';
						$html .='</div>';
						$html .='<div class="invoice_mega_name col-3">';
							$html .='<span><strong>نام و نام خانوادگی   : </strong></span><span>'.get_user_meta($oit['customer_id'] , 'first_name' , true).' '.get_user_meta($oit['customer_id'] , 'last_name' , true).'</span>';
						$html .='</div>';
						$html .='<div class="invoice_mega_name col-3">';
							$html .='<span><strong>کد ملی : </strong></span><span>'.get_user_meta($oit['customer_id'] , 'user_id_number' , true).'</span>';
						$html .='</div>';
						$html .='<div class="invoice_mega_name col-3">';
							$html .='<span><strong>موبایل : </strong></span><span>'.get_user_meta($oit['customer_id'] , 'user_phone_number' , true).'</span>    ';
						$html .='</div>';
						$html .='<div class="invoice_mega_name col-3">';
							$html .='<span><strong>تلفن: </strong></span><span>'.get_user_meta($oit['customer_id'] , 'user_phone' , true).'</span>';
						$html .='</div>';
						$html .='<div class="invoice_mega_name col-6">';
							$html .='<span><strong>آدرس : </strong></span><span>'.get_user_meta($oit['customer_id'] , 'user_address' , true).'</span>';
						$html .='</div>';
						$html .='<div class="invoice_mega_name col-3">';
							$html .='<span><strong>کد پستی : </strong></span><span>'.get_user_meta($oit['customer_id'] , 'zip_postal_code' , true).'</span>';
						$html .='</div>';
						$html .='<div class="invoice_mega_name col-3 p-0">';
							$html .='<span ><strong>شناسه واریز : </strong></span><span>'.get_post_meta($_GET['order_id'] , 'serial_of_invoce' , true).'</span>';
						$html .='</div>';
					$html .='</div>';

					$html .='<div class="mega_invoice_title d-flex">';
						$html .='<h2>شرح کالا</h2>';
					$html .='</div>';

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
							foreach ( $order->get_items() as $item_id => $item  ) {
								$bm = json_decode($item);
								$product_id = $bm->product_id;
								$product = wc_get_product($product_id);
								
								$html .='<tr class="mega_invoice_tb_tr">';
									$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;">'.$i.'</td>';
									$html .='<td class="mega_invoice_tb_tr_td" style="font-size: 13px;padding: 2px;">'.$product->get_name().'</td>';
									$html .='<td class="mega_invoice_tb_tr_td mtn_quantity" style="font-size: 13px;padding: 2px;"><div><input type="number" name="mtn_qty" min="1" max="5" value="'.$bm->quantity.'" style="border:none;margin:none"></div></td>';
									$html .='<td class="mega_invoice_tb_tr_td mtn_price"  price="'.$item->get_subtotal().'"  style="font-size: 13px;padding: 2px;">'.number_format($item->get_subtotal()).'</td>';
									$mboty = $item->get_subtotal() + $mboty;
									$html .='<td class="mega_invoice_tb_tr_td mtn_total" total="'.$item->get_total().'"  style="font-size: 13px;padding: 2px;">'.number_format($item->get_subtotal()).'</td>';

									
								$html .='</tr>';
								$i++;
							}

							if ($mboty != get_post_meta($_GET['order_id'] , '_order_total' , 'yes')){
								update_post_meta( $_GET['order_id'] , '_order_total' , $mboty);
							}
						$html .='</tbody>';
						
						$html .='<table class="mega_invoice_tfooter" mb="'.$mboty.'" ot="'.get_post_meta($_GET['order_id'] , '_order_total' , 'yes').'">';
							$html .='<tbody>';
								$html .='<tr class="mega_invoice_tf_tr">';
									$html .='<th class="mega_invoice_tf_tr_td"><span>جمع به ریال </span></th>';
									$html .='<td class="mega_invoice_tf_tr_td all_total_price" all_total_price="'.$order->get_total().'"><strong>'.number_format($order->get_total()).'<strong></td>';
								$html .='</tr>';
							$html .='</tbody>';
						$html .='</table>';

							
						
					$html .='</table>';
					if(floatval($min_cash_pay)>0){
						$html .='<div class="invoice_footer d-flex flex-wrap">';
							$html .='<div class="col-12">';
								if (isset($_GET['plan_id'])){
									$plan_id=$_GET['plan_id'];
								} 
								
								
								$html .='<div class="mega_hint_after_invoice">';

									$html .='<div class="mhai_item vam_invoice">';
										$html .='<span>مبلغ تسهیلات درخواستی : </span>';


										$pc_80 = $mboty - ( $mboty*0.2)  ;

										$html .='<strong>'.number_format($pc_80).'</strong> ریال ';
										$html .='<span> معادل 80 درصد کل پیش فاکتور</span>';
									$html .='</div>';

									$html .='<div class="mhai_item pish_invoice">';
										$html .='<span>مبلغ پیش پرداخت خرید کالا : </span>';
										$html .='<strong>'.number_format( $mboty - $pc_80 ).'</strong> ریال ';
										$html .='<span> معادل 20 درصد کل پیش فاکور</span>';
									$html .='</div>';

								$html .='</div>';

								$html .='<div class="mega_hint_after_invoice">';
									$html .='<div class="tarh_invoice">';
										$html .='<span>این پیش فاکتور مربوط به طرح : </span>';
										$html .='<strong>'.get_the_title($plan_id).'</strong>';
									$html .='</div>';
									$html .='<div class="branch_invoice">';
										$html .='<span>نماینده فروش : </span>';
										
										$html .='<strong>'.get_user_meta( $branch_id, 'first_name' , true).' '.get_user_meta($branch_id , 'last_name' , true).'</strong>';
									$html .='</div>';
								$html .='</div>';

								$html .='<div class="mega_hint_after_invoice">';
									$html .='<p>پیش فاکتور صادر شده صرفا جهت ارائه به بانک بوده و فاقد هر گونه ارزش دیگر است . </p>';
									$html .='<p><strong>توجه : </strong><span>مدت اعتبار پیش فاکتور از تاریخ صدور به مدت 5 روز کاری می باشد . </span></p>';
									$html .='<p><strong>توجه : </strong><span>تحویل کالا مشروط به ارائه پیش فاکتور تأیید شده بانک به نمایندگی صادر کننده پیش فاکتور می باشد .</span></p>';
								$html .='</div>';
							$html .='</div>';
							$html .='<div class="col-6">مهر و امضاء نمایندگی فروش </div>';
							$html .='<div class="col-6">امضاء خریدار</div>';
						$html .='</div>';
					}else{
						$html .='<div class="invoice_footer d-flex flex-wrap">';
							$html .='<div class="col-12">';
								
								$branch = get_user_by('ID', $branch_id);
								// print_r($branch->data);
								$html .='<p>این پیش فاکتور برای طرح :<strong style="color:red;"> '.get_the_title($_GET['plan_id']).'</strong> صادر گردیده است  . نمایندگی :<strong  style="color:blue;"> '.$branch->data->display_name.'</strong> شماره تماس : <strong  style="color:blue;">'.$branch->data->user_login.'</strong></p>';
								$html .='<p>پیش فاکتور صادر شده صرفا جهت ارائه به بانک بوده و فاقد هر گونه ارزش دیگر است . </p>';
								$html .='<p><strong>توجه : </strong><span>مدت اعتبار پیش فاکتور از تاریخ صدور به مدت 10 روز کاری می باشد . </span></p>';
								$html .='<p><strong>توجه : </strong><span>تحویل کالا مشروط به ارائه پیش فاکتور تأیید شده بانک به نمایندگی صادر کننده پیش فاکتور می باشد .</span></p>';
							$html .='</div>';
							$html .='<div class="col-6">مهر و امضاء نمایندگی فروش </div>';
							$html .='<div class="col-6">امضاء خریدار</div>';
						$html .='</div>';
					}
				$html .='</div>';
			$html .='</div>';
			$html .='<div class="mega_print_invoice">';
				$html .='<button onclick="print_area_of(\'printarea\')">چاپ فاکتور</a>';
			$html .='</div>';

			echo $html;

			
		}
	}
}


update_post_meta( $_SESSION['order_id'], '_order_total' , $mboty);