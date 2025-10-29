<?php 
$args = array(
	'role'=>'branch',
);
$get_users = get_users($args);

?>
<div class="mbcu_header_title">
	<h1>
		<span>ویرایش سریع نمایندگی ها</span>
		<span>[ <span><?php echo get_bloginfo('name'); ?></span> ]</span>
	</h1>
</div>
<table>
    <thead>
        <tr>
            <th>ردیف</th>
            <th>نام و نام خانوادگی</th>
            <th>لاگین</th>
			<th>کد نمایندگی</th>
           	<th>شماره موبایل</th>
			<td></td>
        </tr>
    </thead>
    <tbody>
		<?php $i=1; foreach($get_users as $user):?>
			<tr user_id="<?php echo $user->data->ID; ?>">
				<td><?php echo $i; ?><hr style="margin:0px;"><?php echo $user->data->ID; ?></td>
				<td>
					<span><?php echo get_user_meta($user->data->ID, 'first_name' , true);?></span>
					<span> </span>
					<span><?php echo get_user_meta($user->data->ID, 'last_name' , true);?></span>
				</td>
				<td>
					<?php echo $user->data->user_login;?>
				</td>
				<td>
					<?php echo get_user_meta($user->data->ID , 'branch_serial_number', true);?>
				</td>
				<td>
					<?php echo get_user_meta($user->data->ID , 'billing_phone', true);?>
				</td>
				<td>
					<button onclick="edit_branch_user_by_leasing('<?php echo $user->data->ID ?>')">بروز رسانی نماینده</button>
				</td>
				
			</tr>
		<?php $i++ ; endforeach ; ?>
    </tbody>
</table> 

<?php 

// <button onclick="update_user_branch_by_employee('.$user->data->ID.')">بروز رسانی نماینده</button>
