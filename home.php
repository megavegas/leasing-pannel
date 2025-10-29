<?php 
    require_once('accounts/leasing/action.php');
	$image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' );
?>

<!DOCTYPE html >
<html lang="fa"  dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>کارشناس فروش</title>
		
		<link rel="stylesheet" media="screen" href="https://www.hamtaloans.com/accounts/lib/bootstrap-5.3.3/dist/css/bootstrap.min.css">
		<link rel="stylesheet" media="screen" href="https://hamtaloans.com/accounts/lib/select2/dist/css/select2.min.css">
		
		<link rel="stylesheet" media="screen" href="https://www.hamtaloans.com/accounts/lib/bootstrap-5/css/bootstrap-utilities.rtl.min.css">
		<link rel="stylesheet" media="screen" href="https://hamtaloans.com/accounts/lib/data_tables/datatables.min.css">
		<link rel="stylesheet" media="screen" href="https://www.hamtaloans.com/accounts/leasing/assets/css/style.css">
		<script src="https://hamtaloans.com/wp-includes/js/jquery/jquery.min.js?ver=3.7.1" id="jquery-core-js"></script>
		<script src="https://hamtaloans.com/accounts/lib/data_tables/datatables.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
		<script src="https://hamtaloans.com/accounts/lib/select2/dist/js/select2.full.min.js"></script>
		
		<script src="https://www.hamtaloans.com/accounts/lib/bootstrap-5.3.3/dist/js/bootstrap.bundle.js"></script>
		<script src="https://www.hamtaloans.com/accounts/leasing/assets/js/leasing_account_js.js" id="jquery-core-js"></script>
    </head>
    <body class="rtl" style="overflow-x: hidden;">
			
        <div class="mega_user_account highlight" style="width:100%; z-index:1; position:relative ;">
			
			<?php require_once('layout/menu/top_menu/top_menu.php'); ?>
			<?php require_once('layout/content/content.php'); ?>
            
        </div>

        <footer>
			
			
		</footer>

		<canvas id="canvas-webgl" class="p-canvas-webgl"></canvas>
		<div class="modal fade bd-example-modal-xl" id="targetModal" tabindex="-1" aria-labelledby="targetModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-centered">
				<div class="modal-content">
					<!-- هدر مودال -->
					<div class="mega_modal_header modal-header d-flex justify-content-between align-items-center">
						<h5 class="modal-title" id="targetModalLabel"></h5>
						<button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="the_modal_content p-5">

					</div>
					<div class="mega_modal_footer modal-footer d-flex justify-content-between align-items-center">

					</div>
				</div>
			</div>
		</div>

		
    </body>
</html>