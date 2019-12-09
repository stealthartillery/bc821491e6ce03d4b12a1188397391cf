<?php
	
	$sketch = new SketchGen();
	define('MAX_TOT_MSGS', 10);
	define('MAX_TOT_POSTS', 10);

	class SketchGen {
		public function __construct() {
			set_time_limit ( 0 );
		}

		public function check_acc($obj) {
			$cit_id = $obj['val']['id'];

			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'citizens';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			$cits = LGen('SaviorMan')->read($_obj);
			if (sizeof($cits) === 0) {
				$_obj = [];
				$_obj['val'] = [];
				$_obj['val']['id'] = $cit_id;
				$_obj['keep_name'] = true;
				$_obj['name'] = $cit_id;
				$_obj['def'] = 'citizens';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				$cits = LGen('SaviorMan')->insert($_obj);
			}
			return $cits;
		}

		public function add_paper($obj) {
			$cit_id = $obj['val']['cit_id'];

			/* add papers */
			$_obj = [];
			$_obj['val'] = $obj['val'];
			$_obj['def'] = 'papers';
			$_obj['bridge'] = [];
			$_obj['note'] = 'return full';
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "papers", "puzzled":true}'));
			$paper = LGen('SaviorMan')->insert($_obj);

			/* add citizens/papers */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $paper['id'];
			$_obj['keep_name'] = true;
			$_obj['name'] = $paper['id'];
			$_obj['def'] = 'citizens/papers';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "papers", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);

			/* add papers/contributors */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $cit_id;
			$_obj['keep_name'] = true;
			$_obj['name'] = $cit_id;
			$_obj['def'] = 'papers/contributors';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "papers", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$paper['id'].'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "contributors", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);

			return $paper;
		}

		public function remove_paper($obj) {
			// $cit_id = $obj['val']['cit_id'];
			$paper_id = $obj['val']['paper_id'];

			/* get papers/contributors */
			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'papers/contributors';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "papers", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$paper_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "contributors", "puzzled":true}'));
			$cits = LGen('SaviorMan')->get_all($_obj);
			// return $cits;
			for ($i=0; $i <sizeof($cits) ; $i++) { 
				/* remove cits/papers */
				$_obj = [];
				$_obj['def'] = 'citizens/papers';
				$_obj['name'] = $paper_id;
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cits[$i]['id'].'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "papers", "puzzled":true}'));
				LGen('SaviorMan')->delete_pack($_obj);
			}

			/* remove papers */
			$_obj = [];
			$_obj['def'] = 'papers';
			$_obj['name'] = $paper_id;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "papers", "puzzled":true}'));
			LGen('SaviorMan')->delete_pack($_obj);

			return 1;
		}

		public function update_paper_detail($obj) {
			$cit_id = $obj['val']['cit_id'];
			$paper_id = $obj['val']['paper_id'];

			/* update papers */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val'] = $obj['val'];
			$_obj['def'] = 'papers';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "papers", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$paper_id.'", "puzzled":false}'));
			LGen('SaviorMan')->update($_obj);
		}

		public function get_paper_detail($obj) {
			$paper_id = $obj['val']['paper_id'];

			/* get papers */
			$_obj = [];
			$_obj['namelist'] = ['id','title','subtitle','content'];
			$_obj['def'] = 'papers';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "papers", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$paper_id.'", "puzzled":false}'));
			$_paper = LGen('SaviorMan')->read($_obj);
			return $_paper;
		}

		public function get_papers($obj) {
			$cit_id = $obj['val']['cit_id'];
			$tags = [];

			/* get citizens/tags */
			$_obj = [];
			$_obj['namelist'] = ['id','name','desc'];
			$_obj['def'] = 'citizens/tags';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "tags", "puzzled":true}'));
			$_tags = LGen('SaviorMan')->get_all($_obj);
			for ($i=0; $i <sizeof($_tags); $i++) {
				$tags[$_tags[$i]['id']] = $_tags[$i];
			}

			/* get cits/papers */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'citizens/papers';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "papers", "puzzled":true}'));
			$papers = LGen('SaviorMan')->get_all($_obj);


			for ($i=0; $i <sizeof($papers); $i++) { 
				/* get papers */
				$_obj = [];
				$_obj['val'] = [];
				$_obj['namelist'] = ['id','title','subtitle','type','created_date'];
				$_obj['def'] = 'papers';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "papers", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$papers[$i]['id'].'", "puzzled":false}'));
				$papers[$i] = LGen('SaviorMan')->read($_obj);
				$papers[$i]['tags'] = [];

				/* get papers/tags */
				$_obj = [];
				$_obj['val'] = [];
				$_obj['namelist'] = ['id'];
				$_obj['def'] = 'papers/tags';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "papers", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$papers[$i]['id'].'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "tags", "puzzled":true}'));
				$_tags = LGen('SaviorMan')->get_all($_obj);

				for ($j=0; $j <sizeof($_tags); $j++) { 
					array_push($papers[$i]['tags'], $tags[$_tags[$j]['id']]);
				}
			}

			return $papers;
		}
	}