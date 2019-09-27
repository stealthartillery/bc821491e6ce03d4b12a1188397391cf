function accordion() {
	this.create = create
	this.activate = activate
	this.add = add

	function activate() {
		 $(document).ready(function(){
		     $('.accordion-section-title').click(function(e){
		         var currentAttrvalue = $(this).attr('href');
		         if($(e.target).is('.active')){
		             $(this).removeClass('active');
		             $('.accordion-section-content:visible').slideUp(300);
		         } else {
		             $('.accordion-section-title').removeClass('active').filter(this).addClass('active');
		             $('.accordion-section-content').slideUp(300).filter(currentAttrvalue).slideDown(300);
		         }
		     });
		 });
	}

	function add(accordion, obj) {
		// var accordion = document.querySelector('.accordion.'+id+' .accordion-section')
		var title = str_to_elm('<a class="accordion-section-title theme_clr_text1 theme_clr_bg3_hover" href="#accordion-'+obj['content_id']+'">'+obj['title']+'</a>')
		var elm = str_to_elm('<div id="accordion-'+obj['content_id']+'" class="accordion-section-content"></div>')
		elm.appendChild(obj['elm'])
		title.addEventListener('click', function(evt) {
			evt.preventDefault(); //prevents hash from being append to the url
		})
		accordion.childNodes[0].appendChild(title)
		accordion.childNodes[0].appendChild(elm)
		return accordion
	}

	function create(id) {
		var accordion = str_to_elm('<div class="accordion '+id+'"></div>')
		var section = str_to_elm('<div class="accordion-section theme_clr_text1"></div>')
		accordion.appendChild(section)
		return accordion
		 // <div class="accordion">
//     <div class="accordion-section">
//         <a class="accordion-section-title" href="#accordion-1">accordion section #1</a>
//         <div id="accordion-1" class="accordion-section-content">
//             <p>This is first accordion section</p>
//         </div>
//         <a class="accordion-section-title" href="#accordion-2">accordion section #2</a>
//         <div id="accordion-2" class="accordion-section-content">
//             <p> this is second accordian section</p>
//         </div>
//         <a class="accordion-section-title" href="#accordion-3">accordion section #3</a>
//         <div id="accordion-3" class="accordion-section-content">
//             <p> this is third accordian section</p>
//         </div>
//     </div>
// </div>
	}
}

