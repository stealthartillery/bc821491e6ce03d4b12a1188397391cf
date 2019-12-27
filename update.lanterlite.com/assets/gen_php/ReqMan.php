<?php
	// ini_set("log_errors", 1);
	// ini_set("error_log", BASE_DIR.'storages/store/'. 'store.log');
	// init();
	class ReqMan {
		function send_get($obj, $url='be.citizen.lanterlite.com') {
			// $result = file_get_contents($url.'?f='.LGen('Black')->get($obj['f']).'&o='.LGen('Black')->get($obj['f']));
			if (app_status === 'dev')
				$url = 'http://localhost/app/'.$url.'/gate/';
			else
				$url = 'https://'.$url.'/gate/';
			// return $url.'?f='.urlencode(LGen('Black')->get($obj));
			$result = file_get_contents($url.'?f='.urlencode(LGen('Black')->get($obj)));
			// if ($obj !== undefined)
			return LGen('White')->get($result);
		}

		function send_post($obj, $url='be.citizen.lanterlite.com') {
			$obj = LGen('Black')->get($obj);
			$postdata = http_build_query(
				// $obj
	    array(
	        DATA => $obj,
	        // DATA => LGen('F')->encrypt($obj),
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
			if (app_status === 'dev')
				$result = file_get_contents('http://localhost/app/'.$url.'/gate/', false, $context);
			else
				$result = file_get_contents('https://'.$url.'/gate/', false, $context);
			$result = LGen('White')->get($result);
			return $result;
			// $result = file_get_contents('http://example.com/submit.php', false, $context);
		}
	}
?>