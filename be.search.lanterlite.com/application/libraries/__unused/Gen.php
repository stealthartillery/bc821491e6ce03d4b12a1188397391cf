<?php

class Gen {

  function __construct() {
  	/* DEVELOP */
		$this->dir = dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/lanterlite.gen.php';  	
		/* DEPLOY */
		// $this->dir = dirname( dirname( dirname( __FILE__  ) ) ) . '/assets/lanterlite.gen.php'; 		
		include $this->dir;
		$this->L = $L;
		// $this->import();
  }

	function import(){
		// $this->console_log($this->dir);
		$this->console_log(DATA);
	}

	function console_log( $data ){
		echo '<script type=\'text/javascript\'>';
		echo 'console.log('. json_encode( $data ) .')';
		echo '</script>';
	}

	function console_log2( $data ){
		echo json_encode( $data );
	}

	function get_client_ip() {
    $ip = getenv('HTTP_CLIENT_IP')?:
		getenv('HTTP_X_FORWARDED_FOR')?:
		getenv('HTTP_X_FORWARDED')?:
		getenv('HTTP_FORWARDED_FOR')?:
		getenv('HTTP_FORWARDED')?:
		getenv('REMOTE_ADDR');
	    return $ip;
	}

	function show_hello_world()	{
		return 'Hello World';
	}

}

?>