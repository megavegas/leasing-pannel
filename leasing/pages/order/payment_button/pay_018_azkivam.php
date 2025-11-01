<?php


$get_total = $order->get_total();
$total_amount = (int)$get_total;
$orderId = $order->get_id();
$uid = $order->get_user_id();

$provider_id = mt_rand(100000000, 999999999);
$items = array();
for ($index = 0; $index < count($order->get_items()); $index++) {
    $key = array_keys($order->get_items())[$index];
    $value = $order->get_items()[$key];
    $items[] = array(
        'name' => $value->get_name(),
        'url' => get_permalink($value->get_product_id()),
        'count' => $value->get_quantity(),
        'amount' => $value->get_total() / $value->get_quantity()
    );
}
$callback = get_site_url() . '/my-account/?payment=azki&state=response&orderid='. $orderId . '&uid=' . $uid;
$data_a = array(
    'amount' => $total_amount,
    'redirect_uri' => $callback,
    'fallback_uri' => $callback,
    'provider_id' => $provider_id,
    'mobile_number' => '09304428006',
    'items' => $items
);
$send_results = azki_doRequest('/payment/purchase', $data_a);

azki_branch_create_payment_button($send_results, $total_amount);


