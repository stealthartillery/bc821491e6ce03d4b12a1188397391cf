<?php
	class GlobVar {
		public function __construct() {

			$globvars = BASE_DIR.'assets/gen.obj/globvar';
			$string = file_get_contents($globvars); 
			$globvars = json_decode($string, true); 
			foreach ($globvars as $key => $value) {
				eval('$this->'.$key.'="'.$value.'";');
			}
		}
	}
?>