<?php
	
	$store = new StoreGen();

	class StoreGen {
		public function __construct() {
			set_time_limit ( 0 );
		}

		public function get_id($obj) {
			error_log('get_id');
			$_obj['namelist'] = ['id', 'cit_id'];
			$_obj['def'] = 'stores';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"stores", "puzzled":true}'));
			$stores = LGen('SaviorMan')->get_all($_obj);
			error_log(json_encode($stores));
			foreach ($stores as $key => $value) {
				if (($value['cit_id']) === $obj['cit_id'])
					return $value['id'];
			}
			return LGen('GlobVar')->failed;
		}

		public function add_store($obj) {
			LGen('SaviorMan')->req_validator($obj);

			$_obj = $obj;
			$_obj['namelist'] = ['code_name', 'cit_id'];
			$_obj['bridge'] = [];
			$_obj['val'] = '';
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"stores", "puzzled":true}'));
			$stores = LGen('SaviorMan')->get_all($_obj);
			foreach ($stores as $key => $value) {
				if (($value['cit_id']) === $obj['val']['cit_id'])
					return 'citizen already have store';
				else if (($value['code_name']) === $obj['val']['code_name'])
					return 'store code name is exist';
			}

			$id = LGen('SaviorMan')->insert($obj);
			$_obj = [];
			$_obj['name'] = $obj['val']['name'];
			$_obj['code_name'] = $obj['val']['code_name'];
			$_obj['id'] = $id;
			$_obj['point'] = 0;
			return $_obj;
		}

		public function update_product_price($obj) {

		}

		public function home_content($obj) {
			LGen('SaviorMan')->req_validator($obj);
			$lang = $obj['val']['lang'];
			$id = $obj['val']['prod_id'];
			$page = false;
			if (LGen('JsonMan')->is_key_exist($obj['val'], 'page'))
				if ($obj['val']['page'] === 'page_item')
					$page = 'page_item';

			$id = $obj['val']['prod_id'];
			$res = [];

			$img = $obj;
			$img['def'] = 'products';
			$img['bridge'] = [];
			$img['namelist'] = ["id", "img"];
			if ($page === 'page_item')
				$img['namelist'] = ["multiple", "store_id", "price_point", "price_idr", "price_usd", "price", "id", "img"];
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
			$_res = (LGen('SaviorMan')->read($img));
			foreach ($_res as $key => $value) {
				$res[$key] = $value;
			}
			$img_id = $res['img'];

			if ($page === 'page_item') {
				$asd = [];
				$asd['def'] = 'stores';
				$asd['bridge'] = [];
				$asd['namelist'] = ["code_name","name"];
				array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "stores", "puzzled":true}'));
				array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "'.$res['store_id'].'", "puzzled":false}'));
				$res['store_name'] = (LGen('SaviorMan')->read($asd))['name'];
				$res['store_codename'] = (LGen('SaviorMan')->read($asd))['code_name'];
			}

			$detail = $obj;
			$detail['def'] = 'products/details';
			$detail['bridge'] = [];
			$detail['namelist'] = ["sh_desc","name"];
			if ($page === 'page_item')
				$detail['namelist'] = ["lg_desc","sh_desc","name"];
			array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
			array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "details", "puzzled":true}'));
			array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "'.$lang.'", "puzzled":true}'));
			// array_push($res, LGen('SaviorMan')->read($detail));
			$_res = (LGen('SaviorMan')->read($detail));
			foreach ($_res as $key => $value) {
				$res[$key] = $value;
			}

			$img = $obj;
			$img['def'] = 'products/imgs';
			$img['bridge'] = [];
			$img['namelist'] = ["id", "url"];
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$img_id.'", "puzzled":false}'));
			$res['img'] = LGen('SaviorMan')->read($img);

			if ($page === 'page_item') {
				$imgs = $obj;
				$imgs['def'] = 'products/imgs';
				$imgs['bridge'] = [];
				$imgs['namelist'] = ["id","url"];
				array_push($imgs['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
				array_push($imgs['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
				array_push($imgs['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
				$res['imgs'] = LGen('SaviorMan')->get_all($imgs);
			}

			return $res;
		}

		public function update_product_detail($obj) {
			LGen('SaviorMan')->req_validator($obj);

			$lang = $obj['val']['lang'];
			$id = $obj['val']['prod_id'];

			$detail = $obj;
			$detail['def'] = 'products/details';
			$detail['bridge'] = [];
			array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
			array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "details", "puzzled":true}'));
			array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "'.$lang.'", "puzzled":true}'));
			return LGen('SaviorMan')->update($detail);
		}

		public function add_product_image($obj) {
			LGen('SaviorMan')->req_validator($obj);

			$imgs = $obj['val']['imgs'];
			$id = $obj['val']['prod_id'];

			$img = [];
			$img['def'] = 'products/imgs';
			$img['gate'] = '';
			$img['bridge'] = [];
			$img['val'] = [];
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
			for ($i=0; $i<sizeof($imgs); $i++) {
				$img['val']['url'] = $imgs[$i];
				LGen('SaviorMan')->insert($img);
			}
			return 1;
		}

		public function get_products($obj) {
			$_obj = [];
			$_obj['def'] = 'stores/products';
			$_obj['gate'] = '';
			$_obj['namelist'] = ['prod_id'];
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "stores", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['store_id'].'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			$res = LGen('SaviorMan')->get_all($_obj);
			for ($i=0; $i<sizeof($res); $i++) {
				$res[$i]['prod_id'] = ($res[$i]['prod_id']);
			}
			$final_res = [];

			$prod = [];
			$prod['gate'] = '';
			for ($i=0; $i<sizeof($res); $i++) {
				$prod['bridge'] = [];
				array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
				array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "'.$res[$i]['prod_id'].'", "puzzled":false}'));
				$prod['def'] = 'products';
				$prod['namelist'] = ['img','price'];
				$product = LGen('SaviorMan')->read($prod);

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
				$final_res[$i]['product']= $product;
				$final_res[$i]['imgs']= $imgs;
				$final_res[$i]['details']['id']= $detail_id;
				$final_res[$i]['details']['en']= $detail_en;
			}
			return $final_res;
		}

		public function get_def($obj) {
			$config_dir = HOME_DIR.'storages/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
			return $default;
		}

		public function add_product($obj) {
			// LGen('SaviorMan')->req_validator($obj);
			if (array_key_exists('store_id', $obj))
				return 'no store_id';
			$prod = [];
			$prod['def'] = 'products';
			$prod['gate'] = '';
			$prod['bridge'] = [];
			array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));

			$id = LGen('SaviorMan')->insert($prod);

			$seller = [];
			$seller['val']['prod_id'] = $id;
			$seller['def'] = 'stores/products';
			$seller['gate'] = '';
			$seller['keep_name'] = true;
			$seller['name'] = $id;
			$seller['bridge'] = [];
			array_push($seller['bridge'], LGen('StringMan')->to_json('{"id": "stores", "puzzled":true}'));
			array_push($seller['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['store_id'].'", "puzzled":false}'));
			array_push($seller['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			LGen('SaviorMan')->insert($seller);

			$img = [];
			$img['val']['url'] = '';
			$img['def'] = 'products/imgs';
			$img['gate'] = '';
			$img['bridge'] = [];
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
			array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
			for ($i=0; $i<5; $i++) {
				LGen('SaviorMan')->insert($img);
			}
			return $id;
		}

		public function buy_item($_obj) {
			LGen('SaviorMan')->req_validator($obj);
			// $_obj['cit_id'] = '9DE17B6195D0';
			// $_obj['item_id'] = 'full_license';
			// LGen('SaviorMan')->req_validator($obj);
			$obj['bridge'] = [];
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$_obj['cit_id'].'", "puzzled":false}'));
			$obj['def'] = 'citizens';
			$obj['gate'] = '';
			$obj['namelist'] = ['id', 'verification_code', 'created_date', 'fsize', 'theme_color', 'theme_font', 'email', 'lang', 'is_verified', 'id', 'fullname', 'username', 'gender', 'address', 'phonenum', 'silver', 'point'];
			// $obj['namelist'] = ['silver'];
			$final_obj = [];
			$final_obj['json'] = $obj;
			$final_obj['func'] = 'LGen("SaviorMan")->read';
			$cit = LGen('ReqMan')->send_post($final_obj);

			$prod = [];
			$prod['def'] = 'products';
			$prod['bridge'] = [];
			$prod['namelist'] = ["id", "name", "price", "price_point", "price_idr", "price_usd"];
			array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
			array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "'.$_obj['item_id'].'", "puzzled":false}'));
			$prod = (LGen('SaviorMan')->read($prod));
			
			if ($_obj['cur'] === 'price') {
				$cit['silver'] = (int)$cit['silver'];
				$final_price = (int)((float)$prod['price']*(int)$_obj['qty']);
				if ($cit['silver']<$final_price)
					return 'insufficient silver';
			}
			else if ($_obj['cur'] === 'price_point') {
				$cit['point'] = (int)$cit['point'];
				$final_price = (int)(((float)$prod['price_point']*(int)$_obj['qty']));
				if ($cit['point']<$final_price)
					return 'insufficient point';
			}
			else if ($_obj['cur'] === 'price_idr') {
				$txid = $this->add_tx_pack($cit, $prod, $_obj);
				// $res = [];
				// $res[LGen('GlobVar')->stat] = LGen('GlobVar')->success;
				// $res[LGen('GlobVar')->data] = $cit;
				// // $obj['namelist'] = ['verification_code', 'created_date', 'fsize', 'theme_color', 'theme_font', 'email', 'lang', 'is_verified', 'id', 'fullname', 'username', 'gender', 'address', 'phonenum', 'silver', 'point'];
				// return $res;
				include HOME_DIR . 'app/iPaymu.class.php';
					// return 'insufficient point';
				$urlReturn = HOME_URL . 'payments/ipm/rtn/?id='.$txid;
				// $urlReturn = HOME_URL . 'payments/ipm/?gateway=ipaymu&action=return&user_id='.$user_id.'&item_id='.$item_id.'&date_order='.$date_order.'&price_per_item='.$price_per_item.'&price_total='.$price_total.'&currency='.$currency.'&quantity='.$quantity.'&message='.$message.'&category_id='.$category_id.'&store_id='.$store_id;
				$urlNotify = HOME_URL . 'payments/ipm/ntf/?id='.$txid.'&';
				$urlCancel = HOME_URL;
				$iPaymu = new iPaymu('CD41Pq5.sx.VvqGzE67Dg4nEBx3Iu1');
				$iPaymu->addProduct($_obj['item_name'], $prod['price_idr'], $_obj['qty'], $_obj['item_sh_desc']);
				$res = [];
				$res[LGen('GlobVar')->stat] = 'ready to transfer';
				$res[LGen('GlobVar')->data] = $iPaymu->paymentPage($urlReturn, $urlNotify , $urlCancel, $cit);
				// $res = $iPaymu->paymentPage($urlReturn, $urlNotify , $urlCancel, $cit);
				// error_log(json_encode($res->url));
				// header("LOCATION: ".$res->url);
				return $res;

				return json_decode(json_encode(($res)), true);
				// return json_decode(json_encode(($iPaymu->paymentPage($urlReturn, $urlNotify , $urlCancel, $cit))), true);
				// return $_obj;
			}
			else if ($_obj['cur'] === 'price_usd') {
				return 'not ready';
			}
			// return $final_price;

			$lic = [];
			if ($_obj['item_id'] === '30F6ABE2C6DC') // full license
				$lic['type'] = 'full';
			else if ($_obj['item_id'] === 'AF5F71E09322') // full license
				$lic['type'] = 'theme_color';
			else if ($_obj['item_id'] === 'D731D3F48741') // full license
				$lic['type'] = 'theme_font';
			if (LGen('JsonMan')->is_key_exist($lic, 'type')) { //the item is license
				$asd = [];
				$asd['val'] = $lic;
				$asd['bridge'] = [];
				array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "'.$_obj['cit_id'].'", "puzzled":false}'));
				array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "licenses", "puzzled":true}'));
				$asd['def'] = 'citizens/licenses';
				$asd['gate'] = '';
				$final_obj = [];
				$final_obj['json'] = $asd;
				$final_obj['func'] = 'LGen("SaviorMan")->insert';
				// return $final_obj;
				for ($i=0; $i<(int)$_obj['qty']; $i++)
					$asd = LGen('ReqMan')->send_post($final_obj);
			}

			if ($_obj['item_id'] === '7028104F56C1') {// lanter sword pearl
				$chars = [];
				$chars['def'] = 'chars';
				$chars['bridge'] = [];
				$chars['namelist'] = ["id","pearl","cit_id"];
				array_push($chars['bridge'], LGen('StringMan')->to_json('{"id": "chars", "puzzled":true}'));
				$final_obj = [];
				$final_obj['json'] = $chars;
				$final_obj['func'] = 'LGen("SaviorMan")->get_all';
				$_char = LGen('ReqMan')->send_post($final_obj, 'be.sword.lanterlite.com/');
				foreach ($_char as $key => $value) {
					if ($value['cit_id'] === $cit['id']) {
						$pearl = (int)$_char[$key]['pearl']+(int)$_obj['qty'];
						$chars['val'] = [];
						$chars['val']['pearl'] = $pearl;
						array_push($chars['bridge'], LGen('StringMan')->to_json('{"id": "'.$_char[$key]['id'].'", "puzzled":false}'));
						$final_obj['json'] = $chars;
						$final_obj['func'] = 'LGen("SaviorMan")->update';
						$asd = LGen('ReqMan')->send_post($final_obj, 'be.sword.lanterlite.com/');
						break;
					}
				}
			}

			if ($_obj['item_id'] === 'BF45E033FFEA') {  // lantersilver
				$cit['silver'] = $cit['silver']+(int)$_obj['qty'];
			}

			if ($_obj['cur'] === 'price')
				$cit['silver'] = $cit['silver'] - $final_price;
			else if ($_obj['cur'] === 'price_point')
				$cit['point'] = $cit['point'] - $final_price;

			$asd = [];
			$asd['val'] = [];
			$asd['val']['silver'] = $cit['silver'];
			$asd['val']['point'] = $cit['point'];
			$asd['bridge'] = [];
			array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "'.$_obj['cit_id'].'", "puzzled":false}'));
			$asd['def'] = 'citizens';
			$asd['gate'] = '';
			$final_obj = [];
			$final_obj['json'] = $asd;
			$final_obj['func'] = 'LGen("SaviorMan")->update';
			$asd = LGen('ReqMan')->send_post($final_obj);

			$res = [];
			$res[LGen('GlobVar')->stat] = LGen('GlobVar')->success;
			$res[LGen('GlobVar')->data] = $cit;
			// $obj['namelist'] = ['verification_code', 'created_date', 'fsize', 'theme_color', 'theme_font', 'email', 'lang', 'is_verified', 'id', 'fullname', 'username', 'gender', 'address', 'phonenum', 'silver', 'point'];
			return $res;

			// $asd = LGen('F')->decrypt($asd);
			// $silver = ($asd['silver']);

			// error_log(json_encode($asd));
		}

		public function add_tx_pack($cit, $prod, $order) {
			$tx = [];
			$tx['def'] = 'transactions';
			$tx['bridge'] = [];
			array_push($tx['bridge'], LGen('StringMan')->to_json('{"id": "transactions", "puzzled":true}'));
			$tx['val'] = [];
			$tx['keep_name'] = true;
			$tx['name'] = $order['txid'];
			$tx['val']['id'] = $order['txid'];
			$tx['val']['cit_id'] = $cit['id'];
			$tx['val']['qty'] = $order['qty'];
			$tx['val']['price'] = $prod[$order['cur']];
			$tx['val']['cur'] = $order['cur'];
			$tx['val']['item_id'] = $prod['id'];
			$txid = (LGen('SaviorMan')->insert($tx));
			return $txid;
		}

		public function success_tx_old($tx2) {
			$tx = [];
			$tx['gate'] = '';
			$tx['def'] = 'transactions';
			$tx['bridge'] = [];
			$tx['namelist'] = ['id','price','qty','cur','item_id','cit_id','is_success','purchased_date'];
			array_push($tx['bridge'], LGen('StringMan')->to_json('{"id": "transactions", "puzzled":true}'));
			array_push($tx['bridge'], LGen('StringMan')->to_json('{"id": "'.$tx2['txid'].'", "puzzled":false}'));
			$_tx = LGen('SaviorMan')->read($tx);
			if ($_tx['is_success'])
				return false;
			if ((int)$tx2['price'] < (int)$_tx['price']*(int)$_tx['qty'])
				return false;

			if ($_tx['item_id'] === 'BF45E033FFEA') {
				$cit = [];
				$cit['bridge'] = [];
				array_push($cit['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($cit['bridge'], LGen('StringMan')->to_json('{"id": "'.$_tx['cit_id'].'", "puzzled":false}'));
				$cit['def'] = 'citizens';
				$cit['gate'] = '';
				$cit['namelist'] = ['silver'];
				$final_obj = [];
				$final_obj['json'] = $cit;
				$final_obj['func'] = 'LGen("SaviorMan")->read';
				$_cit = LGen('ReqMan')->send_post($final_obj);
				$_cit['silver'] = $_cit['silver']+$_tx['qty'];
				$cit['val'] = [];
				$cit['val']['silver'] = $_cit['silver'];
				$final_obj['json'] = $cit;
				$final_obj['func'] = 'LGen("SaviorMan")->update';
				LGen('ReqMan')->send_post($final_obj);

				$tx['val']['purchased_date'] = gmdate("Y/m/d H:i:s T");
				$tx['val']['is_success'] = true;
				$txid = (LGen('SaviorMan')->update($tx));
			}
			return true;
		}
	}