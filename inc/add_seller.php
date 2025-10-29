<?php 
$path = preg_replace('/wp-content.*$/','',__DIR__);
include($path.'wp-load.php');

$request_body = file_get_contents('php://input');
$data = json_decode($request_body);

$user_data = array(
	'user_pass'								=> wp_hash_password($data->branch_mobile),
	'user_login'							=> $data->branch_mobile,
	'user_nicename'							=> $data->branch_mobile,
	'user_url'								=> get_site_url(),
	'user_email'							=> '',
	'display_name'							=> $data->fist_name.' '.$data->last_name,
	'nickname'								=> $data->fist_name.' '.$data->last_name,
	'first_name'							=> $data->first_name,
	'last_name'								=> $data->last_name,
	'description'							=> 'نمایندگی شماره : ' .$data->branch_serial_number,
	'user_registered'						=> date("Y-m-d H:i:s"),
	'show_admin_bar_front'					=> false,
	'role'									=> 'seller',
);
$user_id = wp_insert_user( $user_data );

$meta_input = array(
	'branch_leasing_employee_id' 		=> $data->employee,
	'branch_owner_id_cart_number' 		=> $data->branch_id_number,
	'branch_province' 					=> $data->branch_state,
	'branch_city' 						=> $data->branch_city,
	'branch_adress' 					=> $data->branch__address,
	'brach_zip_code' 					=> $data->branch_zip_postal_code,
	'brach_mobile_number' 				=> $data->branch_mobile,
	'brach_phone_number' 				=> $data->branch_phone,
	'branch_contract_serial' 			=> $data->branch_contract_serial,
	'branch_serial_number' 				=> $data->branch_serial_number,
);
foreach($meta_input as $key => $value){
	update_user_meta($user_id , $key , $value);
}

if ( ! is_wp_error( $user_id ) ) {
	$html = '<div class="resp_add_user">';
		$html .= '<div class="rau_info">';
			$html .= '<div class="rau_info_hint">';
				$html .= '<h3>حساب کاربری فروشنده با موفقیت ایجاد گردید .</h3>';
			$html .= '</div>';
			$html .= '<div class="rau_info_main">';
				$html .= '<div><span> نام و نام خانوادگی  : </span><span><strong>'.get_user_meta($user_id , 'first_name', true). ' '.get_user_meta($user_id , 'last_name', true) .'</strong></span></div>';
				$html .= '<div><span> کد فروشنده  : </span><span><strong>'.get_user_meta($user_id , 'branch_serial_number' , true).'</strong></span></div>';
			$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class="rau_more">';
			$html .= '<a href="'.get_site_url().'/my-account/?leasing=add_new_user" class="add_other_new_branch" >ایجاد فروشنده جدید</a>';
			$html .= '<a href="'.get_site_url().'/my-account" class="return_to_dashboard">بازگشت به داشبورد</a>';
		$html .= '</div>';
	$html .= '</div>';
	echo $html;
}else {
	print_r(is_wp_error( $user_id ));
}
