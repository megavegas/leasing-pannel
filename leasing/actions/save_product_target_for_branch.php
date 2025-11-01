<?php
	$path = preg_replace('/accounts.*$/','',__DIR__);
	include($path.'wp-load.php');

	if (isset($_POST)){
		if (isset($_POST['branch_id'])){
			$branch = $_POST['branch_id'];

			if (isset($_POST['qty_target'])){
				$qty = $_POST['qty_target'];

				if (isset($_POST['product'])){
					$product = $_POST['product'];
					
					if (isset($_POST['lemp'])){
						$lemp = $_POST['lemp'];

						if (isset($_POST['target'])){
							$target = $_POST['target'];
							
							global $wpdb ; 
							$sql_used = "SELECT `used` FROM `target_products` WHERE `product_id`= '{$product}';";
							$sql_value = "SELECT `qty` FROM `target_products` WHERE `product_id`='{$product}';";
							$used_value =intval( $wpdb->get_var($sql_used));
							$qty_value = intval($wpdb->get_var($sql_value));
							$avalabel_qty =$qty_value - $used_value ; 

							if ($avalabel_qty>=0){
								if ($avalabel_qty - $qty >= 0){
									$data = [
										'branch'				=>intval($branch),
										'product'				=>intval($product),
										'qty'					=>intval($qty),
										'leasing_employee'		=>intval($lemp),
										'target_id'				=>intval($target)
									];
									$table = 'target_branch_product';
									$result = $wpdb->insert($table, $data);
									$new_used_value = intval($qty) + intval($used_value) ; 
									$data_update = ['used'=> $new_used_value];
									$where = [
										'target_id'=>intval($target),
										'product_id'=>intval($product)
									];

									$wpdb->update(
										'target_products',
										$data_update,
										$where	
									);

									if ($result !== false) {
										echo 'yes';
									}else{
										echo 'no';
									}
								}else{
									echo 'شما نمی توانید بیشتر از تارگت هدف گذاری کنید';
								}
								
							}else{
								echo 'میزان تارگت گذاری از تارگت بیشتر است ';
							}
							
								

						}else{echo 'no_6';}
					}else{echo 'no_5';}
				}else{echo 'no_4';}
			}else{echo 'no_3';}
		}else{echo 'no_2';}
	}else{echo 'no_1';}