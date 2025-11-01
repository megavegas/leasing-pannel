<?php 

$payed_in_cash = payed_values_for_order($order_id);
$order_ammount = $order->get_total()-$payed_in_cash;
branch_get_jetwam_payment_link($order_id , $order_ammount , $customer_id , $branch_id);