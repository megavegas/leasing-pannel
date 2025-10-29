<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');
$message = array();

if (isset($_POST['branch_id'])){
	$user = get_user_by('ID' , $_POST['branch_id']);
	if ($user){

		$message ['cond_one']= 'true';
		$message ['user_id']= $_POST['branch_id'];
		$message ['old_number']= $user -> data->user_login ;
		
		$message ['resutl'] ='<label for="fist_name">';
			$message ['resutl'] .= '<span>';
				$message ['resutl'] .= '<abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr>';
			$message ['resutl'] .= '</span>';
			$message ['resutl'] .= 'شماره نماینده';
		$message ['resutl'] .= '</label>';
		$message ['resutl'] .= '<input type ="text" value="'. $user ->data->user_login .'" name="new_branch_number">';
		$message ['resutl'] .= '<input type ="hidden" value="'. $user ->ID .'" name="branch_id">';

	}else{

		$message ['cond_one']= 'false';
		$message ['user_id']= $_POST['branch_id'];
		$message ['resutl'] ='نمایندگی وجود ندارد';

	}
	


}else{
	$message ['cond_one']= 'false';
	$message ['resutl'] ='نمایندگی ست نشده است';
}
echo json_encode($message);