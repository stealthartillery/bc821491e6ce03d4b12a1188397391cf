<?php defined('BASEPATH') OR exit('no direct script access allowed');

class game extends CI_Controller {

	public function index() {
		$data = json_decode(file_get_contents('php://input'), true);
		include 'token.php'; $Token = new token();

		if ($Token->isTokenValid($data['access_token'], $data['data']['user_username'])) {
		
		// $data['data']['content'] = 'prophet_in_islam';

			//// Create response data.
			$resp_data[RESP_STATUS] = SUCCESS;
			$csv_path = FCPATH . "/storage/game/word_search/content.csv";

		    $csvFile = file($csv_path);
		    $words = [];
		    foreach ($csvFile as $line) {
	        if (str_getcsv($line)[0] == $data['data']['content'])
		        $words[] = str_getcsv($line)[1];
		    }
		    $resp_data['data'] = $words;

			header('Content-Type: application/json');
			echo json_encode($resp_data);
		}
		else {
			$this->output->set_status_header('404');
		}
	}
}
?>