<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

// include FCPATH . '/assets/lanterlite.gen.php';

class EnliteOld extends CI_Controller{

	public function __construct() {
		parent::__construct();
	}

	public function index($search=NULL, $page=NULL) {
		$this->E = new EnliteGen();
		if (isset($_GET["search"]) && isset($_GET['page'])){
			$this->E->search2($_GET["search"], $_GET['page']);
			// $this->search2($_GET["search"], $_GET['page']);
		}
		else if(isset( $_GET["content"])) {
			$this->E->content($_GET["content"]);
			// $this->content($_GET["content"]);
		}
		// include 'enlite_class.php'; $Enlite = new enlite();
		// echo 
	}

	function content($content_id) {
		$id = $this->StringToArray($content_id, ".");
		if ($id[0] == 'AQ') {
			$str = file_get_contents(FCPATH .'/storage/enlite/fix_alquran_v1.json');
			$json = json_decode($str, true);

			$asd_tot = [];
			foreach($json as $item) {
				$tot_match = 0;
				if($item['id'] == $content_id) {
					$asd['title'] = $item['surah'] . ' ('. $item['surah_no'] . ':' . $item['ayat_no'] . ')';
					$asd['subtitle_1'] = $item['source'];
					$asd['subtitle_2'] = $item['surah_no'] . ':' . $item['ayat_no'];
					$asd['content'] = $item['content'];
					$asd['arabic_content'] = $item['ar_content'];
					$asd['postcontent_1'] = $item['type'];
					array_push($asd_tot, $asd);
			  }
			}	
		}
		else {
			$str = file_get_contents(FCPATH .'/storage/enlite/fix_hadith_v1.json');
			$json = json_decode($str, true);

			$asd_tot = [];
			foreach($json as $item) {
				$tot_match = 0;
				if($item['id'] == $content_id) {
			// foreach($json as $item => $value) {
					// $keys = array_keys($json[0]);
					// foreach ($keys as $key) {
					// 	$asd[$key] = $item[$key];
					// }
					// array_push($asd_tot, $asd);
					$asd['title'] = $item['chapter'];
					$asd['subtitle_1'] = $item['source'];
					$asd['subtitle_2'] = $item['hadith_no'];
					$asd['precontent'] = $item['narrator'];
					$asd['content'] = $item['hadith'];
					$asd['arabic_content'] = $item['ar_hadith'];
					$asd['postcontent_1'] = $item['collector'];
					$asd['postcontent_2'] = $item['degree'];
					array_push($asd_tot, $asd);
			  }
			}	
		}

		if (!isset($asd)) {
			// $keys = array_keys($json);
			// foreach ($keys as $key) {
			// 	$asd[$key] = $item[$key];
			// }
			$asd['title'] = 'Content Not Found';
			$asd['subtitle'] = '';	
			$asd['desc'] = '';	
			array_push($asd_tot, $asd);
		}

		$result['data'] = $asd_tot;
		// array_push($result, $asd_tot);
		// echo $json;
		$result = json_encode($result, true);
		echo $result;	
	}

	function search($stringData, $page) {
		$str = file_get_contents(FCPATH .'/storage/enlite/hadith.json');
		// $str = file_get_contents(FCPATH .'/storage/enlite/hadith.json');
		$json = json_decode($str, true);

		$arr = $this->StringToArray($stringData, " ");

		$asd_tot = [];
		foreach($json as $item) {
			$tot_match = 0;
			for ($i=0; $i<sizeof($arr); $i++) {
			  if(strpos(strtolower($item['hadith']), strtolower($arr[$i])) !== false) {
			  	$tot_match++;
			  }

			  if($tot_match == sizeof($arr)) {
			  	$result = $this->manageString($item['hadith'], $arr);
					$asd['id'] = $item['id'];
					$asd['title'] = $result['title'];
					// $asd['title'] = $item['chapter'];
					$asd['type'] = $item['source'] . ' - ' . $item['chapter'];
					$asd['desc'] = $result['content'];
					array_push($asd_tot, $asd);
			  }
			}
		}

		if (!isset($asd)) {
			$asd['title'] = $stringData;
			$asd['type'] = $stringData;	
			$asd['desc'] = $stringData;	
			$result['status'] = 'NOT_FOUND';
			array_push($asd_tot, $asd);
		}
		else {
			$result['status'] = 'FOUND';		
		}

		$cols_per_page = 10;
		$final_result = [];
		$page_tot = ceil(count($asd_tot)/$cols_per_page);
		for ($i=0+($cols_per_page*$page); $i<$cols_per_page+($cols_per_page*$page); $i++) {
			if (isset($asd_tot[$i]))
				array_push($final_result, $asd_tot[$i]);
		} 
		$result['data'] = $final_result;
		$result['page_tot'] = $page_tot;
		// array_push($result, $asd_tot);
		// echo $json;
		$result = json_encode($result, true);
		echo $result;	
	}

	function getBookName($id) {
		if ($id == 'AQ')
			return "Al-Qur'an";
		else if ($id == 'BM')
			return "Bulughul Maram";
		else if ($id == 'SA')
			return "Syarah Arba'in An-Nawawi";
		else 
			return "undefined";
	}

	function searchFrom($db_file, $stringData) {

		$stringData = $this->gen->L->clean_string($stringData);
		$result_2 = $this->gen->L->mysort3($stringData);

		$result_name = [];
		$is_mistake = false;

		$correction = '';
		for ($i=0;$i<sizeof($result_2['words']); $i++) {
			array_push($result_name, $result_2['words'][$i]);
			if ($result_2['scores'][$i] != 100) {
				$is_mistake = true;
				if ($i == sizeof($result_2['words'])-1)
					$correction = $correction . '<b><i>' . $result_2['words'][$i] . '</i></b>';
				else
					$correction = $correction . '<b><i>' . $result_2['words'][$i] . '</i></b>' . ' ';
			}
			else {
				if ($i == sizeof($result_2['words'])-1)
					$correction = $correction . $result_2['words'][$i];
				else
					$correction = $correction . $result_2['words'][$i] . ' ';			
			}

			if ($result_2['words'][$i] == '-') {
				$result_name = null;
				$i = sizeof($result_2['words']);
			}
		}

			// $this->gen->L->printJson($result_name);
		if ($result_name != null) {
			// $this->gen->L->printJson($result_2);

			$str = file_get_contents($db_file);
			$json = json_decode($str, true);

			$arr = $result_name;

			// for ($i=0; $i<sizeof(); $i++) {

			// }

			$asd_tot = [];

			foreach($json as $item) {
				$tot_match = 0;
				for ($i=0; $i<sizeof($arr); $i++) {


				  if(strpos(strtolower($item['content']), strtolower($arr[$i])) !== false) {
				  	$tot_match++;
				  }

				  if($tot_match == sizeof($arr) or $tot_match/sizeof($arr) > 0.5) {
				  	$result = $this->manageString($item['body'], $arr);
						$asd['id'] = $item['id'];
						$asd['title'] = $result['title'];
						$id = $this->StringToArray($item['id'], ".");
						$asd['type'] = $item['header'];
						// $asd['type'] = getBookName($id[0]);
						$asd['desc'] = $result['content'];
						array_push($asd_tot, $asd);
				  }
				}
			}
			$asd_tot['is_mistake'] = $is_mistake;
			$asd_tot['correction'] = $correction;		
		}
		else {
			$asd_tot = [];	
		}
		
		return $asd_tot;
	}

	function popFirstIndex($arr) {
		array_shift($arr);
		return $arr;
	}

	function StringToArray($string, $parser) {return explode($parser,$string);}
	function ArrayToString($arr) {return implode(" ",$arr);}


	function search2($stringData, $page) {
		// $str = file_get_contents(FCPATH .'/storage/enlite/enlite_quran_fix.json');
		// // $str = file_get_contents(FCPATH .'/storage/enlite/hadith.json');
		// $json = json_decode($str, true);

		// $arr = explode(" ",$stringData);

		$asd_tot = [];
		$paresedStr = $this->StringToArray(strtolower($stringData), ":");
		if ($paresedStr[0] == "q") {
			$type = "quran";
			$newArrStr = $this->popFirstIndex($paresedStr);
			$stringData = $this->ArrayToString($newArrStr);
		}
		else if ($paresedStr[0] == "h"){
			$newArrStr = $this->popFirstIndex($paresedStr);
			$stringData = $this->ArrayToString($newArrStr);
			$type = "hadith";
		}
		else {
			$type = "all";
		}

		if ($type == "quran") {
			$srcResult = $this->searchFrom(FCPATH .'/storage/enlite/enlite_quran_fix.json', $stringData);
			$asd_tot = array_merge($asd_tot, $srcResult);
		}
		else if ($type == "hadith") {
			$srcResult = $this->searchFrom(FCPATH .'/storage/enlite/enlite_light_hadith.json', $stringData);
			$asd_tot = array_merge($asd_tot, $srcResult);
			// $asd_tot = mysort($stringData, $asd_tot);
			// printJson($asd_tot);
		}
		else {
			$srcResult1 = $this->searchFrom(FCPATH .'/storage/enlite/enlite_quran_fix.json', $stringData);
			$asd_tot = array_merge($asd_tot, $srcResult1);
			$srcResult2 = $this->searchFrom(FCPATH .'/storage/enlite/enlite_light_hadith.json', $stringData);
			$asd_tot = array_merge($asd_tot, $srcResult2);
			// $this->gen->L->printJson($asd_tot);
			// $this->gen->L->printJson($asd_tot['correction']);
		}

		// printArray($asd_tot);
		// echo printArray($srcResult2);
		// foreach($json as $item) {
		// 	$tot_match = 0;
		// 	for ($i=0; $i<sizeof($arr); $i++) {
		// 	  if(strpos(strtolower($item['content']), strtolower($arr[$i])) !== false) {
		// 	  	$tot_match++;
		// 	  }

		// 	  if($tot_match == sizeof($arr)) {
		// 	  	$result = $this->manageString($item['content'], $arr);
		// 			$asd['id'] = $item['id'];
		// 			$asd['title'] = $result['title'];
		// 			// $asd['title'] = $item['chapter'];
		// 			$id = explode(".", $item['id']);
		// 			if ($id[0] == 'AQ')
		// 				$id = "Al-Qur'an";
		// 			else if ($id[0] == 'BM')
		// 				$id = "Bulughul Maram";
		// 			$asd['type'] = $id;
		// 			$asd['desc'] = $result['content'];
		// 			array_push($asd_tot, $asd);
		// 	  }
		// 	}
		// }

		if (sizeof($asd_tot) == 0) {
			$asd['title'] = $stringData;
			$asd['type'] = $stringData;	
			$asd['desc'] = $stringData;	
			$result['status'] = 'NOT_FOUND';
			array_push($asd_tot, $asd);
			$is_mistake = false;
			$correction = 'wrong keywords';		
		}
		else {
			$is_mistake = $asd_tot['is_mistake'];
			if ($is_mistake)
				$correction = $asd_tot['correction'];
			else
				$correction = 'no correction';

			$result['status'] = 'FOUND';		
		}

		$cols_per_page = 10;
		$final_result = [];
		$page_tot = ceil(count($asd_tot)/$cols_per_page);
		for ($i=0+($cols_per_page*$page); $i<$cols_per_page+($cols_per_page*$page); $i++) {
			if (isset($asd_tot[$i]))
				array_push($final_result, $asd_tot[$i]);
		} 
		$result['data'] = $final_result;
		$result['page_tot'] = $page_tot;
		$result['is_mistake'] = $is_mistake;
		$result['correction'] = $correction;
		$result = json_encode($result, true);
		echo $result;
	}

	function manageString($string, $word) {
		$arr = explode(" ",$string);

		if (sizeof($arr) != 0) {
			$index = 0;
			for ($i=0; $i<sizeof($arr); $i++) {
				if ($this->gen->L->StrCmpCaseInsen($arr[$i], $word[0], 'part')) {
					$index = $i;
					$i = sizeof($arr);
				}
			}

			$str_after = [];
			$isEnd = false;
			for ($i=$index+1; $i<$index+20; $i++) {
				if (array_key_exists($i, $arr)) {
					$match = false;
					for ($j=0; $j<sizeof($word); $j++) {
						if ($this->gen->L->StrCmpCaseInsen($arr[$i], $word[$j], 'part')) {
							array_push($str_after, '<b>' . $arr[$i] . '</b>');
							$match = true;
						}
					}
					if (!$match) {
						array_push($str_after, $arr[$i]);
					}
				}
				else {
					$i = $index+20;
					$isEnd = true;
				}
			}

			if (!$isEnd) {
				array_push($str_after, '...');
			}

			$isEnd = false;
			$str_before = [];
			for ($i=$index-1; $i>$index-20; $i--) {
				if (array_key_exists($i, $arr)) {
					$match = false;
					for ($j=0; $j<sizeof($word); $j++) {
						if ($this->gen->L->StrCmpCaseInsen($arr[$i], $word[$j], 'part')) {
							array_unshift($str_before, '<b>' . $arr[$i] . '</b>');
							$match = true;
						}
					}
					if (!$match) {
						array_unshift($str_before, $arr[$i]);
					}
				}
				else {
					$i = $index-20;
					$isEnd = true;
				}
			}
			if (!$isEnd) {
				array_unshift($str_before, '...');
			}

			$title = $this->getArrayValueUntilIndex($str_after, 5);
			$title2 = $this->getArrayValueUntilIndexBackward($str_before, 2);
			$title2 = $this->ArrayToString($title2);
			$title = $this->ArrayToString($title);

			$str_before = $this->ArrayToString($str_before);
			$str_after = $this->ArrayToString($str_after);

			$result['content'] = $str_before . ' <b>' . $arr[$index] . '</b> ' . $str_after;
			// $result['title'] = ucfirst($arr[$index]) . ' ' . $title;
			if ($title2 != '') {
				$result['title'] = '... ' . $title2 . ' ' . $arr[$index] . ' ' . $title;
			}
			else {
				$result['title'] = ucfirst($arr[$index]) . ' ' . $title;
			}
		}
		else  {
			$result['title'] = '';
			$result['content'] = '';
		}

		return $result;
	}

	function getArrayValueUntilIndex($arr, $until_index) {
		$result = [];
		for ($i=0; $i<$until_index; $i++) {
			if (isset($arr[$i])) {
				$word = $arr[$i];
				$word = str_replace('<b>', '', $word);
				$word = str_replace('</b>', '', $word);
				array_push($result, $word);
			}
		}		
		if ($until_index < sizeof($arr))
			array_push($result, '...');
		return $result;
	}

	function getArrayValueUntilIndexBackward($arr, $until_index) {
		$result = [];
		for ($i=sizeof($arr)-1; $i>sizeof($arr)-1-$until_index; $i--) {
			if (isset($arr[$i])) {
				$word = $arr[$i];
				$word = str_replace('<b>', '', $word);
				$word = str_replace('</b>', '', $word);
				array_unshift($result, $word);
			}
		}	
		// if ($until_index < sizeof($arr))
		// 	array_unshift($result, '...');
		return $result;
	}
}