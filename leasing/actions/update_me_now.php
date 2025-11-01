<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');
global $wpdb;

if (isset($_POST)){
	if (isset($_POST['id'])){
		if (isset($_POST['first_name'])){
			if (isset($_POST['last_name'])){
				if (isset($_POST['user_id_number'])){
					if (isset($_POST['leasing_employee_zone'])){
						if (isset($_POST['user_mobile'])){
							if (isset($_POST['arian_tafzili_code'])){
								if (isset($_POST['employee_contract_code'])){
									$id = $_POST['id'];
									$first_name = $_POST['first_name'];
									$last_name = $_POST['last_name'];
									$user_id_number = $_POST['user_id_number'];
									$leasing_employee_zone = $_POST['leasing_employee_zone'];
									$user_mobile = $_POST['user_mobile'];
									$arian_tafzili_code = $_POST['arian_tafzili_code'];
									$employee_contract_code = $_POST['employee_contract_code'];
									$user = get_user_by('ID',$id);
									if ($user){
										update_user_meta($id , 'first_name' , $first_name);
										update_user_meta($id , 'last_name' , $last_name);
										update_user_meta($id , 'user_id_number' , $user_id_number);
										update_user_meta($id , 'leasing_employee_zone' , $leasing_employee_zone);
										update_user_meta($id , 'user_mobile' , $user_mobile);
										update_user_meta($id , 'arian_tafzili_code' , $arian_tafzili_code);
										update_user_meta($id , 'employee_contract_code' , $employee_contract_code);
										echo 'yes';
									}else{
										echo 'no';
									}
								}
							}
						}
					}
				}
			}
		}
	}
}