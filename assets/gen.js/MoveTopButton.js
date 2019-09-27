LGen.component.mtbtn = new MoveTopButton();

function MoveTopButton() {

	this.set = set
	function set() {
		this.screen = LGen.String.to_elm('<a id="mtbtn" title="Back to top" href="#">&#10148</a>')
		document.body.appendChild(this.screen)
	}

	this.on = on
	function on() {
		$(window).scroll(function() {
	    var height = $(window).scrollTop();
	    if (height > 100) {
        $('#mtbtn').fadeIn();
	    } else {
        $('#mtbtn').fadeOut();
	    }
		});
		$(document).ready(function() {
	    $("#mtbtn").click(function(event) {
        event.preventDefault();
        $(window).animate({ scrollTop: 0 }, "slow");
        return false;
	    });
		});
	}
}
