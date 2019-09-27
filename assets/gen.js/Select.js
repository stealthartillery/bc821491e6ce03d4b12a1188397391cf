LGen.Select = new SelectMan()

function SelectMan () {
	this.get_selected_val = get_selected_val
	function get_selected_val(elm) {
		return elm.options[elm.selectedIndex].value;
	}
}