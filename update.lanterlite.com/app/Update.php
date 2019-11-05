<?php
init();
function get_data($obj) {
	error_log(HOME_DIR . $obj['dir']);
	if ($obj['type'] == 'lgd')
		return LGen('JsonMan')->read(HOME_DIR . $obj['dir']);
	// return (HOME_DIR . $dir);
	if ($obj['type'] == 'img')
		return getcwd();
}