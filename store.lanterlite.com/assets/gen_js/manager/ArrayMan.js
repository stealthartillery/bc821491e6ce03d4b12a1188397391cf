LGen.arr = {
	is_index_exist : function (array, index) {
		return (typeof array[index] === 'undefined')? false : true
	},
	rmv_by_val : function (arr, value) {
		var index = arr.indexOf(value);
		if (index !== -1)
			arr.splice(index, 1);
		return arr
	},
	is_val_exist : function (arr, text) {
		return (arr.indexOf(text) === -1)? false : true
	},
	rmv_first : function (arr) {
		arr.shift();
		return arr;
	},
	rmv_last : function (arr) {
		arr.pop();
		return arr;
	},
	to_str : function (arr, parser) {
		return arr.join(parser)
	},
	is_str_exist : function (arr, str) {
		return arr.indexOf(str.toLowerCase()) > -1;
	},
	is_int_exist : function (arr, int) {
		return arr.includes(int);
	},
	get_index_by_strval : function (arr, str) {
		return arr.indexOf(str);
	},
	shuffle : function (array) {
	  return array.sort(() => Math.random() - 0.5);
	},
}

function shade_set() {
	LGen.set_func({'val':'arr','func':LGen.arr})
	delete LGen.arr
}
shade_set()