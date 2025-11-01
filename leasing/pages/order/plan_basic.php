<?php 
	if (isset($_SESSION['plan_id'])){

		$plan_id = $_SESSION['plan_id'];
		
		if ($plan_id != '54679' ){
			if ($plan_id != '59905'){
				$disoff_1 = 500000000; $disoff_2 = 1000000000; $off_1 = 3 ; $off_2 = 4 ; $off_3 = 5 ; 
			}
		}else{
			$disoff_1 = 0; $disoff_2 = 0; $off_1 = 0 ; $off_2 = 0 ; $off_3 = 0 ;
		}

		
		if ($_SESSION['plan_id'] != '44804' || $_SESSION['plan_id'] != '44804'){
			$palan_precent 		= get_post_meta($plan_id , 'Interest_rate' , true);
		}else{
			$palan_precent 		=0;
		}
		
		
		$banck_account 		= get_post_meta($plan_id , 'bank_account' ,true);
		$shaba_account 		= get_post_meta($plan_id , 'shaba_account' ,true);
		$banck_branch_code 	= get_post_meta($plan_id , 'banck_branch_code' ,true);
		$bank_name 			= get_post_meta($plan_id , 'bank_name' ,true);
		
	}
?>