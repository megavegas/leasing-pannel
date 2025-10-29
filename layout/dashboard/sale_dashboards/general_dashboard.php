<style>
	:root {
		--primary-color: #4a90e2;
		--success-color: #28a745;
		--danger-color: #dc3545;
		--warning-color: #ffc107;
		--border-radius: 8px;
	}
	
	.dashboard-container {
		padding: 20px;
		background-color: #f8f9fa;
		font-family: Vazir, Tahoma, sans-serif;
	}

	/* تب‌ها */
	.tabs-container {
		display: flex;
		gap: 10px;
		margin-bottom: 20px;
		background: white;
		padding: 15px;
		border-radius: var(--border-radius);
		overflow-x: auto;
		box-shadow: 0 2px 4px rgba(0,0,0,0.05);
	}

	.tab-button {
		padding: 10px 20px;
		border: none;
		background: #f0f0f0;
		border-radius: 4px;
		cursor: pointer;
		white-space: nowrap;
		transition: all 0.3s ease;
	}

	.tab-button.active {
		background: var(--primary-color);
		color: white;
	}

	/* بازه زمانی */
	.time-range-selector {
		display: flex;
		gap: 10px;
		margin-bottom: 20px;
		flex-wrap: wrap;
	}

	.time-button {
		padding: 8px 16px;
		border: 1px solid #ddd;
		background: white;
		border-radius: 4px;
		cursor: pointer;
		transition: all 0.3s ease;
		min-width: 80px;
		text-align: center;
	}

	.time-button.active {
		background: var(--primary-color);
		color: white;
		border-color: var(--primary-color);
	}

	/* کارت‌های آماری */
	.stats-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
		gap: 20px;
		margin-bottom: 30px;
	}

	.stat-card {
		background: white;
		padding: 20px;
		border-radius: var(--border-radius);
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		transition: transform 0.3s ease;
	}

	.stat-card:hover {
		transform: translateY(-5px);
	}

	.stat-card h3 {
		color: #666;
		font-size: 0.9rem;
		margin: 0 0 10px 0;
	}

	.stat-card p {
		font-size: 1.5rem;
		margin: 0;
		color: #333;
	}

	/* نمودارها */
	.charts-grid {
		display: grid;
		grid-template-columns: 2fr 1fr;
		gap: 20px;
		margin-bottom: 30px;
	}

	.chart-container {
		background: white;
		padding: 20px;
		border-radius: var(--border-radius);
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	}

	.chart-container h3 {
		margin: 0 0 20px 0;
		color: #333;
		font-size: 1.1rem;
	}

	/* جداول */
	.data-tables {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
		gap: 20px;
	}

	.data-table {
		width: 100%;
		border-collapse: collapse;
		background: white;
		border-radius: var(--border-radius);
		overflow: hidden;
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	}

	.data-table th,
	.data-table td {
		padding: 12px 15px;
		text-align: right;
		border-bottom: 1px solid #eee;
	}

	.data-table th {
		background: #f8f9fa;
		font-weight: 500;
		color: #666;
	}

	.data-table tbody tr:hover {
		background: #f8f9fa;
	}

	/* نشانگر تغییرات */
	.change-indicator {
		display: inline-flex;
		align-items: center;
		font-size: 0.9rem;
		padding: 3px 8px;
		border-radius: 4px;
	}

	.positive-change {
		color: var(--success-color);
		background: rgba(40, 167, 69, 0.1);
	}

	.negative-change {
		color: var(--danger-color);
		background: rgba(220, 53, 69, 0.1);
	}

	/* لودینگ */
	.loading {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: rgba(255,255,255,0.8);
		display: none;
		justify-content: center;
		align-items: center;
		z-index: 1000;
	}

	.loading::after {
		content: '';
		width: 40px;
		height: 40px;
		border: 4px solid #f3f3f3;
		border-top: 4px solid var(--primary-color);
		border-radius: 50%;
		animation: spin 1s linear infinite;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}

	/* ریسپانسیو */
	@media (max-width: 768px) {
		.charts-grid {
			grid-template-columns: 1fr;
		}
		
		.data-tables {
			grid-template-columns: 1fr;
		}

		.time-range-selector {
			justify-content: center;
		}
	}
</style>
</head>
<body>
<div class="dashboard-container">
	<!-- تب‌ها -->
	<div class="tabs-container">
		<button class="tab-button active" data-tab="overview">نمای کلی</button>
		<button class="tab-button" data-tab="products">تحلیل محصولات</button>
		<button class="tab-button" data-tab="branches">تحلیل نمایندگان</button>
		<button class="tab-button" data-tab="payments">تحلیل پرداخت‌ها</button>
		<button class="tab-button" data-tab="trends">روندها</button>
	</div>

	<!-- بازه زمانی -->
	<div class="time-range-selector">
		<button class="time-button active" data-range="daily">روزانه</button>
		<button class="time-button" data-range="weekly">هفتگی</button>
		<button class="time-button" data-range="monthly">ماهانه</button>
		<button class="time-button" data-range="quarterly">فصلی</button>
		<button class="time-button" data-range="yearly">سالانه</button>
	</div>

	<!-- تب نمای کلی -->
	<div id="overview" class="tab-content active">
		<!-- کارت‌های آماری -->
		<div class="stats-grid">
			<div class="stat-card">
				<h3>نمایندگان فعال</h3>
				<p class="active-branches-count">0</p>
				<span class="change-indicator active-branches-change"></span>
			</div>
			<div class="stat-card">
				<h3>فروش موفق</h3>
				<p class="successful-sales">0</p>
				<span class="change-indicator sales-change"></span>
			</div>
			<div class="stat-card">
				<h3>مجموع فروش</h3>
				<p class="total-amount">0</p>
				<span class="change-indicator amount-change"></span>
			</div>
			<div class="stat-card">
				<h3>میانگین رشد</h3>
				<p class="average-growth">0%</p>
				<span class="change-indicator growth-change"></span>
			</div>
		</div>

		<!-- نمودارها -->
		<div class="charts-grid">
			<div class="chart-container" style="position: relative; height: 700px;">
				<h3>روند فروش</h3>
				<canvas id="salesTrendChart"></canvas>
			</div>
			<div class="chart-container" style="position: relative; height: 700px;">
				<h3>توزیع محصولات</h3>
				<canvas id="productsChart"></canvas>
			</div>
		</div>

		<!-- جداول -->
		<div class="data-tables">
			<!-- نمایندگان برتر -->
			<div class="table-wrapper">
				<h3>نمایندگان برتر</h3>
				<table class="data-table" id="topBranchesTable">
					<thead>
						<tr>
							<th>نماینده</th>
							<th>تعداد فروش</th>
							<th>مبلغ کل</th>
							<th>درصد رشد</th>
							<th>محصول پرفروش</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

			<!-- محصولات پرفروش -->
			<div class="table-wrapper">
				<h3>محصولات پرفروش</h3>
				<table class="data-table" id="productsTable">
					<thead>
						<tr>
							<th>محصول</th>
							<th>تعداد فروش</th>
							<th>مبلغ کل</th>
							<th>درصد رشد</th>
							<th>تعداد نمایندگان</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- نمایشگر در حال بارگیری -->
	<div class="loading"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
	jQuery(document).ready(function($) {
		// متغیرهای سراسری
		let currentTimeRange = 'daily';
		let salesTrendChart = null;
		let productsChart = null;
		let chartInstances = {
			salesTrend: null,
			products: null
		};

		function destroyCharts() {
			Object.values(chartInstances).forEach(chart => {
				if (chart) {
					chart.destroy();
				}
			});
		}
		const baseChartOptions = {
			responsive: true,
			maintainAspectRatio: false,
			animation: {
				duration: 0 // حذف انیمیشن برای بهبود عملکرد
			},
			responsiveAnimationDuration: 0, // حذف انیمیشن responsive
			plugins: {
				legend: {
					position: 'bottom',
					rtl: true
				}
			}
		};
		// تابع اصلی به‌روزرسانی داشبورد
		function updateDashboard(data) {
			if (!data) {
				console.error('No data received');
				return;
			}
			
			try {
				console.log('Received data:', data); // برای دیباگ
				updateSummary(data.summary);
				updateCharts(data);
				updateTables(data);
			} catch (error) {
				console.error('Error updating dashboard:', error);
			}
		}

		// دریافت داده‌ها از سرور
		function fetchData() {
			$('.loading').show();
			
			$.ajax({
				url: 'https://hamtaloans.com/accounts/leasing/layout/dashboard/sale_dashboards/general_dashboard_ajax.php',
				type: 'POST',
				data: {
					leasing_employee_id: "<?php echo get_current_user_id(); ?>",
					time_range: currentTimeRange
				},
				success: function(response) {
					if (response.success) {
						lastData = response.data;
						updateDashboard(response.data);
					} else {
						showError(response.message || 'خطا در دریافت اطلاعات');
					}
				},
				error: function(xhr, status, error) {
					console.error('AJAX Error:', error);
					showError('خطا در برقراری ارتباط با سرور');
				},
				complete: function() {
					$('.loading').hide();
				}
			});
		}

		// به‌روزرسانی آمار کلی
		// function updateSummary(summary) {
		// 	$('.active-branches-count').text(formatNumber(summary.activeBranches.count));
		// 	$('.successful-sales').text(formatNumber(summary.sales.total));
		// 	$('.total-amount').text(formatMoney(summary.sales.amount));
		// 	$('.average-growth').text(formatPercent(summary.sales.growth));

		// 	updateChangeIndicator('.active-branches-change', summary.activeBranches.growth);
		// 	updateChangeIndicator('.sales-change', summary.sales.growth);
		// 	updateChangeIndicator('.amount-change', summary.amount.growth);
		// 	updateChangeIndicator('.growth-change', summary.growth.change);
		// }
		function updateSummary(summary) {
			try {
				// بررسی وجود داده و مقداردهی پیش‌فرض
				const activeBranches = summary?.activeBranches?.count || 0;
				const totalSales = summary?.sales?.total || 0;
				const totalAmount = summary?.sales?.total_amount || 0;
				const growth = summary?.sales?.growth || 0;

				// به‌روزرسانی مقادیر
				$('.active-branches-count').text(formatNumber(activeBranches));
				$('.successful-sales').text(formatNumber(totalSales));
				$('.total-amount').text(formatMoney(totalAmount));
				$('.average-growth').text(formatPercent(growth));

				// به‌روزرسانی نشانگرهای تغییر
				if (summary?.activeBranches?.growth !== undefined) {
					updateChangeIndicator('.active-branches-change', summary.activeBranches.growth);
				}
				if (summary?.sales?.growth !== undefined) {
					updateChangeIndicator('.sales-change', summary.sales.growth);
				}
				if (summary?.sales?.total_amount_growth !== undefined) {
					updateChangeIndicator('.amount-change', summary.sales.total_amount_growth);
				}
				if (summary?.sales?.average_growth !== undefined) {
					updateChangeIndicator('.growth-change', summary.sales.average_growth);
				}
			} catch (error) {
				console.error('Error in updateSummary:', error);
				console.log('Received summary data:', summary);
			}
		}

		

		function updateCharts(data) {
			if (!data) return;

			// نمودار روند
			if (data.trend) {
				updateSalesTrendChart(data.trend);
			}

			// نمودار محصولات
			if (data.summary && data.summary.products) {
				updateProductsChart(data.summary.products);
			}
		}


		$('.tab-button').on('click', function() {
			setTimeout(() => {
				// بازسازی نمودارها بعد از تغییر تب
				if (lastData) {
					updateCharts(lastData);
				}
			}, 100);
		});


		let lastData = null;

		// نمودار روند فروش
		function updateSalesTrendChart(trendData) {
			if (!trendData || !trendData.labels || !trendData.sales) {
				console.warn('Invalid trend data');
				return;
			}

			const ctx = document.getElementById('salesTrendChart');
			if (!ctx) return;

			if (salesTrendChart) {
				salesTrendChart.destroy();
			}

			salesTrendChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: trendData.labels,
					datasets: [
						{
							label: 'مبلغ فروش',
							data: trendData.sales,
							borderColor: '#4a90e2',
							tension: 0.4,
							fill: false,
							yAxisID: 'sales'
						},
						{
							label: 'تعداد سفارش',
							data: trendData.orders,
							borderColor: '#50e3c2',
							tension: 0.4,
							fill: false,
							yAxisID: 'orders'
						}
					]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					scales: {
						sales: {
							type: 'linear',
							position: 'left',
							title: {
								display: true,
								text: 'مبلغ فروش (ریال)'
							},
							ticks: {
								callback: value => formatMoney(value)
							}
						},
						orders: {
							type: 'linear',
							position: 'right',
							title: {
								display: true,
								text: 'تعداد سفارش'
							},
							grid: {
								drawOnChartArea: false
							}
						}
					}
				}
			});
		}

		function updateProductsChart(products) {
			if (!products || !Array.isArray(products.topSelling)) {
				console.warn('Invalid products data');
				return;
			}

			const ctx = document.getElementById('productsChart');
			if (!ctx) return;

			if (productsChart) {
				productsChart.destroy();
			}

			// محدود کردن به 5 محصول برتر برای نمایش بهتر
			const topProducts = products.topSelling.slice(0, 5);

			productsChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: topProducts.map(p => p.name),
					datasets: [{
						label: 'تعداد فروش',
						data: topProducts.map(p => p.count),
						backgroundColor: '#50e3c2',
						borderColor: '#3baf9f',
						borderWidth: 1
					}]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					plugins: {
						legend: {
							display: false
						},
						tooltip: {
							rtl: true,
							callbacks: {
								label: function(context) {
									let label = context.dataset.label || '';
									if (label) {
										label += ': ';
									}
									label += formatNumber(context.raw);
									return label;
								}
							}
						}
					},
					scales: {
						y: {
							beginAtZero: true,
							ticks: {
								callback: value => formatNumber(value)
							}
						}
					}
				}
			});
		}
		function updateTables(data) {
			try {
				// جدول نمایندگان برتر
				const branchesHtml = data.details.branches.bestPerforming.map(branch => `
					<tr>
						<td>${branch.name}</td>
						<td>${formatNumber(branch.orderCount)}</td>
						<td>${formatMoney(branch.totalSales)}</td>
						<td>${formatChangeIndicator(branch.growth)}</td>
						<td>${branch.topProduct}</td>
					</tr>
				`).join('');
				$('#topBranchesTable tbody').html(branchesHtml);

				// جدول محصولات
				const productsHtml = data.summary.products.topSelling.map(product => `
					<tr>
						<td>${product.name}</td>
						<td>${formatNumber(product.count)}</td>
						<td>${formatMoney(product.totalAmount)}</td>
						<td>${formatChangeIndicator(product.growth)}</td>
						<td>${formatNumber(product.uniqueBranches)}</td>
					</tr>
				`).join('');
				$('#productsTable tbody').html(productsHtml);
			} catch (error) {
				console.error('Error in updateTables:', error);
				console.log('Data received:', data);
			}
		}
		// توابع کمکی
		function formatMoney(amount) {
			return new Intl.NumberFormat('fa-IR').format(amount) + ' ریال';
		}

		function formatNumber(num) {
			return new Intl.NumberFormat('fa-IR').format(num);
		}

		function formatPercent(value) {
			return new Intl.NumberFormat('fa-IR', { 
				style: 'percent', 
				minimumFractionDigits: 1,
				maximumFractionDigits: 1 
			}).format(value / 100);
		}

		function formatChangeIndicator(value) {
			const absValue = Math.abs(value);
			const className = value >= 0 ? 'positive-change' : 'negative-change';
			const arrow = value >= 0 ? '↑' : '↓';
			return `<span class="${className}">${arrow} ${formatNumber(absValue)}%</span>`;
		}

		function updateChangeIndicator(selector, value) {
			$(selector).html(formatChangeIndicator(value));
		}

		function showError(message) {
			const errorDiv = $('.error-message');
			if (errorDiv.length === 0) {
				$('<div/>')
					.addClass('error-message')
					.text(message)
					.insertAfter('.time-range-selector')
					.fadeIn();
			} else {
				errorDiv.text(message).fadeIn();
			}
			setTimeout(() => {
				$('.error-message').fadeOut();
			}, 5000);
		}

		// رویدادها
		$('.time-button').on('click', function() {
			const newRange = $(this).data('range');
			if (newRange !== currentTimeRange) {
				currentTimeRange = newRange;
				$(this).siblings().removeClass('active');
				$(this).addClass('active');
				fetchData();
			}
		});

		// تب‌ها
		$('.tab-button').on('click', function() {
			const tab = $(this).data('tab');
			$('.tab-button').removeClass('active');
			$(this).addClass('active');
			$('.tab-content').hide();
			$(`#${tab}`).show();
		});

		// راه‌اندازی اولیه
		fetchData();

		// به‌روزرسانی خودکار
		setInterval(fetchData, 300000); // هر 5 دقیقه
	});
</script>