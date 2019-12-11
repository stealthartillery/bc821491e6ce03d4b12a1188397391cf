<?php
	
	$sword = new SwordGen();

	class SwordGen {
		public function __construct() {
			set_time_limit ( 0 );
		}
		public function get_def($obj) {
			$config_dir = HOME_DIR.'storages/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
		return $default;
		}		
	}