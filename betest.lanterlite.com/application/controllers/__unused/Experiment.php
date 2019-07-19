<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

// include FCPATH . '/assets/lanterlite.gen.php';

class Experiment extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index($no="1") {
		if (isset($_GET["no"])) {
			if ($_GET['no'] == "1"){ 
				// unset($_SESSION['counter']);
				session_start();

				// Set session variables
				// $_SESSION["favcolor"] = "green";
				// $_SESSION["favanimal"] = "cat";
				echo $_SESSION["favanimal"];

				// $stateService = new StateService();

				// // $state['date'] = getdate();

				// // echo print_r($state['date'], true) . PHP_EOL;

				// // $stateService->saveState('testing', $state);

				// // unset($state['date']); # Simulate losing state by deleting the $state variable from memory.

				// $state = $stateService->getState('testing');

				// echo print_r($state['date'], true) . PHP_EOL;
			}
			else if ($_GET['no'] == "2"){ 
				// Create a temporary file and return its path
				$tmp = tempnam('/tmp', 'PHP');

				// Get the file token key
				$key = ftok($tmp, 'a');

				// Attach the SHM resource, notice the cast afterwards
				$id = shm_attach($key);

				if ($id === false) {
				    die('Unable to create the shared memory segment');
				}

				// Cast to integer, since prior to PHP 5.3.0 the resource id 
				// is returned which can be exposed when casting a resource
				// to an integer
				$id = (integer) $id;
			}
			else if ($_GET['no'] == "3"){ 
				
			}
		}
	}
}