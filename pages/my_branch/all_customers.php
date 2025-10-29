<?php
	global $wpdb;
	global $woocommerce;
	global $mega_admin;
	$t1 = $wpdb->prefix .'branch_customers';
	$t2 = $wpdb->prefix .'usermeta';
	$t3 = $wpdb->prefix .'users';
	$lid = get_current_user_id();

	// SELECT * FROM `edu_users` AS a INNER JOIN `edu_usermeta` AS b ON a.ID = b.user_id WHERE b.meta_key='branch_leasing_employee_id' AND b.meta_value='749';

	$sql = "SELECT * FROM `{$t3}` AS a INNER JOIN `{$t2}` AS b ON a.ID = b.user_id WHERE b.meta_key='branch_leasing_employee_id' AND b.meta_value={$lid} " ;
	$orders_list = $wpdb->get_results($sql);
	echo '<table id ="mega_data_list" class="mega_data_list">';
		echo '<thead>
				<tr>
					<th style="text-align: center !important;">مشتری</th>
					<th style="text-align: center !important;">شماره</th>
					<th style="text-align: center !important;">تاریخ</th>
					<th style="text-align: center !important;">نام طرح</th>
					<th style="text-align: center !important;">نماینده</th>
					<th style="text-align: center !important;">مبلغ کل</th>
					<th style="text-align: center !important;">مشاهده</th>
				</tr>
			</thead>';
		echo '<tbody>';
		foreach($orders_list as $item){
			$bid = $item->user_id;
			$cql = "SELECT a.customer_id , a.order_id , a.plan_id FROM edu_branch_customers AS a WHERE a.branch_id={$bid} ORDER BY a.order_id DESC;";
			
			$bracus = $wpdb->get_results($cql);
			// print_r($bracus);
			foreach($bracus as $cus){
				$order = wc_get_order($cus->order_id);

				if (wc_get_order($cus->order_id)){
					$tt = $order->get_total();
					if ($order->get_total()){
						echo '<tr>';

							// calculate subtotal 
							$sub_total = intval($order->get_subtotal());
							// calculate order total
							$or_total = intval($order->get_total());
							// calculate plan rate
							$plan_rate = intval(get_post_meta( $cus->plan_id, 'Interest_rate' , true ));

							$sub_intrest = intval( intval( $sub_total * $plan_rate)  / 100 ) + $sub_total;
							$total = intval( intval( $or_total * $plan_rate) / 100 ) + $or_total;

							$customer = get_userdata( $cus->customer_id );
							if ($customer){
								$c_name = $customer->first_name;
      							$c_family = $customer->last_name;
							}
							

							$branch = get_userdata($bid);


							// print_r($customer);
							echo '<td>'.$c_name .' '.$c_family.'</td>';
							echo '<td>'.$cus->order_id.'</td>';

							$now = new DateTime($order->get_date_created());
							$formatter = new IntlDateFormatter(
								"fa_IR@calendar=persian", 
								IntlDateFormatter::FULL, 
									IntlDateFormatter::FULL, 
								'Asia/Tehran', 
								IntlDateFormatter::TRADITIONAL, 
								"yyyy/MM/dd");


							echo '<td>'.$formatter->format($now).'</td>';
							echo '<td plan_id="'.$cus->plan_id.'" intrest_rate = "">'.get_the_title($cus->plan_id).'</td>';	
							echo '<td>'.
									get_user_meta($item->user_id , 'first_name' , true) . ' ' .get_user_meta($item->user_id , 'last_name' , true).
									'<hr style="padding:0px ; margin:0px;">'.
									get_user_meta($item->user_id,'branch_serial_number',true).
								'</td>';
							echo '<td>'.$order->get_total().'</td>';
							echo '<td><a href="'.get_site_url().'/my-account/?leasing=order&order_id='.$cus->order_id.'&plan_id='.$cus->plan_id.'&customer_id='.$cus->customer_id.'" target="_blank">مشاهده سفارش</a></td>';
						echo '</tr>';
					}

				}
				
				
			}
		}
		echo '</tbody>';

	echo '</table>';