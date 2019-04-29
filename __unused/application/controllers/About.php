<?php 
class About extends CI_Controller {

	public function index() { 
		$this->load->helper('url'); 
		$this->load->view('init.php'); 
		$this->load->view('page_about.php');
	}
	
}