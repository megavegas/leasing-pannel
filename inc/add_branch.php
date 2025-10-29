<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');

global $wpdb ; 

$request_body = file_get_contents('php://input');
$data = json_decode($request_body);

$user_data = array(
	'user_pass'								=> $data->branch_mobile,
	'user_login'							=> $data->branch_mobile,
	'user_nicename'							=> $data->branch_mobile,
	'user_url'								=> get_site_url(),
	'user_email'							=> '',
	'display_name'							=> $data->first_name.' '.$data->last_name,
	'nickname'								=> $data->first_name.' '.$data->last_name,
	'first_name'							=> $data->first_name,
	'last_name'								=> $data->last_name,
	'description'							=> 'نمایندگی شماره : ' .$data->branch_serial_number,
	'user_registered'						=> date("Y-m-d H:i:s"),
	'show_admin_bar_front'					=> false,
	'role'									=> 'branch',
);
$user_id = wp_insert_user( $user_data );

$zone_id = get_user_meta($data->employee , 'my_sale_zone' , true);
$zone_name = get_the_title($zone_id);
$my_zone_manager_id = get_post_meta($zone_id , 'zone_master' , true );
$my_zone_manager_id = $my_zone_manager_id[0];
$my_zone_manager_name = get_user_meta($my_zone_manager_id , 'first_name' , true) . ' ' . get_user_meta($my_zone_manager_id , 'last_name' , true);
$state_name_query ="SELECT `term_id` FROM `edu_terms` WHERE `name` = 'خوزستان' ORDER BY `term_id` DESC LIMIT 1;";
$state_name = $wpdb->get_var($state_name_query);

$state_id_query ="SELECT `term_id` FROM `edu_terms` WHERE `name` = 'خوزستان' ORDER BY `term_id` DESC LIMIT 1;";
$state_id = $wpdb->get_var($state_name_query);

$meta_input = array(
	
	'branch_leasing_employee_id' 		=> $data->employee,
	'my_leasing_employee_name'			=> get_user_meta($data->employee , 'first_name' , true) . ' ' . get_user_meta( $data->employee , 'last_name' , $data->employee) ,

	'branch_owner_id_cart_number' 		=> $data->branch_id_number,
	'branch_province' 					=> $data->branch_state,
	'branch_city' 						=> $data->branch_city,
	'branch_adress' 					=> $data->branch__address,
	'brach_zip_code' 					=> $data->branch_zip_postal_code,
	'brach_mobile_number' 				=> $data->branch_mobile,
	'brach_phone_number' 				=> $data->branch_phone,
	'branch_contract_serial' 			=> $data->branch_contract_serial,
	'branch_serial_number' 				=> $data->branch_serial_number,
	'added_by_leasing' 					=> get_current_user_id(),
	'my_zone_id'						=> get_user_meta($data->employee , 'my_sale_zone' , true),
	'my_zone_manager_id'				=> $my_zone_manager_id,
	'my_zone_manager_name'				=> $my_zone_manager_name,
	'my_zone_number'					=> $zone_name ,
	'my_zone_state'						=> $state_name,
	'my_zone_state_id'					=> $state_id,

);
foreach($meta_input as $key => $value){
	update_user_meta($user_id , $key , $value);
}

if ( ! is_wp_error( $user_id ) ) {
	echo '<div class="container bg-white rounded shadow-sm mt-5">';
		$html = '<div class="resp_add_user">';
			$html .= '<div class="rau_info">';
				$html .= '<div class="rau_info_hint">';
					$html .= '<h3>حساب کاربری نمایندگی با موفقیت ایجاد گردید .</h3>';
				$html .= '</div>';
				$html .= '<div class="rau_info_main">';
					$html .= '<div><span> نام و نام خانوادگی  : </span><span><strong>'.get_user_meta($user_id , 'first_name', true). ' '.get_user_meta($user_id , 'last_name', true) .'</strong></span></div>';
					$html .= '<div><span> کد نمایندگی  : </span><span><strong>'.get_user_meta($user_id , 'branch_serial_number' , true).'</strong></span></div>';
				$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="rau_more">';
				$html .= '<a href="'.get_site_url().'/my-account/?leasing=add_new_user" class="btn btn-primary" >ایجاد نماینده جدید</a>';
				$html .= '<a href="'.get_site_url().'/my-account"  class="btn btn-info">بازگشت به داشبورد</a>';
			$html .= '</div>';
		$html .= '</div>';
		echo $html;
	echo '</div>';
}else {
	echo '<div class="container bg-white rounded shadow-sm">';
		if (is_wp_error( $user_id )){
			echo '<div class="bg-danger text-white p-5 mt-5 mb-5">';
				if (is_wp_error($user_id)) {
					echo implode(', ', $user_id->get_error_messages());
				}
			echo '</div>';	
			echo '<div class="go_to_ex_page">';
				echo '<a href="'.get_site_url().'/my-account/?leasing=add_new_user"  class="btn btn-info">بازگشت</a>';
			echo '</div>';
		}
	echo '</div>';
}
