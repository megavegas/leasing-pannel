<?php $emp_id = get_current_user_id();?>
<div class="mega_branch_create_user">
	<div class="mbcu_header_title">
        <h1><span>ویرایش حساب کاربری من</span></h1>
    </div>
	<div class="mega_ordere_page d-flex flex-wrap mega_branch_create_user container">
		<div class="bg-white text-dark p-4 general_form_width">
			<div class="mbcu_item col-lg-6 col-md-12">
				<label for="fist_name"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>نام</label>
				<input type="text" name="first_name" value="<?php echo get_user_meta($emp_id , 'first_name' , true); ?>" required>
			</div>
			<div class="mbcu_item col-lg-6 col-md-12">
				<label for="last_name"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>نام خانوادگی </label>
				<input type="text" name="last_name" value="<?php echo get_user_meta($emp_id , 'last_name' , true) ; ?>" required>
			</div>
			<div class="mbcu_item col-12">
				<label for="user_id_number"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>کد ملی نماینده</label>
				<input type="text" name="user_id_number" required size="10"  value="<?php echo get_user_meta($emp_id , 'user_id_number' , true) ; ?>">
			</div>
			<hr>
			
			<div class="mbcu_item col-12 states">
				<label for="user_state"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>منطقه</label>
				
				
				<?php 
					$region_sql = "SELECT * FROM `edu_regions_global` WHERE 1;";
					$regions = $wpdb->get_results($region_sql);
				?>
				<select name="leasing_employee_zone" required>

					<option disabled>منطقه مورد نظر خود را انتخاب کنید</option>
					<?php 
						$user_state = get_user_meta($emp_id , 'leasing_employee_zone' , true) ;
					?>
					<?php 
						$h = '';
						$i=1;
						foreach($regions as $region){
							if ($user_state == $region->id){
								$h .='<option value="'.$region->id.'" selected>'.$region->name.' '.$i.'</option>';
							}else{
								$h .='<option value="'.$region->id.'">'.$region->name.' '.$i.'</option>';
							}
							
							$i++;
						}
						
						echo $h ; 
					?>
				</select>
			</div>

			<div class="mbcu_item col-12">
				<label for="user_mobile"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>تلفن همراه</label>
				<input type="text" name="user_mobile" value="<?php echo get_user_meta($emp_id , 'user_mobile' , true) ; ?>" required size="11">
			</div>

			<div class="mbcu_item col-12">
				<label for="employee_contract_code"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>کد قرارداد</label>
				<input type="text" name="employee_contract_code" value="<?php echo get_user_meta($emp_id , 'employee_contract_code' , true) ; ?>"  required>
			</div>

			<div class="mbcu_item col-12">
				<label for="arian_tafzili_code"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>کد تفضیلی آرین</label>
				<input type="text" name="arian_tafzili_code" value="<?php echo get_user_meta($emp_id , 'arian_tafzili_code' , true) ; ?>" required>
			</div>

			<hr>
			<div class="mbcu_submit col-12 mt-5">
				<button onclick="update_me_now('<?php echo get_current_user_id();?>')" class="btn btn-success">بروز رسانی </button>
			</div>

		</div>
	</div>

</div>