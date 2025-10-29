<?php 
	$lemp = get_current_user_id(); 	
	global $wpdb ; 

	if (isset($_GET['target_id'])){
		$the_target = $_GET['target_id'];
		$sql = "
			SELECT 
			a.id AS id,
			a.target_id as target_id ,
			a.product_id as product_id , 
			a.type AS type,
			a.qty AS qty,
			a.used AS used,
			c.post_title as product_title
			FROM `target_products` as a 
			LEFT JOIN edu_posts AS c on a.product_id = c.ID
			WHERE a.target_id = '{$the_target}'
		";
	}else{
		$the_target = 0 ;
		$sql = '';
	}

	$results = $wpdb->get_results($sql);
	$total_results = count($results);
	$i = 0 ;
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
		.z-base-zero{
			position:relative;
			z-index:0;
		}
    </style>

	
    <div class="container position-relative z-base-zero">
        <div class="table-container">
            <h2 class="mb-4">محصولات تارگت شده</h2>
            <div class="loading">در حال بارگذاری...</div>
            <table class="table table-striped table-bordered mb-5 mt-5" width="100%">
                <thead>
                    <tr>
                        <th>شناسه</th>
						<th>عنوان</th>
						<th>نوع</th>
                        <th>مقدار پایه</th>
						<th>تخصیص داده شده</th>
						<th>عملیات</th>
                    </tr>
                </thead>
				<tbody>
					<?php 
						$h ='';
						foreach($results as $item){
							$i++;
							$h .='<tr>';
								$h .='<td>'.$i.'</td>';
								$h .='<td>'.$item->product_title.'</td>';
								$h .='<td>'.$item->type .'</td>';
								$h .='<td>'.$item->qty .'</td>';
								$h .='<td>'.$item->used .'</td>';
								$h .='<td>';
									$h .='<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#targetModal"';
										$h .= ' onclick="set_product_target_to_branch(\''.$lemp.'\' , \''.$item->product_id.'\' , \''.$item->target_id.'\')"';
										$h .='>تخصیص به نماینده';
									$h .='</button>';
								$h .='</td>';
							$h .='</tr>';
						}
						echo $h;
					?>
				</tbody>
            </table>
        </div>
    </div>

	
