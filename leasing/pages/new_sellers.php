<?php 

	global $wpdb;

	if (isset($_POST['new_branch_submit'])){
		print_r($_POST);
		if (isset($_POST['first_name'])){$first_name = $_POST['first_name'];}
		else {$first_name = '';}
		
		if (isset($_POST['last_name'])){$last_name = $_POST['last_name'];}
		else {$last_name = '';}
		
		if (isset($_POST['user_id_number'])){$user_id_number = $_POST['user_id_number'];}
		else {$user_id_number = '';}
		
		if (isset($_POST['user_state'])){$user_state = $_POST['user_state'];}
		else {$user_state = '';}
		
		if (isset($_POST['user_city'])){$user_city = $_POST['user_city'];}
		else {$user_city = '';}
		
		if (isset($_POST['user_address'])){$user_address = $_POST['user_address'];}
		else {$user_address = '';}
		
		if (isset($_POST['user_phone'])){$user_phone = $_POST['user_phone'];}
		else {$user_phone = '';}
		
		if (isset($_POST['user_mobile'])){$user_mobile = $_POST['user_mobile'];}
		else {$user_mobile = '';}

		if (isset($_POST['zip_postal_code'])){$zip_postal_code = $_POST['zip_postal_code'];}
		else {$zip_postal_code = '';}

		if ($user_mobile!=''){
			$user_data = array(
				'user_login' 			=> $_POST['user_mobile'],
				'user_pass' 			=> wp_hash_password($user_id_number),
				'display_name' 			=> $_POST['first_name'].' '.$_POST['last_name'],
				'user_url'				=> get_site_url(),
			);

			$user_id = wp_insert_user($user_data);
			if (! is_wp_error( $user_id )){
				
				$meta_inputs = array(
					'child_of'=> 'branch' , 
					'maker_branch_id'		=> get_current_user_id(),
					'user_id_number' 		=> $user_id_number,
					'user_state'			=> $user_state,
					'user_city'				=> $user_city,
					'user_address'			=> $user_address,
					'user_phone'			=> $user_phone,
					'user_mobile'			=> $user_mobile,
					'first_name' 			=> $first_name,
					'last_name'	 			=> $last_name,
					'zip_postal_code'		=> $zip_postal_code,
					'user_phone_number'		=> $_POST['user_mobile'],
					'show_admin_bar_front' 	=> false,
					'role' 					=> 'seller',
				);
				foreach($meta_inputs as $k => $value){
					update_user_meta($user_id , $k , $value );
				}
				echo 'کاربر مصرف کننده با شماره شناسه'.$user_id.' در سیستم ثبت شد .<br>';
				echo 'نام کاربر : '.$first_name .' '.$last_name.'<br>';
				echo 'تلفن کاربر : '.$_POST['user_mobile'].'<br>';
				echo 'کدپستی کاربر : '.$zip_postal_code.'<br>';
				echo '<hr>';
			}else{
				echo "تعریف کاربر جدید با مشکل مواجه شد .<hr>";
			}
		}
		
	}

	$t1= $wpdb->prefix . 'terms';
	$t2= $wpdb->prefix . 'term_taxonomy';
	$sql = "SELECT B.term_id , B.name FROM `edu_term_taxonomy`as A INNER JOIN `edu_terms` AS B on A.term_id = B.term_id WHERE A.parent='0' and A.taxonomy='state_city';";
	$states  = $wpdb -> get_results($sql);

?>
<div class="mega_branch_create_user container">
    <div class="mbcu_header_title">
        <h1>
            <span>افزودن نمایندگی ( عاملیت فروش )</span>
            <span>[ <span><?php echo get_bloginfo('name'); ?></span> ]</span>
        </h1>
    </div>

	
    <div class="mbcu_inner d-flex flex-wrap">
		<div class="mbcu_item col-lg-6 col-md-12">
			<label for="fist_name"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>نام</label>
			<input type="text" name="branch_first_name" required>
		</div>
		<div class="mbcu_item col-lg-6 col-md-12">
			<label for="last_name"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>نام خانوادگی </label>
			<input type="text" name="branch_last_name" required>
		</div>
		<div class="mbcu_item col-12">
			<label for="user_id_number"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>کد ملی نماینده</label>
			<input type="text" name="branch_id_number" required size="10">
		</div>
		<hr>
		
		<div class="mbcu_item col-lg-6 col-md-12 states">
			<label for="user_state"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>استان</label>
			<select name="branch_state" required onchange='changes_the_state_cities(jQuery(this).val());'>
				<option disabled>استان مورد نظر خود را انتخاب کنید</option>
				<?php foreach($states as $stat):?>	
					<option value="<?php echo $stat->term_id; ?>"><?php echo $stat->name; ?></option>
				<?php endforeach; ?>
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
			<input type="text" name="branch__address"  required>
		</div>
		
		<div class="mbcu_item col-12">
			<label for="zip_postal_code"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>کدپستی فروشگاه</label>
			<input type="text" name="branch_zip_postal_code" required size="10">
		</div>
		<hr>
		<div class="mbcu_item col-lg-6 col-md-12">
			<label for="user_phone"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>تلفن ثابت فروشگاه </label>
			<input type="text" name="branch_phone" required>
		</div>
		<div class="mbcu_item col-lg-6 col-md-12">
			<label for="user_mobile"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>تلفن همراه نماینده</label>
			<input type="text" name="branch_mobile" required size="11">
		</div>

		<div class="mbcu_item col-12">
			<label for="user_mobile"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>کد قرارداد</label>
			<input type="text" name="branch_contract_serial" required>
		</div>

		<div class="mbcu_item col-12">
			<label for="user_mobile"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>کد شش رقمی نمایندگی</label>
			<input type="text" name="branch_serial_number" required>
		</div>

		<hr>
		<div class="mbcu_submit col-12">
			<button onclick="register_branch('<?php echo get_current_user_id();?>')" class="register_button">ثبت نام نمایندگی</button>
		</div>

    </div>
</div>