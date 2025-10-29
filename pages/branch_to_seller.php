<?php 
$args = array(
	'role'=>'branch',
);
$get_users = get_users($args);

?>
<div class="mbcu_header_title">
	<h1>
		<span>تبدیل نمایندگی به فروشنده</span>
		<span>[ <span><?php echo get_bloginfo('name'); ?></span> ]</span>
	</h1>
</div>
<table class="tbl_branch_to_other_types">
    <thead>
        <tr>
            <th>ردیف</th>
            <th>نام و نام خانوادگی</th>
			<td>تبدیل به فروشنده</td>
			<td>تبدیل به نماینده</td>
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
					<button onclick="branch_to_seller_by_employee('<?php echo $user->data->ID ?>')" class="btn btn-info">فروشنده</button>
				</td>
				<td>
					<button onclick="branch_to_seller_by_employee('<?php echo $user->data->ID ?>')"  class="btn btn-danger">مصرف کننده</button>
				</td>
				
			</tr>
		<?php $i++ ; endforeach ; ?>
    </tbody>
</table> 


