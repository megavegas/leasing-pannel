<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');


if ($_POST){
	if (isset($_POST['leasing_id'])){
		if (isset($_POST['branch_id'])){
			$buser = get_user_by('ID' , $_POST['branch_id']);
			if ($buser) {
				if (in_array('branch', $buser->roles)){
					$user->remove_cap('branch');
					echo "دسترسی نماینده لغو گردید";
					update_user_meta($_POST['branch_id'] , 'i_remove_branch_cap' , $_POST['leasing_id'] );
					update_user_meta($_POST['branch_id'] , 'remove_branch_cap_date' , date('Y:m:d') );
					update_user_meta($_POST['branch_id'] , 'remove_branch_cap_time' , date('h:i:s') );
				}else{
					echo 'این کاربر نماینده نیست';
				}
			}else{
				echo "یوزر یافت نشد";
			}
		}else{
			echo 'نماینده نامشخص است .';
		}
	}else{
		echo "کارشناس فروش نامشخص است";
	}
}else{
	echo "اطلاعات ناقص است ";
}