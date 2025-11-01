<?php 

	if(isset($_GET['order_id'])){
		

		$order_promotion = get_post_meta($_GET['order_id'] , '_order_promotion' , true);
		$discount_percentage = get_post_meta($_GET['order_id'] , 'discount_percentage' , true);
		$total = get_post_meta($order->get_id() , '_order_total' , true);
		if ($order_promotion > 0){
			$total = $order->get_total();
			if ($discount_percentage >0){
				$oppp = ($total * $discount_percentage )/100;
				if ($oppp == $order_promotion){

					// ///////////////////////////////////////////////////////////////// 
					// calculate pay able part of order 
					// /////////////////////////////////////////////////////////////////
					$pey_ = $total - $order_promotion ; 
				}else{


					// ///////////////////////////////////////////////////////////////// 
					// if $order_promotion not equal to $oppp .
					// if the plan is not equal to bmi plan or some none discountable plans .
					// /////////////////////////////////////////////////////////////////


					if ($plan_id != '54679' ){
						if ($plan_id != '59905'){
							$disoff_1 = 500000000; $disoff_2 = 1000000000; $off_1 = 3 ; $off_2 = 4 ; $off_3 = 5 ; 
						}
					}else{
						$disoff_1 = 0; $disoff_2 = 0; $off_1 = 0 ; $off_2 = 0 ; $off_3 = 0 ;
					}

					// ///////////////////////////////////////////////////////////////// 
					// calculate undifined promption for othe order 
					// /////////////////////////////////////////////////////////////////
					
					
					if($disoff_1 >= $total){
						$off_1 =3;
						$promotion = $total * $off_1  / 100 ;
						$discount_percentage = $off_1;  
						$pey_ = $total - $promotion ; 
					}elseif($disoff_1 < $total & $disoff_2 >= $total){
						if ($off_1 != 0 & $off_2 !=0){
							$promotion = $total * $off_2  / 100 ;
							$discount_percentage = $off_2;  
							$pey_ = $total - $promotion ;  
						}elseif ($off_2==0){ 
							$promotion = $total * $off_1  / 100 ;
							$discount_percentage = $off_1;  
							$pey_ = $total - $promotion ;
						}
					}elseif( $disoff_2 < $total  ){
						
						if ($off_3 !=0)	{
							$promotion = $total * $off_3  / 100 ;
							$discount_percentage = $off_3;  
							$pey_ = $total - $promotion ;  
						}elseif ($off_2 != 0 )	{
							$promotion = $total * $off_2  / 100 ;
							$discount_percentage = $off_2;  
							$pey_ = $total - $promotion ;  
						}elseif ($off_1 != 0)	{
							$promotion = $total * $off_1  / 100 ;
							$discount_percentage = $off_1;  
							$pey_ = $total - $promotion ;  
						}else{
							$promotion  = 0 ; 
							$discount_percentage = 0 ;
							$pey_ = $total - $promotion ;
						}
					}else{

						// ///////////////////////////////////////////////////////////////// 
						// this order id dosent contain any discount for any customers 
						// /////////////////////////////////////////////////////////////////
						$promotion  = 0 ; 
						$discount_percentage = 0 ;
						$pey_ = $total - $promotion ;
					}

					$promotion  = 0 ; 
					$discount_percentage = 0 ;
					$pey_ = $total - $promotion ;



				}
			}

		}else{
			// ///////////////////////////////////////////////////////////////// 
			// if $order_promotion not equal to $oppp .
			// if the plan is not equal to bmi plan or some none discountable plans .
			// /////////////////////////////////////////////////////////////////


			if ($plan_id != '54679' ){
				if ($plan_id != '59905'){
					$disoff_1 = 500000000; $disoff_2 = 1000000000; $off_1 = 3 ; $off_2 = 4 ; $off_3 = 5 ; 
				}
			}else{
				$disoff_1 = 0; $disoff_2 = 0; $off_1 = 0 ; $off_2 = 0 ; $off_3 = 0 ;
			}

			// ///////////////////////////////////////////////////////////////// 
			// calculate undifined promption for othe order 
			// /////////////////////////////////////////////////////////////////
			
			
			if($disoff_1 >= $total){
				$off_1 =3;
				$promotion = $total * $off_1  / 100 ;
				$discount_percentage = $off_1;  
				$pey_ = $total - $promotion ; 
			}elseif($disoff_1 < $total & $disoff_2 >= $total){
				if ($off_1 != 0 & $off_2 !=0){
					$promotion = $total * $off_2  / 100 ;
					$discount_percentage = $off_2;  
					$pey_ = $total - $promotion ;  
				}elseif ($off_2==0){ 
					$promotion = $total * $off_1  / 100 ;
					$discount_percentage = $off_1;  
					$pey_ = $total - $promotion ;
				}
			}elseif( $disoff_2 < $total  ){
				
				if ($off_3 !=0)	{
					$promotion = $total * $off_3  / 100 ;
					$discount_percentage = $off_3;  
					$pey_ = $total - $promotion ;  
				}elseif ($off_2 != 0 )	{
					$promotion = $total * $off_2  / 100 ;
					$discount_percentage = $off_2;  
					$pey_ = $total - $promotion ;  
				}elseif ($off_1 != 0)	{
					$promotion = $total * $off_1  / 100 ;
					$discount_percentage = $off_1;  
					$pey_ = $total - $promotion ;  
				}else{
					$promotion  = 0 ; 
					$discount_percentage = 0 ;
					$pey_ = $total - $promotion ;
				}
			}else{

				// ///////////////////////////////////////////////////////////////// 
				// this order id dosent contain any discount for any customers 
				// /////////////////////////////////////////////////////////////////
				$promotion  = 0 ; 
				$discount_percentage = 0 ;
				$pey_ = $total - $promotion ;
			}
		}

		$promotion  = 0 ; 
		$discount_percentage = 0 ;
		$pey_ = $total - $promotion ;
		update_post_meta($order->get_id() , '_order_promotion' , $promotion);
		update_post_meta($order->get_id() , 'discount_percentage' , $discount_percentage );
		update_post_meta($order->get_id() , '_pay_able_part' , $pey_);
	}else{
		die('سفارش ست نشده است .');
	}

	
	