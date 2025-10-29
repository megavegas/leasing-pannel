<div class="container">
	<div class="row justify-content-center">
		<div class="w-100">
			<div class="search-form bg-white border-light rounded shadow-sm p-5 d-flex flex-wrap justify-content-center ">
				<input type="text" class="form-control-lg" name="search-input" placeholder="نام، کد ملی یا شماره تماس را وارد کنید" required>
    			<button type="submit" class="btn btn-primary btn-lg" onclick="acount_search_for_user()" >جستجو</button>
			</div>
		</div>
	</div>
</div>


<div class="container result_of_search">
	
</div>


<script>
	function acount_search_for_user (){
		jQuery.ajax({
			url: "https://hamtaloans.com/accounts/leasing/actions/search_for_customers.php",
			type: 'post',
			data : {
				track : jQuery('[name="search-input"]').val(),
			},
			success: function(result){
				jQuery('.result_of_search').html('');
				jQuery('.result_of_search').html(result);
			}
		});
	}
</script>