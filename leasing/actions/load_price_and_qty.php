<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');


$product_id = $_POST['product_id'];
$product 	= wc_get_product($product_id);

if ($product){
	echo $product->get_price();
}else{
	echo 0;
}


