<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index() { 
		$this->load->helper('url'); 
		$this->load->view('init'); 
		$this->load->view('page_product.php'); 
	} 

	// public function alkhulafa() { 
	// 	$this->load->helper('url'); 
	// 	$this->load->view('init'); 
	// 	$this->load->view('header'); 
	// 	$this->load->view('about/index');
	// 	// $this->load->view('product/alkhulafa.php'); 
	// 	$this->load->view('footer'); 		 
	// } 
} 
?>