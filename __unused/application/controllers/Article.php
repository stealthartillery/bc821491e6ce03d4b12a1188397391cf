<?php 
class Article extends CI_Controller {

	public function _remap($page="01") {
    $this->index($page);
  }

	public function index($page="01") { 
		$L = new Lanterlite();
		if ($page=="index") {
			$this->load->helper('url'); 
			$this->load->view('init'); 
			$this->load->view('page_article_home.php'); 
		}
		else {
			$dir = BASE_DIR . 'assets/corelite/lang/page_article';
			$result = $L->getFileNamesInsideDir($dir);
			$is_exist = false;
			foreach ($result[DATA] as $key => $value) {
				if ($value == $page) {
					$this->load->helper('url'); 
					$this->load->view('init'); 
					$this->load->view('page_article.php'); 
				  echo '<script>';
				  echo "var news_id = '" . $page . "';";
				  echo '</script>';
				  $is_exist = true;
				  break;
				}
			}
			if (!$is_exist) {
				$this->load->helper('url'); 
				$this->load->view('init'); 
				$this->load->view('page_notfound.php'); 			
			}
		}
	}	
}