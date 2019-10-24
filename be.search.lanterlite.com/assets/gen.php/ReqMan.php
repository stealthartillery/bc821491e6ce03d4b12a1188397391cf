<?php
	ini_set("log_errors", 1);
	ini_set("error_log", BASE_DIR.'storages/store/'. 'store.log');
	class ReqMan {
		function send_post($obj) {
			$postdata = http_build_query(
				// $obj
	    array(
	        DATA => LGen('F')->encrypt($obj),
			)
	    // array(
	    //     'var1' => 'some content',
	    //     'var2' => 'doh'
			  //   )
			);

	    // array(
	    //     DATA => json_encode($obj),
			  //   )
			$opts = array('http' =>
			    array(
			        'method'  => 'POST',
			        'header'  => 'Content-Type: application/x-www-form-urlencoded',
			        'content' => $postdata
			    )
			);

			$context  = stream_context_create($opts);
			error_log('json_encode($context)');
			error_log('asd ' . json_encode($opts));
			$result = file_get_contents('http://localhost/app/be.citizen.lanterlite.com/gate/', false, $context);
			return $result;
			// $result = file_get_contents('http://example.com/submit.php', false, $context);
		}
	}
?>