
    <style>
        .dashboard-container {
            padding: 20px;
            background-color: #f8f9fa;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-right: 4px solid #4a90e2;
        }
        .stat-card.active-branches {
            border-right-color: #28a745;
        }
        .filters {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: right;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .positive-change { color: #28a745; }
        .negative-change { color: #dc3545; }
        .loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255,255,255,0.9);
            padding: 20px;
            border-radius: 8px;
            display: none;
        }
    </style>
	
    <div class="dashboard-container">
        <div class="stats-grid">
            <!-- نمایندگان فعال -->
            <div class="stat-card active-branches">
                <h3>نمایندگان فعال دیروز</h3>
                <p class="active-branches-count">0</p>
            </div>
            <div class="stat-card">
                <h3>کل سفارشات</h3>
                <p class="total-orders">0</p>
            </div>
            <div class="stat-card">
                <h3>سفارشات موفق</h3>
                <p class="successful-orders">0</p>
            </div>
            <div class="stat-card">
                <h3>سفارشات لغو شده</h3>
                <p class="cancelled-orders">0</p>
            </div>
        </div>

        <div class="filters">
            <select id="branchFilter">
                <option value="">همه نمایندگان من</option>
            </select>
            <select id="planFilter">
                <option value="">همه طرح‌ها</option>
            </select>
            <select id="statusFilter">
                <option value="">همه وضعیت‌ها</option>
                <option value="increase">افزایشی</option>
                <option value="decrease">کاهشی</option>
            </select>
        </div>

        <div class="table-container">
            <table id="comparisonTable">
                <thead>
                    <tr>
                        <th>نماینده</th>
                        <th>طرح</th>
                        <th>شماره سفارش</th>
                        <th>تاریخ</th>
                        <th>سفارشات دیروز</th>
                        <th>موفق</th>
                        <th>لغو شده</th>
                        <th>درصد تغییر</th>
                        <th>وضعیت</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="loading">در حال بارگذاری...</div>

    <script>
        jQuery(document).ready(function($) {
            const leasing_employee_id = <?php echo get_current_user_id(); ?>;

            function fetchData() {
                $('.loading').show();
                
                $.ajax({
                    url: 'https://hamtaloans.com/accounts/leasing/layout/dashboard/sale_dashboards/sale_compair_ajax_dayli.php',
                    type: 'POST',
                    data: {
                        leasing_employee_id: leasing_employee_id,
                        branch: $('#branchFilter').val(),
                        plan: $('#planFilter').val(),
                        status: $('#statusFilter').val()
                    },
                    success: function(response) {
                        updateDashboard(response);
                        $('.loading').hide();
                    },
                    error: function() {
                        alert('خطا در دریافت اطلاعات');
                        $('.loading').hide();
                    }
                });
            }

            function updateDashboard(data) {
                // به‌روزرسانی آمار کلی
                $('.active-branches-count').text(data.activeBranchesCount);
                $('.total-orders').text(data.totalOrders);
                $('.successful-orders').text(data.successfulOrders);
                $('.cancelled-orders').text(data.cancelledOrders);

                // به‌روزرسانی جدول
                const tbody = $('#comparisonTable tbody');
                tbody.empty();

                data.comparisons.forEach(item => {
                    const changeClass = item.changePercentage >= 0 ? 'positive-change' : 'negative-change';
                    const row = `
                        <tr>
                            <td>${item.branchName}</td>
                            <td>${item.planName}</td>
                            <td>${item.orderId}</td>
                            <td>${item.orderDate}</td>
                            <td>${item.yesterdayOrders}</td>
                            <td>${item.yesterdaySuccessful}</td>
                            <td>${item.yesterdayCancelled}</td>
                            <td class="${changeClass}">${item.changePercentage}%</td>
                            <td>${item.orderStatus}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });

                // به‌روزرسانی فیلتر نمایندگان اگر خالی است
                if ($('#branchFilter option').length <= 1) {
                    const branchFilter = $('#branchFilter');
                    data.branches.forEach(branch => {
                        branchFilter.append(`<option value="${branch.id}">${branch.name}</option>`);
                    });
                }
            }

            // رویدادهای فیلترها
            $('.filters select').on('change', fetchData);

            // بارگذاری اولیه
            fetchData();

            // به‌روزرسانی خودکار
            setInterval(fetchData, 300000);
        });
    </script>