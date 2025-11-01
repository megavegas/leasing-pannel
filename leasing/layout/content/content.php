<div class="">
	<?php 
		$pages 			= '/home/hamtaloa/domains/hamtaloans.com/private_html/accounts/leasing/pages/';
		$order 			= '/home/hamtaloa/domains/hamtaloans.com/private_html/accounts/leasing/order/';
		$sale 			= '/home/hamtaloa/domains/hamtaloans.com/private_html/accounts/leasing/pages/sale/';
		$sale_dashboards= '/home/hamtaloa/domains/hamtaloans.com/private_html/accounts/leasing/layout/dashboard/sale_dashboards/';
		$targets		= '/home/hamtaloa/domains/hamtaloans.com/private_html/accounts/leasing/pages/target/';
		$layout			= '/home/hamtaloa/domains/hamtaloans.com/private_html/accounts/leasing/layout/';
		$tools			= '/home/hamtaloa/domains/hamtaloans.com/private_html/accounts/leasing/pages/tools/';
										 
		if (isset($_GET)){
			if (isset($_GET['leasing'])){
				if ($_GET['leasing'] == 'add_new_user'){
					require_once($pages.'new_branch.php');
				}elseif($_GET['leasing'] == 'remove_branch'){
					require_once($pages.'remove_branch.php');
				}elseif($_GET['leasing'] == 'branch_to_seller'){
					require_once($pages.'branch_to_seller.php');
				}elseif($_GET['leasing'] == 'search_branch'){
					require_once($pages.'/my_branch/list_of_branches.php');
				}elseif($_GET['leasing'] == 'quik_edit_sellers'){
					require_once($pages.'quik_edit_sellers.php');
				}elseif($_GET['leasing'] == 'edit_branch'){
					require_once($pages.'/my_branch/edit_my_branch.php');
				}elseif($_GET['leasing'] == 'remove_sellers'){
					require_once($pages.'remove_sellers.php');
				}elseif($_GET['leasing'] == 'branch_all_customer'){
					require_once('/mega/inc/pages/account/leasing/pages/my_branch/all_customers.php');
				}elseif($_GET['leasing'] == 'all_customers'){
					require_once($pages.'/my_branch/all_customers.php');
				}elseif($_GET['leasing'] == 'order'){
					require_once($pages.'/my_branch/order.php');
				}elseif($_GET['leasing'] == 'saller_to_branch'){
					require_once($pages.'saller_to_branch.php');
				}elseif($_GET['leasing'] == 'saller_to_branch'){
					require_once($pages.'saller_to_branch.php');
				}elseif($_GET['leasing'] == 'saller_to_branch'){
					require_once($pages.'saller_to_branch.php');
				}elseif($_GET['leasing'] == 'customer_to_branch'){
					require_once($pages.'customer_to_branch.php');
				}elseif($_GET['leasing'] == 'add_custom_invoice'){
					require_once($pages.'add_custom_invoice.php');
				}elseif($_GET['leasing'] == 'search_order'){
					require_once($order.'search.php');
				}elseif($_GET['leasing'] == 'edit_my_account'){
					require_once($pages.'edit_my_account.php');
				}elseif($_GET['leasing'] == 'edit_branch_number'){
					require_once($pages.'/my_branch/edit_branch_number.php');
				}elseif($_GET['leasing'] == 'branch_to_user'){
					require_once($pages.'/my_branch/branch_to_user.php');
				}
				elseif($_GET['leasing'] == 'add_new_customer_to_branch'){
					require_once($pages.'add_new_customer_to_branch.php');
				}
				elseif($_GET['leasing'] == 'reprot_home'){
					require_once($layout.'dashboard/report_home.php');
				}
				else{
					require_once($layout.'dashboard/dashboard.php');
				}
			}elseif (isset($_GET['sale'])){
				$sale_val = $_GET['sale'] ; 
				require_once($sale.'sale.php');
			}elseif (isset($_GET['compair'])){
				$sale_val = $_GET['compair'] ; 
				require_once($sale_dashboards.'sale_compair.php');
			}elseif (isset($_GET['dashboard'])){
				$sale_val = $_GET['dashboard'] ; 
				require_once($sale_dashboards.'general_dashboard.php');
			}elseif (isset($_GET['target'])){
				$sale_val = $_GET['target'] ;
				if ($sale_val == 'my'){
					require_once($targets.'my_target.php');
				}elseif($sale_val == 'see_products'){
					require_once($targets.'see_products.php');
				}
				
			}elseif (isset($_GET['tools'])){
				$sale_val = $_GET['tools'] ;
				if ($sale_val == 'bajet_balance'){
					require_once($tools.'bajet_balance.php');
				}elseif($sale_val == 'change_plan'){
					require_once($tools.'change_order_plan.php');
				}elseif($sale_val == 'check_cash_payment_bill'){
					
					if (isset($_GET['bill_id'])){
						require_once($tools.'cahs_bill_id.php');
					}else{
						require_once($tools.'check_cash_payment_bill.php');
					}
				}

				
				
			}else{
				require_once($layout.'dashboard/dashboard.php');
			}
		}else{
			require_once($layout.'dashboard/dashboard.php');
		}
	?>
</div>