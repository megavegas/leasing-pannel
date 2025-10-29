<?php 
$response  = tara_branch_authenticate($order_id);
$html  .= tara_branch_create_payement_butten( $response , $mablaghe_pardakht , $order_id);

$html  .= form_of_section_payment_by_bmi_gateway($order_id , $customer_id );