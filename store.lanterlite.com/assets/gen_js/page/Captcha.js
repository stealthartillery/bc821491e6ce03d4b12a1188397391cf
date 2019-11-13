LGen.component.captcha = new captcha()
LGen.component.captcha.set()

function captcha () {
	this.name = 'captcha'
	this.url_names = ['captcha']
	this.a = ''
	this.total_solved = 3
	this.current_solved = 0
	this.solved = false
	this.when_solved = function(){}
	this.solved_num_list = []
	this.num = null

	this.set = set
	function set () {
		var page = LGen.component.captcha
		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="captcha" style="display: none;">'+
			'<div class="bground">'+
				'<div class="content">'+
					'<div class="title theme fttl">'+'Please solve these questions to login.'+'</div>'+
					'<div class="question theme fp">'+''+'</div>'+
					'<select class="choices select theme fp">'+
					'</select>'+
					'<button class="std gold confirm_btn theme fp bgclr1 hover1">'+'Confirm'+'</button>'+
					'<button class="std gold home_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
				'</div>'+
				'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.bground .title')},
			{"elm":page.screen.querySelector('.bground .confirm_btn')},
			{"elm":page.screen.querySelector('.bground .home_btn')},
		]
		page.set_event()
		LGen.Page.init(page)
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.captcha
		LGen.set_button(page.screen.querySelector('.home_btn'))
		LGen.set_button_click(page.screen.querySelector('.home_btn'), function(_this) {
			LGen.Page.change(page.previous_page)
		})
		LGen.set_button(page.screen.querySelector('.confirm_btn'))
		LGen.set_button_click(page.screen.querySelector('.confirm_btn'), function(_this) {
			var ans = $( "select.choices option:selected" ).text()
		 	if (page.a === ans) {
		 		page.current_solved += 1
		 		page.solved_num_list.push(page.num)
		 		if (page.current_solved === page.total_solved) {
					page.solved = true
					page.solved_num_list = []
					page.when_solved()
		 			LGen.Page.change(page.previous_page)
		 		}
		 		else
			 		page.update()
		 		// lprint('correct')
		 	}
		 	else {
		 		// lprint('incorrect')
		 		// page.update()
		 	}
			// lprint(ans);
			// $(page.screen.querySelector('select.choices')).change(function(){ 
			// 	// lprint($(this).val())
			// });
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.captcha
		LGen.Page.Self.update(page)

		LGen.call({'c':'elm','f':'clear_childs'})(page.screen.querySelector('select.choices'))

		// var total_captcha = 10
		// var num = LGen.call({'c':'num','f':'gen_rand'})(1,total_captcha);
    // LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).base_url + "assets/gen_obj/captcha/"+LGen.citizen.get({'key':'lang','safe':'safe'})+"/"+num+'.lgen', function(obj) {
    // LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).fe_url + "update.lanterlite.com/storages/captcha/"+LGen.citizen.get({'key':'lang','safe':'safe'})+"/"+num+'.lgen', function(obj) {
		var _obj = {
			"func": "get_data",
			"json": {
				"dir": "assets/content/lang/captcha//detail.lgen",
				"type": "lgd"
			}
		}
		LGen.call({'c':'req','f':'get'})('update.lanterlite.com/gate', _obj, function(obj) {
			// lprint(obj)
			var total_captcha = obj['total_captcha']
			page.num = null;
			while(page.num === null || LGen.call({'c':'arr','f':'is_val_exist'})(page.solved_num_list, page.num)) {
				page.num = LGen.call({'c':'num','f':'gen_rand'})(1,total_captcha)
				if (!LGen.call({'c':'arr','f':'is_val_exist'})(page.solved_num_list, page.num))
					page.start_question()
			}

    })
	}

	this.start_question = function () {
		var page = LGen.component.captcha
		var _obj = {
			"func": "get_data",
			"json": {
				"dir": "assets/content/lang/captcha/"+LGen.citizen.get({'key':'lang','safe':'safe'})+"/"+page.num+'.lgen', 
				"type": "lgd"
			}
		}
		LGen.call({'c':'req','f':'get'})('update.lanterlite.com/gate', _obj, function(obj) {
			page.screen.querySelector('.question').innerText = obj.q
			page.a = obj.a
    	// lprint(obj)
    	var rand_choices = []
    	for (var i=0; i<obj.c.length; i++) {
    		rand_choices.push(i)
    	}
    	rand_choices = LGen.call({'c':'arr','f':'shuffle'})(rand_choices)
    	for (var i=0; i<obj.c.length; i++) {
				page.screen.querySelector('select.choices').appendChild(
					LGen.call({'c':'str', 'f':'to_elm'})('<option>'+obj.c[rand_choices[i]]+'</option>')
				)
    	}
    	// LGen.propkey = obj
    })		
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.captcha
		page.previous_page = ''
		// setTimeout(function() {
		// 	LGen.component.header.show(LGen.Page.speed)
		// }, LGen.Page.speed)
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.captcha
		page.update()
		page.solved = false
		page.current_solved = 0
		LGen.component.header.hide()
		LGen.component.footbar.hide()
	}
}