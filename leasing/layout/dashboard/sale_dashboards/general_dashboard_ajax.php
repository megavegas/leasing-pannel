<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

header('Content-Type: application/json; charset=utf-8');

// دریافت پارامترها
$leasing_employee_id = isset($_POST['leasing_employee_id']) ? intval($_POST['leasing_employee_id']) : 0;
$time_range = isset($_POST['time_range']) ? sanitize_text_field($_POST['time_range']) : 'daily';

global $wpdb;

// تنظیم بازه زمانی
$date_ranges = [
    'daily' => [
        'start' => date('Y-m-d 00:00:00', strtotime('-1 day')),
        'end' => date('Y-m-d 23:59:59', strtotime('-1 day')),
        'prev_start' => date('Y-m-d 00:00:00', strtotime('-2 day')),
        'prev_end' => date('Y-m-d 23:59:59', strtotime('-2 day')),
        'group_by' => 'HOUR(payment_date.meta_value)'
    ],
    'weekly' => [
        'start' => date('Y-m-d 00:00:00', strtotime('-7 days')),
        'end' => date('Y-m-d 23:59:59'),
        'prev_start' => date('Y-m-d 00:00:00', strtotime('-14 days')),
        'prev_end' => date('Y-m-d 23:59:59', strtotime('-7 days')),
        'group_by' => 'DATE(payment_date.meta_value)'
    ],
    'monthly' => [
        'start' => date('Y-m-d 00:00:00', strtotime('first day of last month')),
        'end' => date('Y-m-d 23:59:59', strtotime('last day of last month')),
        'prev_start' => date('Y-m-d 00:00:00', strtotime('first day of -2 month')),
        'prev_end' => date('Y-m-d 23:59:59', strtotime('last day of last month')),
        'group_by' => 'DATE(payment_date.meta_value)'
    ]
];

$current_range = $date_ranges[$time_range] ?? $date_ranges['daily'];

// دریافت لیست نمایندگان
$branch_query = $wpdb->prepare("
    SELECT 
        um.user_id,
        (
            SELECT meta_value 
            FROM {$wpdb->prefix}usermeta 
            WHERE user_id = um.user_id 
            AND meta_key = 'first_name'
        ) as first_name,
        (
            SELECT meta_value 
            FROM {$wpdb->prefix}usermeta 
            WHERE user_id = um.user_id 
            AND meta_key = 'last_name'
        ) as last_name
    FROM {$wpdb->prefix}usermeta um
    WHERE um.meta_key = 'branch_leasing_employee_id'
    AND um.meta_value = %d",
    $leasing_employee_id
);

$branches = $wpdb->get_results($branch_query);

if (empty($branches)) {
    echo json_encode([
        'success' => false,
        'message' => 'نماینده‌ای یافت نشد'
    ]);
    exit;
}

$branch_ids = array_map(function($branch) {
    return $branch->user_id;
}, $branches);

$branch_ids_str = implode(',', array_map('intval', $branch_ids));

// کوئری فروش‌های موفق
$sales_query = $wpdb->prepare("
    SELECT 
        bc.branch_id,
        orders.ID as order_id,
        payment_date.meta_value as paid_date,
        order_total.meta_value as order_total,
        gateway.meta_value as payment_gateway,
        plan.ID as plan_id,
        plan.post_title as plan_title,
        items.order_item_name as product_name,
        item_total.meta_value as product_total
    FROM {$wpdb->prefix}branch_customers bc
    JOIN {$wpdb->prefix}posts orders ON orders.ID = bc.order_id
    JOIN {$wpdb->prefix}posts plan ON plan.ID = bc.plan_id
    JOIN {$wpdb->prefix}postmeta payment_date ON payment_date.post_id = orders.ID 
        AND payment_date.meta_key = '_paid_date'
    JOIN {$wpdb->prefix}postmeta order_total ON order_total.post_id = orders.ID 
        AND order_total.meta_key = '_order_total'
    JOIN {$wpdb->prefix}postmeta gateway ON gateway.post_id = orders.ID 
        AND gateway.meta_key = '_payment_method'
    JOIN {$wpdb->prefix}woocommerce_order_items items ON items.order_id = orders.ID
        AND items.order_item_type = 'line_item'
    JOIN {$wpdb->prefix}woocommerce_order_itemmeta item_total ON item_total.order_item_id = items.order_item_id
        AND item_total.meta_key = '_line_total'
    WHERE bc.branch_id IN ({$branch_ids_str})
    AND orders.post_status in ('wc-completed' , 'wc-proccessing' , 'wc-ersal_shode')
    AND payment_date.meta_value BETWEEN %s AND %s",
    $current_range['start'],
    $current_range['end']
);

// echo $sales_query ; 

$sales_data = $wpdb->get_results($sales_query);


// محاسبه آمار کلی دوره جاری
$current_stats = [
    'total_amount' => 0,
    'order_count' => 0,
    'products' => [],
    'branches' => [],
    'gateways' => []
];

foreach ($sales_data as $sale) {
    $current_stats['total_amount'] += floatval($sale->order_total);
    $current_stats['order_count']++;
    
    // آمار محصولات
    if (!isset($current_stats['products'][$sale->product_name])) {
        $current_stats['products'][$sale->product_name] = [
            'count' => 0,
            'amount' => 0,
            'branches' => []
        ];
    }
    $current_stats['products'][$sale->product_name]['count']++;
    $current_stats['products'][$sale->product_name]['amount'] += floatval($sale->product_total);
    $current_stats['products'][$sale->product_name]['branches'][$sale->branch_id] = true;

    // آمار نمایندگان
    if (!isset($current_stats['branches'][$sale->branch_id])) {
        $current_stats['branches'][$sale->branch_id] = [
            'count' => 0,
            'amount' => 0,
            'products' => [],
            'last_sale' => null
        ];
    }
    $current_stats['branches'][$sale->branch_id]['count']++;
    $current_stats['branches'][$sale->branch_id]['amount'] += floatval($sale->order_total);
    $current_stats['branches'][$sale->branch_id]['products'][$sale->product_name] = 
        ($current_stats['branches'][$sale->branch_id]['products'][$sale->product_name] ?? 0) + 1;
    
    if ($current_stats['branches'][$sale->branch_id]['last_sale'] === null || 
        strtotime($sale->paid_date) > strtotime($current_stats['branches'][$sale->branch_id]['last_sale'])) {
        $current_stats['branches'][$sale->branch_id]['last_sale'] = $sale->paid_date;
    }

    // آمار درگاه‌های پرداخت
    if (!isset($current_stats['gateways'][$sale->payment_gateway])) {
        $current_stats['gateways'][$sale->payment_gateway] = [
            'count' => 0,
            'amount' => 0
        ];
    }
    $current_stats['gateways'][$sale->payment_gateway]['count']++;
    $current_stats['gateways'][$sale->payment_gateway]['amount'] += floatval($sale->order_total);
}

// دریافت آمار دوره قبل برای محاسبه رشد
$previous_query = str_replace(
    [$current_range['start'], $current_range['end']], 
    [$current_range['prev_start'], $current_range['prev_end']], 
    $sales_query
);

$previous_data = $wpdb->get_results($previous_query);
$previous_stats = [
    'total_amount' => 0,
    'order_count' => 0,
    'products' => [],
    'branches' => [],
    'gateways' => []
];

foreach ($previous_data as $sale) {
    $previous_stats['total_amount'] += floatval($sale->order_total);
    $previous_stats['order_count']++;
    
    // آمار محصولات دوره قبل
    if (!isset($previous_stats['products'][$sale->product_name])) {
        $previous_stats['products'][$sale->product_name] = [
            'count' => 0,
            'amount' => 0
        ];
    }
    $previous_stats['products'][$sale->product_name]['count']++;
    $previous_stats['products'][$sale->product_name]['amount'] += floatval($sale->product_total);

    // آمار نمایندگان دوره قبل
    if (!isset($previous_stats['branches'][$sale->branch_id])) {
        $previous_stats['branches'][$sale->branch_id] = [
            'count' => 0,
            'amount' => 0
        ];
    }
    $previous_stats['branches'][$sale->branch_id]['count']++;
    $previous_stats['branches'][$sale->branch_id]['amount'] += floatval($sale->order_total);

    // آمار درگاه‌های پرداخت دوره قبل
    if (!isset($previous_stats['gateways'][$sale->payment_gateway])) {
        $previous_stats['gateways'][$sale->payment_gateway] = [
            'count' => 0,
            'amount' => 0
        ];
    }
    $previous_stats['gateways'][$sale->payment_gateway]['count']++;
    $previous_stats['gateways'][$sale->payment_gateway]['amount'] += floatval($sale->order_total);
}

// در PHP، کوئری روند زمانی
$trend_query = $wpdb->prepare("
    SELECT 
        {$current_range['group_by']} as time_unit,
        COUNT(DISTINCT orders.ID) as order_count,
        SUM(CAST(order_total.meta_value AS DECIMAL(10,2))) as total_amount,
        MIN(payment_date.meta_value) as min_date,
        COUNT(DISTINCT bc.branch_id) as active_branches_count
    FROM {$wpdb->prefix}branch_customers bc
    JOIN {$wpdb->prefix}posts orders ON orders.ID = bc.order_id
    JOIN {$wpdb->prefix}postmeta payment_date ON payment_date.post_id = orders.ID 
        AND payment_date.meta_key = '_paid_date'
    JOIN {$wpdb->prefix}postmeta order_total ON order_total.post_id = orders.ID 
        AND order_total.meta_key = '_order_total'
    WHERE bc.branch_id IN ({$branch_ids_str})
    AND orders.post_status in ('wc-completed' , 'wc-proccessing' , 'wc-ersal_shode') 
    AND payment_date.meta_value BETWEEN %s AND %s
    GROUP BY {$current_range['group_by']}
    ORDER BY time_unit ASC",
    $current_range['start'],
    $current_range['end']
);


// echo $trend_query.'<br><br>' ; 
$trend_data = $wpdb->get_results($trend_query);

// تابع کمکی برای پر کردن ساعت‌های خالی در روند روزانه
function fill_missing_hours($trend_data) {
    if ($current_range['type'] !== 'daily') {
        return $trend_data;
    }

    $complete_trend = [];
    for ($hour = 0; $hour < 24; $hour++) {
        $found = false;
        foreach ($trend_data as $point) {
            if ((int)$point->time_unit === $hour) {
                $complete_trend[] = $point;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $empty_point = (object)[
                'time_unit' => sprintf('%02d', $hour),
                'order_count' => 0,
                'total_amount' => 0,
                'active_branches_count' => 0
            ];
            $complete_trend[] = $empty_point;
        }
    }
    return $complete_trend;
}

// تابع کمکی برای فرمت‌بندی برچسب‌های زمانی
function format_time_labels($trend_data, $range_type) {
    $formatted_labels = [];
    foreach ($trend_data as $point) {
        switch ($range_type) {
            case 'daily':
                $formatted_labels[] = $point->time_unit . ':00';
                break;
            case 'weekly':
                $date = new DateTime($point->min_date);
                $formatted_labels[] = $date->format('Y-m-d');
                break;
            case 'monthly':
                $date = new DateTime($point->min_date);
                $formatted_labels[] = $date->format('d');
                break;
            default:
                $formatted_labels[] = $point->time_unit;
        }
    }
    return $formatted_labels;
}

// پر کردن نقاط خالی و فرمت‌بندی برچسب‌ها
$trend_data = fill_missing_hours($trend_data);
$formatted_labels = format_time_labels($trend_data, $current_range['type']);


// تابع محاسبه درصد رشد
function calculate_growth($old_value, $new_value) {
    if ($old_value == 0) return $new_value > 0 ? 100 : 0;
    return round((($new_value - $old_value) / $old_value) * 100, 2);
}

// ساخت آرایه نمایندگان فعال
$active_branches = [];
foreach ($current_stats['branches'] as $branch_id => $stats) {
    $branch_info = array_filter($branches, function($b) use ($branch_id) {
        return $b->user_id == $branch_id;
    });
    $branch_info = reset($branch_info);
    
    if ($branch_info) {
        $previous_amount = $previous_stats['branches'][$branch_id]['amount'] ?? 0;
        $active_branches[] = [
            'id' => $branch_id,
            'name' => trim($branch_info->first_name . ' ' . $branch_info->last_name),
            'totalSales' => $stats['amount'],
            'orderCount' => $stats['count'],
            'lastSaleDate' => $stats['last_sale'],
            'growth' => calculate_growth($previous_amount, $stats['amount']),
            'topProduct' => array_search(max($stats['products']), $stats['products'])
        ];
    }
}

// مرتب‌سازی محصولات بر اساس تعداد فروش
arsort($current_stats['products']);
$top_products = [];
foreach (array_slice($current_stats['products'], 0, 10, true) as $product_name => $stats) {
    $previous_amount = $previous_stats['products'][$product_name]['amount'] ?? 0;
    $top_products[] = [
        'name' => $product_name,
        'count' => $stats['count'],
        'totalAmount' => $stats['amount'],
        'growth' => calculate_growth($previous_amount, $stats['amount']),
        'uniqueBranches' => count($stats['branches'])
    ];
}

// آماده‌سازی داده‌های درگاه‌های پرداخت
$payment_gateways = [];
foreach ($current_stats['gateways'] as $gateway => $stats) {
    $previous_amount = $previous_stats['gateways'][$gateway]['amount'] ?? 0;
    $payment_gateways[] = [
        'name' => $gateway,
        'count' => $stats['count'],
        'amount' => $stats['amount'],
        'growth' => calculate_growth($previous_amount, $stats['amount'])
    ];
}

// آماده‌سازی داده‌های روند
$trend = [
    'labels' => $formatted_labels,
    'sales' => array_map(function($point) { 
        return floatval($point->total_amount); 
    }, $trend_data),
    'orders' => array_map(function($point) { 
        return intval($point->order_count); 
    }, $trend_data),
    'activeBranches' => array_map(function($point) { 
        return intval($point->active_branches_count); 
    }, $trend_data)
];

// ساخت پاسخ نهایی
$response = [
    'success' => true,
    'data' => [
        'summary' => [
            'activeBranches' => [
                'count' => count($active_branches),
                'list' => $active_branches
            ],
            'sales' => [
                'total' => $current_stats['total_amount'],
                'count' => $current_stats['order_count'],
                'growth' => calculate_growth($previous_stats['total_amount'], $current_stats['total_amount'])
            ],
            'products' => [
                'topSelling' => $top_products
            ],
            'paymentGateways' => $payment_gateways
        ],
        'trend' => $trend,
        'details' => [
            'branches' => [
                'bestPerforming' => array_slice($active_branches, 0, 5)
            ],
            'products' => [
                'byBranch' => array_map(function($branch) use ($current_stats) {
                    return [
                        'branchId' => $branch['id'],
                        'branchName' => $branch['name'],
                        'products' => array_map(function($count, $product) use ($current_stats) {
                            return [
                                'name' => $product,
                                'count' => $count,
                                'amount' => $current_stats['products'][$product]['amount']
                            ];
                        }, $current_stats['branches'][$branch['id']]['products'], 
                           array_keys($current_stats['branches'][$branch['id']]['products']))
                    ];
                }, array_slice($active_branches, 0, 5))
            ]
        ],
        'period' => [
            'start' => $current_range['start'],
            'end' => $current_range['end'],
            'type' => $time_range
        ]
    ]
];

echo json_encode($response);