<?php 
	/**
	 * @author Franky So <frankyso.mail@gmail.com>
	 */
	// namespace iPaymu;
	class iPaymu	{
		public $apiKey;
		public $urlReturn;
		public $urlNotify;
		public $urlCancel;
		public $products 	=	array();
		public $payment;

		protected $productListModified 	=	true;

		function __construct($apiKey='')
		{
			$this->setApiKey($apiKey);
		}

		/**
		 * Get a part of the iPaymu object
		 *
		 * @param string $name
		 *
		 * @throws InvalidArgumentException
		 *
		 * @return string|int
		 */

		public function __get($name)
		{
		    switch (true) {
		        case $name === 'paymentPage':
		            return $this->paymentPage();

		        case $name === 'balance':
		            return (int) $this->checkBalance();

		        case $name === 'status':
		            return (int) $this->checkStatus();

		        default:
		            throw new InvalidArgumentException(sprintf("Unknown getter '%s'", $name));
		    }
		}

		/**
		 * Check if an attribute exists on the object
		 *
		 * @param string $name
		 *
		 * @return bool
		 */
		public function __isset($name)
		{
		    try {
		        $this->__get($name);
		    } catch (InvalidArgumentException $e) {
		        return false;
		    }

		    return true;
		}

		/**
		 * Set a part of the iPaymu object
		 *
		 * @param string                  $name
		 * @param string|int $value
		 *
		 * @throws InvalidArgumentException
		 */
		public function __set($name, $value)
		{
		    switch ($name) {
		        // case 'redirectURL':
		        //     $this->setDate($value, $this->month, $this->day);
		        //     break;

		        default:
		            throw new InvalidArgumentException(sprintf("Unknown setter '%s'", $name));
		    }
		}

		public static function api($apiKey)
		{
			return new static($apiKey);
		}

		/**
		 * Add new Product to iPaymu Url
		 *
		 * @param string                  $name
		 * @param string|int $value
		 *
		 * @throws InvalidArgumentException
		 */
		public function addProduct($name='', $price=0, $qty=1, $comment='')
		{
			$this->products['name']		=	$name;
			$this->products['price']		=	$price;
			$this->products['qty']		=	$qty;
			$this->products['comment']	=	$comment;
			$this->productListModified 		=	true;
		}


		/**
		 * Generate Payment Page
		 *
		 * @param string|url        $urlReturn
		 * @param string|url 		$urlNotify
		 * @param string|url 		$urlCancel
		 *
		 * @throws InvalidArgumentException
		 */

		public function paymentPage($urlReturn = '', $urlNotify='' , $urlCancel = '', $buyer)
		{
			if ($this->productListModified==false) {
				return $this->payment;
			}

			$urlReturn 	=	isset($urlReturn)?$urlReturn:$this->urlReturn;
			$urlNotify 	=	isset($urlNotify)?$urlNotify:$this->urlNotify;
			$urlCancel 	=	isset($urlCancel)?$urlCancel:$this->urlCancel;

			// error_log('comment => ' . json_encode($this->products['comment']));
			// error_log('comment => ' . json_encode($this->products['comment']));
			$params = array(
			            'key'      => $this->apiKey,
			            'action'   => 'payment',
			            'product'  => $this->products['name'],
			            'price'    => $this->products['price'],
			            'quantity' => $this->products['qty'],
			            'comments' => $this->products['comment'],
			            'ureturn'  => $urlReturn,
			            'unotify'  => $urlNotify,
			            'ucancel'  => $urlCancel,

							    // 'pay_method'  => 'cstore', // Metode pembayaran yang akan ditampilkan (VA BAG => arthagraha, VA Niaga => niaga, VA BNI => bni, Kartu Kredit => cc, Convenience Store (Alfamart/Indomaret) => cstore, COD => cod, Saldo iPaymu => member)
							    // 'pay_channel' => 'alfamart', // Channel dari metode pembayaran, jika ada (Misal dari metode pembayaran Convenience Store => indomaret, alfamart)
							    'buyer_name'  => $buyer['fullname'], // Nama customer/pembeli(opsional) 
							    'buyer_phone' => $buyer['phonenum'], // No HP customer/pembeli (opsional)
							    'buyer_email' => $buyer['email'], // Email customer/pembeli (opsional)

			            'format'   => 'json'
			        );

			$params_string = http_build_query($params);

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://my.ipaymu.com/payment.htm');
			curl_setopt($ch, CURLOPT_POST, count($params));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

			$request = curl_exec($ch);

			if ( $request === false ) {
			    echo 'Curl Error: ' . curl_error($ch);
			} else {
			    
			    $result = json_decode($request, false);

			    if( isset($result->url) )
			    {
			        $this->payment = $result;
			        return $result;
			    }
			    else {
			    	throw new \Exception($result->Keterangan, $result->Status);
			    }
			}
			curl_close($ch);
		}


		/**
		 * Set Api Key
		 */
		public function setApiKey($apiKey=null)
		{
			if ($apiKey!=null) {
				$this->apiKey = $apiKey;
				$this->apiValid();
			}
		}

		/**
		 * Check API Valid
		 *
		 *
		 * @throws InvalidArgumentException
		 */
		public function apiValid()
		{
			$result = file_get_contents("https://my.ipaymu.com/api/CekSaldo.php?key=".$this->apiKey."&format=json");
			if (isset($result->Status)) {
				if ($result->Status=="-1001") {
					throw new \Exception($result->Keterangan, $result->status);
				}
				else
				{
					return true;
				}
			}

			return true;
		}


		/**
		 * Get transaction details
		 *
		 * @param string|url        $id transaction
		 */
		public function transaction($id)
		{
			return file_get_contents("https://my.ipaymu.com/api/CekTransaksi.php?key=".$this->apiKey."&id=$id&format=json");
			// return json_decode(file_get_contents("https://my.ipaymu.com/api/CekTransaksi.php?key=".$this->apiKey."&id=$id&format=json"));
		}


		/**
		 * Check Balance
		 */
		private function checkBalance()
		{
			$balance = json_decode(file_get_contents("https://my.ipaymu.com/api/CekSaldo.php?key=".$this->apiKey."&format=json"));
			// echo $this->apiKey;
			// echo file_get_contents("https://my.ipaymu.com/api/CekSaldo.php?key=".$this->apiKey."&format=json");
			// echo file_get_contents("https://google.com");
			// $params_string = http_build_query($params);

			// $url = 'https://google.com';
			// //open connection
			// $ch = curl_init();

			// curl_setopt($ch, CURLOPT_URL, $url);
			// curl_setopt($ch, CURLOPT_POST, count($params));
			// curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

			// //execute post
			// $request = curl_exec($ch);
			// if ( $request === false ) {
			//     echo 'Curl Error: ' . curl_error($ch);
			// }

			// echo json_encode($request);
			// echo 'asdasdasd';
			return $balance->Saldo;
		}

		/**
		 * Check User status
		 */
		private function checkStatus()
		{
			$url = "https://my.ipaymu.com/api/CekStatus.php?key=".$this->apiKey."&format=json";
			$balance = json_decode(file_get_contents($url));
			return $balance->StatusUser;
		}
	}
?>
