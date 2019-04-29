<?php 
class Maintenance extends CI_Controller {

	public function index() { 
		$this->load->helper('url'); 
		$this->load->view('header'); 
		$this->load->view('maintenance');
		$this->load->view('footer'); 
	}
	
}