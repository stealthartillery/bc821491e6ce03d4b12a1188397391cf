<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Donate extends CI_Controller {
	public function index() { 
		$this->load->helper('url'); 
		$this->load->view('init.php'); 
		$this->load->view('page_donate.php'); 
	} 
} 
?>