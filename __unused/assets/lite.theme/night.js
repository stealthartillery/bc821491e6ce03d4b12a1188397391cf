var theme = new theme();
console.log('asd')

function theme () {
	this.color = new color()

	function color() {
		this.main1 = "black"

		this.text1 = "white"
		this.text2 = "ivory"
		this.text3 = "lightgray"

		this.bgcontrast1 = "white"
		this.bgcontrast2 = "ivory"

		this.fgcontrast1 = "black"
		this.fgcontrast2 = "#1a1a1a"
		this.fgcontrast3 = "lightgray"

		this.row1 = "black"
		this.row2 = "#0d0d0d"

		this.highlight = "green"
		this.disable = "gray"

		this.contrast_blue = "lightskyblue"
		this.contrast_red = "orangered"
		this.contrast_green = "limegreen"
		this.contrast_grey = "lightgray"
		this.contrast_goldenrod = "goldenrod"
	}

}
