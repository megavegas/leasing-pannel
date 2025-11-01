<?php 

	if ($order_status == 'compleated'){
		$html .='<div class="col-12" style="color:#fff;background:green;padding:20px;margin:40px auto;">';
			$html .='سفارش تکمیل شده است';
		$html .='</div>';
	}elseif($order_status == 'prossessing'){
		$html .='<div class="col-12" style="color:#000;background:pink;padding:20px;margin:40px auto;">';
			$html .='سفارش پرداخت شده است اما در انتظار تأیید ادمین است ';
		$html .='</div>';
	}elseif($order_status == 'half_payed_bmi'){
		$html .='<div class="col-12" style="color:#fff;background:pink;padding:20px;margin:40px auto;">';
			$html .='سفارش به صورت چند باره پرداخت شده است و نیازمند تأیید ادمین است ';
		$html .='</div>';
	}elseif($order_status == 'ersal_shode'){
		$html .='<div class="col-12" style="color:#fff;background:black;padding:20px;margin:40px auto;">';
			$html .='این سفارش ارسال شده است و وضعیت آن غیر قابل تغییر خواهد بود ';
		$html .='</div>';
	}elseif($order_status == 'cancelled'){
		$html .='<div class="col-12" style="color:#fff;background:red;padding:20px;margin:40px auto;">';
			$html .='این سفارش لغو شده است و وضعیت آن غیر قابل تغییر خواهد بود';
		$html .='</div>';
	}