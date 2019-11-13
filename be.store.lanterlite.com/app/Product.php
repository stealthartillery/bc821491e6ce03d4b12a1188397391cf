<?php
	init();
	$product = new Product(); 
	class Product {
		public function __construct() {
			set_time_limit ( 0 );
		}

		public function get_id($cit_id) {
			$_obj['namelist'] = ['id', 'cit_id'];
			$_obj['def'] = 'stores';
			$_obj['gate'] = '';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"stores", "puzzled":true}'));
			$stores = LGen('SaviorMan')->get_all($_obj);
			foreach ($stores as $key => $value) {
				if (base64_decode($value['cit_id']) === $cit_id)
					return $value['id'];
			}
			return LGen('GlobVar')->failed;
		}

		// public function update($obj) {
		// 	LGen('SaviorMan')->req_validator($obj);

		// 	// add product to products
		// 	$_obj['def'] = 'products';
		// 	$_obj['bridge'] = [];
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"products", "puzzled":true}'));
		// 	$prod_id = LGen('SaviorMan')->insert($_obj);

		// 	// add prod_id to store
		// 	$_obj['def'] = 'stores';
		// 	$_obj['val']['prod_id'] = $prod_id;
		// 	$_obj['bridge'] = [];
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"stores", "puzzled":true}'));
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"'.$obj['store_id'].'", "puzzled":false}'));
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"products", "puzzled":true}'));
		// 	LGen('SaviorMan')->insert($_obj);

		// 	return $prod_id;
		// }

		// public function update_product_price($obj) {

		// }

		public function home_content($obj) {
			LGen('SaviorMan')->req_validator($obj);
			$lang = $obj['val']['lang'];
			$id = $obj['val']['prod_id'];
			$res = [];

			$img = $obj;
			$img['def'] = 'products';
			$img['bridge'] = [];
			$img['namelist'] = ["img"];
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
			$img_id = base64_decode(LGen('SaviorMan')->read($img)['img']);

			$detail = $obj;
			$detail['def'] = 'products/details';
			$detail['bridge'] = [];
			$detail['namelist'] = ["sh_desc","name"];
			array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
			array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "details", "puzzled":true}'));
			array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "'.$lang.'", "puzzled":true}'));
			$res = LGen('SaviorMan')->read($detail);

			$img = $obj;
			$img['def'] = 'products/imgs';
			$img['bridge'] = [];
			$img['namelist'] = ["url"];
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$img_id.'", "puzzled":false}'));
			$res['img'] = LGen('SaviorMan')->read($img);
			return $res;
		}

		// public function update_product_detail($obj) {
		// 	LGen('SaviorMan')->req_validator($obj);

		// 	$lang = $obj['val']['lang'];
		// 	$id = $obj['val']['prod_id'];

		// 	$detail = $obj;
		// 	$detail['def'] = 'products/details';
		// 	$detail['bridge'] = [];
		// 	array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 	array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
		// 	array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "details", "puzzled":true}'));
		// 	array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "'.$lang.'", "puzzled":true}'));
		// 	return LGen('SaviorMan')->update($detail);
		// }

		// public function add_product_image($obj) {
		// 	LGen('SaviorMan')->req_validator($obj);

		// 	$imgs = $obj['val']['imgs'];
		// 	$id = $obj['val']['prod_id'];

		// 	$img = [];
		// 	$img['def'] = 'products/imgs';
		// 	$img['gate'] = 'store';
		// 	$img['bridge'] = [];
		// 	$img['val'] = [];
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
		// 	for ($i=0; $i<sizeof($imgs); $i++) {
		// 		$img['val']['url'] = $imgs[$i];
		// 		LGen('SaviorMan')->insert($img);
		// 	}
		// 	return 1;
		// }

		public function get_all_names($obj) {
			if (!array_key_exists('store_id', $obj))
				return LGen('GlobVar')->failed;
			if (!array_key_exists('lang', $obj))
				return LGen('GlobVar')->failed;

			$_obj = [];
			$_obj['def'] = 'stores/products';
			$_obj['namelist'] = ['prod_id'];
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "stores", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['store_id'].'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			$res = LGen('SaviorMan')->get_all($_obj);
			for ($i=0; $i<sizeof($res); $i++) {
				$res[$i]['prod_id'] = base64_decode($res[$i]['prod_id']);
			}
			$final_res = [];

			$prod = [];
			$prod['bridge'] = [];
			array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "'.$res[$i]['prod_id'].'", "puzzled":false}'));

			for ($i=0; $i<sizeof($res); $i++) {
				$prod['def'] = 'products';
				$prod['namelist'] = ['img','price'];
				$_prod = LGen('SaviorMan')->read($prod);

				$prod['def'] = 'products/imgs';
				$prod['namelist'] = ['id','url'];
				array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
				$imgs = LGen('SaviorMan')->get_all($prod); // get imgs

				array_pop($prod['bridge']); // remove id
				$prod['def'] = 'products/details';
				$prod['namelist'] = ['name'];
				array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "details", "puzzled":true}'));
				array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['lang'].'", "puzzled":true}'));
				$detail = LGen('SaviorMan')->read($prod); // get id content
				
				// array_pop($prod['bridge']); // remove id
				// array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "en", "puzzled":true}'));
				// $detail_en = LGen('SaviorMan')->read($prod); // get en content

				array_push($final_res, []);
				$final_res[$i]['product'] = $_prod;
				$final_res[$i]['imgs'] = $imgs;
				$final_res[$i]['detail'] = $detail_id;
				// $final_res[$i]['details']['en']= $detail_en;
			}
			return $final_res;
		}

		public function get($obj) {
			if (!array_key_exists('prod_id', $obj))
				return LGen('GlobVar')->failed;
			if (!array_key_exists('lang', $obj))
				return LGen('GlobVar')->failed;

			$prod['bridge'] = [];
			array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['prod_id'].'", "puzzled":false}'));
			$prod['def'] = 'products';
			$prod['namelist'] = ['img','price'];
			$_prod = LGen('SaviorMan')->read($prod);

			$prod['def'] = 'products/imgs';
			$prod['namelist'] = ['id','url'];
			array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
			$imgs = LGen('SaviorMan')->get_all($prod); // get imgs

			array_pop($prod['bridge']); // remove id
			$prod['def'] = 'products/details';
			$prod['namelist'] = ['sh_desc','lg_desc','name'];
			array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "details", "puzzled":true}'));
			array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['lang'].'", "puzzled":true}'));
			$detail_id = LGen('SaviorMan')->read($prod); // get id content

			$final_res = [];
			$final_res['product']= $_prod;
			$final_res['imgs']= $imgs;
			$final_res['detail']= $detail_id;
			return $final_res;
		}

		public function get_all($obj) {
			$_obj = [];
			$_obj['def'] = 'stores/products';
			$_obj['namelist'] = ['prod_id'];
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "stores", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['store_id'].'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			$res = LGen('SaviorMan')->get_all($_obj);
			for ($i=0; $i<sizeof($res); $i++) {
				$res[$i]['prod_id'] = base64_decode($res[$i]['prod_id']);
			}
			$final_res = [];

			$prod = [];
			$prod['gate'] = 'store';
			for ($i=0; $i<sizeof($res); $i++) {
				$prod['bridge'] = [];
				array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
				array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "'.$res[$i]['prod_id'].'", "puzzled":false}'));
				$prod['def'] = 'products';
				$prod['namelist'] = ['img','price'];
				$_prod = LGen('SaviorMan')->read($prod);

				$prod['def'] = 'products/imgs';
				$prod['namelist'] = ['id','url'];
				array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
				$imgs = LGen('SaviorMan')->get_all($prod); // get imgs

				array_pop($prod['bridge']); // remove id
				$prod['def'] = 'products/details';
				$prod['namelist'] = ['sh_desc','lg_desc','name'];
				array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "details", "puzzled":true}'));
				array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "id", "puzzled":true}'));
				$detail_id = LGen('SaviorMan')->read($prod); // get id content
				
				array_pop($prod['bridge']); // remove id
				array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "en", "puzzled":true}'));
				$detail_en = LGen('SaviorMan')->read($prod); // get en content

				array_push($final_res, []);
				$final_res[$i]['product']= $_prod;
				$final_res[$i]['imgs']= $imgs;
				$final_res[$i]['details']['id']= $detail_id;
				$final_res[$i]['details']['en']= $detail_en;
			}
			return $final_res;
		}

		public function add($obj) {
			if (!array_key_exists('store_id', $obj))
				return LGen('GlobVar')->failed;

			// add new product
			$_obj = [];
			$_obj['def'] = 'products';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			$prod_id = LGen('SaviorMan')->insert($_obj);

			// add prod_id to store
			$_obj = [];
			$_obj['val']['prod_id'] = $prod_id;
			$_obj['def'] = 'stores/products';
			$_obj['keep_name'] = true;
			$_obj['name'] = $prod_id;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "stores", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['store_id'].'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);

			// add detail to prod 
			$_obj = [];
			$_obj['def'] = 'products/details';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$prod_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "details", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "id", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);
			array_pop($_obj['bridge']);
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "en", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);

			// add imgs to prod
			$_obj = [];
			$_obj['val']['url'] = 'image.lanterlite.com/store/default_product.webp';
			$_obj['def'] = 'products/imgs';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$prod_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
			$imgs = [];
			for ($i=0; $i<5; $i++) {
				array_push($imgs, LGen('SaviorMan')->insert($_obj));
			}

			$res = [];
			$res['imgs'] = $imgs;
			$res['prod_id'] = $prod_id;
			return $res;
		}

		public function update($obj) {
			if (!array_key_exists('lang', $obj))
				return LGen('GlobVar')->failed;
			if (!array_key_exists('img', $obj))
				return LGen('GlobVar')->failed;
			if (!array_key_exists('price', $obj))
				return LGen('GlobVar')->failed;
			if (!array_key_exists('prod_id', $obj))
				return LGen('GlobVar')->failed;
			if (!array_key_exists('imgs', $obj))
				return LGen('GlobVar')->failed;
			if (!array_key_exists('detail', $obj))
				return LGen('GlobVar')->failed;

			// update product img and price
			$_obj = [];
			$_obj['def'] = 'products';
			$_obj['val']['img'] = $obj['img'];
			$_obj['val']['price'] = $obj['price'];
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['prod_id'].'", "puzzled":false}'));
			$prod_id = LGen('SaviorMan')->update($_obj);

			// update product detail 
			$_obj = [];
			$_obj['def'] = 'products/details';
			$_obj['val'][$obj['lang']] = $obj['detail'];
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$prod_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "details", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['lang'].'", "puzzled":true}'));
			LGen('SaviorMan')->update($_obj);

			// add product imgs
			$_obj = [];
			$_obj['def'] = 'products/imgs';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$prod_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
			$imgs = [];
			for ($i=0; $i<5; $i++) {
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['imgs'][$i]['id'].'", "puzzled":false}'));
				$_obj['val']['url'] = $obj['imgs'][$i]['url'];
				array_push($imgs, LGen('SaviorMan')->update($_obj));
				array_pop($_obj['bridge']);
			}

			return 1;
		}

		public function buy_item($_obj) {
			LGen('SaviorMan')->req_validator($obj);
			error_log('asd');
			$_obj['cit_id'] = '9DE17B6195D0';
			$_obj['item_id'] = 'full_license';
			// LGen('SaviorMan')->req_validator($obj);
			$obj['bridge'] = [];
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$_obj['cit_id'].'", "puzzled":false}'));
			$obj['def'] = 'citizens';
			$obj['gate'] = 'savior';
			$obj['namelist'] = ['silver'];
			$final_obj = [];
			$final_obj['json'] = $obj;
			$final_obj['func'] = 'LGen("SaviorMan")->read';
			$asd = LGen('ReqMan')->send_post($final_obj);
			$asd = LGen('F')->decrypt($asd);
			$silver = base64_decode($asd['silver']);

			// error_log(json_encode($asd));
			return true;
		}
	}