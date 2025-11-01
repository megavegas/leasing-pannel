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
    'title',     // تغییر داده شده برای مشخص کردن جدول
    'year',
    'start',
    'end',
    'id'
];
$order_by = $columns[$order_column];

if ($cond == 'my'){
	$query ="SELECT * FROM `targets`";
	$query_total = "SELECT count(`id`) FROM `targets`";
}

// echo $_GET['cond'] ; 
// اضافه کردن جستجو
	if (!empty($search)) {
		$query .= $wpdb->prepare(" AND (
			`title` LIKE %s OR
			`year` LIKE %s OR
			`start` LIKE %s OR
			`end` LIKE %s OR
			`id` LIKE %s 
		)",
		'%' . $wpdb->esc_like($search) . '%',
		'%' . $wpdb->esc_like($search) . '%',
		'%' . $wpdb->esc_like($search) . '%',
		'%' . $wpdb->esc_like($search) . '%',
		'%' . $wpdb->esc_like($search) . '%'
		);
	}

	// اضافه کردن مرتب‌سازی و محدودیت
	$query .= "WHERE `user` LIKE '{$employee}'
	ORDER BY `id` {$order_dir} 
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

foreach ($results as $row) {
	
	$rowx =[
		'id'			=> 	$row['id'],
		'title'			=> 	$row['title'],
		'type'			=> 	$row['type'],
		'user'			=> 	$row['user'],
		'start'			=> 	$row['start'],
		'end'			=> 	$row['end'],
		'year'			=>  $row['year'],
		'created_at'	=>	$row['created_at'],
		'updated_at'	=>	$row['updated_at'],
		'funcs'			=>  '<a href="'.get_site_url().'/my-account/?target=see_products&target_id='.$row['id'].'" class="btn btn-outline-dark">مشاهده</a>'
	]; 
	$data[] = $rowx;
	
}


// ساخت پاسخ
$response = [
    "draw" => $draw,
    "recordsTotal" => intval($total_records),
    "recordsFiltered" => intval($total_records),
    "data" => $data
];

echo json_encode($response);