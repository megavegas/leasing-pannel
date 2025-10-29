<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

header('Content-Type: application/json; charset=utf-8');

// دریافت پارامترها
$leasing_employee_id = isset($_POST['leasing_employee_id']) ? intval($_POST['leasing_employee_id']) : 0;
$branch_id = isset($_POST['branch']) ? intval($_POST['branch']) : 0;
$plan_id = isset($_POST['plan']) ? intval($_POST['plan']) : 0;
$status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';

global $wpdb;

// ابتدا نمایندگان مربوط به این کارشناس لیزینگ را پیدا می‌کنیم
$branch_ids_query = $wpdb->prepare("
    SELECT user_id 
    FROM {$wpdb->prefix}usermeta 
    WHERE meta_key = 'branch_leasing_employee_id' 
    AND meta_value = %d", 
    $leasing_employee_id
);

$branch_ids = $wpdb->get_col($branch_ids_query);

if (empty($branch_ids)) {
    echo json_encode([
        'error' => 'نماینده‌ای یافت نشد',
        'activeBranchesCount' => 0,
        'totalOrders' => 0,
        'successfulOrders' => 0,
        'cancelledOrders' => 0,
        'branches' => [],
        'comparisons' => []
    ]);
    exit;
}

$branch_ids_str = implode(',', array_map('intval', $branch_ids));

// کوئری برای تعداد نمایندگان فعال دیروز
$active_branches_query = $wpdb->prepare("
    SELECT COUNT(DISTINCT bc.branch_id) as active_count
    FROM {$wpdb->prefix}branch_customers bc
    JOIN {$wpdb->prefix}posts orders ON orders.ID = bc.order_id
    WHERE bc.branch_id IN ({$branch_ids_str})
    AND DATE(orders.post_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
");

$active_branches_count = $wpdb->get_var($active_branches_query);

// کوئری برای دیروز
$yesterday_query = "
    SELECT 
        bc.branch_id,
        bc.order_id,
        CONCAT(
            COALESCE((SELECT meta_value FROM {$wpdb->prefix}usermeta 
             WHERE user_id = bc.branch_id AND meta_key = 'first_name'), ''),
            ' ',
            COALESCE((SELECT meta_value FROM {$wpdb->prefix}usermeta 
             WHERE user_id = bc.branch_id AND meta_key = 'last_name'), '')
        ) as branch_name,
        orders.post_status as order_status,
        orders.post_date as order_date,
        plan.ID as plan_id,
        plan.post_title as plan_name,
        COUNT(bc.id) as total_orders,
        SUM(CASE WHEN orders.post_status = 'completed' THEN 1 ELSE 0 END) as successful_orders,
        SUM(CASE WHEN orders.post_status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_orders,
        COUNT(CASE WHEN orders.post_status = 'completed' THEN bc.id END) as plan_successful_count
    FROM {$wpdb->prefix}branch_customers bc
    JOIN {$wpdb->prefix}posts orders ON orders.ID = bc.order_id
    JOIN {$wpdb->prefix}posts plan ON plan.ID = bc.plan_id
    WHERE bc.branch_id IN ({$branch_ids_str})
    AND DATE(orders.post_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
";

// کوئری برای پریروز (مشابه دیروز با تغییر در تاریخ)
$day_before_query = str_replace(
    'INTERVAL 1 DAY',
    'INTERVAL 2 DAY',
    $yesterday_query
);

// اضافه کردن فیلترها
if ($branch_id > 0) {
    $yesterday_query .= $wpdb->prepare(" AND bc.branch_id = %d", $branch_id);
    $day_before_query .= $wpdb->prepare(" AND bc.branch_id = %d", $branch_id);
}

if ($plan_id > 0) {
    $yesterday_query .= $wpdb->prepare(" AND plan.ID = %d", $plan_id);
    $day_before_query .= $wpdb->prepare(" AND plan.ID = %d", $plan_id);
}

// گروه‌بندی
$yesterday_query .= " GROUP BY bc.branch_id, plan.ID";
$day_before_query .= " GROUP BY bc.branch_id, plan.ID";

$yesterday_data = $wpdb->get_results($yesterday_query);
$day_before_data = $wpdb->get_results($day_before_query);
// تابع محاسبه درصد تغییرات
function calculate_percentage_change($old_value, $new_value) {
    if ($old_value == 0) {
        return $new_value > 0 ? 100 : 0;
    }
    return round((($new_value - $old_value) / $old_value) * 100, 2);
}

// آماده‌سازی پاسخ
$response = [
    'activeBranchesCount' => intval($active_branches_count),
    'totalOrders' => 0,
    'successfulOrders' => 0,
    'cancelledOrders' => 0,
    'branches' => [],
    'comparisons' => []
];

// لیست نمایندگان برای فیلتر
foreach ($branch_ids as $b_id) {
    $first_name = $wpdb->get_var($wpdb->prepare(
        "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = %d AND meta_key = 'first_name'",
        $b_id
    ));
    $last_name = $wpdb->get_var($wpdb->prepare(
        "SELECT meta_value FROM {$wpdb->prefix}usermeta WHERE user_id = %d AND meta_key = 'last_name'",
        $b_id
    ));
    
    $response['branches'][] = [
        'id' => $b_id,
        'name' => trim($first_name . ' ' . $last_name)
    ];
}

// محاسبه آمار کلی
foreach ($yesterday_data as $data) {
    $response['totalOrders'] += $data->total_orders;
    $response['successfulOrders'] += $data->successful_orders;
    $response['cancelledOrders'] += $data->cancelled_orders;
}

// آماده‌سازی داده‌های مقایسه‌ای
foreach ($yesterday_data as $yesterday) {
    // پیدا کردن داده متناظر در پریروز
    $day_before = null;
    foreach ($day_before_data as $before) {
        if ($before->branch_id == $yesterday->branch_id && $before->plan_id == $yesterday->plan_id) {
            $day_before = $before;
            break;
        }
    }
    
    $change_percentage = calculate_percentage_change(
        $day_before ? $day_before->total_orders : 0,
        $yesterday->total_orders
    );

    // اعمال فیلتر وضعیت
    if ($status === 'increase' && $change_percentage <= 0) {
        continue;
    }
    if ($status === 'decrease' && $change_percentage >= 0) {
        continue;
    }

    $comparison = [
        'branchId' => $yesterday->branch_id,
        'branchName' => $yesterday->branch_name,
        'orderId' => $yesterday->order_id,
        'planName' => $yesterday->plan_name,
        'orderDate' => $yesterday->order_date,
        'yesterdayOrders' => $yesterday->total_orders,
        'yesterdaySuccessful' => $yesterday->successful_orders,
        'yesterdayCancelled' => $yesterday->cancelled_orders,
        'orderStatus' => $yesterday->order_status,
        'changePercentage' => $change_percentage
    ];

    $response['comparisons'][] = $comparison;
}

// ارسال پاسخ
echo json_encode($response);