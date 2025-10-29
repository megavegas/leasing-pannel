<?php if (isset($_GET)){if (isset($_GET['branch_id'])){$buser = get_user_by('ID' , $_GET['branch_id']);}} ?>

<?php 
	
	global $wpdb;

	

	$t1= $wpdb->prefix . 'terms';
	$t2= $wpdb->prefix . 'term_taxonomy';
	$sql = "SELECT B.term_id , B.name FROM `edu_term_taxonomy`as A INNER JOIN `edu_terms` AS B on A.term_id = B.term_id WHERE A.parent='0' and A.taxonomy='state_city';";
	$states  = $wpdb -> get_results($sql);

?>
<div class="mega_branch_create_user">
	<div class="mbcu_header_title">
        <h1><span>ویرایش نمایندگی</span></h1>
    </div>
	<div class="mega_ordere_page d-flex flex-wrap mega_branch_create_user container">
		<div class="bg-light text-dark p-4 general_form_width">
			<div class="mbcu_item col-lg-6 col-md-12">
				<label for="fist_name"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>نام</label>
				<input type="text" name="branch_first_name" value="<?php echo get_user_meta($buser ->data ->ID , 'first_name' , true); ?>" required>
			</div>
			<div class="mbcu_item col-lg-6 col-md-12">
				<label for="last_name"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>نام خانوادگی </label>
				<input type="text" name="branch_last_name" value="<?php echo get_user_meta($buser ->data ->ID , 'last_name' , true) ; ?>" required>
			</div>
			<div class="mbcu_item col-12">
				<label for="user_id_number"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>کد ملی نماینده</label>
				<input type="text" name="branch_id_number" required size="10"  value="<?php echo get_user_meta($buser ->data ->ID , 'branch_owner_id_cart_number' , true) ; ?>">
			</div>
			<hr>
			
			<div class="mbcu_item col-lg-6 col-md-12 states">
				<label for="user_state"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>استان</label>
				<select name="branch_state" required onchange='changes_the_state_cities(jQuery(this).val());'>

					<option disabled>استان مورد نظر خود را انتخاب کنید</option>
					<?php 
						$user_state = get_user_meta($buser ->data ->ID , 'branch_state' , true) ;
						foreach($states as $stat):
						if ($user_state == $stat->term_id ){
							echo '<option value="'.$stat->term_id.'" selected>'.$stat->name.'</option>';
						}else{
							echo '<option value="'.$stat->term_id.'">'.$stat->name.'</option>';
						}
						endforeach; 
					?>
				</select>
			</div>

			<div class="mbcu_item col-lg-6 col-md-12 city">
				<label for="user_city"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>شهر</label>
				<select name="branch_city" required >
					<option disabled>شهر مورد نظر خود را انتخاب کنید</option>
				</select>
			</div>
			
			<div class="mbcu_item col-12">
				<label for="user_address"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>آدرس فروشگاه</label>
				<input type="text" name="branch__address" value="<?php echo get_user_meta($buser ->data ->ID , 'user_address' , true) ; ?>"  required>
			</div>
			
			<div class="mbcu_item col-12">
				<label for="zip_postal_code"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>کدپستی فروشگاه</label>
				<input type="text" name="branch_zip_postal_code" value="<?php echo get_user_meta($buser ->data ->ID , 'zip_postal_code' , true) ; ?>" required size="10">
			</div>
			<hr>
			<div class="mbcu_item col-lg-6 col-md-12">
				<label for="user_phone"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>تلفن ثابت فروشگاه </label>
				<input type="text" name="branch_phone" value="<?php echo get_user_meta($buser ->data ->ID , 'user_phone' , true) ; ?>" required>
			</div>
			<div class="mbcu_item col-lg-6 col-md-12">
				<label for="user_mobile"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>تلفن همراه نماینده</label>
				<input type="text" name="branch_mobile" value="<?php echo get_user_meta($buser ->data ->ID , 'user_mobile' , true) ; ?>" required size="11">
			</div>

			<div class="mbcu_item col-12">
				<label for="user_mobile"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>کد قرارداد</label>
				<input type="text" name="branch_contract_serial" value="<?php echo get_user_meta($buser ->data ->ID , 'branch_contract_serial' , true) ; ?>"  required>
			</div>

			<div class="mbcu_item col-12">
				<label for="user_mobile"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>کد شش رقمی نمایندگی</label>
				<input type="text" name="branch_serial_number" value="<?php echo get_user_meta($buser ->data ->ID , 'branch_serial_number' , true) ; ?>" required>
			</div>

			<hr>
			<div class="mbcu_submit col-12 mt-5">
				<button onclick="update_branch_now('<?php echo get_current_user_id();?>' , '<?php echo $buser ->data ->ID ;?>')" class="btn btn-success">بروز رسانی نماینگی </button>
			</div>

		</div>
	</div>

</div>