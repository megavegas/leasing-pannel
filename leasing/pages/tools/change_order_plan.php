<?php
function change_order_plan(){
	global $wpdb ; 
	echo '<div class="pg-bg-dark">';
		echo '<div class="container">';
			echo '<div class="col-12 p-5">';
				if (isset($_POST['bill_id'])) {
					$bill_id = isset($_POST['bill_id']) ? sanitize_text_field($_POST['bill_id']) : '';
					
					if ($bill_id) {
						$plan_id = get_plan_id_form_bc_orders($bill_id);
						if ($plan_id){
							$order = wc-get_order($bill_id);
							if ($order){
								$order_status = $order->get_status(); 
								if ($order_status == 'pendig'){

									$branch_id = get_branch_id_form_branch_customers($bill_id);
									$branch_employee = get_user_meta($branch_id , 'branch_leasing_employee_id' , true);
									if (get_current_user_id() == $branch_employee){
										$data =['plan_id' => $plan_id];
										$where = ['order_id' => $bill_id ] ;
										$db_table =$wpdb->prefix . 'branch_customers' ; 
										
										$resutl = $wpdb -> update ($db_table , $data , $where );
										if ($resutl){
											echo 'بروز رسانی با موفقیت انجام شد' ;
										}else{
											echo 'در فرایند بروز رسانی خطایی رخ داده است ';
										}

									}else{
										echo 'این فاکتور توسط نماینده شما ثبت نشده است';
									}
									
								}else{
									echo 'به دلیل وضعیت سفارش امکان تغییر طرح فروش وجود ندارد';
								}
							}else{
								echo 'سفارش حذف شده است یا وجود ندارد';
							}
						}else{
							echo 'طرح ست نشده است';
						}
						
					}else{
						echo 'شماره سفارش ست نشده است';
					}
				}else{
					echo 'شماره سفارش ست نشده است';
				}
				
				$plans = $wpdb->get_results("SELECT `ID` , `post_status` , `post_title` FROM `edu_posts` WHERE `post_type` LIKE 'leasing_plans' AND post_status LIKE 'publish';");
				foreach($plans as $plan){
					echo '<option value="'.$plan->ID.'">'.$plan->post_title.'</option>';
				}

				$html  = '<form method="post" class="col-12 pg-clip p-5 bg-white">
						<label>انتخاب طرح</label>
						
						<select name="plan_id" reauired>

						</select>


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


change_order_plan() ; 