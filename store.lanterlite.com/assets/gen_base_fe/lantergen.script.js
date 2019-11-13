function L(obj) {
	if (is_arr(obj))
		return new LArray(obj)
	
	function is_arr(what) {
    return Object.prototype.toString.call(what) === '[object Array]';
	}
}