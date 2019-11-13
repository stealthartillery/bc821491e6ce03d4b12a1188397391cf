LGen.date = {
	to_local : function (_date, abbreviate_month=true) {
		if (abbreviate_month) {
			var month_name = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
		  	"Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
			];
		}
		else {
			var month_name = ["January", "February", "March", "April", "May", "June",
			  "July", "August", "September", "October", "November", "December"
			];
		}
		if (_date === '' || _date === null || _date === undefined)
			return ''
		var _date = _date.toString()
		var date = new Date(_date);
		// November 12, 2018 at 4:39
		var result = month_name[date.getMonth()] + ' ' + date.getDate()+', '+ date.getFullYear()+' at '+date.getHours()+':'+date.getMinutes()
		return result
	}
}

function shade_set() {
	LGen.set_func({'val':'date','func':LGen.date})
	delete LGen.date
}
shade_set()