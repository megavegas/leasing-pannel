<?php

$response = top_createOrder($order_id);
if ($response){
	$array = json_decode($response, true);
	if ($array['status'] == 0) {
		echo '<a href="' . htmlspecialchars($array['data']['serviceURL']) . '" target="_blank"><button class="btn btn-success">پرداخت با تاپ</button></a>';
	} else {
		echo '<span class="" style="background: #efefef;padding: 11px;border-radius: 12px;"> پرداخت تاپ با مشکل مواجه شده است </span><br><div>' . htmlspecialchars($array['message']) . '</div>';
	}
}else{
	echo 'error 1 : payment_gateway is not working goood';
}

 
