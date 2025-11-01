<?php 
$args = array(
	'role'=>'branch',
);
$get_users = get_users($args);
?>
<div class="mbcu_header_title">
	<h1>
		<span>حذف نمایندگی </span>
		<span>[ <span><?php echo get_bloginfo('name'); ?></span> ]</span>
	</h1>
	<div class="remove_branch_seller_allert">
		در نظر داشته باشید که حذف نمایندگی غیر قابل بازگشت است لذا در خصوص حذف نمایندگی ها پیش از هر اقدامی کاملا اطمینان حاصل فرمایید .
	</div>
</div>
<table>
    <thead>
        <tr>
            <th>ردیف</th>
            <th>نام و نام خانوادگی</th>
            <th>کد نمایندگی</th>
			<td>حذف</td>
        </tr>
    </thead>
    <tbody>
		<?php $i=1; foreach($get_users as $user):?>
			<tr user_id="<?php echo $user->data->ID; ?>">
				<td><?php echo $i; ?><hr style="margin:0px;"><?php echo $user->data->ID; ?></td>
				<td>
					<?php echo get_user_meta($user->data->ID, 'first_name' , true).' '. get_user_meta($user->data->ID, 'last_name' , true);?>
				</td>
				<td>
					<?php echo get_user_meta($user->data->ID , 'branch_serial_number', true);?>
				</td>
				<td>
					<button onclick="remove_branch_by_employee('<?php echo $user->data->ID ?>')">حذف نماینده</button>
				</td>
				
			</tr>
		<?php $i++ ; endforeach ; ?>
    </tbody>
</table> 


