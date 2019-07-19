<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Asd extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->L = new Lanterlite();
	}

	public function index() {
		echo 'asd';
	}
}