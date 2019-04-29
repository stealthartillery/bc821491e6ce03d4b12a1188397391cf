<?php 
class Experiment extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() { 
		$this->load->helper('url'); 
		$this->load->view('experiment/index.php'); 
	} 

	public function dbms() { 
		$this->load->helper('url'); 
		$this->load->view('init'); 
		$this->load->view('header'); 
		$this->load->view('experiment/dbms.php');
		$this->load->view('footer'); 		 
	} 

	// public function enlite() { 
	// 	$this->load->helper('url'); 
	// 	$this->load->view('experiment/enlite.php');
	// } 
}
?>