<?php
	
	$square = new SquareGen();
	define('MAX_TOT_MSGS', 10);
	define('MAX_TOT_POSTS', 10);

	class SquareGen {
		public function __construct() {
			set_time_limit ( 0 );
		}

		public function delete_chat_msg($obj) {
			$chat_id = $obj['val']['chat_id'];
			$msg_id = $obj['val']['msg_id'];

			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['is_deleted'] = 1;
			$_obj['def'] = 'chats/msgs';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "msgs", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$msg_id.'", "puzzled":false}'));
			$_msg = LGen('SaviorMan')->update($_obj);
			return $_msg;
		}

		public function add_post($obj) {
			$text = $obj['val']['text'];
			$cit_id = $obj['val']['cit_id'];

			/* add new posts */
			$_obj = [];
			$_obj['val'] = $obj['val'];
			$_obj['def'] = 'posts';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
			$_post_id = LGen('SaviorMan')->insert($_obj);

			/* add post to citizens/posts */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $_post_id;
			$_obj['def'] = 'citizens/posts';
			$_obj['name'] = $_post_id;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
			$_cit_post = LGen('SaviorMan')->insert($_obj);

			return 1;
		}

		public function add_chat_msg($obj) {
			$chat_id = $obj['val']['chat_id'];
			$cit_id = $obj['val']['cit_id'];
			$username = $obj['val']['username'];
			$text = $obj['val']['text'];

			/* Insert new chat */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['cit_id'] = $cit_id;
			$_obj['val']['text'] = $text;
			$_obj['def'] = 'chats/msgs';
			$_obj['note'] = 'return full';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "msgs", "puzzled":true}'));
			$_msg = LGen('SaviorMan')->insert($_obj);

			/* Change last msg in chat */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['last_msg'] = '@'.$username.': '.$text;
			$_obj['val']['last_msg_date'] = $_msg['created_date'];
			// $_obj['val']['last_msg_date'] = $_msg['created_date'];
			$_obj['def'] = 'chats';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			LGen('SaviorMan')->update($_obj);

			/* get chat type */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['namelist'] = ['type'];
			// $_obj['val']['last_msg_date'] = $_msg['created_date'];
			$_obj['def'] = 'chats';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			$_chat = LGen('SaviorMan')->read($_obj);

			if ($_chat['type'] === 'personal') {
				$_obj = [];
				$_obj['namelist'] = ['id'];
				$_obj['def'] = 'chats/members';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
				$_mbrs = LGen('SaviorMan')->get_all($_obj);
				foreach ($_mbrs as $m_key => $m_val) {
					/* get chat status in cit */
					// $_obj = [];
					// $_obj['namelist'] = ['id'];
					// $_obj['def'] = 'citizens/chats';
					// $_obj['bridge'] = [];
					// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
					// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
					// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
					// $_mbrs = LGen('SaviorMan')->get_all($_obj);

					$_obj = [];
					$_obj['val'] = [];
					$_obj['val']['need_check_last_msg'] = 1;
					$_obj['def'] = 'citizens/chats';
					$_obj['bridge'] = [];
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$m_val['id'].'", "puzzled":false}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
					LGen('SaviorMan')->update($_obj);
				}
			}

			else if ($_chat['type'] === 'group') {
				$_obj = [];
				$_obj['namelist'] = ['id'];
				$_obj['def'] = 'chats/members';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
				$_mbr = LGen('SaviorMan')->get_all($_obj)[0];

				$_obj = [];
				$_obj['namelist'] = ['id'];
				$_obj['def'] = 'groups/members';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$_mbr['id'].'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
				$_mbrs = LGen('SaviorMan')->get_all($_obj);
				foreach ($_mbrs as $m_key => $m_val) {
					$_obj = [];
					$_obj['val'] = [];
					$_obj['val']['need_check_last_msg'] = 1;
					$_obj['def'] = 'citizens/chats';
					$_obj['bridge'] = [];
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$m_val['id'].'", "puzzled":false}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
					LGen('SaviorMan')->update($_obj);
				}
			}
			return $_msg;
		}

		public function get_new_msg($obj) {
			$chat_id = $obj['val']['chat_id'];
			$n_msgs = $obj['val']['n_msgs'];

			$_obj = [];
			$_obj['namelist'] = ['id', 'created_date'];
			$_obj['def'] = 'chats/msgs';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "msgs", "puzzled":true}'));
			$_chats = LGen('SaviorMan')->get_all($_obj);
			$_chats = LGen('ArrJsonMan')->sort($_chats, 'created_date', false);
			$n_msgs2 = sizeof($_chats);

			$new_msgs = [];
			if (sizeof($_chats) > (int)$n_msgs) {
				$n_new_msgs = sizeof($_chats) - (int)$n_msgs;
				for ($i=(int)$n_msgs; $i<sizeof($_chats); $i++) {
					array_push($new_msgs, $_chats[$i]);
				}
			}

			foreach ($new_msgs as $nm_key => $nm_val) {
				$_obj = [];
				$_obj['namelist'] = ['id','img','text','cit_id','is_deleted','created_date'];
				$_obj['def'] = 'chats/msgs';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "msgs", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$nm_val['id'].'", "puzzled":false}'));
				$new_msg = LGen('SaviorMan')->read($_obj);
				$new_msgs[$nm_key] = [];
				$new_msgs[$nm_key]['msg_id'] = $new_msg['id'];
				$new_msgs[$nm_key]['text'] = $new_msg['text'];
				$new_msgs[$nm_key]['cit_id'] = $new_msg['cit_id'];
				$new_msgs[$nm_key]['is_deleted'] = $new_msg['is_deleted'];
				$new_msgs[$nm_key]['date'] = $new_msg['created_date'];

				$_obj = [];
				$_obj['namelist'] = ['img', 'username','fullname'];
				$_obj['def'] = 'citizens';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$new_msg['cit_id'].'", "puzzled":false}'));
				$data = [];
				$data['o'] = $_obj;
				$data['f'] = "LGen('SaviorMan')->read";
				$cit = LGen('ReqMan')->send_get($data, 'be.citizen.lanterlite.com');	
				$new_msgs[$nm_key]['cit_img'] = $cit['img'];
				$new_msgs[$nm_key]['username'] = $cit['username'];
				$new_msgs[$nm_key]['fullname'] = $cit['fullname'];			
			}
					// $qwe['msg_id'] = $m_val['id'];
					// $qwe['text'] = $m_val['text'];
					// $qwe['date'] = $m_val['created_date'];
					// $qwe['img'] = $m_val['img'];
					// $qwe['cit_id'] = $m_val['cit_id'];
					// $qwe['is_deleted'] = $m_val['is_deleted'];
					// $qwe['fullname'] = $cits[$m_val['cit_id']]['fullname'];
					// $qwe['username'] = $cits[$m_val['cit_id']]['username'];
			$res = [];
			$res['data'] = $new_msgs;
			$res['n_msgs'] = $n_msgs2;
			return $res;
		}

		public function get_chatroom($obj) {
			$chat_id = $obj['val']['chat_id'];

			$chats = [];
			$chats['data'] = [];
			$cits = [];

			/* get type of chat */
			$_obj = [];
			$_obj['namelist'] = ['type'];
			$_obj['def'] = 'chats';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			$_chat =  LGen('SaviorMan')->read($_obj);

			/* get cit_ids from chat */
			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'chats/members';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
			$_mbrs = LGen('SaviorMan')->get_all($_obj);

			if ($_chat['type'] === 'group') {
				$_obj = [];
				$_obj['namelist'] = ['id'];
				$_obj['def'] = 'groups/members';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$_mbrs[0]['id'].'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
				$_mbrs = LGen('SaviorMan')->get_all($_obj);
			}

			/* get citizen mbr */
			foreach ($_mbrs as $mbr_key => $mbr_val) {
				$_obj = [];
				$_obj['namelist'] = ['img', 'username','fullname'];
				$_obj['def'] = 'citizens';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$mbr_val['id'].'", "puzzled":false}'));
				$data = [];
				$data['o'] = $_obj;
				$data['f'] = "LGen('SaviorMan')->read";
				$cits[$mbr_val['id']] = LGen('ReqMan')->send_get($data, 'be.citizen.lanterlite.com');
			}

			/* get chat msgs */
			$_obj = [];
			$_obj['namelist'] = ['id','text','img','created_date','cit_id','is_deleted'];
			$_obj['def'] = 'chats/msgs';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "msgs", "puzzled":true}'));
			$_msgs = LGen('SaviorMan')->get_all($_obj);
			$_msgs = LGen('ArrJsonMan')->sort($_msgs, 'created_date', false);

			/* combine chat msgs with cit info */
			$start_from = 0;
			$chats['n_msgs'] = sizeof($_msgs);
			$chats['older_msgs'] = '';
			if (sizeof($_msgs) > MAX_TOT_MSGS) {
				$start_from = sizeof($_msgs)-MAX_TOT_MSGS;
				if (sizeof($_msgs)-(MAX_TOT_MSGS*2) >= 0)
					$read_from = sizeof($_msgs)-(MAX_TOT_MSGS*2);
				else
					$read_from = 0;
				$chats['older_msgs'] = $read_from.'-'.(string)(sizeof($_msgs)-MAX_TOT_MSGS);
			}
			// return $_msgs;
			for ($i=$start_from; $i<sizeof($_msgs); $i++) {
				$qwe = [];
				$qwe['msg_id'] = $_msgs[$i]['id'];
				$qwe['text'] = $_msgs[$i]['text'];
				$qwe['date'] = $_msgs[$i]['created_date'];
				$qwe['img'] = $_msgs[$i]['img'];
				$qwe['cit_id'] = $_msgs[$i]['cit_id'];
				$qwe['is_deleted'] = $_msgs[$i]['is_deleted'];
				$qwe['cit_img'] = (LGen('JsonMan')->is_key_exist($cits, $_msgs[$i]['cit_id']) ? $cits[$_msgs[$i]['cit_id']]['img'] : '');
				$qwe['fullname'] = (LGen('JsonMan')->is_key_exist($cits, $_msgs[$i]['cit_id']) ? $cits[$_msgs[$i]['cit_id']]['fullname'] : '-');
				$qwe['username'] = (LGen('JsonMan')->is_key_exist($cits, $_msgs[$i]['cit_id']) ? $cits[$_msgs[$i]['cit_id']]['username'] : '-');
				array_push($chats['data'], $qwe);
			}

			return $chats;
		}

		public function get_older_msgs($obj) {
			$cit_id = $obj['val']['cit_id'];
			$chat_id = $obj['val']['chat_id'];
			$older_msgs = $obj['val']['older_msgs'];
			$arr = explode("-", $older_msgs);
			$from = $arr[0];
			$until = $arr[1];
			$msgs = [];

			/* get type of chat */
			$_obj = [];
			$_obj['namelist'] = ['type'];
			$_obj['def'] = 'chats';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			$_chat =  LGen('SaviorMan')->read($_obj);

			/* get cit_ids from chat */
			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'chats/members';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
			$_mbrs = LGen('SaviorMan')->get_all($_obj);

			if ($_chat['type'] === 'group') {
				$_obj = [];
				$_obj['namelist'] = ['id'];
				$_obj['def'] = 'groups/members';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$_mbrs[0]['id'].'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
				$_mbrs = LGen('SaviorMan')->get_all($_obj);
			}

			/* get citizen mbr */
			foreach ($_mbrs as $mbr_key => $mbr_val) {
				$_obj = [];
				$_obj['namelist'] = ['img', 'username','fullname'];
				$_obj['def'] = 'citizens';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$mbr_val['id'].'", "puzzled":false}'));
				$data = [];
				$data['o'] = $_obj;
				$data['f'] = "LGen('SaviorMan')->read";
				$cits[$mbr_val['id']] = LGen('ReqMan')->send_get($data, 'be.citizen.lanterlite.com');
			}

			/* get chat msgs */
			$_obj = [];
			$_obj['namelist'] = ['id','text','img','created_date','cit_id','is_deleted'];
			$_obj['def'] = 'chats/msgs';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "msgs", "puzzled":true}'));
			$_msgs = LGen('SaviorMan')->get_all($_obj);
			$_msgs = LGen('ArrJsonMan')->sort($_msgs, 'created_date', false);

			$chats = [];
			$chats['data'] = [];
			$chats['n_msgs'] = sizeof($_msgs);
			$chats['older_msgs'] = '';
			if ($from > 0) {
				$read_until = $from;
				$read_from = $from-MAX_TOT_MSGS;
				if ($read_from < 0)
					$read_from = 0;
				$chats['older_msgs'] = $read_from.'-'.$read_until;
			}
			for ($i=$from; $i<$until; $i++) {
				$qwe = [];
				$qwe['msg_id'] = $_msgs[$i]['id'];
				$qwe['text'] = $_msgs[$i]['text'];
				$qwe['date'] = $_msgs[$i]['created_date'];
				$qwe['img'] = $_msgs[$i]['img'];
				$qwe['cit_id'] = $_msgs[$i]['cit_id'];
				$qwe['cit_img'] = $cits[$_msgs[$i]['cit_id']]['img'];
				$qwe['is_deleted'] = $_msgs[$i]['is_deleted'];
				$qwe['fullname'] = $cits[$_msgs[$i]['cit_id']]['fullname'];
				$qwe['username'] = $cits[$_msgs[$i]['cit_id']]['username'];
				array_push($chats['data'], $qwe);
			}



			// for ($i=$from; $i<$until; $i++) {
			// 	array_push($msgs, $_msgs[$i]);
			// }

			return $chats;

		}

		public function get_new_last_msg($obj) {
			$cit_id = $obj['val']['cit_id'];

			$chats = [];

			$_obj = [];
			$_obj['namelist'] = ['id', 'need_check_last_msg'];
			$_obj['def'] = 'citizens/chats';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			$cits_chat = LGen('SaviorMan')->get_all($_obj);
			foreach ($cits_chat as $ci_key => $ci_val) {
				if ($ci_val['need_check_last_msg']) {
					/* get chat type */
					$_obj = [];
					$_obj['namelist'] = ['id', 'last_msg'];
					$_obj['def'] = 'chats';
					$_obj['bridge'] = [];
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$ci_val['id'].'", "puzzled":false}'));
					$_chat = LGen('SaviorMan')->read($_obj);
					array_push($chats, $_chat);

					$_obj = [];
					$_obj['val'] = [];
					$_obj['val']['need_check_last_msg'] = 0;
					$_obj['def'] = 'citizens/chats';
					$_obj['bridge'] = [];
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$ci_val['id'].'", "puzzled":false}'));
					LGen('SaviorMan')->update($_obj);
				}
			}
			return $chats;
		}

		// public function get_posts_cont($obj) {
		// 	$cit_id = $obj['val']['cit_id'];
		// 	$n_post = $obj['val']['n_post'];

		// 	/* get cit follows */
		// 	$_obj = [];
		// 	$_obj['namelist'] = ['id'];
		// 	$_obj['def'] = 'citizens';
		// 	$_obj['bridge'] = [];
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "follows", "puzzled":true}'));
		// 	$_cit_follows =  LGen('SaviorMan')->get_all($_obj);

		// 	/* add current cit id */
		// 	$_obj = [];
		// 	$_obj['id'] = $cit_id;
		// 	array_push($_cit_follows, $_obj);

		// 	$res = [];
		// 	$res['data'] = $posts;
		// 	$res['n_post'] = sizeof($posts);
		// 	return $res;

		// }

		public function check_like($obj) {
		}

		public function delete_post($obj) {
			$cit_id = $obj['val']['cit_id'];
			$post_id = $obj['val']['post_id'];

			/* get cits in posts/likes */
			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'posts/likes';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$post_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "likes", "puzzled":true}'));
			$cit = LGen('SaviorMan')->get_all($_obj);

			for ($i=0; $i<sizeof($cit) ; $i++) { 
				/* del post_id in cits/likes */
				$_obj = [];
				$_obj['name'] = $post_id;
				$_obj['def'] = 'citizens/likes';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit[$i]['id'].'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "likes", "puzzled":true}'));
				LGen('SaviorMan')->delete_pack($_obj);
			}

			/* del post_id in cits/posts */
			$_obj = [];
			$_obj['name'] = $post_id;
			$_obj['def'] = 'citizens/posts';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
			LGen('SaviorMan')->delete_pack($_obj);

			/* del post_id in posts */
			$_obj = [];
			$_obj['name'] = $post_id;
			$_obj['def'] = 'posts';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
			LGen('SaviorMan')->delete_pack($_obj);

			return 1;
		}

		public function like_post($obj) {
			$cit_id = $obj['val']['cit_id'];
			$post_id = $obj['val']['post_id'];

			/* get like in posts/likes */
			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'posts/likes';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$post_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "likes", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			$cit = LGen('SaviorMan')->read($_obj);
			/* if cit already like the post */
			if (sizeof($cit) > 0) {

				/* del like in posts/likes */
				$_obj = [];
				$_obj['def'] = 'posts/likes';
				$_obj['name'] = $cit_id;
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$post_id.'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "likes", "puzzled":true}'));
				LGen('SaviorMan')->delete_pack($_obj);

				/* del like in citizens/likes */
				$_obj = [];
				$_obj['val'] = [];
				$_obj['val']['id'] = $post_id;
				$_obj['def'] = 'citizens/likes';
				$_obj['name'] = $post_id;
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "likes", "puzzled":true}'));
				LGen('SaviorMan')->delete_pack($_obj);

				/* get n likes in post */
				$_obj = [];
				$_obj['namelist'] = ['id'];
				$_obj['def'] = 'posts/likes';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$post_id.'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "likes", "puzzled":true}'));
				$likes = LGen('SaviorMan')->get_all($_obj);

				$res = [];
				$res['n_likes'] = sizeof($likes);
				$res['has_like'] = false;
				return $res;
			}

			/* add like in posts/likes */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['cit_id'] = $cit_id;
			$_obj['def'] = 'posts/likes';
			$_obj['name'] = $cit_id;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$post_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "likes", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);

			/* add like in citizens/likes */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $post_id;
			$_obj['def'] = 'citizens/likes';
			$_obj['name'] = $post_id;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "likes", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);

			/* get n likes in post */
			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'posts/likes';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$post_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "likes", "puzzled":true}'));
			$likes = LGen('SaviorMan')->get_all($_obj);

			$res = [];
			$res['n_likes'] = sizeof($likes);
			$res['has_like'] = true;
			return $res;
		}

		public function get_posts($obj) {
			$cit_id = $obj['val']['cit_id'];
			$n_post = $obj['val']['n_post'];
			$res = [];

			/* get cit follows */
			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'citizens/follows';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "follows", "puzzled":true}'));
			$_cit_follows =  LGen('SaviorMan')->get_all($_obj);

			/* add current cit id */
			$_obj = [];
			$_obj['id'] = $cit_id;
			array_push($_cit_follows, $_obj);

			$cits = [];
			$posts = [];
			for ($i=0; $i<sizeof($_cit_follows); $i++) { 
				/* get cit post id  */
				$_obj = [];
				$_obj['namelist'] = ['id'];
				$_obj['def'] = 'citizens/posts';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$_cit_follows[$i]['id'].'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
				$_posts = LGen('SaviorMan')->get_all($_obj);
				for ($j=0; $j<sizeof($_posts); $j++) { 
					/* get post detail  */
					$_obj = [];
					$_obj['namelist'] = ['id', 'cit_id', 'text', 'created_date'];
					$_obj['def'] = 'posts';
					$_obj['bridge'] = [];
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$_posts[$j]['id'].'", "puzzled":false}'));
					array_push($posts, LGen('SaviorMan')->read($_obj));
				}
			}

			$posts = LGen('ArrJsonMan')->sort($posts, 'created_date', false);

			$posts2 = [];
			$n_post2 = sizeof($posts);

			$start_from = 0;

			if ($obj['status'] === 'init') {
				$older_posts = '';
				$from = 0;
				if ($n_post2 > MAX_TOT_POSTS) {
					$from = $n_post2 - MAX_TOT_POSTS;
					if ($n_post2-(MAX_TOT_POSTS*2) >= 0)
						$read_from = $n_post2-(MAX_TOT_POSTS*2);
					else
						$read_from = 0;
					$older_posts = $read_from.'-'.(string)($n_post2-MAX_TOT_POSTS);
				}
				for ($i=$from; $i<$n_post2; $i++)
					array_push($posts2, $posts[$i]);
				$res['older_posts'] = $older_posts;
			}
			else if ($obj['status'] === 'get_older_posts') {
				$older_posts = $obj['val']['older_posts'];
				$arr = explode("-", $older_posts);
				$from = $arr[0];
				$until = $arr[1];

				$older_posts = '';
				if ($from > 0) {
					$read_until = $from;
					$read_from = $from-MAX_TOT_POSTS;
					if ($read_from < 0)
						$read_from = 0;
					$older_posts = $read_from.'-'.$read_until;
				}

				for ($i=$from; $i<$until; $i++)
					array_push($posts2, $posts[$i]);
				$res['older_posts'] = $older_posts;
				$posts2 = LGen('ArrJsonMan')->sort($posts2, 'created_date', true);
			}
			else if ($obj['status'] === 'get_posts_cont') {
				$from = $n_post;
				if ($n_post2 !== $n_post) {
					for ($i=$from; $i<$n_post2; $i++)
						array_push($posts2, $posts[$i]);
				}
			}

			$posts = $posts2; 

			for ($i=0; $i<sizeof($_cit_follows); $i++) { 
				/* get list of cits detail */
				$_obj = [];
				$_obj['namelist'] = ['img', 'username', 'fullname'];
				$_obj['def'] = 'citizens';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$_cit_follows[$i]['id'].'", "puzzled":false}'));
				$data = [];
				$data['o'] = $_obj;
				$data['f'] = "LGen('SaviorMan')->read";
				$cits[$_cit_follows[$i]['id']] = LGen('ReqMan')->send_get($data, 'be.citizen.lanterlite.com');

				$_obj = [];
				$_obj['namelist'] = ['badge'];
				$_obj['def'] = 'citizens';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$_cit_follows[$i]['id'].'", "puzzled":false}'));
				$cits[$_cit_follows[$i]['id']]['badge'] = LGen('SaviorMan')->read($_obj)['badge'];
			}

			for ($i=0; $i<sizeof($posts); $i++) {
				$posts[$i]['cit_img'] = $cits[$posts[$i]['cit_id']]['img'];
				$posts[$i]['cit_username'] = $cits[$posts[$i]['cit_id']]['username'];
				$posts[$i]['cit_fullname'] = $cits[$posts[$i]['cit_id']]['fullname'];
				$posts[$i]['badge'] = $cits[$posts[$i]['cit_id']]['badge'];
				// $posts[$i]['type'] = 'Citizen';

				/* get n likes in post */
				$_obj = [];
				$_obj['namelist'] = ['id'];
				$_obj['def'] = 'posts/likes';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$posts[$i]['id'].'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "likes", "puzzled":true}'));
				$_likes = LGen('SaviorMan')->get_all($_obj);
				$posts[$i]['n_likes'] = sizeof($_likes);

				/* get like in posts/likes */
				$_obj = [];
				$_obj['namelist'] = ['id'];
				$_obj['def'] = 'posts/likes';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "posts", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$posts[$i]['id'].'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "likes", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
				$_cit = LGen('SaviorMan')->read($_obj);

				/* if cit already like the post */
				if (sizeof($_cit) > 0)
					$posts[$i]['has_like'] = true;
				else
					$posts[$i]['has_like'] = false;
			}

			$res['data'] = $posts;
			$res['n_post'] = $n_post2;
			return $res;
		}

		public function get_chats($obj) {
			$cit_id = $obj['val']['cit_id'];
			$cits = [];
			$grps = [];

			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'citizens/chats';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			$chat_ids =  LGen('SaviorMan')->get_all($_obj);
			foreach ($chat_ids as $ci_key => $ci_val) {

				/* get chat type */
				$_obj = [];
				$_obj['namelist'] = ['type', 'last_msg', 'last_msg_date'];
				$_obj['def'] = 'chats';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$ci_val['id'].'", "puzzled":false}'));
				$_chat = LGen('SaviorMan')->read($_obj);

				if ($_chat['type'] === 'personal') {
					$_obj = [];
					$_obj['namelist'] = ['id'];
					$_obj['def'] = 'chats/members';
					$_obj['bridge'] = [];
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$ci_val['id'].'", "puzzled":false}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
					$_mbrs = LGen('SaviorMan')->get_all($_obj);

					if ($_mbrs[0]['id'] !== $cit_id)
						$_mbr = $_mbrs[0];
					else
						$_mbr = $_mbrs[1];
					$_mbr['chat_id'] = $ci_val['id'];
					$_mbr['last_msg'] = $_chat["last_msg"];
					$_mbr['last_msg_date'] = $_chat["last_msg_date"];
					$_mbr['num_unreaded_msg'] = 0;
					array_push($cits, $_mbr);
				}
				else if ($_chat['type'] === 'group') {
					$_obj = [];
					// $_obj['namelist'] = ['id','img','fullname','username'];
					$_obj['namelist'] = ['id'];
					$_obj['def'] = 'chats/members';
					$_obj['bridge'] = [];
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$ci_val['id'].'", "puzzled":false}'));
					array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
					$_grp = LGen('SaviorMan')->get_all($_obj)[0];

					$_grp['chat_id'] = $ci_val['id'];
					$_grp['last_msg'] = $_chat["last_msg"];
					$_grp['last_msg_date'] = $_chat["last_msg_date"];
					$_grp['num_unreaded_msg'] = 0;
					array_push($grps, $_grp);
				}
			}

			foreach ($cits as $key => $value) {
				/* get cit img and fullname */
				$_obj = [];
				$_obj['namelist'] = ['img', 'username', 'fullname'];
				$_obj['def'] = 'citizens';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$value['id'].'", "puzzled":false}'));
				$data = [];
				$data['o'] = $_obj;
				$data['f'] = "LGen('SaviorMan')->read";
				$res = LGen('ReqMan')->send_get($data, 'be.citizen.lanterlite.com');

				$cits[$key]['img'] = $res['img'];
				$cits[$key]['username'] = $res['username'];
				$cits[$key]['name'] = $res['fullname'];
				$cits[$key]['type'] = 'Citizen';
				// $cits[$key]['cit_type'] = '';
			}
			// return $cits;

			foreach ($grps as $key => $value) {
				$_obj = [];
				$_obj['namelist'] = ['img', 'username', 'fullname'];
				$_obj['def'] = 'groups';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$value['id'].'", "puzzled":false}'));
				$res = LGen('SaviorMan')->read($_obj);


				$grps[$key]['img'] = $res['img'];
				$grps[$key]['username'] = $res['username'];
				$grps[$key]['name'] = $res['fullname'];

				/* get cit type in guild/members */
				// $_obj = [];
				// $_obj['namelist'] = ['type'];
				// $_obj['def'] = 'groups/members';
				// $_obj['bridge'] = [];
				// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
				// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$value['id'].'", "puzzled":false}'));
				// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
				// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
				// $_mbr = LGen('SaviorMan')->read($_obj);
				// $grps[$key]['cit_type'] = $_mbr['type'];
				$grps[$key]['type'] = 'Group';
			}

			$chats = [];
			foreach ($cits as $key => $value) {
				array_push($chats, $value);
			}
			foreach ($grps as $key => $value) {
				array_push($chats, $value);
			}

			$chats = LGen('ArrJsonMan')->sort($chats, 'last_msg_date', true);

			return $chats;

			// $res = $cits;
			// return $cits;
			// $_obj = [];
			// $_obj['namelist'] = ['cit_id'];
			// $_obj['def'] = 'citizens/follows';
			// $_obj['bridge'] = [];
			// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "follows", "puzzled":true}'));
			// $cits = LGen('SaviorMan')->get_all($_obj);
			// // return $cits;
			// foreach ($cits as $key => $value) {
			// 	$_obj = [];
			// 	$_obj['namelist'] = ['img', 'fullname'];
			// 	$_obj['def'] = 'citizens';
			// 	$_obj['bridge'] = [];
			// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$value['cit_id'].'", "puzzled":false}'));
			// 	$data = [];
			// 	$data['o'] = $_obj;
			// 	$data['f'] = "LGen('SaviorMan')->read";
			// 	$res = LGen('ReqMan')->send_get($data, 'be.citizen.lanterlite.com');
			// 	// $cits = LGen('SaviorMan')->get_all($_obj);
			// 	// return $res;
			// 	if (LGen('JsonMan')->is_key_exist($res, 'img'))
			// 		$cits[$key]['img'] = $res['img'];
			// 	if (LGen('JsonMan')->is_key_exist($res, 'fullname'))
			// 		$cits[$key]['name'] = $res['fullname'];
			// 	else
			// 		$cits[$key]['name'] = '0';
			// 	$cits[$key]['last_msg'] = '0';
			// 	$cits[$key]['num_unreaded_msg'] = 0;
			// }
			// return $cits;
		}

		// public function get_chats($obj) {
		// 	$cit_id = $obj['val']['cit_id'];
		// 	$_obj = [];
		// 	$_obj['namelist'] = ['chat_id'];
		// 	$_obj['def'] = ['citizens/chats'];
		// 	$_obj['bridge'] = [];
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
		// 	return LGen('SaviorMan')->get_all($_obj);
		// }

		/* fixed */
		public function search_cit_grp($obj) {
			$name = LGen('StringMan')->clean(strtolower($obj['user_keyword']));
			$cit_id = ($obj['id']);
			$cit_grps = [];

			/* get all grps fullname and username */
			$_obj['namelist'] = ['id', 'img', 'badge', 'username','fullname'];
			$_obj['def'] = 'groups';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
			$grps = LGen('SaviorMan')->get_all($_obj);
			for ($i=0; $i<sizeof($grps); $i++) {
				$grps[$i]['type'] = 'Group';
				/* check grp fullname and username */
				if (LGen('StringMan')->is_val_exist(strtolower($grps[$i]['username']), $name) || LGen('StringMan')->is_val_exist(strtolower($grps[$i]['fullname']), $name))
					array_push($cit_grps, $grps[$i]);
			}

			/* get all cits fullname and username */
			$_obj['namelist'] = ['id','badge'];
			$_obj['def'] = 'citizens';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			$cits = LGen('SaviorMan')->get_all($_obj);

			for ($i=0; $i<sizeof($cits); $i++) {
				$_obj = [];
				$_obj['namelist'] = ['id', 'img', 'badge', 'username','fullname'];
				$_obj['def'] = 'citizens';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cits[$i]['id'].'", "puzzled":false}'));
				$data = [];
				$data['o'] = $_obj;
				$data['f'] = "LGen('SaviorMan')->read";
				$cit = LGen('ReqMan')->send_get($data, 'be.citizen.lanterlite.com');
				$cit['type'] = 'Citizen';
				$cit['badge'] = $cits[$i]['badge'];
				if ($cit['id'] === $cit_id)
					continue;
				/* check cit fullname and username */
				if (LGen('StringMan')->is_val_exist(strtolower($cit['username']), $name) || LGen('StringMan')->is_val_exist(strtolower($cit['fullname']), $name))
					array_push($cit_grps, $cit);
			}
			return $cit_grps;
		}

		/* fixed */
		public function unjoin($obj) {
			$cit_id = $obj['cit_id'];
			$grp_id = $obj['grp_id'];

			/* del cit_id in groups/members */
			$_obj = [];
			$_obj['name'] = $cit_id;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$grp_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
			LGen('SaviorMan')->delete_pack($_obj);

			/* del grp_id from citizens/groups */
			$_obj = [];
			$_obj['name'] = $grp_id;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
			LGen('SaviorMan')->delete_pack($_obj);

			/* get chat_id from group */
			$_obj = [];
			$_obj['namelist'] = ['chat_id'];
			$_obj['def'] = 'groups';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$grp_id.'", "puzzled":false}'));
			$_grp = LGen('SaviorMan')->read($_obj);
			$chat_id = $_grp['chat_id'];

			/* del grp chat_id from citizens */
			$_obj = [];
			$_obj['name'] = $chat_id;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			LGen('SaviorMan')->delete_pack($_obj);

			return 1;
		}

		/* fixed */
		public function join($obj) {
			$cit_id = $obj['cit_id'];
			$grp_id = $obj['grp_id'];

			/* get cit_id in groups/members */
			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'groups/members';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$grp_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			$_cit = LGen('SaviorMan')->read($_obj);
			// return $_cit;
			/* if already joined then unjoin */
			if (LGen('JsonMan')->is_key_exist($_cit, 'id'))
				return $this->unjoin($obj);

			/* set group in citizens/groups */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $grp_id;
			$_obj['def'] = 'citizens/groups';
			$_obj['name'] = $grp_id;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);

			/* set cit_id in groups/members */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $cit_id;
			$_obj['def'] = 'groups/members';
			$_obj['name'] = $cit_id;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$grp_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);

			/* get group chat_id */
			$_obj = [];
			$_obj['def'] = 'groups';
			$_obj['namelist'] = ['chat_id'];
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$grp_id.'", "puzzled":false}'));
			$_grp = LGen('SaviorMan')->read($_obj);
			$chat_id = $_grp['chat_id'];

			/* set chat_id to citizens/chats */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $chat_id;
			$_obj['def'] = 'citizens/chats';
			$_obj['name'] = $chat_id;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			$cits = LGen('SaviorMan')->insert($_obj);
		}

		/* fixed */
		public function unfollow($obj) {
			$cit_id1 = $obj['cit_id1'];
			$cit_id2 = $obj['cit_id2'];
			$chat_id = $this->get_chat_id_by_two_cit_ids($cit_id1, $cit_id2);

			/* del chat id in cit1 citizens/chats */
			$_obj = [];
			$_obj['def'] = 'citizens/chats';
			$_obj['name'] = $chat_id;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id1.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			$cits = LGen('SaviorMan')->delete_pack($_obj);

			/* del chat id in cit2 citizens/chats */
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			$cits = LGen('SaviorMan')->delete_pack($_obj);

			/* del follows in cit 1 */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $cit_id2;
			$_obj['def'] = 'citizens/follows';
			$_obj['name'] = $cit_id2;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id1.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "follows", "puzzled":true}'));
			$cits = LGen('SaviorMan')->delete_pack($_obj);

			/* del followers in cit 2 */
			$_obj = [];
			$_obj['def'] = 'citizens/followers';
			$_obj['name'] = $cit_id1;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "followers", "puzzled":true}'));
			$cits = LGen('SaviorMan')->delete_pack($_obj);

			return 1;
		}

		/* fixed */
		public function follow($obj) {
			$cit_id1 = $obj['cit_id1'];
			$cit_id2 = $obj['cit_id2'];
			$chat_id = $this->get_chat_id_by_two_cit_ids($cit_id1, $cit_id2);

			/* get cit_id in groups/members */
			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'citizens/follows';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id1.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "follows", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
			$_cit = LGen('SaviorMan')->read($_obj);

			/* if already follow then unfollow */
			if (LGen('JsonMan')->is_key_exist($_cit, 'id'))
				return $this->unfollow($obj);

			/* set follows in cit 1 */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $cit_id2;
			$_obj['def'] = 'citizens/follows';
			$_obj['name'] = $cit_id2;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id1.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "follows", "puzzled":true}'));
			$cits = LGen('SaviorMan')->insert($_obj);

			/* set followers in cit 2 */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $cit_id1;
			$_obj['def'] = 'citizens/followers';
			$_obj['name'] = $cit_id1;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "followers", "puzzled":true}'));
			$cits = LGen('SaviorMan')->insert($_obj);

			/* set chat id */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['type'] = 'personal';
			$_obj['def'] = 'chats';
			$_obj['name'] = $chat_id;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			$chat_id = LGen('SaviorMan')->insert($_obj);

			/* set chat id to each citizens/chats */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $chat_id;
			$_obj['def'] = 'citizens/chats';
			$_obj['name'] = $chat_id;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id1.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			$cits = LGen('SaviorMan')->insert($_obj);

			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			$cits = LGen('SaviorMan')->insert($_obj);

			/* set both cits to chats/members */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $cit_id1;
			$_obj['name'] = $cit_id1;
			$_obj['def'] = 'chats/members';
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
			$cits = LGen('SaviorMan')->insert($_obj);
			$_obj['val']['id'] = $cit_id2;
			$_obj['name'] = $cit_id2;
			$cits = LGen('SaviorMan')->insert($_obj);

			return true;
		}

		public function get_chat_id_by_two_cit_ids($cit_id1, $cit_id2) {
			/* get cit 1 created_date */
			$_obj = [];
			$_obj['namelist'] = ['created_date'];
			$_obj['def'] = 'citizens';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id1.'", "puzzled":false}'));
			$data = [];
			$data['o'] = $_obj;
			$data['f'] = "LGen('SaviorMan')->read";
			$cit1 = LGen('ReqMan')->send_get($data, 'be.citizen.lanterlite.com');	

			/* get cit 2 created_date */
			$_obj = [];
			$_obj['namelist'] = ['created_date'];
			$_obj['def'] = 'citizens';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
			$data = [];
			$data['o'] = $_obj;
			$data['f'] = "LGen('SaviorMan')->read";
			$cit2 = LGen('ReqMan')->send_get($data, 'be.citizen.lanterlite.com');	

			if ($cit1['created_date'] >= $cit2['created_date'])
				$chat_id = $cit_id1.$cit_id2;
			else if ($cit2['created_date'] > $cit1['created_date'])
				$chat_id = $cit_id2.$cit_id1;
			return $chat_id;
		}

		public function get_cit_detail($obj) {
			$cit_id1 = $obj['cit_id1'];
			$cit_id2 = $obj['cit_id2'];

			/* get cit type in guild/members */
			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'citizens';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
			$_cit = LGen('SaviorMan')->read($_obj);

			/* if cit_id2 is citizen */
			if (sizeof($_cit) > 0) {
				/* get cit detail citizens */
				$_obj = [];
				$_obj['namelist'] = ['id', 'img', 'username', 'fullname'];
				$_obj['def'] = 'citizens';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
				$data = [];
				$data['o'] = $_obj;
				$data['f'] = "LGen('SaviorMan')->read";
				$res = LGen('ReqMan')->send_get($data, 'be.citizen.lanterlite.com');	

				/* get cit type in square/citizens */
				$_obj = [];
				$_obj['namelist'] = ['status', 'desc', 'badge'];
				$_obj['def'] = 'citizens';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
				$_mbr = LGen('SaviorMan')->read($_obj);

				$res['status'] = $_mbr['status'];
				$res['desc'] = $_mbr['desc'];
				$res['badge'] = $_mbr['badge'];

				$res['type'] = 'Citizen';
				$res['cit_type'] = '';
			}
			else {
				/* get group detail */
				$_obj = [];
				$_obj['namelist'] = ['id', 'img', 'username', 'fullname', 'status', 'desc', 'badge'];
				$_obj['def'] = 'groups';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
				$res = LGen('SaviorMan')->read($_obj);

				/* get cit type in groups/members */
				$_obj = [];
				$_obj['namelist'] = ['type'];
				$_obj['def'] = 'groups/members';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id1.'", "puzzled":false}'));
				$_mbr = LGen('SaviorMan')->read($_obj);
				$res['type'] = 'Group';
				/* if cit is not group member */
				if (sizeof($_mbr) === 0)
					$res['cit_type'] = '';
				else
					$res['cit_type'] = $_mbr['type'];
			}
			return $res;
		}

		// public function check_follow_stat($obj) {
		// 	$cit_id1 = $obj['cit_id1'];
		// 	$cit_id2 = $obj['cit_id2'];

		// 	$_obj = [];
		// 	$_obj['namelist'] = ['id'];
		// 	$_obj['def'] = 'citizens/follows';
		// 	$_obj['bridge'] = [];
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id1.'", "puzzled":false}'));
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "follows", "puzzled":true}'));
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
		// 	$cits = LGen('SaviorMan')->read($_obj);
		// 	if (sizeof($cits) === 0)
		// 		return false;
		// 	return true;
		// }

		public function check_follow_stat($obj) {
			$cit_id1 = $obj['cit_id1'];
			$cit_id2 = $obj['cit_id2'];

			/* get cit type in guild/members */
			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = 'citizens';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
			$_cit = LGen('SaviorMan')->read($_obj);

			/* if cit_id2 is group */
			if (sizeof($_cit) === 0) {
				$_obj = [];
				$_obj['namelist'] = ['id'];
				$_obj['def'] = 'citizens/groups';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id1.'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
				$cits = LGen('SaviorMan')->read($_obj);
				if (sizeof($cits) === 0)
					return false;
			}
			else {
				$_obj = [];
				$_obj['namelist'] = ['id'];
				$_obj['def'] = 'citizens/follows';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id1.'", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "follows", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id2.'", "puzzled":false}'));
				$cits = LGen('SaviorMan')->read($_obj);
				if (sizeof($cits) === 0)
					return false;
			}
			return true;
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

		public function update_group($obj) {
			$group_id = $obj['val']['group_id'];
			$img = $obj['val']['img'];

			/* upload image */
			$_obj = [];
			$_obj['gate'] = 'groups/'.$group_id;
			$_obj['img'] = $img;

			$final_obj = [];
			$final_obj['json'] = $_obj;
			$final_obj['func'] = '$image->add_image';
			$img = LGen('ReqMan')->send_post($final_obj, 'image.lanterlite.com');

			/* set group img to groups */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['img'] = $img;
			$_obj['def'] = 'groups';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$group_id.'", "puzzled":false}'));
			LGen('SaviorMan')->update($_obj);

			return $img;
		}

		public function add_group($obj) {
			$cit_id = $obj['val']['cit_id'];
			$_obj = [];
			// $_obj['img'] = $obj['img'];
			// $_obj['gate'] = 'square';
			// $final_obj = [];
			// $final_obj['json'] = $obj;
			// $final_obj['func'] = 'LGen("SaviorMan")->read';
			// $obj['img'] = LGen('ReqMan')->send_post($final_obj);
			$group_id = LGen('F')->gen_id();

			/* upload image */
			$_obj = [];
			$_obj['gate'] = 'groups/'.$group_id;
			$_obj['img'] = $obj['val']['img'];

			$final_obj = [];
			$final_obj['json'] = $_obj;
			$final_obj['func'] = '$image->add_image';
			$obj['val']['img'] = LGen('ReqMan')->send_post($final_obj, 'image.lanterlite.com');

			/* create chat id */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['type'] = 'group';
			$_obj['def'] = 'chats';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			$chat_id = LGen('SaviorMan')->insert($_obj);

			/* create group */
			$obj['bridge'] = [];
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id":"groups", "puzzled": true}'));
			$obj['def'] = 'groups';
			$obj['val']['chat_id'] = $chat_id;
			$obj['name'] = $group_id;
			$obj['keep_name'] = true;
			LGen('SaviorMan')->insert($obj);

			/* set group_id to chats/members */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $group_id;
			$_obj['def'] = 'chats/members';
			$_obj['name'] = $group_id;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$chat_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);

			/* set chat id to each citizens/chats */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $chat_id;
			$_obj['def'] = 'citizens/chats';
			$_obj['name'] = $chat_id;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chats", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);

			/* set group_id to each citizens/chats */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $group_id;
			$_obj['def'] = 'citizens/groups';
			$_obj['name'] = $group_id;
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);

			/* set cit to groups/members */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $cit_id;
			$_obj['val']['type'] = 'leader';
			$_obj['name'] = $cit_id;
			$_obj['def'] = 'groups/members';
			$_obj['keep_name'] = true;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "groups", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$group_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "members", "puzzled":true}'));
			LGen('SaviorMan')->insert($_obj);

			return 1;
		}

		// public function get_id($obj) {
		// 	$_obj['namelist'] = ['id', 'cit_id'];
		// 	$_obj['def'] = 'stores';
		// 	$_obj['bridge'] = [];
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"stores", "puzzled":true}'));
		// 	$stores = LGen('SaviorMan')->get_all($_obj);
		// 	foreach ($stores as $key => $value) {
		// 		if (($value['cit_id']) === $obj['cit_id'])
		// 			return $value['id'];
		// 	}
		// 	return LGen('GlobVar')->failed;
		// }

		// public function add_store($obj) {
		// 	LGen('SaviorMan')->req_validator($obj);

		// 	$_obj = $obj;
		// 	$_obj['namelist'] = ['code_name', 'cit_id'];
		// 	$_obj['bridge'] = [];
		// 	$_obj['val'] = '';
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"stores", "puzzled":true}'));
		// 	$stores = LGen('SaviorMan')->get_all($_obj);
		// 	foreach ($stores as $key => $value) {
		// 		if (($value['cit_id']) === $obj['val']['cit_id'])
		// 			return 'citizen already have store';
		// 		else if (($value['code_name']) === $obj['val']['code_name'])
		// 			return 'store code name is exist';
		// 	}

		// 	$id = LGen('SaviorMan')->insert($obj);
		// 	$_obj = [];
		// 	$_obj['name'] = $obj['val']['name'];
		// 	$_obj['code_name'] = $obj['val']['code_name'];
		// 	$_obj['id'] = $id;
		// 	$_obj['point'] = 0;
		// 	return $_obj;
		// }

		// public function update_product_price($obj) {

		// }

		// public function home_content($obj) {
		// 	LGen('SaviorMan')->req_validator($obj);
		// 	$lang = $obj['val']['lang'];
		// 	$id = $obj['val']['prod_id'];
		// 	$page = false;
		// 	if (LGen('JsonMan')->is_key_exist($obj['val'], 'page'))
		// 		if ($obj['val']['page'] === 'page_item')
		// 			$page = 'page_item';

		// 	$id = $obj['val']['prod_id'];
		// 	$res = [];

		// 	$img = $obj;
		// 	$img['def'] = 'products';
		// 	$img['bridge'] = [];
		// 	$img['namelist'] = ["id", "img"];
		// 	if ($page === 'page_item')
		// 		$img['namelist'] = ["multiple", "store_id", "price_point", "price_idr", "price_usd", "price", "id", "img"];
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
		// 	$_res = (LGen('SaviorMan')->read($img));
		// 	foreach ($_res as $key => $value) {
		// 		$res[$key] = $value;
		// 	}
		// 	$img_id = $res['img'];

		// 	if ($page === 'page_item') {
		// 		$asd = [];
		// 		$asd['def'] = 'stores';
		// 		$asd['bridge'] = [];
		// 		$asd['namelist'] = ["code_name","name"];
		// 		array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "stores", "puzzled":true}'));
		// 		array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "'.$res['store_id'].'", "puzzled":false}'));
		// 		$res['store_name'] = (LGen('SaviorMan')->read($asd))['name'];
		// 		$res['store_codename'] = (LGen('SaviorMan')->read($asd))['code_name'];
		// 	}

		// 	$detail = $obj;
		// 	$detail['def'] = 'products/details';
		// 	$detail['bridge'] = [];
		// 	$detail['namelist'] = ["sh_desc","name"];
		// 	if ($page === 'page_item')
		// 		$detail['namelist'] = ["lg_desc","sh_desc","name"];
		// 	array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 	array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
		// 	array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "details", "puzzled":true}'));
		// 	array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "'.$lang.'", "puzzled":true}'));
		// 	// array_push($res, LGen('SaviorMan')->read($detail));
		// 	$_res = (LGen('SaviorMan')->read($detail));
		// 	foreach ($_res as $key => $value) {
		// 		$res[$key] = $value;
		// 	}

		// 	$img = $obj;
		// 	$img['def'] = 'products/imgs';
		// 	$img['bridge'] = [];
		// 	$img['namelist'] = ["id", "url"];
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$img_id.'", "puzzled":false}'));
		// 	$res['img'] = LGen('SaviorMan')->read($img);

		// 	if ($page === 'page_item') {
		// 		$imgs = $obj;
		// 		$imgs['def'] = 'products/imgs';
		// 		$imgs['bridge'] = [];
		// 		$imgs['namelist'] = ["id","url"];
		// 		array_push($imgs['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 		array_push($imgs['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
		// 		array_push($imgs['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
		// 		$res['imgs'] = LGen('SaviorMan')->get_all($imgs);
		// 	}

		// 	return $res;
		// }

		// public function update_product_detail($obj) {
		// 	LGen('SaviorMan')->req_validator($obj);

		// 	$lang = $obj['val']['lang'];
		// 	$id = $obj['val']['prod_id'];

		// 	$detail = $obj;
		// 	$detail['def'] = 'products/details';
		// 	$detail['bridge'] = [];
		// 	array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 	array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
		// 	array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "details", "puzzled":true}'));
		// 	array_push($detail['bridge'], LGen('StringMan')->to_json('{"id": "'.$lang.'", "puzzled":true}'));
		// 	return LGen('SaviorMan')->update($detail);
		// }

		// public function add_product_image($obj) {
		// 	LGen('SaviorMan')->req_validator($obj);

		// 	$imgs = $obj['val']['imgs'];
		// 	$id = $obj['val']['prod_id'];

		// 	$img = [];
		// 	$img['def'] = 'products/imgs';
		// 	$img['gate'] = '';
		// 	$img['bridge'] = [];
		// 	$img['val'] = [];
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
		// 	for ($i=0; $i<sizeof($imgs); $i++) {
		// 		$img['val']['url'] = $imgs[$i];
		// 		LGen('SaviorMan')->insert($img);
		// 	}
		// 	return 1;
		// }

		// public function get_products($obj) {
		// 	$_obj = [];
		// 	$_obj['def'] = 'stores/products';
		// 	$_obj['gate'] = '';
		// 	$_obj['namelist'] = ['prod_id'];
		// 	$_obj['bridge'] = [];
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "stores", "puzzled":true}'));
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['store_id'].'", "puzzled":false}'));
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 	$res = LGen('SaviorMan')->get_all($_obj);
		// 	for ($i=0; $i<sizeof($res); $i++) {
		// 		$res[$i]['prod_id'] = ($res[$i]['prod_id']);
		// 	}
		// 	$final_res = [];

		// 	$prod = [];
		// 	$prod['gate'] = '';
		// 	for ($i=0; $i<sizeof($res); $i++) {
		// 		$prod['bridge'] = [];
		// 		array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 		array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "'.$res[$i]['prod_id'].'", "puzzled":false}'));
		// 		$prod['def'] = 'products';
		// 		$prod['namelist'] = ['img','price'];
		// 		$product = LGen('SaviorMan')->read($prod);

		// 		$prod['def'] = 'products/imgs';
		// 		$prod['namelist'] = ['id','url'];
		// 		array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
		// 		$imgs = LGen('SaviorMan')->get_all($prod); // get imgs

		// 		array_pop($prod['bridge']); // remove id
		// 		$prod['def'] = 'products/details';
		// 		$prod['namelist'] = ['sh_desc','lg_desc','name'];
		// 		array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "details", "puzzled":true}'));
		// 		array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "id", "puzzled":true}'));
		// 		$detail_id = LGen('SaviorMan')->read($prod); // get id content
				
		// 		array_pop($prod['bridge']); // remove id
		// 		array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "en", "puzzled":true}'));
		// 		$detail_en = LGen('SaviorMan')->read($prod); // get en content

		// 		array_push($final_res, []);
		// 		$final_res[$i]['product']= $product;
		// 		$final_res[$i]['imgs']= $imgs;
		// 		$final_res[$i]['details']['id']= $detail_id;
		// 		$final_res[$i]['details']['en']= $detail_en;
		// 	}
		// 	return $final_res;
		// }

		// public function get_def($obj) {
		// 	$config_dir = HOME_DIR.'storages/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
		// 	$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
		// 	return $default;
		// }

		// public function add_product($obj) {
		// 	// LGen('SaviorMan')->req_validator($obj);
		// 	if (array_key_exists('store_id', $obj))
		// 		return 'no store_id';
		// 	$prod = [];
		// 	$prod['def'] = 'products';
		// 	$prod['gate'] = '';
		// 	$prod['bridge'] = [];
		// 	array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));

		// 	$id = LGen('SaviorMan')->insert($prod);

		// 	$seller = [];
		// 	$seller['val']['prod_id'] = $id;
		// 	$seller['def'] = 'stores/products';
		// 	$seller['gate'] = '';
		// 	$seller['keep_name'] = true;
		// 	$seller['name'] = $id;
		// 	$seller['bridge'] = [];
		// 	array_push($seller['bridge'], LGen('StringMan')->to_json('{"id": "stores", "puzzled":true}'));
		// 	array_push($seller['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['store_id'].'", "puzzled":false}'));
		// 	array_push($seller['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 	LGen('SaviorMan')->insert($seller);

		// 	$img = [];
		// 	$img['val']['url'] = '';
		// 	$img['def'] = 'products/imgs';
		// 	$img['gate'] = '';
		// 	$img['bridge'] = [];
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "'.$id.'", "puzzled":false}'));
		// 	array_push($img['bridge'], LGen('StringMan')->to_json('{"id": "imgs", "puzzled":true}'));
		// 	for ($i=0; $i<5; $i++) {
		// 		LGen('SaviorMan')->insert($img);
		// 	}
		// 	return $id;
		// }

		// public function buy_item($_obj) {
		// 	LGen('SaviorMan')->req_validator($obj);
		// 	// $_obj['cit_id'] = '9DE17B6195D0';
		// 	// $_obj['item_id'] = 'full_license';
		// 	// LGen('SaviorMan')->req_validator($obj);
		// 	$obj['bridge'] = [];
		// 	array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
		// 	array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$_obj['cit_id'].'", "puzzled":false}'));
		// 	$obj['def'] = 'citizens';
		// 	$obj['gate'] = '';
		// 	$obj['namelist'] = ['id', 'verification_code', 'created_date', 'fsize', 'theme_color', 'theme_font', 'email', 'lang', 'is_verified', 'id', 'fullname', 'username', 'gender', 'address', 'phonenum', 'silver', 'point'];
		// 	// $obj['namelist'] = ['silver'];
		// 	$final_obj = [];
		// 	$final_obj['json'] = $obj;
		// 	$final_obj['func'] = 'LGen("SaviorMan")->read';
		// 	$cit = LGen('ReqMan')->send_post($final_obj);

		// 	$prod = [];
		// 	$prod['def'] = 'products';
		// 	$prod['bridge'] = [];
		// 	$prod['namelist'] = ["id", "name", "price", "price_point", "price_idr", "price_usd"];
		// 	array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "products", "puzzled":true}'));
		// 	array_push($prod['bridge'], LGen('StringMan')->to_json('{"id": "'.$_obj['item_id'].'", "puzzled":false}'));
		// 	$prod = (LGen('SaviorMan')->read($prod));
			
		// 	if ($_obj['cur'] === 'price') {
		// 		$cit['silver'] = (int)$cit['silver'];
		// 		$final_price = (int)((float)$prod['price']*(int)$_obj['qty']);
		// 		if ($cit['silver']<$final_price)
		// 			return 'insufficient silver';
		// 	}
		// 	else if ($_obj['cur'] === 'price_point') {
		// 		$cit['point'] = (int)$cit['point'];
		// 		$final_price = (int)(((float)$prod['price_point']*(int)$_obj['qty']));
		// 		if ($cit['point']<$final_price)
		// 			return 'insufficient point';
		// 	}
		// 	else if ($_obj['cur'] === 'price_idr') {
		// 		$txid = $this->add_tx_pack($cit, $prod, $_obj);
		// 		// $res = [];
		// 		// $res[LGen('GlobVar')->stat] = LGen('GlobVar')->success;
		// 		// $res[LGen('GlobVar')->data] = $cit;
		// 		// // $obj['namelist'] = ['verification_code', 'created_date', 'fsize', 'theme_color', 'theme_font', 'email', 'lang', 'is_verified', 'id', 'fullname', 'username', 'gender', 'address', 'phonenum', 'silver', 'point'];
		// 		// return $res;
		// 		include HOME_DIR . 'app/iPaymu.class.php';
		// 			// return 'insufficient point';
		// 		$urlReturn = HOME_URL . 'payments/ipm/rtn/?id='.$txid;
		// 		// $urlReturn = HOME_URL . 'payments/ipm/?gateway=ipaymu&action=return&user_id='.$user_id.'&item_id='.$item_id.'&date_order='.$date_order.'&price_per_item='.$price_per_item.'&price_total='.$price_total.'&currency='.$currency.'&quantity='.$quantity.'&message='.$message.'&category_id='.$category_id.'&store_id='.$store_id;
		// 		$urlNotify = HOME_URL . 'payments/ipm/ntf/?id='.$txid.'&';
		// 		$urlCancel = HOME_URL;
		// 		$iPaymu = new iPaymu('CD41Pq5.sx.VvqGzE67Dg4nEBx3Iu1');
		// 		$iPaymu->addProduct($_obj['item_name'], $prod['price_idr'], $_obj['qty'], $_obj['item_sh_desc']);
		// 		$res = [];
		// 		$res[LGen('GlobVar')->stat] = 'ready to transfer';
		// 		$res[LGen('GlobVar')->data] = $iPaymu->paymentPage($urlReturn, $urlNotify , $urlCancel, $cit);
		// 		// $res = $iPaymu->paymentPage($urlReturn, $urlNotify , $urlCancel, $cit);
		// 		// error_log(json_encode($res->url));
		// 		// header("LOCATION: ".$res->url);
		// 		return $res;

		// 		return json_decode(json_encode(($res)), true);
		// 		// return json_decode(json_encode(($iPaymu->paymentPage($urlReturn, $urlNotify , $urlCancel, $cit))), true);
		// 		// return $_obj;
		// 	}
		// 	else if ($_obj['cur'] === 'price_usd') {
		// 		return 'not ready';
		// 	}
		// 	// return $final_price;

		// 	$lic = [];
		// 	if ($_obj['item_id'] === '30F6ABE2C6DC') // full license
		// 		$lic['type'] = 'full';
		// 	else if ($_obj['item_id'] === 'AF5F71E09322') // full license
		// 		$lic['type'] = 'theme_color';
		// 	else if ($_obj['item_id'] === 'D731D3F48741') // full license
		// 		$lic['type'] = 'theme_font';
		// 	if (LGen('JsonMan')->is_key_exist($lic, 'type')) { //the item is license
		// 		$asd = [];
		// 		$asd['val'] = $lic;
		// 		$asd['bridge'] = [];
		// 		array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
		// 		array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "'.$_obj['cit_id'].'", "puzzled":false}'));
		// 		array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "licenses", "puzzled":true}'));
		// 		$asd['def'] = 'citizens/licenses';
		// 		$asd['gate'] = '';
		// 		$final_obj = [];
		// 		$final_obj['json'] = $asd;
		// 		$final_obj['func'] = 'LGen("SaviorMan")->insert';
		// 		// return $final_obj;
		// 		for ($i=0; $i<(int)$_obj['qty']; $i++)
		// 			$asd = LGen('ReqMan')->send_post($final_obj);
		// 	}

		// 	if ($_obj['item_id'] === '7028104F56C1') {// lanter sword pearl
		// 		$chars = [];
		// 		$chars['def'] = 'chars';
		// 		$chars['bridge'] = [];
		// 		$chars['namelist'] = ["id","pearl","cit_id"];
		// 		array_push($chars['bridge'], LGen('StringMan')->to_json('{"id": "chars", "puzzled":true}'));
		// 		$final_obj = [];
		// 		$final_obj['json'] = $chars;
		// 		$final_obj['func'] = 'LGen("SaviorMan")->get_all';
		// 		$_char = LGen('ReqMan')->send_post($final_obj, 'be.sword.lanterlite.com/');
		// 		foreach ($_char as $key => $value) {
		// 			if ($value['cit_id'] === $cit['id']) {
		// 				$pearl = (int)$_char[$key]['pearl']+(int)$_obj['qty'];
		// 				$chars['val'] = [];
		// 				$chars['val']['pearl'] = $pearl;
		// 				array_push($chars['bridge'], LGen('StringMan')->to_json('{"id": "'.$_char[$key]['id'].'", "puzzled":false}'));
		// 				$final_obj['json'] = $chars;
		// 				$final_obj['func'] = 'LGen("SaviorMan")->update';
		// 				$asd = LGen('ReqMan')->send_post($final_obj, 'be.sword.lanterlite.com/');
		// 				break;
		// 			}
		// 		}
		// 	}

		// 	if ($_obj['item_id'] === 'BF45E033FFEA') {  // lantersilver
		// 		$cit['silver'] = $cit['silver']+(int)$_obj['qty'];
		// 	}

		// 	if ($_obj['cur'] === 'price')
		// 		$cit['silver'] = $cit['silver'] - $final_price;
		// 	else if ($_obj['cur'] === 'price_point')
		// 		$cit['point'] = $cit['point'] - $final_price;

		// 	$asd = [];
		// 	$asd['val'] = [];
		// 	$asd['val']['silver'] = $cit['silver'];
		// 	$asd['val']['point'] = $cit['point'];
		// 	$asd['bridge'] = [];
		// 	array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
		// 	array_push($asd['bridge'], LGen('StringMan')->to_json('{"id": "'.$_obj['cit_id'].'", "puzzled":false}'));
		// 	$asd['def'] = 'citizens';
		// 	$asd['gate'] = '';
		// 	$final_obj = [];
		// 	$final_obj['json'] = $asd;
		// 	$final_obj['func'] = 'LGen("SaviorMan")->update';
		// 	$asd = LGen('ReqMan')->send_post($final_obj);

		// 	$res = [];
		// 	$res[LGen('GlobVar')->stat] = LGen('GlobVar')->success;
		// 	$res[LGen('GlobVar')->data] = $cit;
		// 	// $obj['namelist'] = ['verification_code', 'created_date', 'fsize', 'theme_color', 'theme_font', 'email', 'lang', 'is_verified', 'id', 'fullname', 'username', 'gender', 'address', 'phonenum', 'silver', 'point'];
		// 	return $res;

		// 	// $asd = LGen('F')->decrypt($asd);
		// 	// $silver = ($asd['silver']);

		// 	// error_log(json_encode($asd));
		// }

		// public function add_tx_pack($cit, $prod, $order) {
		// 	$tx = [];
		// 	$tx['def'] = 'transactions';
		// 	$tx['bridge'] = [];
		// 	array_push($tx['bridge'], LGen('StringMan')->to_json('{"id": "transactions", "puzzled":true}'));
		// 	$tx['val'] = [];
		// 	$tx['keep_name'] = true;
		// 	$tx['name'] = $order['txid'];
		// 	$tx['val']['id'] = $order['txid'];
		// 	$tx['val']['cit_id'] = $cit['id'];
		// 	$tx['val']['qty'] = $order['qty'];
		// 	$tx['val']['price'] = $prod[$order['cur']];
		// 	$tx['val']['cur'] = $order['cur'];
		// 	$tx['val']['item_id'] = $prod['id'];
		// 	$txid = (LGen('SaviorMan')->insert($tx));
		// 	return $txid;
		// }

		// public function success_tx_old($tx2) {
		// 	$tx = [];
		// 	$tx['gate'] = '';
		// 	$tx['def'] = 'transactions';
		// 	$tx['bridge'] = [];
		// 	$tx['namelist'] = ['id','price','qty','cur','item_id','cit_id','is_success','purchased_date'];
		// 	array_push($tx['bridge'], LGen('StringMan')->to_json('{"id": "transactions", "puzzled":true}'));
		// 	array_push($tx['bridge'], LGen('StringMan')->to_json('{"id": "'.$tx2['txid'].'", "puzzled":false}'));
		// 	$_tx = LGen('SaviorMan')->read($tx);
		// 	if ($_tx['is_success'])
		// 		return false;
		// 	if ((int)$tx2['price'] < (int)$_tx['price']*(int)$_tx['qty'])
		// 		return false;

		// 	if ($_tx['item_id'] === 'BF45E033FFEA') {
		// 		$cit = [];
		// 		$cit['bridge'] = [];
		// 		array_push($cit['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
		// 		array_push($cit['bridge'], LGen('StringMan')->to_json('{"id": "'.$_tx['cit_id'].'", "puzzled":false}'));
		// 		$cit['def'] = 'citizens';
		// 		$cit['gate'] = '';
		// 		$cit['namelist'] = ['silver'];
		// 		$final_obj = [];
		// 		$final_obj['json'] = $cit;
		// 		$final_obj['func'] = 'LGen("SaviorMan")->read';
		// 		$_cit = LGen('ReqMan')->send_post($final_obj);
		// 		$_cit['silver'] = $_cit['silver']+$_tx['qty'];
		// 		$cit['val'] = [];
		// 		$cit['val']['silver'] = $_cit['silver'];
		// 		$final_obj['json'] = $cit;
		// 		$final_obj['func'] = 'LGen("SaviorMan")->update';
		// 		LGen('ReqMan')->send_post($final_obj);

		// 		$tx['val']['purchased_date'] = gmdate("Y/m/d H:i:s T");
		// 		$tx['val']['is_success'] = true;
		// 		$txid = (LGen('SaviorMan')->update($tx));
		// 	}
		// 	return true;
		// }
	}