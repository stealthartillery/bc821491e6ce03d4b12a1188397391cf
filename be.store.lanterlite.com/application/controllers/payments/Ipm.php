<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

include HOME_DIR . 'app/lanterapp.php';
include BASE_DIR . 'assets/gen_base_be/lantergen.php';

class Ipm extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
	}

	public function rtn() {
		if (isset($_GET["trx_id"])) {
			$param = $_GET;
		}
		else if (isset($_POST["trx_id"])) {
			$param = $_POST;
		}
		else {
			$param = [];
		}
		error_log(json_encode($param));
		$this->add_pgtx_id($param['id'],$param['trx_id']);
		if (app_status === 'dev')
			header("LOCATION: http://localhost/app/store.lanterlite.com/order_success");
		else
			header("LOCATION: https://store.lanterlite.com/order_success");
		return true;
	}

	public function ntf() {
		if (isset($_GET["?trx_id"])) {
			$param = $_GET;
		}
		else if (isset($_POST["?trx_id"])) {
			$param = $_POST;
		}
		else {
			$param = [];
		}
		error_log(json_encode($param));
		$this->success_tx($param);
		return true;
	}

	public function add_pgtx_id($id, $pgtx_id) {
		$tx = [];
		$tx['gate'] = '';
		$tx['val'] = [];
		$tx['val']['pgtx_id'] = $pgtx_id;
		$tx['def'] = 'transactions';
		$tx['bridge'] = [];
		array_push($tx['bridge'], LGen('StringMan')->to_json('{"id": "transactions", "puzzled":true}'));
		array_push($tx['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
		$_tx = LGen('SaviorMan')->update($tx);
		return true;
	}

	public function success_tx($tx2) {
		if (!LGen('JsonMan')->is_key_exist($tx2,'?trx_id'))
			return false;
		if (!LGen('JsonMan')->is_key_exist($tx2,'id'))
			return false;
		if ($tx2['status'] !== 'berhasil')
			return false;
		$tx = [];
		$tx['gate'] = '';
		$tx['def'] = 'transactions';
		$tx['bridge'] = [];
		$tx['namelist'] = ['id','pgtx_id','price','qty','cur','item_id','cit_id','is_success','purchased_date'];
		array_push($tx['bridge'], LGen('StringMan')->to_json('{"id": "transactions", "puzzled":true}'));
		array_push($tx['bridge'], LGen('StringMan')->to_json('{"id": "'.$tx2['id'].'", "puzzled":false}'));
		$_tx = LGen('SaviorMan')->read($tx);
		if ((int)$_tx['is_success'])
			return false;
		error_log(json_encode($_tx));
		if ((int)$tx2['total'] < (int)$_tx['price']*(int)$_tx['qty'])
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
			$tx['val']['is_success'] = 1;
			$txid = (LGen('SaviorMan')->update($tx));
		}
		return true;
	}
}