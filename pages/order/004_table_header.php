<?php 
	$html .='<table style="margin: 40px 0px 5px 0px ; width:100%">';
				$html .='<tr style="border:none;">';
					$html .='<td style="text-align: center;vertical-align: middle;padding: 0px; border: none;">';
						$html .='<h2 style="margin: 0px;">پیش فاکتور</h2>';
					$html .='</td>';
					$html .='<td style="text-align: center;vertical-align: middle;padding: 0px; border: none;">';
						$html .='<span>وب سایت  : '.get_site_url().'</span>';
					$html .='</td>';
					$html .='<td style="text-align: center;vertical-align: middle;padding: 0px; border: none;">';
					$html .='<div>';
						$html .='<div><span>تاریخ : '.$formatter->format($now).'</span></div>';
						$html .= '<div><span>شماره : '.$order_id.'</span></div>';
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

					$banck_account 		= get_post_meta($plan_id , 'bank_account' ,true);
					$shaba_account 		= get_post_meta($plan_id , 'shaba_account' ,true);
					$banck_branch_code 	= get_post_meta($plan_id , 'banck_branch_code' ,true);
					$bank_name 			= get_post_meta($plan_id , 'bank_name' ,true);
					if ($bank_name != ''){$html .='<span><strong>نام بانک : </strong></span><span>'.$bank_name.'</span> ';}
					if ($banck_account != ''){$html .='<span><strong>شماره حساب : </strong></span><span>'.$banck_account.'</span> ';}
					if ($banck_branch_code != ''){$html .='<span><strong>کد شعبه : </strong></span><span>'.$banck_branch_code.'</span> ';}
					
				$html .='</div>';
			$html .='</div>';
			global $national_id ;
			$national_id = get_user_meta($user_id , 'user_id_number' , true) ; 
			$html .='<div class="customer_informaition d-flex flex-wrap">';
				$html .='<div class="cust_infor_title col-12">';
					$html .='اطلاعات مشتری';
				$html .='</div>';
				$html .='<div class="invoice_mega_name col-3">';
					$html .='<span><strong>نام و نام خانوادگی   : </strong></span><span>'.get_user_meta($user_id , 'first_name' , true).' '.get_user_meta($user_id , 'last_name' , true).'</span>';
				$html .='</div>';
				$html .='<div class="invoice_mega_name col-3">';
					$html .='<span><strong>کد ملی : </strong></span><span>'.get_user_meta($user_id , 'user_id_number' , true).'</span>';
				$html .='</div>';
				$html .='<div class="invoice_mega_name col-3">';
					$html .='<span><strong>موبایل : </strong></span><span>'.get_user_meta($user_id , 'user_phone_number' , true).'</span>    ';
				$html .='</div>';
				$html .='<div class="invoice_mega_name col-3">';
					$html .='<span><strong>تلفن: </strong></span><span>'.get_user_meta($user_id , 'user_phone' , true).'</span>';
				$html .='</div>';
				$html .='<div class="invoice_mega_name col-6">';
					$html .='<span><strong>آدرس : </strong></span><span>'.get_user_meta($user_id , 'user_address' , true).'</span>';
				$html .='</div>';
				$html .='<div class="invoice_mega_name col-3">';
					$html .='<span><strong>کد پستی : </strong></span><span>'.get_user_meta($user_id , 'zip_postal_code' , true).'</span>';
				$html .='</div>';
				$html .='<div class="invoice_mega_name col">';
					$bd_day =get_user_meta($user_id , 'bd_day' , true);
					if ($bd_day == ''){$bd_day = '00';}
					$bd_month =get_user_meta($user_id , 'bd_month' , true);
					if ($bd_month == ''){$bd_month = '00';}
					$bd_year =get_user_meta($user_id , 'bd_year' , true);
					if ($bd_year == ''){$bd_year = '0000';}

					$html .='<span><strong>تاریخ تولد: </strong></span><span>'.$bd_year.'/'.$bd_month.'/'.$bd_day.'</span>';
				$html .='</div>';

				if ($order_id != '68418'){

					$rr = get_post_meta($order_id , 'serial_of_invoce' , true); 
					if ($rr == '' || strlen($rr) < 20){
						$html .='<div class="invoice_mega_name col-3 pt-0 pb-0">';
					
							$branch_id = get_user_meta($user_id , 'maker_branch_id' , true);

							$table_name = $wpdb->prefix .'branch_customers';
							$cuid = $user_id;
							$sql_ship = "SELECT COUNT(ID) AS BB FROM {$table_name} AS A WHERE A.branch_id = {$branch_id} AND A.customer_id = {$cuid};";
							$counterx = $wpdb->get_results($sql_ship);
							// print_r($counterx[0]->BB);
							$aaa = '';
							
							if (intval($counterx[0]->BB) == 0){
								$aaa = '01';
							}elseif (intval($counterx[0]->BB) >0 && intval($counterx[0]->BB) < 10){
								$aaa = '0'.$counterx[0]->BB;
							}elseif (intval($counterx[0]->BB) >= 10 && intval($counterx) <100 ){
								$aaa = $counterx[0]->BB;
							}else{
								if (intval($counterx[0]->BB - 99) == 0){
									$aaa = '00';
								}elseif (intval($counterx[0]->BB -99) < 10){
									$aaa = '0'.intval($counterx[0]->BB -99);
								}elseif (($counterx[0]->BB -99) > 10 & ($counterx[0]->BB -99) <100 ){
									$aaa = ($counterx[0]->BB -99);
								}
							}
									



							$table_one = $wpdb -> prefix . 'woocommerce_order_items';
							$table_tow = $wpdb -> prefix . 'woocommerce_order_itemmeta';
							if (isset($_SESSION['order_id'])){
								$order_id = $_SESSION['order_id'];						
							}
							

							$sql_order_item = "SELECT * FROM `{$table_one}` AS a INNER JOIN `{$table_tow}` AS b ON a.order_item_id = b.order_item_id WHERE a.order_id = '{$order_id}';";
							$results = $wpdb -> get_results($sql_order_item);
							


							$bbcode = get_user_meta($branch_id , 'branch_serial_number' , true).get_user_meta($user_id , 'user_id_number' , true).$aaa;

							$alp = intval((intval($bbcode[0])*3)+(intval($bbcode[1])*5)+(intval($bbcode[2])*7)+(intval($bbcode[3])*11)+(intval($bbcode[4])*13)+(intval($bbcode[5])*17)+(intval($bbcode[6])*19)+(intval($bbcode[7])*23)+(intval($bbcode[8])*29)+(intval($bbcode[9])*31)+(intval($bbcode[10])*37)+(intval($bbcode[11])*41)+(intval($bbcode[12])*43)+(intval($bbcode[13])*47)+(intval($bbcode[14])*49)+(intval($bbcode[15])*53)+(intval($bbcode[16])*59)+(intval($bbcode[17])*61));

							
							$alp_query="SELECT MOD({$alp},99) as moooood;";
							$alp_data = $wpdb -> get_results($alp_query);

							echo strlen($alp_data[0]->moooood);
							if (strlen($alp_data[0]->moooood) < 2){
								$ser_con = '0'.$alp_data[0]->moooood;
							}else{
								$ser_con = $alp_data[0]->moooood;
							}

							$order_serial_number = $bbcode.$ser_con ; 
							// echo '<script>alert("'.$ser_con.'")</script>';

							$html .='<span alp="'.$alp.'" b_code="'.$bbcode.'" alp_query="'.$ser_con.'" ><strong>شناسه واریز : </strong></span><span>'.$order_serial_number.'</span>';
							update_post_meta($order_id , 'serial_of_invoce' , $order_serial_number );
						$html .='</div>';
					}else{
						$html .='<div class="invoice_mega_name col-3 pt-0 pb-0">';
							$html .='<span><strong>شناسه واریز : </strong></span><span>'.$rr.'</span>';
						$html .='</div>';
					}
					
					
					
				}
			$html .='</div>';

			$html .='<div class="mega_invoice_title d-flex">';
				$html .='<h2>شرح کالا</h2>';
			$html .='</div>';


