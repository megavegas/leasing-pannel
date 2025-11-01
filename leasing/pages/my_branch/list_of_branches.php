<?php 
/**
 * نمایش لیست نمایندگان مدیر منطقه
 * بهینه‌شده برای امنیت و کارایی
 */

global $wpdb;

// دریافت اطلاعات کاربر جاری و منطقه
$user_id = get_current_user_id();
if (!$user_id) {
    echo '<div class="error">لطفاً وارد حساب کاربری خود شوید.</div>';
    return;
}

$my_zone = get_region_row_by_manager_id($user_id);
if (!$my_zone || empty($my_zone->states)) {
    echo '<div class="error">منطقه‌ای برای شما تعریف نشده است.</div>';
    return;
}

// تبدیل states به آرایه و اعتبارسنجی
$my_states = json_decode($my_zone->states);
if (!is_array($my_states) || empty($my_states)) {
    echo '<div class="error">استان‌های منطقه شما تعریف نشده است.</div>';
    return;
}

// آماده‌سازی placeholders برای prepared statement (امنیت SQL Injection)
$placeholders = implode(',', array_fill(0, count($my_states), '%s'));

// کوئری بهینه‌شده با prepared statement
$query = $wpdb->prepare("
    SELECT DISTINCT b.user_id 
    FROM {$wpdb->usermeta} AS a 
    INNER JOIN {$wpdb->usermeta} AS b ON a.user_id = b.user_id 
    WHERE a.meta_key = 'branch_province' 
        AND a.meta_value IN ($placeholders)
        AND b.meta_key = 'edu_capabilities' 
        AND b.meta_value LIKE %s
    ORDER BY b.user_id ASC
", array_merge($my_states, ['%branch%']));

$branches = $wpdb->get_results($query);

if (empty($branches)) {
    echo '<div class="no-results">نماینده‌ای در منطقه شما یافت نشد.</div>';
    return;
}

// استخراج IDs برای کوئری‌های بعدی
$branch_ids = wp_list_pluck($branches, 'user_id');

// دریافت تمام user meta های مورد نیاز در یک کوئری (بهبود کارایی)
$meta_keys = ['first_name', 'last_name', 'branch_serial_number', 'branch_contract_serial'];
$meta_placeholders = implode(',', array_fill(0, count($meta_keys), '%s'));
$ids_placeholders = implode(',', array_fill(0, count($branch_ids), '%d'));

$user_metas_query = $wpdb->prepare("
    SELECT user_id, meta_key, meta_value 
    FROM {$wpdb->usermeta} 
    WHERE user_id IN ($ids_placeholders)
        AND meta_key IN ($meta_placeholders)
", array_merge($branch_ids, $meta_keys));

$user_metas_raw = $wpdb->get_results($user_metas_query);

// سازماندهی user meta در آرایه برای دسترسی سریع
$user_metas = [];
foreach ($user_metas_raw as $meta) {
    $user_metas[$meta->user_id][$meta->meta_key] = $meta->meta_value;
}

// دریافت تعداد مشتریان هر نماینده در یک کوئری (بهبود کارایی N+1)
$customers_query = $wpdb->prepare("
    SELECT branch_id, COUNT(DISTINCT customer_id) as customer_count
    FROM {$wpdb->prefix}branch_customers
    WHERE branch_id IN ($ids_placeholders)
    GROUP BY branch_id
", $branch_ids);

$customers_counts = $wpdb->get_results($customers_query, OBJECT_K);

// دریافت اطلاعات کاربران
$users = get_users([
    'include' => $branch_ids,
    'fields' => ['ID', 'user_login']
]);

$users_by_id = [];
foreach ($users as $user) {
    $users_by_id[$user->ID] = $user;
}

?>

<div class="mega_list list_of_branches d-flex flex-wrap position-relative mt-4">
    <div class="ml_container">
        <div class="mop_title">
            <h1>لیست نمایندگان من (<?php echo count($branches); ?> نماینده)</h1>
        </div>
        <div class="ml_inner_box position-relative">
            <table id="all_branch_list" class="w-100">
                <thead class="abl_header">
                    <tr class="abl_h_row">
                        <th class="abl_h_row_number">ردیف</th>
                        <th class="abl_h_name">نام و نام خانوادگی</th>
                        <th class="abl_h_id">کد تفضیلی</th>
                        <th class="abl_h_mobile">شماره تلفن</th>
                        <th class="abl_h_contract">کد قرارداد</th>
                        <th class="abl_h_customers">تعداد مشتریان</th>
                        <th class="abl_h_edit">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $row_number = 1;
                    foreach ($branches as $branch) : 
                        $user_id = $branch->user_id;
                        $user = $users_by_id[$user_id] ?? null;
                        
                        if (!$user) continue;
                        
                        // دریافت meta های کاربر از آرایه کش‌شده
                        $first_name = $user_metas[$user_id]['first_name'] ?? '';
                        $last_name = $user_metas[$user_id]['last_name'] ?? '';
                        $serial_number = $user_metas[$user_id]['branch_serial_number'] ?? '-';
                        $contract_serial = $user_metas[$user_id]['branch_contract_serial'] ?? '-';
                        $customer_count = $customers_counts[$user_id]->customer_count ?? 0;
                        
                        $full_name = trim($first_name . ' ' . $last_name) ?: 'نام نامشخص';
                    ?>
                    <tr>
                        <td class="abl_b_row_number"><?php echo $row_number++; ?></td>
                        <td class="abl_b_name"><?php echo esc_html($full_name); ?></td>
                        <td class="abl_b_id"><?php echo esc_html($serial_number); ?></td>
                        <td class="abl_b_mobile" dir="ltr"><?php echo esc_html($user->user_login); ?></td>
                        <td class="abl_b_contract"><?php echo esc_html($contract_serial); ?></td>
                        <td class="abl_b_customers"><?php echo number_format_i18n($customer_count); ?></td>
                        <td class="abl_b_edit">
                            <a href="<?php echo esc_url(add_query_arg([
                                'leasing' => 'edit_branch',
                                'branch_id' => $user_id
                            ], wc_get_account_endpoint_url('my-account'))); ?>" class="button">
                                ویرایش
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
#all_branch_list {
    border-collapse: collapse;
    background: #fff;
}

#all_branch_list th {
    background: #f8f9fa;
    padding: 12px;
    text-align: right;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

#all_branch_list td {
    padding: 10px 12px;
    border-bottom: 1px solid #e9ecef;
}

#all_branch_list tbody tr:hover {
    background: #f8f9fa;
}

.abl_b_edit .button {
    padding: 6px 16px;
    background: #0073aa;
    color: #fff;
    text-decoration: none;
    border-radius: 3px;
    display: inline-block;
    transition: background 0.3s;
}

.abl_b_edit .button:hover {
    background: #005177;
}

.error, .no-results {
    padding: 15px;
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 4px;
    margin: 20px 0;
}
</style>