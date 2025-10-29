<?php 

$path = preg_replace('/accounts.*$/','',__DIR__);
include($path.'wp-load.php');
global $wpdb;

if ($_POST['track']) {
    $search_query = $_POST['track'];
    $args = [
        'meta_query' => [
            'relation' => 'OR',
            [
                'key'     => 'first_name',
                'value'   => $search_query,
                'compare' => 'LIKE'
            ],
            [
                'key'     => 'last_name',
                'value'   => $search_query,
                'compare' => 'LIKE'
            ],
            [
                'key'     => 'user_id_number',
                'value'   => $search_query,
                'compare' => 'LIKE'
            ],
            [
                'key'     => 'user_mobile',
                'value'   => $search_query,
                'compare' => 'LIKE'
            ],
        ]
    ];

    $user_query = new WP_User_Query($args);
    $users = $user_query->get_results();

    // بررسی اینکه کاربران یافت شده‌اند یا خیر
    if (!empty($users)) {
        $html = ''; // تعریف متغیر html قبل از حلقه
        ?>
		<div class="w-100  mb-5 p-5 bg-white mt-3 rounded border-light shadow-lg">
			<table class="w-100">
				<thead>
					<tr>
						<th>ردیف</th>
						<th>شناسه</th>
						<th>نام</th>
						<th>شماره تماس</th>
						<th>کد ملی</th>
						<th>عملیات</th>
					</tr>
				</thead>
				<tbody>
			<?php
			$counter = 1; // شمارنده برای ردیف
			foreach ($users as $item) {
				$user_cap = get_user_capabilities($item->ID);
				$cond = in_array("branch", user_cap);
				if ($cond){
					$user_mobile = get_user_meta($item->ID, 'user_mobile', true);
					$user_id_number = get_user_meta($item->ID, 'user_id_number', true);
					
					$html .= "<tr >";
						$html .= "<td>" . $counter . "</td>";
						$html .= "<td>" . $item->ID . "</td>";
						$html .= "<td>" . esc_html($item->data->display_name) . "</td>";
						$html .= "<td>" . esc_html($user_mobile) . "</td>";
						$html .= "<td>" . esc_html($user_id_number) . "</td>";
						$html .= "<td>";
							$html .='<div class="d-flex flex-wrap p-2">';
								$html .= "<div class='p-2'><button onclick='convert_thei_branch_to_customer(\"".get_current_user_id()."\" , \"".$item->ID."\")' class='btn btn-outline-secondary' style='font-size:12px;'>تبدیل به مشتری</button></div>";
								// $html .= "<div class='p-2'><button onclick='convert_this_user_to_branch(\"".get_current_user_id()."\" , \"".$item->ID."\")' class='btn btn-outline-danger' style='font-size:12px;'>تبدیل به نماینده</button></div>";
							$html .="</div>";
						$html .= "</td>";
					$html .= "</tr>";
					$counter++; // افزایش شمارنده
				}
				
			}
			echo $html;
			?>
				</tbody>
			</table>
		</div>
        <?php
    } else {
        echo 'هیچ کاربری یافت نشد.';
    }
}
