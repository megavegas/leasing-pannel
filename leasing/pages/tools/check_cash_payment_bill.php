<?php 
function check_cash_payment_for_bill(){
	echo '<div class="pg-bg-dark">';
		echo '<div class="container">';
			echo '<div class="col-12 p-5">';
				if (isset($_POST['bill_id'])) {
					$bill_id = isset($_POST['bill_id']) ? sanitize_text_field($_POST['bill_id']) : '';
					
					if ($bill_id) {
						$sql ="SELECT *  FROM `edu_customer_cash_payment` WHERE order_id ='{$bill_id}'";
						global $wpdb ; 
						$results = $wpdb->get_results($sql);
						?>
						<table class="table table-sm">
							<thead>
								<tr>
									<th>ردیف</th>
									<th>تاریخ</th>
									<th>مبلغ</th>
									<th>وضعیت پرداخت</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$m = ''; 
								$i = 1 ;
								foreach($results as $item){
									$m .= '<tr>'; 
										$m .= '<td>'.$i.'</td>'; 
										$m .= '<td>'.$item->pay_date.'</td>';
										$m .= '<td>'.$item->ammount.'</td>';
										$json = json_decode($item->json , true);
										// print_r($json);
										if ($json['ResCode'] == 0 ){
											$status = '<span class="text-success">موفق</span>';
										}else{
											$status = '<span class="text-danger">ناموفق</span>';
										}
										$m .= '<td>'.$status.'</td>';
									$m .= '</tr>';
									 
								}
								echo $m ;
								?>
							</tbody>
						</table>
						<?php
					}
				}
				$html  = '<form method="post" class="col-12 pg-clip p-5 bg-white">
						<label>شماره فاکتور</label>
						<input type="text" name="bill_id" placeholder="شناسه سفارش را وارد کنید" class="form-control">
						
						<hr>
						<button type="submit" name="apply_coupon" class="btn btn-warning">بررسی</button>
					</form>';
				echo $html ;
			echo '</div>';
		echo '</div>';
	echo '</div>';
}



check_cash_payment_for_bill(); 