<?php 

global $wpdb ;
global $woocommerce ;

$t1 = $wpdb -> prefix . 'users';
$t2 = $wpdb -> prefix . 'usermeta';

$user_id = get_current_user_id();

$sql = "SELECT B.user_id FROM `{$t1}` AS A INNER JOIN `{$t2}` AS B ON A.ID = B.meta_value WHERE B.meta_key='branch_leasing_employee_id' AND B.meta_value={$user_id};";
$branches = $wpdb -> get_results($sql);

?>

<div class="mega_list list_of_branches d-flex flex-wrap position-relative mt-4">
	<div class="ml_container">
		<div class="mop_title">
			<h1>لیست نمایندگان من</h1>
		</div>
		<div class="ml_inner_box position-relative">
	<?php 

				$html = '<table id="all_branch_list" class="w-100">';
					$html .= '<thead class="abl_header">';
						$html .= '<tr class="abl_h_row">';
							$html .= '<th class="abl_h_row_number">ردیف</th>';
							$html .= '<th class="abl_h_name">نام و نام خانوادگی</th>';
							$html .= '<th class="abl_h_id">شناسه</th>';
							$html .= '<th class="abl_h_mobile">شماره تلفن</th>';
							$html .= '<th class="abl_h_mobile">کد تفضیلی</th>';
							$html .= '<th class="abl_h_mobile">کد قرارداد</th>';
							$html .= '<th class="abl_h_edit">ویرایش</th>';
						$html .= '</tr>';
					$html .= '</thead>';
					$i = 1;
					$html .= '<tbody>';
					foreach($branches as $b){
						$user = get_user_by('ID' , $b->user_id);

						$bid = $b->user_id;

						$cql = "SELECT DISTINCT a.customer_id FROM edu_branch_customers AS a WHERE a.branch_id={$bid};";
						$bracus = $wpdb->get_results($cql);

						$pi_sql = "SELECT  a.order_id FROM edu_branch_customers AS a WHERE a.branch_id={$bid};";
						$pi = $wpdb->get_results($cql);
						
						$html .= '<tr>';
							$html .= '<td class="abl_b_row_number">'.$i.'</td>';$i++;
							$html .= '<td class="abl_b_name">'.get_user_meta($user->ID , 'first_name' , true).' ' .get_user_meta($user->ID , 'last_name' , true).'</td>';
							$html .= '<td class="abl_b_id">'.get_user_meta($user->ID , 'branch_serial_number' , true).'</td>';
							$html .= '<td class="abl_b_mobile">'.$user->user_login.'</td>';
							$html .= '<td class="abl_b_mobile">'.get_user_meta($user->ID , 'branch_serial_number' , true).'</td>';
							$html .= '<td class="abl_b_mobile">'.get_user_meta($user->ID , 'branch_contract_serial' , true).'</td>';
							$html .= '<td class="abl_b_edit"><a href="'.get_site_url().'/my-account/?leasing=edit_branch&branch_id='.$b->user_id.'"><span>ویرایش</span></a></td>';
						$html .= '</tr>';
					}
					$html .= '</tbody>';
				$html .= '</table>';

				echo $html;
	?>
	</div>
</div>