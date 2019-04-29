<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class NotFound extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() { 
		$this->output->set_status_header('404');
		$this->load->helper('url'); 
		$this->load->view('init'); 
		$this->load->view('page_notfound'); 
		// $this->load->view('footer'); 		 
	} 
} 
?>