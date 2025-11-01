<?php 
$args = array(
	'role'=>'seller',
);
$get_users = get_users($args);

?>
<div class="mbcu_header_title">
	<h1>
		<span>ویرایش سریع فروشنده</span>
		<span>[ <span><?php echo get_bloginfo('name'); ?></span> ]</span>
	</h1>
</div>
<table>
    <thead>
        <tr>
            <th>ردیف</th>
            <th>نام و نام خانوادگی</th>
            <th>لاگین | کد نمایندگی</th>
           	<th>شماره موبایل</th>
			<td></td>
        </tr>
    </thead>
    <tbody>
		<?php $i=1; foreach($get_users as $user):?>
			<tr user_id="<?php echo $user->data->ID; ?>">
				<td><?php echo $i; ?><hr style="margin:0px;"><?php echo $user->data->ID; ?></td>
				<td>
					<label>نام</label>
					<input type ="text" name="first_name" value="<?php echo get_user_meta($user->data->ID, 'first_name' , true);?>">
					<hr style="margin:0px;">
					<label>نام خانوادگی</label>
					<input type ="text" name="last_name" value="<?php echo get_user_meta($user->data->ID, 'last_name' , true);?>">
				</td>
				<td>
					<label>شناسه کاربری</label>
					<input type ="text" name="user_login" value="<?php echo $user->data->user_login;?>">
					<hr style="margin:0px;">
					<label>کد نماینده</label>
					<input type ="text" name="branch_serial" value="<?php echo get_user_meta($user->data->ID , 'branch_serial_number', true);?>">
				</td>
				<td>
					<label>موبایل نماینده</label>
					<input type ="text" name="billing_phone" value="<?php echo get_user_meta($user->data->ID , 'billing_phone', true);?>">
				</td>
				<td>
					<button onclick="update_user_branch_by_employee('<?php echo $user->data->ID ?>')">بروز رسانی نماینده</button>
				</td>
				
			</tr>
		<?php $i++ ; endforeach ; ?>
    </tbody>
</table> 


