<?php 
global $wpdb ; 
$table_name = $wpdb -> prefix.'posts';
$table_name2 = $wpdb -> prefix.'postmeta';
$sql_plans = "SELECT * FROM `{$table_name}` WHERE (`post_status`='publish' OR `post_status`='private') AND `post_type`='leasing_plans';";
$sql = "
	SELECT * FROM `{$table_name}` AS a 
	INNER JOIN `{$table_name2}` AS b 
	ON a.ID = b.post_id 
	WHERE a.post_status='publish' 
	AND a.post_type = 'leasing_plans' 
	AND b.meta_key = 'number_plan' 
	AND b.meta_value > 0
	ORDER BY b.meta_value ASC ;
";

$all_plans = $wpdb -> get_results($sql);
$hp = '';
foreach($all_plans as $plan){
	$hp .='<option value="'.$plan->ID.'">'.$plan->post_title.'</option>';
}

$cid = get_current_user_id() ; 
$sql_leasing_role_branch = "SELECT a.user_id as ID FROM `edu_usermeta` as a WHERE a.meta_key like '%cap%' AND a.meta_value like '%branch%'";
$all_branches = $wpdb->get_results($sql_leasing_role_branch);
$hb = '';
foreach($all_branches as $user){
	$hb .='<option value="'.$user->ID.'">'.get_user_meta($user->ID , 'first_name' , true) .' '. get_user_meta($user->ID , 'last_name' , true) .' - '. get_user_meta($user->ID , 'brach_mobile_number' , true) .'</option>';
}

?>
<style>
	.new_product_added_to_order {
		padding: 30px;
		border: 1px solid gainsboro;
		margin: 20px 0 20px 0;
		border-radius: 5px;
		background: ghostwhite;
		text-align: right;
	}

	.new_product_added_to_order * {
		text-align: right !important;
	}
	.added_to_order {
		border: 1px solid gainsboro;
		background: ghostwhite;
		border-radius: 5px;
		display: flex;
		justify-content: flex-start;
		align-items: flex-start;
		flex-wrap: wrap;
		padding: 10px 0 0 0;
	}

	.added_item {
		width: 100%;
		display: flex;
		justify-content: space-between;
		align-items: center;
		border: 1px solid gainsboro;
		padding: 10px;
		margin: 0px 10px 10px;
		border-radius: 10px;
		background: #fff;
	}

	.added_item img {width: 50px;}
</style>
<div class="container mt-5 mb-5">
	<div class="inner_page_title">
		<h1>ساخت سفارش</h1>
	</div>
</div>
<div class="container mt-5 mb-5">
	<div class="create_custome_invoice col-12">
		<div class="cci_item d-flex flex-wrap">
			<label>انتخاب طرح</label>
			<select name="plan" class="sel2">
				<?php echo $hp; ?>
			</select>
		</div>
		<div class="cci_item d-flex flex-wrap">
			<label>انتخاب نماینده</label>
			<select name="branches" onchange="load_customers_of_branch()"  class="sel2">
				<?php echo $hb; ?>
			</select>
		</div>
		
		<div class="cci_item d-flex flex-wrap">
			<label>انتخاب مشتری</label>
			<select name="load_customers" class="sel2">
				
			</select>
		</div>


		
		<div calss="col-12 border rounded shadow-sm">
			<div class="new_product_added_to_order">
				<label>محصول جدید</label>
				<select name="the_product" onchange="bc_qty_price_new_corder()" class="sel2">
					<option>انتخاب محصول</option>
					<?php 
						$sql = "SELECT `ID` , `post_title` FROM `edu_posts` WHERE `post_status` LIKE 'publish' AND `post_type` LIKE 'product';";
						$products = $wpdb->get_results($sql);

						$hpro = '';
						foreach($products as $prod){
							$product = wc_get_product($prod->ID);
							if ($product){
								$hpro .= '<option value="'.$prod->ID.'">'.$prod->post_title.'  | '.$product->get_stock_status() . ' | '.$product->get_stock_quantity().'</option>';
							}
							
						}
						echo $hpro ;
					?>
				</select>

				<div class="col-12 load_items_of_product"></div>
			</div>
			<div class="">
				<label></label>
				<button onclick="add_new_product_to_customer_order()">افزودن محصول +</button>
			</div>
			<div class="added_to_order"></div>
		
					
			<div class="">
				<label></label>
				<input type = "submit" name="submit_custom_order">
			</div>
		</div>
		
	</div>
</div>


<?php 
