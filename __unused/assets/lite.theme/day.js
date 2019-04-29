var theme = new theme();
console.log('asd')

function theme () {
	this.color = new color()

	function color() {
		this.main1 = "white"

		this.text1 = "black"
		this.text2 = "#1a1a1a"
		this.text3 = "dimgray"

		this.bgcontrast1 = "black"
		this.bgcontrast2 = "#1a1a1a"

		this.fgcontrast1 = "white"
		this.fgcontrast2 = "ivory"
		this.fgcontrast3 = "lightgray"

		this.row1 = "white"
		this.row2 = "ivory"

		this.highlight = "yellow"
		this.disable = "lightgray"

		this.contrast_blue = "#0600AD"
		this.contrast_red = "red"
		this.contrast_green = "#008000"
		this.contrast_grey = "#1a1a1a"
		this.contrast_goldenrod = "darkgoldenrod"
	}

}
