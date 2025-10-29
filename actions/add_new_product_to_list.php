<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');


$product_id =  $_POST['product_id'];
$product 	=  wc_get_product($product_id);
$price 		=  $_POST['price'];
$qty 		=  $_POST['qty'];
if ($product){
	
	$html ='<div class="added_item" product="'.$product_id.'">';
		$html .='<div style="width:60px;"><img src="'.wp_get_attachment_image_url($product->get_image_id(), 'thumbnail').'"></div>';
		$html .='<input  type="hidden" product="'.$product_id.'"  price="'.$price.'"  qty="'.$qty.'">';
		$html .='<div>'.get_the_title($product_id).'</div>';
		$html .='<div price="'.$price.'">'.number_format($price).'</div>';
		$html .='<div qty="'.$qty.'">'.$qty.'</div>';
		$html .='<div><button class="remove-item-btn" onclick="remove_item_from_list(this)" Style="background:red;" data-pid="'.$product_id.'" >حذف از لیست</button></div>';
	$html .='<div>';
	echo $html;
}


