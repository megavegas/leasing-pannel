<?php 
$args = array(
	'role'=>'seller',
);
$get_users = get_users($args);
?>
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


