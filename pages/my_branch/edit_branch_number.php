<?php global $wpdb; ?>


<div class="mega_branch_create_user">
	<div class="mbcu_header_title">
        <h1><span>ویرایش شماره تماس نماینده</span></h1>
    </div>
	<div class="mega_ordere_page d-flex flex-wrap mega_branch_create_user container">
		<div class="bg-light text-dark p-4 general_form_width">
			<div class="mbcu_item col-12">
				<label for="fist_name"><span><abbr title="آیتم الزامی ـ حتما باید این فیلد را با مقدار صحیح پر کنید">*</abbr></span>انتخاب نماینده</label>
				<select name="branches" required onchange='change_branch_user(jQuery(this).val() , "branch_edit_user");' class="sel2">

					<option>نماینده</option>
					<?php 
						$lid = get_current_user_id();
						
						if (current_user_can('administrator')){
							$sql = "SELECT * FROM `edu_usermeta` WHERE `meta_key` LIKE 'edu_capabilities' AND `meta_value` LIKE '%branch%'";
						}else{
							$sql = "SELECT user_id FROM `edu_usermeta` WHERE `branch_leasing_employee_id` =  '{$lid}';";
						}
						$branches = $wpdb->get_results ($sql);
						foreach($branches as $uid):
							$buser = get_user_by("ID" , $uid->user_id);
							echo '<option value="'.$buser->ID.'">'.$buser->data->display_name .  ' | '  . $buser->data->user_login .'</option>';
						endforeach; 
					?>
				</select>
			</div>
			<hr>
			<div class="branch_edit_user mbcu_item col-12">
				
			</div>

			
			<div class="mbcu_submit col-12 mt-5">
				<button onclick="update_branch_number('<?php echo get_current_user_id();?>' , '<?php echo $buser ->data ->ID ;?>' , 'branch_edit_user')" class="btn btn-success">بروز رسانی نماینگی </button>
			</div>

		</div>
	</div>

</div>