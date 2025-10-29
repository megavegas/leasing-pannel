<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');


print_r($_POST);
