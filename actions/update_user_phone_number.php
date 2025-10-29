<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');
global $wpdb ; 
if (isset($_POST)){
	if (isset($_POST['branch_number'])){
		if (isset($_POST['branch_id'])){

			$id 						= $_POST['branch_id'];
			$user_mobile 				= $_POST['branch_number'];
			$user_old_mobile 			= get_user_by('ID',$id)->data->user_login;
			$userx						= get_user_by('ID',$id);

			if ($userx){
				$ud = array(
					'user_login' 	=> $user_mobile, // نام کاربری جدید
					'user_pass'  	=> wp_hash_password($user_mobile), // پسورد جدید
					'user_nicename'		=> $user_mobile,
					'user_email'	=> $user_mobile.'@hamta-gp.com',
				);
				$uw = array( 'ID' => $_POST['branch_id']);
				$updated = $wpdb->update($wpdb->prefix.'users',$ud , $uw);

				$userd = get_user_by( 'ID' ,  $id );
				update_user_meta($id , 'user_mobile' 			, $user_mobile);
				update_user_meta($id , 'brach_mobile_number' 	, $user_mobile);
				update_user_meta($id , 'old_mobile' 			, $user_old_mobile);

				if ( false === $updated ) {
				
					echo $wpdb->last_error;
					echo $wpdb->last_query ; 
				} else {
					echo 'اطلاعات کاربر با موفقیت به‌روزرسانی شد.';
				}

			}else{echo 'no';}
		}else{echo 'error_1';}
	}else{echo 'error_2';}
}else{echo 'error_3';}