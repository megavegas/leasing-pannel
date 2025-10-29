<?php 
$today = $order->get_date_created();
$date = new DateTime($today);
$expiration_days = get_option('proforma_invoice_expiration_day');
// افزودن 9 روز به تاریخ
$date->add(new DateInterval('P'.$expiration_days.'D'));
$expire_date = $date->format('Y/m/d') ; 
$expire_date = new DateTime($expire_date);
	

	$order_status = $order->get_status();

	if ($order_status == 'compleated'){
		$html .='<div class="col-12" style="color:#000;background:#f1f1f1;padding:20px;margin:0 0 10px 0; border:1px solid #000 ">';
			$html .='سفارش تکمیل شده است';
		$html .='</div>';
	}elseif($order_status == 'prossessing'){
		$html .='<div class="col-12" style="color:#000;background:#f1f1f1;padding:20px;margin:0 0 10px 0; border:1px solid #000 ">';
			$html .='سفارش پرداخت شده است اما پس از تکمیل  ';
		$html .='</div>';
	}elseif($order_status == 'half_payed_bmi'){
		// $html .='<div class="col-12" style="color:#000;background:#f1f1f1;padding:20px;margin:0 0 10px 0; border:1px solid #000 ">';
		// 	$html .='سفارش به صورت چند باره پرداخت شده است و نیازمند تأیید ادمین است ';
		// $html .='</div>';
	}elseif($order_status == 'ersal_shode'){
		$html .='<div class="col-12" style="color:#000;background:#f1f1f1;padding:20px;margin:0 0 10px 0; border:1px solid #000 ">';
			$html .='این سفارش ارسال شده است و وضعیت آن غیر قابل تغییر خواهد بود ';
		$html .='</div>';
	}elseif($order_status == 'cancelled'){
		$html .='<div class="col-12" style="color:#000;background:#f1f1f1;padding:20px;margin:0 0 10px 0; border:1px solid #000 ">';
			$html .='این سفارش لغو شده است و وضعیت آن غیر قابل تغییر خواهد بود';
		$html .='</div>';
	}elseif($order_status == 'pending'){
		$html .='<div class="col-12" style="color:#000;background:#f1f1f1;padding:20px;margin:0 0 10px 0; border:1px solid #000 ">';
			$html .='این سفارش هنوز پرداخت نشده است تا وضعیت این سفارش مشخص نشود شما قادر به ثبت سفارش دیگری در سیستم نخواهید بود';
		$html .='</div>';
	}
	
	if ($order_status == 'cancelled' || $order_status == 'pending'){
		$html .='<div class="invoice_footer d-flex flex-wrap">';
			$html .='<div class="col-12">';
				
				if ($order_id != '68418'){
					$html .='<p><span>این پیش فاکتور مربوط به طرح : </span><strong style="color:red">'.get_the_title($order_details[0]->plan_id).'</strong></p>';
					if ($discount>0){
						$html .='<div>آقای / خانم <strong>'.get_user_meta($user_id , 'first_name' , true).' '.get_user_meta($user_id , 'last_name' , true).'</strong> بر اساس پیش فاکتور صادر شده مبلغ وام درخواستی شما <strong style="color:red;">'.$ftotal.'</strong>ریال می باشد</div>';
					}else{
						$html .='<div>آقای / خانم <strong>'.get_user_meta($user_id, 'first_name' , true).' '.get_user_meta($user_id , 'last_name' , true).'</strong> بر اساس پیش فاکتور صادر شده مبلغ وام درخواستی شما <strong style="color:red;">'.$ftotal.'</strong>ریال می باشد</div>';
					}

					
					$html .='<p><strong>پیش فاکتور صادر شده صرفا جهت ارائه به بانک بوده و فاقد هر گونه ارزش دیگر است . </strong></p>';
					// $html .='<p><strong style="color:red">توجه : </strong><span>این پیش فاکتور پس از تاریخ '.$formatter->format($expire_date).' لغو شده در نظر گرفته شده و فاقد هیچ گونه ارزشی می باشد</span></p>';
					$html .='<p><strong style="color:red">توجه : </strong><span>همتالونز در خصوص موجود بودن کالا در زمان مراجعه مشتری و یا تغییرات قیمت کالای مندرج در این پیش فاکتور هیچ گونه تعهدی نخواهد داشت </span></p>';
					$html .='<p><strong style="color:green">توصیه : </strong><strong><span>با کوتاه تر نمودن فرایند دریافت تسهیلات از بوجود آمدن موارد فوق یعنی نا موجود شدن و یا تغییر قیمت تا حد امکان جلوگیری فرمایید </span></strong></p>';
					
				}else{
					$html .='<p><strong style="color:red">شما مجاز به استفاده از این پیش فاکتور جهت دریافت وام نمی باشید .</strong></p>';
				}
				

			$html .='</div>';

		$html .='</div>';
	}