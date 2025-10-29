<?php 
	echo $sale_val ;
	$lemp = get_current_user_id(); 
	
	global $wpdb ; 
	
	
?>

	<style>
        .table-container {
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: 20px auto;
        }
        .table thead th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255,255,255,0.8);
            padding: 20px;
            border-radius: 5px;
            display: none;
        }
    </style>

    <div class="container-fluid">
        <div class="table-container">
            <h2 class="mb-4">سفارش‌های امروز</h2>
            <div class="loading">در حال بارگذاری...</div>
            <table id="ordersTable" class="table table-striped table-bordered mb-5 mt-5" width="100%">
                <thead>
                    <tr>
                       
                        <th>سفارش</th>
						<th>نماینده</th>
                        <th>مشتری</th>
						<th>کد ملی مشتری</th>
                        <th>طرح</th>
                        <th>تاریخ</th>
                        <th>وضعیت</th>
						<th>مشاهده</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

	<script>
    jQuery.noConflict();
    
    (function($) {
        $(document).ready(function() {
            var ordersTable = $('#ordersTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 20,
                ajax: {
                    url: 'https://hamtaloans.com/accounts/leasing/pages/sale/get_orders.php?cond=<?php echo $sale_val; ?>',
                    type: 'POST',
                    beforeSend: function() {
                        $('.loading').show();
                    },
                    complete: function() {
                        $('.loading').hide();
                    }
                },
                columns: [
                    { data: 'order_id' },
                    { data: 'branch_id' },
                    { data: 'customer_id' },
                    { data: 'customer_national_code' },
                    { data: 'plan_id' },
                    { data: 'post_date' },
                    { data: 'post_status' },
					{ data: 'oooo' }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Persian.json'
                },
                order: [[5, 'desc']], // تغییر به 5 برای ستون تاریخ
                responsive: true,
                dom: 'Bfrtip',
                lengthMenu: [[20, 50, 100], [20, 50, 100]]
            });

            $('.loading').on('click', function() {
                $(this).hide();
            });

            function refreshTable() {
                ordersTable.ajax.reload(null, false);
            }

            setInterval(refreshTable, 300000);
        });
    })(jQuery);

    window.jq = jQuery;
</script>


