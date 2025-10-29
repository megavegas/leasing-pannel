<?php
	$path = preg_replace('/accounts.*$/','',__DIR__);
	include($path.'wp-load.php');
	if (isset($_POST['leasing_employee'])){
		$lemp = $_POST['leasing_employee'] ; 
	}else{
		$lemp = 0;
	}
	if (isset($_POST['product'])){
		$product = $_POST['product'] ; 
	}else{
		$product = 0;
	}

	if (isset($_POST['target_id'])){
		$target = $_POST['target_id'] ; 
	}else{
		$target = 0;
	}
	
	if ($lemp != 0 && $product != 0 && $lemp == get_current_user_id()){
		$sql_branches = "
			SELECT 
			a.user_id as branch_id,
			b.meta_value as first_name,
			c.meta_value as last_name,
			d.meta_value as mobile
			from edu_usermeta as a
			LEFT JOIN edu_usermeta as b on a.user_id = b.user_id
			LEFT JOIN edu_usermeta as c on a.user_id = c.user_id
			LEFT JOIN edu_usermeta as d on a.user_id = d.user_id
			WHERE a.meta_key LIKE 'branch_leasing_employee_id' AND
			a.meta_value LIKE '{$lemp}' AND
			b.meta_key LIKE 'first_name' AND
			c.meta_key LIKE 'last_name' AND
			d.meta_key LIKE 'brach_mobile_number'
		";
		global $wpdb ; 
		
		$all_branches =$wpdb -> get_results($sql_branches) ;
		$product_items = wc_get_product($product);
		if ($product_items && $all_branches){
			// print_r($all_branches);
			echo '<div class="w=100">';
				echo '<div class="product_target_set border rounded mb-4 p-2 d-flex">';
					echo '<img src="'.wp_get_attachment_image_url($product_items->get_image_id() , 'thumbnail').'" width="100px" height="100px">';
					echo '<div class="">'.$product_items->get_name().'</div>';;
				echo '</div>';
				echo '<div class="item_in_list border rounded mb-4 p-2">';
					echo '<label class="col-12">انتخاب نمایندگی:</label>';
					echo '<select name="select_branch_for_targeting" class="sel2 w-100">';
						echo '<option>انتخاب یک نماینده</option>';
						foreach($all_branches as $branch){
							echo '<option value="'.$branch->branch_id.'">'.$branch->first_name .' '.$branch->last_name .' | ' .$branch->mobile.'</option>';
						}
					echo '</select>';

					echo '<label class="col-12">تعداد : </label>';
					echo '<input type="number" name="qty_for_product" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">';
					echo '<input type="hidden" name="product_id" value="'.$product.'">';
					echo '<input type="hidden" name="leasing_employee" value="'.$lemp.'">';
					echo '<input type="hidden" name="target_id" value="'.$target.'">';
				echo '</div>';

				echo '<div class="p-4 mb-2"><button onclick="save_product_target_for_branch()">ذخیره</button></div>';
				echo '<script>jQuery(".sel2").select2();</script>';
			echo '</div>';
		}else{

		}
		
	}

?>
<div class="">

</div>