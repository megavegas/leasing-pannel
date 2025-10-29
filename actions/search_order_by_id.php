<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');
global $wpdb;
// print_r($_POST);

// print_r($_POST['oid']);

if (isset($_POST['order_id'])){
	$order = wc_get_order($_POST['order_id']);
	if ($order){
		$customer_user = get_post_meta($_POST['order_id'] , '_customer_user' , true);
		$first_name = get_user_meta($customer_user , 'fist_name' , true) ; 
		$last_name = get_user_meta($customer_user , 'last_name' , true) ; 
		$km = get_user_meta($customer_user , 'user_id_number' , true) ; 
		$um = get_user_meta($customer_user , 'user_mobile' , true) ; 
		$up = get_user_meta($customer_user , 'user_phune' , true) ; 
		?>
			<div class="mega_ordere_page d-flex flex-wrap">
				<div class="mop_title">
					<h1>جستجوی سفارش <?php echo $_POST['order_id'] ; ?></h1>
				</div>
				<hr>

				<div class="mop_inner">
					<div class="mopi_item">
						<span>شناسه سفارش :</span>
						<strong><?php echo $_POST['order_id']; ?></strong>
					</div>
					<div class="mopi_item">
						<span>نام :</span>
						<strong><?php echo $first_name .' '.$last_name; ?></strong>
					</div>
					<div class="mopi_item">
						<span>کد ملی : </span>
						<strong><?php echo $km; ?></strong>
					</div>
					<div class="mopi_item">
						<span>همراه : </span>
						<strong><?php echo $um; ?></strong>
					</div>
					<div class="mopi_item">
						<span>تلفن : </span>
						<strong><?php echo $up ; ?></strong>
					</div>
					<div class="mopi_item">
						<span>آدرس : </span>
						<strong><?php echo $km; ?></strong>
					</div>
					<div class="mopi_item">
						<span>مبلغ سفارش : </span>
						<strong><?php echo number_format($order->get_total()); ?></strong>
						<span class="in_bound_badg">ریال </span>
					</div>
					<div class="mopi_item">
						<span>پرداخت نقدی : </span>
						<strong><?php echo number_format(payed_values_for_order($_POST['order_id'])); ?></strong> 
						<span class="in_bound_badg">ریال </span>
					</div>
					<div class="mopi_item">
						<span>دفعات پرداخت: </span>
						<strong><?php echo count_of_payed_values_for_order($_POST['order_id']); ?></strong>
					</div>
					<div class="mopi_item">
						<span>کسر از حقوق : </span>
						<strong><?php echo number_format(get_kasrehoghoogh($_POST['order_id'])); ?></strong>
						<span class="in_bound_badg">ریال </span>
					</div>
					<div class="mopi_item">
						<span>تخفیف: </span>
						<strong><?php echo number_format($order->get_discount_total()); ?></strong>
						<span class="in_bound_badg">ریال </span>
					</div>
					<div class="mopi_item">
						<span>هزینه ها: </span>
						<strong><?php echo number_format($order->get_total_fees()); ?></strong>
						<span class="in_bound_badg">ریال </span>
					</div>
					<div class="mopi_item">
						<span>وضعیت : </span>
						<strong><?php echo $order->get_status(); ?></strong>
					</div>
					<div class="mopi_item">
						<span>تاریخ پرداخت : </span>
						<strong><?php echo$order->get_date_paid(); ?></strong>
					</div>
					<div class="mopi_item">
						<span>وضعیت : </span>
						<strong><?php echo $order->get_payment_method_title(); ?></strong>
					</div>
					<div class="mopi_item">
						<span>تاریخ تکمیل سفارش : </span>
						<strong><?php echo $order->get_date_completed(); ?></strong>
					</div>
					

					<div class="mopi_item">
						<span>عملیات: </span>
						<strong><a href="<?php echo get_site_url();?>/my-account?leasing=order&order_id=<?php echo $_POST['order_id']; ?>">مشاهده سفارش</a></strong>
					</div>
					
				</div>
			</div>
		<?
	}
}else{
	echo '01' ; 
}