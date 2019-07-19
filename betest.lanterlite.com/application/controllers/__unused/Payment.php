<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Payment extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->L = new Lanterlite();
		include BASE_DIR . 'assets/backlite/php/ModelUser.php';
		$this->user = new ModelUser();
	}

	public function index() {
		// $this->L->printJson($_GET);
		if (isset($_GET["gateway"])) {
			$param = $_GET;
		}
		else if (isset($_POST["gateway"])) {
			$param = $_POST;
		}
		else {
			$param = [];
		}
		// $this->L->printJson($param);
		
		// if (isset($param["gateway"]))
		// 	echo 'asd';
		// else 
		// 	echo 'asda';

		// $this->L->printJson($param);
		// if (isset($_GET["gateway"]))
		// 	echo 'asd1';
		// else 
		// 	echo 'asda1';


		if (isset($param["gateway"]) && isset($param["action"])) {
			if ($param["gateway"] == 'ipaymu') {
				include BASE_DIR . 'assets/lite.php/iPaymu.class.php';

				if ($param["action"] == 'bal') {
					$iPaymu = new iPaymu('CD41Pq5.sx.VvqGzE67Dg4nEBx3Iu1');
					echo $iPaymu->balance;
				}
				if ($param["action"] == 'stat') {
					$iPaymu = new iPaymu('CD41Pq5.sx.VvqGzE67Dg4nEBx3Iu1');
					echo $iPaymu->status;
				}
				if ($param["action"] == 'trans') {
					$id_transaksi = $param["trans_id"];
					$iPaymu = new iPaymu('CD41Pq5.sx.VvqGzE67Dg4nEBx3Iu1');
					echo json_encode($iPaymu->transaction($id_transaksi));
				}
				if ($param["action"] == 'new_trans') {
					$prod_name = $param["prod_name"];
					$prod_price = $param["prod_price"];
					$prod_qty = $param["prod_qty"];
					$prod_info = $param["prod_info"];
					$user_id = $param["user_id"];
					$urlReturn = HOME_URL . 'payment/?gateway=ipaymu&action=return&user_id='.$user_id;
					$urlNotify = HOME_URL . 'payment/?gateway=ipaymu&action=notif&user_id='.$user_id;
					$urlCancel = 'https://www.lanterlite.com/';

					$iPaymu = new iPaymu('CD41Pq5.sx.VvqGzE67Dg4nEBx3Iu1');
					$iPaymu->addProduct($prod_name, $prod_price, $prod_qty, $prod_info);
					echo json_encode($iPaymu->paymentPage($urlReturn, $urlNotify , $urlCancel));
				}

				if ($param["action"] == 'return') {
					$trans_obj = $param;

					$data = $this->user->get_trans($trans_obj['user_id']);
					if ($data[RES_STAT] == SUCCESS && $data[DATA] !== null) {
						$trans_list = $data[DATA];
						foreach ($trans_list as $key => $value) {
							// $this->L->printJson($value);
							// $this->L->printJson($trans_obj);
							// echo ($value['trx_id'] === $trans_obj['trx_id']);
							// echo ($value['trx_id'] . ' ' .  $trans_obj['trx_id']);
							if ($value['trx_id'] == $trans_obj['trx_id']) {
								$trans_list[$key] = $trans_obj;
								break;
							}
							else if ($key==sizeof($trans_list)-1) {
								array_push($trans_list, $trans_obj);
								break;
							}
						}
					}
					else {
						$trans_list = [];
						array_push($trans_list, $trans_obj);
					}
					
					$this->user->set_trans($trans_obj['user_id'], $trans_list);
					
					header("Location: https://www.lanterlite.com");
					die();
				}

				if ($param["action"] == 'notif') {
					$trans_obj = $param;

					$data = $this->user->get_trans($trans_obj['user_id']);
					if ($data[RES_STAT] == SUCCESS && $data[DATA] !== null) {
						$trans_list = $data[DATA];
						foreach ($trans_list as $key => $value) {
							if ($value['trx_id'] == $trans_obj['trx_id']) {
								$trans_list[$key] = $trans_obj;
								break;
							}
							else if ($key==sizeof($trans_list)-1) {
								array_push($trans_list, $trans_obj);
								break;
							}
						}
					}
					else {
						$trans_list = [];
						array_push($trans_list, $trans_obj);
					}

					$this->user->set_trans($trans_obj['user_id'], $trans_list);
				}
			}
		}
	}

	public function notif() {
		echo 'asd';
		$this->L->printJson($_POST);
		// $trans_obj = $_POST;
		// $trans_obj['gateway'] = 'ipaymu';

		// $trans_list = $this->user->get_trans($trans_obj['user_id']);
		// foreach ($trans_list as $key => $value) {
		// 	if ($value['trx_id'] == $trans_obj['trx_id']) {
		// 		$trans_list[$key] = $trans_obj;
		// 		break;
		// 	}
		// }

		// include BASE_DIR . 'assets/backlite/php/ModelUser.php';
		// $user = new ModelUser();
		// $this->user->set_trans($trans_obj['user_id'], $trans_list);
	}
}

// http://localhost/app/be.lanterlite.com/payment/?gateway=ipaymu&action=bal
// http://localhost/app/be.lanterlite.com/payment/?gateway=ipaymu&action=stat
// http://localhost/app/be.lanterlite.com/payment/?gateway=ipaymu&action=trans&&trans_id=txid
// http://localhost/app/be.lanterlite.com/payment/?gateway=ipaymu&action=new_trans&user_id=f7718beb9db5b6d6b2afaabbe604e21e&prod_name=Lanterlite+Theme+License+Card&prod_price=20000&prod_qty=1&prod_info=Lisensi+untuk+menggunakan+fitur+tema+tambahan+pada+aplikasi+Lanterlite

//contoh pembayaran
// sid: ab8aa19fe630617f40ba5e4c07e38e483c3c2850e1cf53ad9a9add5174eeb26b1bb627b7993a45847a504cccd1c2961119f5f6f8d1cfc74b79599171afd9a81f
// url: https://my.ipaymu.com/process.htm?sessionID=ab8aa19fe630617f40ba5e4c07e38e483c3c2850e1cf53ad9a9add5174eeb26b1bb627b7993a45847a504cccd1c2961119f5f6f8d1cfc74b79599171afd9a81f

// dia nanti ngirim ini ke sini: https://www.lanterlite.com/&trx_id=369481&status=pending&tipe=nonmember&d=eyJuYW1lYWMiOiJJZmFuIERoYW5pIFByYXNvam8iLCJlbWFpbGFjY291bnQiOiJpZmFuZGhhbmlwQGdtYWlsLmNvbSIsInBob25lIjoiMDgxMTIxMDA3NzMifQ%3D%3D

// dipecah: 
// trx_id=369481
// status=pending
// tipe=nonmember
// d=eyJuYW1lYWMiOiJJZmFuIERoYW5pIFByYXNvam8iLCJlbWFpbGFjY291bnQiOiJpZmFuZGhhbmlwQGdtYWlsLmNvbSIsInBob25lIjoiMDgxMTIxMDA3NzMifQ%3D%3D


		// $status = $_POST['status'];
		// $trx_id = $_POST['trx_id'];
		// $sid = $_POST['sid'];
		// $product = $_POST['product'];
		// $quantity = $_POST['quantity'];
		// $merchant = $_POST['merchant'];
		// $buyer = $_POST['buyer'];
		// $total = $_POST['total'];
		// $no_rekening_deposit = $_POST['no_rekening_deposit'];
		// $action = $_POST['action'];
		// $comments = $_POST['comments'];
		// $no_rekening_deposit = $_POST['referer'];

		// if ($_POST['status'] == 'berhasil')
		// 	$trans_obj['status'] = 'paid';
		// else
		// 	$trans_obj['status'] = 'not_paid';

		// $trans_obj['txid_gateway'] = $trx_id
		// $trans_obj['txid_tradelite'] = ''
