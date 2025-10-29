<?php 
$args = array(
	'role'=>'seller',
);
$get_users = get_users($args);

?>
<div class="mbcu_header_title">
	<h1>
		<span>تبدیل فروشنده به نماینده</span>
		<span>[ <span><?php echo get_bloginfo('name'); ?></span> ]</span>
	</h1>
</div>
<table>
    <thead>
        <tr>
            <th>ردیف</th>
            <th>نام و نام خانوادگی</th>
			<td>تبدیل</td>
        </tr>
    </thead>
    <tbody>
		<?php $i=1; foreach($get_users as $user):?>
			<tr user_id="<?php echo $user->data->ID; ?>">
				<td><?php echo $i; ?><hr style="margin:0px;"><?php echo $user->data->ID; ?></td>
				<td>
					<?php echo get_user_meta($user->data->ID, 'first_name' , true);?> <?php echo get_user_meta($user->data->ID, 'last_name' , true);?>
				</td>
				
				<td>
					<button onclick="seller_to_branch_by_employee('<?php echo $user->data->ID ?>')">تبدیل به نمایندگی</button>
				</td>
				
			</tr>
		<?php $i++ ; endforeach ; ?>
    </tbody>
</table> 


