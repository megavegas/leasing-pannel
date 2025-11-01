<?php 
global $wpdb ; 
$sql = "SELECT * FROM view_leasing_sale_report WHERE leasing_employee = '".get_current_user_id()."' ;";
if (current_user_can('administrator')){
	$sql = "SELECT * FROM view_leasing_sale_report WHERE leasing_employee = '2609' ;";
}
$report = $wpdb->get_results($sql);

?>
<div class="mega_list list_of_branches d-flex flex-wrap position-relative mt-4">
	<div class="ml_container">
		<div class="mop_title">
			<h1>فروش نمایندگان</h1>
		</div>
		<div class="ml_inner_box position-relative">
			<table class="w-100" id="all_branch_list">
				<thead>
					<tr>
						<th>ردیف</th>
						<th>نماینده</th>
						<th>فروش کل</th>
						<th>پرداخت نقی</th>
						<th>تخفیف</th>
						<th>تعداد سفارش</th>
					</tr>
				</thead>
				<tbody>
					<?php 	
						$i = 1 ; 
						foreach($report as $item){
							echo '<tr>';
								echo '<td>'.$i.'</td>';
								echo '<td>'.$item->bin.'</td>';
								echo '<td>'.number_format($item->total_factor).'</td>';
								echo '<td>'.number_format($item->cash_payment).'</td>';
								echo '<td>'.number_format($item->coupun_amount).'</td>';
								echo '<td>'.$item->ocount.'</td>';
							echo '</tr>';
							$i++;
						}
						
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>