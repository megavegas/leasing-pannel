<?php
$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');

global $wpdb;
header('Content-Type: application/json');

// پارامترهای DataTables
$cond = isset($_GET['cond']) ? $_GET['cond'] : "today_sale";
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 20;
$search = isset($_POST['search']['value']) ? sanitize_text_field($_POST['search']['value']) : '';
$order_column = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 7;
$order_dir = isset($_POST['order'][0]['dir']) ? sanitize_text_field($_POST['order'][0]['dir']) : 'DESC';
$employee = get_current_user_id();

// تبدیل شماره ستون به نام ستون
$columns = [
    'branch_name',     // تغییر داده شده برای مشخص کردن جدول
    'customer_name',
    'customer_national_code',
    'order_id',
    'plan_name'
];
$order_by = $columns[$order_column];

if ($cond == 'today_sale'){
	$query = " SELECT * FROM `vw_orders_today` WHERE `leasing_employee` like '{$employee}'  ";
	$query_total = " SELECT count(`branch_id`) FROM `vw_orders_today` WHERE `leasing_employee` like '{$employee}'  ";
}elseif($cond == 'last_day_sale'){
	$query = " SELECT * FROM `leasing_employee_orders_yesterday` WHERE `leasing_employee` like '{$employee}'  ";
	$query_total = " SELECT count(`branch_id`) FROM `leasing_employee_orders_yesterday` WHERE `leasing_employee` like '{$employee}'  ";
}elseif($cond == 'this_week_sale'){
	$query = " SELECT * FROM `leasing_employee_orders_current_week` WHERE `leasing_employee` like '{$employee}'  ";
	$query_total = " SELECT count(`branch_id`) FROM `leasing_employee_orders_current_week` WHERE `leasing_employee` like '{$employee}'  ";
}elseif($cond == 'last_week_sale'){
	$query = " SELECT * FROM `leasing_employee_orders_last_week` WHERE `leasing_employee` like '{$employee}'  ";
	$query_total = " SELECT count(`branch_id`) FROM `leasing_employee_orders_last_week` WHERE `leasing_employee` like '{$employee}'  ";
}elseif($cond == 'this_month_sale'){
	$query = " SELECT * FROM `leasing_employee_orders_current_month` WHERE `leasing_employee` like '{$employee}'  ";
	$query_total = "SELECT count(`branch_id`) FROM `leasing_employee_orders_current_month` WHERE `leasing_employee` like '{$employee}'  ";
}elseif($cond == 'last_month_sale'){
	$query = " SELECT * FROM `leasing_employee_orders_last_month` WHERE `leasing_employee` like '{$employee}'  ";
	$query_total = "SELECT count(`branch_id`) FROM `leasing_employee_orders_last_month` WHERE `leasing_employee` like '{$employee}'  ";
}elseif($cond == 'this_year_sale'){
	$query = "SELECT * FROM `leasing_employee_orders_current_year` WHERE `leasing_employee` like '{$employee}'  ";
	$query_total = " SELECT count(`branch_id`) FROM `leasing_employee_orders_current_year` WHERE `leasing_employee` like '{$employee}'  ";
}elseif($cond == 'last_year_sale'){
	$query = " SELECT * FROM `leasing_employee_orders_last_year` WHERE `leasing_employee` like '{$employee}'  ";
	$query_total = " SELECT count(`branch_id`) FROM `leasing_employee_orders_last_year` WHERE `leasing_employee` like '{$employee}'  ";
}else{
	 
	$query = " SELECT * FROM `vw_orders_today` WHERE `leasing_employee` like '{$employee}'  ";
	$query_total = " SELECT count(`branch_id`) FROM `vw_orders_today` WHERE `leasing_employee` like '{$employee}'  ";
}

// echo $_GET['cond'] ; 
// اضافه کردن جستجو
	if (!empty($search)) {
		$query .= $wpdb->prepare(" AND (
			`order_id` LIKE %s OR
			`customer_name` LIKE %s OR
			`branch_name` LIKE %s OR
			`plan_name` LIKE %s OR
			`customer_national_code` LIKE %s 
		)",
		'%' . $wpdb->esc_like($search) . '%',
		'%' . $wpdb->esc_like($search) . '%',
		'%' . $wpdb->esc_like($search) . '%',
		'%' . $wpdb->esc_like($search) . '%',
		'%' . $wpdb->esc_like($search) . '%'
		);
	}

	// اضافه کردن مرتب‌سازی و محدودیت
	$query .= "  
	ORDER BY `order_id` {$order_dir} 
	";
	$query .= $wpdb->prepare(" 
	LIMIT %d OFFSET %d 
	", $length, $start);

// اجرای کوئری اصلی
$results = $wpdb->get_results($query, ARRAY_A);
 
// print_r($query);
// گرفتن تعداد کل رکوردها
$total_records = $wpdb->get_var($query_total);

$data = [];
if ($results) {
	$i = 1;
    foreach ($results as $row) {
		// print_r($row);
        // تبدیل تاریخ به فرمت فارسی
        // $row['post_date'] = date('Y/m/d H:i', strtotime($row['post_date']));
        
		$row_order = wc_get_order($row['order_id']);
		if ($row_order){
			$row_status = $row_order->get_status();
		}else{
			$row_status = 'trash';
		}

		$row['order_status'] = $row_status;

        // تبدیل وضعیت به فارسی
        $status_map = [
            'completed' 	=> 'تکمیل شده',
            'processing' 	=> 'در حال پردازش',
            'pending' 		=> 'در انتظار',
            'cancelled' 	=> 'لغو شده',
            'refunded' 		=> 'مسترد شده',
            'failed' 		=> 'ناموفق',
            'trash' 		=> 'حذف شده'
        ];

        $row['post_status'] = isset($status_map[$row['order_status']]) ? $status_map[$row['order_status']] : $row['order_status'];
		$org = get_the_title($row['organization']);
		if ($org == '' || empty($org)){
			$org = 'همتالونز';
		}

		$plan = get_the_title($row['plan_id']);
		if ($plan == '' || empty($plan)){
			$plan = 'همتالونز';
		}

		if (!isset($row['customer_national_code'])){
			$row['customer_national_code'] = $row['km'];
		}

		
        $rowx =[
			'branch_id'		=> get_user_meta($row['branch_id'] , 'first_name' , true) .' '.get_user_meta($row['branch_id'] ,  'last_name' , true),
			'customer_id'	=> $row['customer_name'],
			'customer_national_code'	=> $row['customer_national_code'],
			'plan_id'		=> $row['plan_name'],
			'order_id'		=> $row['order_id'],
			'post_date'		=> $row['order_create_date'],
			'post_status'	=>  $row['post_status'],
			'oooo'			=> '<a href="'.get_site_url().'/my-account/?leasing=order&order_id='. $row['order_id'].'">مشاهده</a>'
		]; 
        $data[] = $rowx;
		$i++;
    }
}

// ساخت پاسخ
$response = [
    "draw" => $draw,
    "recordsTotal" => intval($total_records),
    "recordsFiltered" => intval($total_records),
    "data" => $data
];

echo json_encode($response);