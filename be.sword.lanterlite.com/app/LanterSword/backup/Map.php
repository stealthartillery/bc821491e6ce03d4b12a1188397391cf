<?php 

class Map {

	public function __construct() {
		set_time_limit ( 0 );
	}

	function get_data($map_id, $key, $encoded=true) {
		$data = LGen('JsonMan')->read(dir.'maps/'.$map_id.'/'.$key);
		if ($encoded)
			$data = ($data);
		return $data;
	}
}