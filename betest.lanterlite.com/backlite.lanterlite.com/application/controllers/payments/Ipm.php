<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Ipm extends CI_Controller {

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
					$prod_info = $param["prod_info"];
					$message = $param["message"];
					$user_id = $param["user_id"];
					$item_id = $param["item_id"];
					$store_id = $param["store_id"];
					$category_id = $param["category_id"];
					$quantity = $param["quantity"];
					$price_per_item = $param['price_per_item'];
					$price_total = $param['price_total'];
					$currency = $param["currency"];

					$date_order = new DateTime();
					$date_order = date_format($date_order, 'Y-m-d : H:i:s');

					$urlReturn = HOME_URL . 'payments/ipm/?gateway=ipaymu&action=return&user_id='.$user_id.'&item_id='.$item_id.'&date_order='.$date_order.'&price_per_item='.$price_per_item.'&price_total='.$price_total.'&currency='.$currency.'&quantity='.$quantity.'&message='.$message.'&category_id='.$category_id.'&store_id='.$store_id;
					$urlNotify = HOME_URL . 'payments/ipm/notif/';
					$urlCancel = 'https://www.lanterlite.com/';

					$iPaymu = new iPaymu('CD41Pq5.sx.VvqGzE67Dg4nEBx3Iu1');
					$iPaymu->addProduct($prod_name, $price_per_item, $quantity, $prod_info);
					echo json_encode($iPaymu->paymentPage($urlReturn, $urlNotify , $urlCancel));
				}

				if ($param["action"] == 'return') {
					$trans_obj = $param;
					$trans_obj['tx_id'] = $param['trx_id'];
					$trans_obj['type'] = $param['tipe'];
					unset($trans_obj['trx_id']);
					unset($trans_obj['tipe']);
					unset($trans_obj['d']);

					$data = $this->user->get_trans($trans_obj['user_id']);
					if ($data[RES_STAT] == SUCCESS && $data[DATA] !== null) {
						$trans_list = $data[DATA];

						foreach ($trans_list as $key => $value) {
							if ($value['tx_id'] == $trans_obj['tx_id']) {
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

					$tradelite_trans_obj['user_id'] = $trans_obj['user_id'];
					$tradelite_trans_obj['item_id'] = $trans_obj['item_id'];
					$tradelite_trans_obj['quantity'] = $trans_obj['quantity'];
					$tradelite_trans_obj['currency'] = $trans_obj['currency'];
					$tradelite_trans_obj['price_per_item'] = $trans_obj['price_per_item'];
					$tradelite_trans_obj['price_total'] = $trans_obj['price_total'];
					$tradelite_trans_obj['date_order'] = $trans_obj['date_order'];
					$this->user->set_tradelite_trans($trans_obj['tx_id'], $tradelite_trans_obj);
					
					header("Location: https://www.lanterlite.com");
					die();
				}
			}
		}
	}

	public function notif() {
		if (isset($_GET["trx_id"])) {
			$param = $_GET;
		}
		else if (isset($_POST["trx_id"])) {
			$param = $_POST;
		}
		else {
			$param = [];
		}

		if ($param["status"] == 'berhasil') {
			$data = $this->user->get_tradelite_trans($param["trx_id"]);
			if (!isset($data[DATA]['date_purchase'])) {

				$date_purchase = new DateTime();
				$date_purchase = date_format($date_purchase, 'Y-m-d : H:i:s');

				$trans_obj['user_id'] = $tradelite_trans_obj['user_id'] = $user_id											= (isset($data[DATA]['user_id']) ? $data[DATA]['user_id'] : '');
				$trans_obj['item_id'] = $tradelite_trans_obj['item_id'] = $item_id 											= (isset($data[DATA]['item_id']) ? $data[DATA]['item_id'] : '');
				$trans_obj['quantity'] = $tradelite_trans_obj['quantity'] = $quantity 									= (isset($data[DATA]['quantity']) ? $data[DATA]['quantity'] : '');
				$trans_obj['currency'] = $tradelite_trans_obj['currency'] = $currency 									= (isset($data[DATA]['currency']) ? $data[DATA]['currency'] : '');
				$trans_obj['price_per_item'] = $tradelite_trans_obj['price_per_item'] = $price_per_item = (isset($data[DATA]['price_per_item']) ? $data[DATA]['price_per_item'] : '');
				$trans_obj['price_total'] = $tradelite_trans_obj['price_total'] = $price_total 					= (isset($data[DATA]['price_total']) ? $data[DATA]['price_total'] : '');
				$trans_obj['status'] = $tradelite_trans_obj['status'] = $param['status'] = 'purchased';
				$trans_obj['tx_id'] = $tradelite_trans_obj['tx_id'] = $param['trx_id'];
				$trans_obj['date_order'] = $tradelite_trans_obj['date_order'] = $date_order 						= (isset($data[DATA]['date_order']) ? $data[DATA]['date_order'] : '');
				$trans_obj['date_purchase'] = $tradelite_trans_obj['date_purchase'] = $date_purchase; 
				$trans_obj['gateway'] = 'ipaymu'; 

				// $trans_obj['payment_total'] = $param['total'];

				// if (isset($param['no_rekening_deposit']))
				// 	$trans_obj['account_number'] = $param['no_rekening_deposit'];

				$data = $this->user->get_trans($user_id);
				if ($data[RES_STAT] == SUCCESS && $data[DATA] !== null) {

					$trans_list = $data[DATA];

					foreach ($trans_list as $key => $value) {
						if ($value['tx_id'] == $trans_obj['tx_id']) {
							$trans_obj['store_id'] = $tradelite_trans_obj['store_id'] = (isset($value['store_id']) ? $value['store_id'] : '');
							$trans_obj['message'] = (isset($value['message']) ? $value['message'] : '');
							$trans_obj['category_id'] = (isset($value['category_id']) ? $value['category_id'] : '');
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

				// $this->printJson($trans_obj);
				if (isset($trans_obj['category_id']) && isset($trans_obj['store_id'])) {
					if ($trans_obj['category_id'] == 'license' && $trans_obj['store_id'] == 'lanterlite') {
						$licenses_new = [];
						for ($i=0; $i<(int)$trans_obj['quantity']; $i++) {
							$license_new['license_id'] = $trans_obj['item_id'];
							array_push($licenses_new, $license_new);
						}
						$licenses_old = $this->user->get_license($trans_obj['user_id'], 'id')[DATA];
						// $this->printJson($trans_obj);
						foreach ($licenses_old as $key => $value) {
							$license_old['license_id'] = $value['license_id'];
							array_push($licenses_new, $license_old);
						}
						$this->user->set_license($trans_obj['user_id'], $licenses_new);
					}
				}

				$this->user->set_trans($user_id, $trans_list);
				$this->user->set_tradelite_trans($trans_obj['tx_id'], $tradelite_trans_obj);
			}
		}
	}
}

// http://localhost/app/be.lanterlite.com/payments/ipm/?gateway=ipaymu&action=bal
// http://localhost/app/be.lanterlite.com/payments/ipm/?gateway=ipaymu&action=stat
// http://localhost/app/be.lanterlite.com/payments/ipm/?gateway=ipaymu&action=trans&&trans_id=txid
// http://localhost/app/be.lanterlite.com/payments/ipm/?gateway=ipaymu&action=new_trans&item_id=item12345&quantity=1&price_total=5000&price_per_item=5000&currency=idr&user_id=f7718beb9db5b6d6b2afaabbe604e21e&prod_name=Lanterlite+Theme+License+Card&prod_info=Lisensi+untuk+menggunakan+fitur+tema+tambahan+pada+aplikasi+Lanterlite

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
