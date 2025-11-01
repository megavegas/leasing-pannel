let leasing_action_path = 'https://hamtaloans.com/accounts/leasing/inc/';
function register_branch(leasing_employee_id){
	
	var fist_name=jQuery('[name="branch_first_name"]').val();
	var last_name =jQuery('[name="branch_last_name"]').val();
	var branch_id_number= jQuery('[name="branch_id_number"]').val();
	var cond_id_lenght =branch_id_number.length;

	var branch_state= jQuery('[name="branch_state"]').val();
	var branch_city=jQuery('[name="branch_city"]').val();
	var branch__address=jQuery('[name="branch__address"]').val();
	var branch_zip_postal_code=jQuery('[name="branch_zip_postal_code"]').val();
	var cond_post_code_length = branch_zip_postal_code.length;
	var branch_phone = jQuery('[name="branch_phone"]').val();
	var bp_length = branch_phone.length;

	var branch_mobile = jQuery('[name="branch_mobile"]').val();
	var bmob_length = branch_mobile.length;

	var branch_contract_serial = jQuery('[name="branch_contract_serial"]').val();
	
	var branch_serial_number=jQuery('[name="branch_serial_number"]').val();
	var branch_serial_number_lenght = branch_serial_number.length;
	
	let sendme = {
		"employee"					:leasing_employee_id,
		"first_name"					:fist_name,
		"last_name"					:last_name,
		"branch_id_number"			:branch_id_number,
		"branch_state"				:branch_state,
		"branch_city"				:branch_city,
		"branch__address"			:branch__address,
		"branch_zip_postal_code"	:branch_zip_postal_code,
		"branch_phone"				:branch_phone,
		"branch_mobile"				:branch_mobile,
		"branch_contract_serial"	:branch_contract_serial,
		"branch_serial_number"		:branch_serial_number,
	}
	
	var ale_ert = '';
	var cond1 , cond2 , cond3 , cond4 , cond5 , cond6 , cond7 = true;
	if (parseInt(branch_serial_number_lenght)<6){
		ale_ert =ale_ert+'سریال نمایندگی کمتر از ۶ رقم است .\n';
		cond1 = false;
	}else if(parseInt(branch_serial_number_lenght)>6){
		ale_ert =ale_ert+'سریال نمایندگی بیشتر از ۶ رقم است .\n';
		cond1 = false;
	}else{cond2 = true;}

	if (parseInt(cond_post_code_length)<10){
		ale_ert =ale_ert+'کد پستی نمایندگی کمتر از ۱۰ رقم است .\n';
		cond2 = false;
	}else if(parseInt(cond_post_code_length)>10){
		ale_ert =ale_ert+'کد پستی نمایندگی بیشتر از ۱۰ رقم است .\n';
		cond2 = false;
	}else{cond2 = true;}

	if (parseInt(cond_id_lenght)<10){
		ale_ert =ale_ert+'کد ملی نمایندگی کمتر از ۱۰ رقم است .\n';
		cond3 = false;
	}else if(parseInt(cond_id_lenght)>10){
		ale_ert =ale_ert+'کد ملی نمایندگی بیشتر از ۱۰ رقم است .\n';
		cond3 = false;
	}else{cond3 = true;}
	
	if (ale_ert == ''){
		ajax_add_new_branch(sendme);	
	}else{
		alert(ale_ert);
	}
	// ajax_add_new_branch(myJSON);
}


function ajax_add_new_branch(sendme){
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // document.getElementById("txtHint").innerHTML = this.responseText;
		
		jQuery('.mega_branch_create_user').html(this.response);
      }
    };
 	
    xmlhttp.open("POST", leasing_action_path+"add_branch.php", true);
    xmlhttp.send(JSON.stringify(sendme));
}




let url_base = 'https://hamtaloans.com/wp-content/themes/woodmart/mega/';


function changes_the_state_cities(state){
	changes_the_state_cities_ajax(state);
}

function changes_the_state_cities_ajax(state){
	var c = "state="+state ;
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // document.getElementById("txtHint").innerHTML = this.responseText;
		jQuery('[name="user_city"], [name="branch_city"]').html('');
		jQuery('[name="user_city"], [name="branch_city"]').html(this.response);
      }
    };
    xmlhttp.open("GET", url_base+"inc/functions/ajax/get_cities_of_state.php?"+c, true);
    xmlhttp.send(c);
}


jQuery('#all_branch_list').DataTable(
	{
		paging: true , 
		searching: true , 
		ordering:  true 
	}
);

jQuery('.tbl_branch_to_other_types').DataTable(
	{
		paging: true , 
		searching: true , 
		ordering:  true 
	}
);



jQuery('[name="submit_custom_order"]').click(function(){
	
});



function leasing_search_order(code){
	if (code=='byid'){
		var items = jQuery('[name="order_id"]').val();
		jQuery.ajax({
			url: "https://hamtaloans.com/accounts/leasing/actions/search_order_by_id.php",
			type: 'post', // performing a POST request
			data : {
				order_id : items,
			}, 
			success: function(result){
				jQuery('.leasing_searched_results').html(result);
			}
		});
	}else if (code = 'byname'){
		
	}
} 




function update_branch_now (id , bid){
	
	let omg ={
		'user_id_number' 			: jQuery('[name="branch_id_number"]').val(),
		'user_state'				: jQuery('[name="branch_state"]').val(),
		'user_city'					: jQuery('[name="branch_city"]').val(),
		'user_address'				: jQuery('[name="branch__address"]').val(),
		'user_phone'				: jQuery('[name="user_phone"]').val(),
		'user_mobile'				: jQuery('[name="branch_mobile"]').val(),
		'first_name' 				: jQuery('[name="branch_first_name"]').val(),
		'last_name'	 				: jQuery('[name="branch_last_name"]').val(),
		'zip_postal_code'			: jQuery('[name="branch_zip_postal_code"]').val(),
		'branch_serial_number'		: jQuery('[name="branch_serial_number"]').val(),
		"branch_contract_serial"	: jQuery('[name="branch_contract_serial"]').val(),
		'user_phone_number'			: jQuery('[name="user_mobile"]').val(),
		'show_admin_bar_front' 		: 'false',
		'role' 						: 'branch',
		"creator"					: id,
		'branch_id'					: bid
	}
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.response == 'yes'){
				alert('بروز رسانی با موفقیت به انجام رسید');
			}else{
				alert('متأسفانه بروز رسانی نماینده با موفقیت انجام نگردیدد');
			}
		}
    };
	var ac_path = 'https://hamtaloans.com/accounts/leasing/pages/my_branch/update_now_branch.php';
    xmlhttp.open("POST", ac_path);
    xmlhttp.send(JSON.stringify(omg));


}

function print_area_of(area){
	var css ='';
	var divContents = jQuery("#"+area).html();
	var a = window.open('', '', 'height=auto, width=100%');
	a.document.write('<html><head><link rel="stylesheet" id="bootstrap-css" href="https://hamtaloans.com/wp-content/themes/woodmart/css/bootstrap.min.css?ver=6.4.2" type="text/css" media="all"></head>');
	a.document.write('<body style="direction:rtl;font-size:12px;">'+divContents+'<style>.shop_informaition{border:1px solid #000;padding:10px;margin-bottom:10px;border-radius:10px;background:#f1f1f1}.mua_content{color:red}.table_header>.table_header:first-child{display:flex;justify-content:center;align-items:center}.table_header>.table_header:first-child h2{text-align:center;margin:0}.table_header>div:first-child{display:flex;justify-content:center;align-items:center}.table_header>div:first-child h2{margin:0}.table_header>div:nth-child(2){display:flex;justify-content:center;align-items:center}.table_header>div:last-child{display:flex;justify-content:center;align-items:center}.customer_informaition{border:1px solid #000;padding:10px;border-radius:10px}.cust_infor_title{display:flex;justify-content:center;align-items:center;font-size:12px;font-weight:900;border-bottom:1px solid gainsboro;margin-bottom:5px;padding:0 0 6px 0}.mega_invoice_title{margin:10px 0 10px 0;border:none;text-align:center;display:flex;justify-content:center;align-items:center;border-radius:10px;background:#f1f1f1}.mega_invoice_title>h2{margin:0;padding:10px}table.mega_invoice_table{border-collapse:separate;border-spacing:5px;width:100%}th.mega_invoice_th_tr_td{border:none;background:#eee;text-align:center;border-radius:10px}tbody.mega_invoice_tbody>tr.mega_invoice_tb_tr>td:nth-child(3),tbody.mega_invoice_tbody>tr.mega_invoice_tb_tr>td:nth-child(4),tbody.mega_invoice_tbody>tr.mega_invoice_tb_tr>td:nth-child(5){font-weight:900}tbody.mega_invoice_tbody>tr.mega_invoice_tb_tr>td{border:1px solid #cfcfcf;text-align:center;border-radius:10px;padding:6px}table.mega_invoice_tfooter{border-collapse:separate;border-spacing:5px;width:100%;height:90px}table.mega_invoice_tfooter>tbody>tr>td,table.mega_invoice_tfooter>tbody>tr>th{border:1px solid #eee;border-radius:10px;font-size:20px;text-align:center}th.mega_invoice_tf_tr_td{background:#f1f1f1}.mega_alert{padding:10px;position:relative;display:flex;justify-content:flex-start;align-items:center;margin-bottom:20px}.mega_alert-success{border:1px solid #d2dfde;border-radius:10px;background:#f2fffe}@font-face{font-family:IRANSans;font-style:normal;font-weight:900;src:url("fonts/fanum/eot/IRANSansWeb(FaNum)_Black.eot");src:url("fonts/fanum/eot/IRANSansWeb(FaNum)_Black.eot?#iefix") format("embedded-opentype"),url("fonts/fanum/woff2/IRANSansWeb(FaNum)_Black.woff2") format("woff2"),url("fonts/fanum/woff/IRANSansWeb(FaNum)_Black.woff") format("woff"),url("fonts/fanum/ttf/IRANSansWeb(FaNum)_Black.ttf") format("truetype")}@font-face{font-family:IRANSans;font-style:normal;font-weight:700;src:url("fonts/fanum/eot/IRANSansWeb(FaNum)_Bold.eot");src:url("fonts/fanum/eot/IRANSansWeb(FaNum)_Bold.eot?#iefix") format("embedded-opentype"),url("fonts/fanum/woff2/IRANSansWeb(FaNum)_Bold.woff2") format("woff2"),url("fonts/fanum/woff/IRANSansWeb(FaNum)_Bold.woff") format("woff"),url("fonts/fanum/ttf/IRANSansWeb(FaNum)_Bold.ttf") format("truetype")}@font-face{font-family:IRANSans;font-style:normal;font-weight:500;src:url("fonts/fanum/eot/IRANSansWeb(FaNum)_Medium.eot");src:url("fonts/fanum/eot/IRANSansWeb(FaNum)_Medium.eot?#iefix") format("embedded-opentype"),url("fonts/fanum/woff2/IRANSansWeb(FaNum)_Medium.woff2") format("woff2"),url("fonts/fanum/woff/IRANSansWeb(FaNum)_Medium.woff") format("woff"),url("fonts/fanum/ttf/IRANSansWeb(FaNum)_Medium.ttf") format("truetype")}@font-face{font-family:IRANSans;font-style:normal;font-weight:300;src:url("fonts/fanum/eot/IRANSansWeb(FaNum)_Light.eot");src:url("fonts/fanum/eot/IRANSansWeb(FaNum)_Light.eot?#iefix") format("embedded-opentype"),url("fonts/fanum/woff2/IRANSansWeb(FaNum)_Light.woff2") format("woff2"),url("fonts/fanum/woff/IRANSansWeb(FaNum)_Light.woff") format("woff"),url("fonts/fanum/ttf/IRANSansWeb(FaNum)_Light.ttf") format("truetype")}@font-face{font-family:IRANSans;font-style:normal;font-weight:200;src:url("fonts/fanum/eot/IRANSansWeb(FaNum)_UltraLight.eot");src:url("fonts/fanum/eot/IRANSansWeb(FaNum)_UltraLight.eot?#iefix") format("embedded-opentype"),url("fonts/fanum/woff2/IRANSansWeb(FaNum)_UltraLight.woff2") format("woff2"),url("fonts/fanum/woff/IRANSansWeb(FaNum)_UltraLight.woff") format("woff"),url("fonts/fanum/ttf/IRANSansWeb(FaNum)_UltraLight.ttf") format("truetype")}@font-face{font-family:IRANSans;font-style:normal;font-weight:400;src:url("fonts/fanum/eot/IRANSansWeb(FaNum).eot");src:url("fonts/fanum/eot/IRANSansWeb(FaNum).eot?#iefix") format("embedded-opentype"),url("fonts/fanum/woff2/IRANSansWeb(FaNum).woff2") format("woff2"),url("fonts/fanum/woff/IRANSansWeb(FaNum).woff") format("woff"),url("fonts/fanum/ttf/IRANSansWeb(FaNum).ttf") format("truetype")}*{font-family:iransans;}.invoice_mega_name{padding:0}.invoice_footer p{margin:0;font-size:12px}.invoice_footer>div:first-child{margin-bottom:40px}.invoice_footer{margin-bottom:40px}.col-lg-4 {width:calc(33.33% - 2px)!important;}@media print {button {visibility: hidden;}}</style><button onclick="window.print();"> چاپ پیش فاکتور </button></body></html>');
	a.focus();
	a.document.close();
	
}


function load_customers_of_branch (){
	var branch = jQuery('[name="branches"]').val();
	jQuery.ajax({
		url: "https://hamtaloans.com/accounts/leasing/actions/load_branch_customers.php",
		type: 'post', // performing a POST request
		data : {
			branch_id : branch,
		},
		success: function(result){
			jQuery('[name="load_customers"]').html(result);
			console.log(result);
		}
	});
}










    document.addEventListener("DOMContentLoaded", function() {

		class Plane {
		constructor() {
			this.uniforms = {
			time: {
				type: 'f',
				value: 0,
			},
			};
			this.mesh = this.createMesh();
			this.time = 0.03;
		}
		createMesh() {
			return new THREE.Mesh(
				
			new THREE.PlaneGeometry(256, 256, 256, 256),
			
			new THREE.RawShaderMaterial({
				uniforms: this.uniforms,
				vertexShader: "#define GLSLIFY 1\nattribute vec3 position;\n\nuniform mat4 projectionMatrix;\nuniform mat4 modelViewMatrix;\nuniform float time;\n\nvarying vec3 vPosition;\n\nmat4 rotateMatrixX(float radian) {\n  return mat4(\n    1.0, 0.0, 0.0, 0.0,\n    0.0, cos(radian), -sin(radian), 0.0,\n    0.0, sin(radian), cos(radian), 0.0,\n    0.0, 0.0, 0.0, 1.0\n  );\n}\n\n//\n// GLSL textureless classic 3D noise \"cnoise\",\n// with an RSL-style periodic variant \"pnoise\".\n// Author:  Stefan Gustavson (stefan.gustavson@liu.se)\n// Version: 2011-10-11\n//\n// Many thanks to Ian McEwan of Ashima Arts for the\n// ideas for permutation and gradient selection.\n//\n// Copyright (c) 2011 Stefan Gustavson. All rights reserved.\n// Distributed under the MIT license. See LICENSE file.\n// https://github.com/ashima/webgl-noise\n//\n\nvec3 mod289(vec3 x)\n{\n  return x - floor(x * (1.0 / 289.0)) * 289.0;\n}\n\nvec4 mod289(vec4 x)\n{\n  return x - floor(x * (1.0 / 289.0)) * 289.0;\n}\n\nvec4 permute(vec4 x)\n{\n  return mod289(((x*34.0)+1.0)*x);\n}\n\nvec4 taylorInvSqrt(vec4 r)\n{\n  return 1.79284291400159 - 0.85373472095314 * r;\n}\n\nvec3 fade(vec3 t) {\n  return t*t*t*(t*(t*6.0-15.0)+10.0);\n}\n\n// Classic Perlin noise\nfloat cnoise(vec3 P)\n{\n  vec3 Pi0 = floor(P); // Integer part for indexing\n  vec3 Pi1 = Pi0 + vec3(1.0); // Integer part + 1\n  Pi0 = mod289(Pi0);\n  Pi1 = mod289(Pi1);\n  vec3 Pf0 = fract(P); // Fractional part for interpolation\n  vec3 Pf1 = Pf0 - vec3(1.0); // Fractional part - 1.0\n  vec4 ix = vec4(Pi0.x, Pi1.x, Pi0.x, Pi1.x);\n  vec4 iy = vec4(Pi0.yy, Pi1.yy);\n  vec4 iz0 = Pi0.zzzz;\n  vec4 iz1 = Pi1.zzzz;\n\n  vec4 ixy = permute(permute(ix) + iy);\n  vec4 ixy0 = permute(ixy + iz0);\n  vec4 ixy1 = permute(ixy + iz1);\n\n  vec4 gx0 = ixy0 * (1.0 / 7.0);\n  vec4 gy0 = fract(floor(gx0) * (1.0 / 7.0)) - 0.5;\n  gx0 = fract(gx0);\n  vec4 gz0 = vec4(0.5) - abs(gx0) - abs(gy0);\n  vec4 sz0 = step(gz0, vec4(0.0));\n  gx0 -= sz0 * (step(0.0, gx0) - 0.5);\n  gy0 -= sz0 * (step(0.0, gy0) - 0.5);\n\n  vec4 gx1 = ixy1 * (1.0 / 7.0);\n  vec4 gy1 = fract(floor(gx1) * (1.0 / 7.0)) - 0.5;\n  gx1 = fract(gx1);\n  vec4 gz1 = vec4(0.5) - abs(gx1) - abs(gy1);\n  vec4 sz1 = step(gz1, vec4(0.0));\n  gx1 -= sz1 * (step(0.0, gx1) - 0.5);\n  gy1 -= sz1 * (step(0.0, gy1) - 0.5);\n\n  vec3 g000 = vec3(gx0.x,gy0.x,gz0.x);\n  vec3 g100 = vec3(gx0.y,gy0.y,gz0.y);\n  vec3 g010 = vec3(gx0.z,gy0.z,gz0.z);\n  vec3 g110 = vec3(gx0.w,gy0.w,gz0.w);\n  vec3 g001 = vec3(gx1.x,gy1.x,gz1.x);\n  vec3 g101 = vec3(gx1.y,gy1.y,gz1.y);\n  vec3 g011 = vec3(gx1.z,gy1.z,gz1.z);\n  vec3 g111 = vec3(gx1.w,gy1.w,gz1.w);\n\n  vec4 norm0 = taylorInvSqrt(vec4(dot(g000, g000), dot(g010, g010), dot(g100, g100), dot(g110, g110)));\n  g000 *= norm0.x;\n  g010 *= norm0.y;\n  g100 *= norm0.z;\n  g110 *= norm0.w;\n  vec4 norm1 = taylorInvSqrt(vec4(dot(g001, g001), dot(g011, g011), dot(g101, g101), dot(g111, g111)));\n  g001 *= norm1.x;\n  g011 *= norm1.y;\n  g101 *= norm1.z;\n  g111 *= norm1.w;\n\n  float n000 = dot(g000, Pf0);\n  float n100 = dot(g100, vec3(Pf1.x, Pf0.yz));\n  float n010 = dot(g010, vec3(Pf0.x, Pf1.y, Pf0.z));\n  float n110 = dot(g110, vec3(Pf1.xy, Pf0.z));\n  float n001 = dot(g001, vec3(Pf0.xy, Pf1.z));\n  float n101 = dot(g101, vec3(Pf1.x, Pf0.y, Pf1.z));\n  float n011 = dot(g011, vec3(Pf0.x, Pf1.yz));\n  float n111 = dot(g111, Pf1);\n\n  vec3 fade_xyz = fade(Pf0);\n  vec4 n_z = mix(vec4(n000, n100, n010, n110), vec4(n001, n101, n011, n111), fade_xyz.z);\n  vec2 n_yz = mix(n_z.xy, n_z.zw, fade_xyz.y);\n  float n_xyz = mix(n_yz.x, n_yz.y, fade_xyz.x);\n  return 2.2 * n_xyz;\n}\n\nvoid main(void) {\n  vec3 updatePosition = (rotateMatrixX(radians(90.0)) * vec4(position, 1.0)).xyz;\n  float sin1 = sin(radians(updatePosition.x / 128.0 * 90.0));\n  vec3 noisePosition = updatePosition + vec3(0.0, 0.0, time * -30.0);\n  float noise1 = cnoise(noisePosition * 0.08);\n  float noise2 = cnoise(noisePosition * 0.06);\n  float noise3 = cnoise(noisePosition * 0.4);\n  vec3 lastPosition = updatePosition + vec3(0.0,\n    noise1 * sin1 * 8.0\n    + noise2 * sin1 * 8.0\n    + noise3 * (abs(sin1) * 2.0 + 0.5)\n    + pow(sin1, 2.0) * 40.0, 0.0);\n\n  vPosition = lastPosition;\n  gl_Position = projectionMatrix * modelViewMatrix * vec4(lastPosition, 1.0);\n}\n",
				fragmentShader: "precision highp float;\n#define GLSLIFY 1\n\nvarying vec3 vPosition;\n\nvoid main(void) {\n  float opacity = (96.0 - length(vPosition)) / 256.0 * 0.6;\n  vec3 color = vec3(0.039, 0.345, 0.792);\n gl_FragColor = vec4(color, opacity);\n}\n",
				transparent: true
			})
			);
		}
		render(time) {
			this.uniforms.time.value += time * this.time;
		}
		}

		const canvas = document.getElementById('canvas-webgl');
		const renderer = new THREE.WebGLRenderer({
		antialias: false,
		canvas: canvas,
		});
		const scene = new THREE.Scene();
		const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 2, 10000);
		const clock = new THREE.Clock();

		const plane = new Plane();

		const resizeWindow = () => {
		canvas.width = window.innerWidth;
		canvas.height = window.innerHeight;
		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();
		renderer.setSize(window.innerWidth, window.innerHeight);
		}
		const on = () => {
		jQuery(window).on('resize', () => {
			resizeWindow();
		});
		}
		const render = () => {
		plane.render(clock.getDelta());
		renderer.render(scene, camera);
		}
		const renderLoop = () => {
		render();
		requestAnimationFrame(renderLoop);
		}

		const init = () => {
		renderer.setSize(window.innerWidth, window.innerHeight);
		renderer.setClearColor(0xeeeeee, 1.0);
		camera.position.set(0, 16, 128);
		camera.lookAt(new THREE.Vector3(0, 28, 0));

		scene.add(plane.mesh);

		on();
		resizeWindow();
		renderLoop();
		}
		init();

	});


jQuery('.sel2').select2();
	
function bco_getHiddenInputsValues() {
	let hiddenInputs = document.querySelectorAll('.added_item input[type="hidden"]');
	var items = {};
	var item ={};
	var i = 0 ;
	var branch = jQuery('[name="branches"]').val();
	var plan = jQuery('[name="plan"]').val();
	var customer = jQuery('[name="load_customers"]').val();
	items = {
		branch :branch,
		plan:plan,
		customer:customer
	}
	
	
	hiddenInputs.forEach((input, index) => {
        var product = input.getAttribute('product');
        var price = input.getAttribute('price');
        var quantity = input.getAttribute('qty');
        
        if (product !== '' && price !== '' && quantity !== '') {
            item[index] = {
                pro: product,
                qty: quantity,
                price: price
            };
        }
    });
    
    jQuery.extend(true, items, {products: item});
	return items;
}




function remove_item_from_list(event) {
    event.closest('.added_item').remove();
}


function add_new_product_to_customer_order (){

	var product = jQuery('[name="the_product"]').val();
	var qty = jQuery('[name="pqty_val"]').val();
	var price = jQuery('[name="pprice_val"]').val();
	if (jQuery('.added_item[product="' + product + '"]').length > 0) {
        alert("این محصول از قبل در لیست موجود است.");
        return; // جلوگیری از اضافه کردن محصول تکراری
    }
	jQuery.ajax({
		url: "https://hamtaloans.com/accounts/leasing/actions/add_new_product_to_list.php",
		type: 'post', // performing a POST request
		data : {
			product_id : product,
			price : price,
			qty : qty
		}, 
		success: function(result){
			jQuery('.added_to_order').append(result);
			jQuery('.pqty'+product).remove();
			jQuery('.pprice'+product).remove();
				 
		}
	
	});
}
function bc_qty_price_new_corder(){
	var product = jQuery('[name="the_product"]').val();
	jQuery.ajax({
		url: "https://hamtaloans.com/accounts/leasing/actions/load_price_and_qty.php",
		type: 'post', // performing a POST request
		data : {
			product_id : product,
		}, 
		success: function(result){
			
			var h ='<div class="pqty'+product+'"><label>تعداد</label><input type="number" min="1" max="10" name="pqty_val" value="1"></div>';
				h = h+ '<div class="pprice'+product+'"><label>مبلغ</label><input type="number" min="1" max="10000000000000" name="pprice_val" value="'+result+'"></div>';		
			jQuery('.load_items_of_product').append(h);
		}
	});
}




jQuery('[name="submit_custom_order"]').click(function(){
	var items = bco_getHiddenInputsValues();
	jQuery.ajax({
		url: "https://hamtaloans.com/accounts/leasing/actions/create_new_order_for_branch_customer.php",
		type: 'post', // performing a POST request
		data : {
			order_items : items,
		}, 
		success: function(result){
			var prefix = "Yes_";

			if (str.indexOf(prefix) === 0) {
				str = result.substring(prefix.length);
			}
			alert('سفارش شما با شماره : '+str+' برای مشتری به ثبت رسید .');
			location.reload();
		}
	});
});




function update_me_now (id){
	
	jQuery.ajax({
		url: "https://hamtaloans.com/accounts/leasing/actions/update_me_now.php",
		type: 'post', // performing a POST request
		data : {
			'id' 						: id,
			'first_name' 				: jQuery('[name="first_name"]').val(),
			'last_name'	 				: jQuery('[name="last_name"]').val(),
			'user_id_number'			: jQuery('[name="user_id_number"]').val(),
			'leasing_employee_zone'		: jQuery('[name="leasing_employee_zone"]').val(),
			'user_mobile'				: jQuery('[name="user_mobile"]').val(),
			'arian_tafzili_code'		: jQuery('[name="arian_tafzili_code"]').val(),
			"employee_contract_code"	: jQuery('[name="employee_contract_code"]').val()
			
		}, 
		success: function(result){

			if (result == 'yes'){
				alert('بروز رسانی با موفقیت به انجام رسید');
				location.reload();
			}else{
				alert('متأسفانه بروز رسانی نماینده با موفقیت انجام نگردیدد');
			}

			
		}
	});

}


function update_branch_number (req_id,bd_id , target){
	jQuery.ajax({
		url: "https://hamtaloans.com/accounts/leasing/actions/update_user_phone_number.php",
		type: 'post', // performing a POST request
		data : {
			'branch_id' 				: jQuery('[name="branch_id"]').val(),
			'branch_editor'				: req_id , 
			'branch_number' 			: jQuery('[name="new_branch_number"]').val()
		}, 
		success: function(result){

			if (result == 'yes'){
				alert('کاربر با موفقیت بروز رسانی شد .');
				// location.reload();
			}else{
				alert('کاربر بروز رسانی نشد کد خطا : '+result+' .');
				// location.reload();
			}

			
		}
	});
}

function change_branch_user(id,target){
	jQuery.ajax({
		url: "https://hamtaloans.com/accounts/leasing/actions/load_branch_number.php",
		type: 'post', // performing a POST request
		data : {
			'branch_id': id,
		}, 
		success: function(result){
			var js_on = JSON.parse(result);
			if (js_on.cond_one == 'true'){
				jQuery('.'+target).html(js_on.resutl);
			}else{
				jQuery('.'+target).html(js_on.resutl);
			}
		}
	});
}


function convert_thei_branch_to_customer(leasing , branch ){
	jQuery.ajax({
		url: "https://hamtaloans.com/accounts/leasing/actions/change_branch_to_customer.php",
		type: 'post', // performing a POST request
		data : {
			'branch_id': branch,
			'leasing_id' : leasing
		}, 
		success: function(result){
			if (result != ''){
				alert(result);
				// location.reload();
			}else{
				alert(result);
			}
		}
	});
}

function convert_this_user_to_branch(leasing , branch ){
	jQuery.ajax({
		url: "https://hamtaloans.com/accounts/leasing/actions/change_customer_to_branch.php",
		type: 'post', // performing a POST request
		data : {
			'branch_id': branch,
			'leasing_id' : leasing
		}, 
		success: function(result){
			if (result != ''){
				alert(result);
				// location.reload();
			}else{
				alert(result);
			}
		}
	});
}



function createAnimatedHand() {
    // Create style element
    const style = document.createElement('style');
    style.textContent = `
        .animated-hand {
            --hue: 223;
            --sat: 10%;
            --gray0: hsl(0,0%,100%);
            --gray1: hsl(var(--hue),var(--sat),90%);
            --gray2: hsl(var(--hue),var(--sat),80%);
            --gray3: hsl(var(--hue),var(--sat),70%);
            --gray4: hsl(var(--hue),var(--sat),60%);
            --gray5: hsl(var(--hue),var(--sat),50%);
            --gray6: hsl(var(--hue),var(--sat),40%);
            --gray7: hsl(var(--hue),var(--sat),30%);
            --gray8: hsl(var(--hue),var(--sat),20%);
            --gray9: hsl(var(--hue),var(--sat),10%);
            --trans-dur: 0.3s;
            --anim-dur: 1s;
            --anim-timing: cubic-bezier(0.65,0,0.35,1);
            display: block;
            margin: auto;
            width: 9.6em;
            height: auto;
        }

        .hand__finger-inner {
            animation-duration: var(--anim-dur);
            animation-timing-function: var(--anim-timing);
            animation-iteration-count: infinite;
            animation-name: finger-inner;
            fill: var(--gray4);
        }

        .hand__finger {
            animation-duration: var(--anim-dur);
            animation-timing-function: var(--anim-timing);
            animation-iteration-count: infinite;
        }

        .hand__finger--pinky {
            animation-name: pinky;
            animation-delay: calc(var(--anim-dur) * 0.16);
        }

        .hand__finger--ring {
            animation-name: ring;
            animation-delay: calc(var(--anim-dur) * 0.12);
        }

        .hand__finger--middle .hand__finger-inner {
            animation-delay: calc(var(--anim-dur) * 0.08);
        }

        .hand__finger--index {
            animation-name: index;
            animation-delay: calc(var(--anim-dur) * 0.04);
        }

        .hand__finger--thumb .hand__finger-inner {
            animation-name: thumb-inner;
        }

        .hand__nail {
            fill: var(--gray0);
        }

        .hand__skin {
            fill: var(--gray2);
        }

        @keyframes finger-inner {
            from, 80%, to {
                transform: translate(0,0);
            }
            40% {
                animation-timing-function: cubic-bezier(0.32,0,0.67,0);
                transform: translate(0,-3px);
            }
        }

        @keyframes thumb-inner {
            from, 80%, to {
                transform: translate(0,0) skewY(0);
            }
            40% {
                animation-timing-function: cubic-bezier(0.32,0,0.67,0);
                transform: translate(-0.5px,-3px) skewY(-15deg);
            }
        }

        @keyframes pinky {
            from, 80%, to {
                transform: translate(0,3.5px);
            }
            40% {
                animation-timing-function: cubic-bezier(0.32,0,0.67,0);
                transform: translate(0,1.2px);
            }
        }

        @keyframes ring {
            from, 80%, to {
                transform: translate(6.5px,1.8px);
            }
            40% {
                animation-timing-function: cubic-bezier(0.32,0,0.67,0);
                transform: translate(6.5px,0.5px);
            }
        }

        @keyframes index {
            from, 80%, to {
                transform: translate(19.5px,2.5px);
            }
            40% {
                animation-timing-function: cubic-bezier(0.32,0,0.67,0);
                transform: translate(19.5px,1.2px);
            }
        }

        @media (prefers-color-scheme: dark) {
            .hand__finger-inner {
                fill: var(--gray9);
            }
            .hand__nail {
                fill: var(--gray5);
            }
            .hand__skin {
                fill: var(--gray7);
            }
        }
    `;

    // Create SVG element
    const svgContent = `
        <svg class="animated-hand" viewBox="0 0 32 20" width="32px" height="20px">
            <clipPath id="finger-pinky">
                <rect rx="2.5" ry="2.5" width="6" height="15" />
            </clipPath>
            <clipPath id="finger-ring">
                <rect rx="2.5" ry="2.5" width="6" height="18" />
            </clipPath>
            <clipPath id="finger-middle">
                <rect rx="2.5" ry="2.5" width="6" height="20" />
            </clipPath>
            <clipPath id="finger-index">
                <rect rx="2.5" ry="2.5" width="6" height="17" />
            </clipPath>
            <clipPath id="finger-thumb">
                <rect width="6" height="15.2" />
            </clipPath>
            <g class="hand__finger hand__finger--pinky" transform="translate(0,3.5)" clip-path="url(#finger-pinky)">
                <g class="hand__finger-inner">
                    <rect class="hand__skin" rx="2.5" ry="2.5" width="6" height="15" />
                    <rect rx="0.25" ry="0.25" width="3" height="0.5" x="1.5" y="1.5" />
                    <rect rx="0.25" ry="0.25" width="3" height="0.5" x="1.5" y="2.5" />
                    <path class="hand__nail" d="M 2 10 H 4 A 1 1 0 0 1 5 11 V 12 A 2 2 0 0 1 3 14 H 3 A 2 2 0 0 1 1 12 V 11 A 1 1 0 0 1 2 10 Z" />
                </g>
            </g>
            <g class="hand__finger hand__finger--ring" transform="translate(6.5,1.8)" clip-path="url(#finger-ring)">
                <g class="hand__finger-inner">
                    <rect class="hand__skin" rx="2.5" ry="2.5" width="6" height="18" />
                    <rect rx="0.25" ry="0.25" width="3" height="0.5" x="1.5" y="1.5" />
                    <rect rx="0.25" ry="0.25" width="3" height="0.5" x="1.5" y="2.5" />
                    <path class="hand__nail" d="M 2 13 H 4 A 1 1 0 0 1 5 14 V 15 A 2 2 0 0 1 3 17 H 3 A 2 2 0 0 1 1 15 V 14 A 1 1 0 0 1 2 13 Z" />
                </g>
            </g>
            <g class="hand__finger hand__finger--middle" transform="translate(13,0)" clip-path="url(#finger-middle)">
                <g class="hand__finger-inner">
                    <rect class="hand__skin" rx="2.5" ry="2.5" width="6" height="20" />
                    <rect rx="0.25" ry="0.25" width="3" height="0.5" x="1.5" y="1.5" />
                    <rect rx="0.25" ry="0.25" width="3" height="0.5" x="1.5" y="2.5" />
                    <path class="hand__nail" d="M 2 15 H 4 A 1 1 0 0 1 5 16 V 17 A 2 2 0 0 1 3 19 H 3 A 2 2 0 0 1 1 17 V 16 A 1 1 0 0 1 2 15 Z" />
                </g>
            </g>
            <g class="hand__finger hand__finger--index" transform="translate(19.5,2.5)" clip-path="url(#finger-index)">
                <g class="hand__finger-inner">
                    <rect class="hand__skin" rx="2.5" ry="2.5" width="6" height="17" />
                    <rect rx="0.25" ry="0.25" width="3" height="0.5" x="1.5" y="1.5" />
                    <rect rx="0.25" ry="0.25" width="3" height="0.5" x="1.5" y="2.5" />
                    <path class="hand__nail" d="M 2 12 H 4 A 1 1 0 0 1 5 13 V 14 A 2 2 0 0 1 3 16 H 3 A 2 2 0 0 1 1 14 V 13 A 1 1 0 0 1 2 12 Z" />
                </g>
            </g>
            <g class="hand__finger hand__finger--thumb" transform="translate(26,0)" clip-path="url(#finger-thumb)">
                <g class="hand__finger-inner">
                    <path class="hand__skin" d="M 0 0 C 0 0 0.652 0.986 1.494 1.455 C 2.775 2.169 6 0.763 6 3.018 C 6 5.197 4.62 7 2.61 7 C 1.495 7 0 7 0 7 L 0 0 Z" transform="translate(0,8.2)" />
                </g>
            </g>
        </svg>
    `;

    return {
        appendTo: function(container) {
            // Add style to document head
            document.head.appendChild(style);
            
            // Add SVG to container
            container.innerHTML = svgContent;
        },
        getHTML: function() {
            return `<style>${style.textContent}</style>${svgContent}`;
        }
    };
}

function save_product_target_for_branch(){
	var branch 				= jQuery('[name="select_branch_for_targeting"]').val();
	var qty 				= jQuery('[name="qty_for_product"]').val();
	var product_id 			= jQuery('[name="product_id"]').val();
	var leasing_employee 	= jQuery('[name="leasing_employee"]').val();
	var target_id 			= jQuery('[name="target_id"]').val();
	const hand = createAnimatedHand();
	jQuery('.the_modal_content').html(hand.getHTML());

	jQuery.ajax({
		url: "https://hamtaloans.com/accounts/leasing/actions/save_product_target_for_branch.php",
		type: 'post', // performing a POST request
		data : {
			'branch_id'		: branch,
			'qty_target' 	: qty,
			'product' 		: product_id,
			'lemp'			: leasing_employee,
			'target'		: target_id
		}, 
		success: function(result){
			if (result == 'yes'){
				jQuery('.the_modal_content').html('');
				jQuery('.btn-close').click();
				alert('با موفقیت ثبت شد');

			}else{
				alert('ثبت نا موفق');
			}
		}
	});
}

function set_product_target_to_branch(lemp,the_product , target){
	jQuery('.mega_modal_header h5').html('ثبت تارگت برای نماینده');
	const hand = createAnimatedHand();
    jQuery('.the_modal_content').html(hand.getHTML());
	
	jQuery.ajax({
		url: "https://hamtaloans.com/accounts/leasing/actions/load_branch_target_list.php",
		type: 'post', // performing a POST request
		data : {
			'leasing_employee': lemp,
			'product' : the_product,
			'target_id' : target
		}, 
		success: function(result){
			if (result != ''){
				jQuery('.the_modal_content').html(result);
			}else{
				
			}
		}
	});
}