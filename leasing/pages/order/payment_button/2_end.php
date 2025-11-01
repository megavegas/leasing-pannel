<?php 

	if ($os == 'proforma-invoice'){
		$html  .= '<div class="col-12 shadow-md border rounded bg-danger text-white text-center">'.'صورت حساب پرداخت نشده'.'</div>';
	}elseif($os == 'completed'){
		$html  .= '<div class="col-12 shadow-md border rounded bg-success text-white text-center">'.'صورت حساب پرداخت شده است'.'</div>';
	}elseif($os == 'processing'){
		$html  .= '<div class="col-12 shadow-md border rounded bg-success text-white text-center">'.'صورت حساب پرداخت شده است'.'</div>';
	}else{
		
	}