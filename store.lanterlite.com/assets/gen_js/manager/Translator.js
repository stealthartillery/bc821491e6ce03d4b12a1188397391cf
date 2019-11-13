
LGen.translator = {

	set : function () {
	 	LGen.call({'c':'obj','f':'read'})(LGen.system.get({'safe':'safe'}).base_url+'assets/gen_base_fe/gen.words', function(obj) {
	 		LGen.translator.words = []
			if (LGen.call({'c':'black','f':'check'})({'val':obj,'safe':'safe'}))
				obj = LGen.call({'c':'white','f':'get'})({'val':obj,'safe':'safe'})
			for (var i=0; i<obj.length; i++) {
		 		LGen.translator.words.push(obj[i])
			}
		 	LGen.call({'c':'obj','f':'read'})(LGen.system.get({'safe':'safe'}).home_url+'app/app.words', function(obj) {
				if (LGen.call({'c':'black','f':'check'})({'val':obj,'safe':'safe'}))
					obj = LGen.call({'c':'white','f':'get'})({'val':obj,'safe':'safe'})
				for (var i=0; i<obj.length; i++) {
			 		LGen.translator.words.push(obj[i])
				}
			})
		})
	},

	get : function (obj) {
		if (!obj.hasOwnProperty('words'))
			return 'not valid'
		if (!obj.hasOwnProperty('lang'))
			obj['lang'] = LGen.citizen.get({'key':'lang','safe':'safe'})
		if (!obj.hasOwnProperty('from_lang') || obj['from_lang'] === '')
			obj['from_lang'] = LGen.Page.lang;
		if (obj['from_lang'] === obj['lang'])
			return obj['words']
		var lower_case_word = obj['words'].toLowerCase()
		for (var i=0; i<LGen.translator.words.length; i++) {
			var lower_case_word2 = LGen.translator.words[i][obj['from_lang']].toLowerCase()
			if (lower_case_word === lower_case_word2) {
				// if (obj['title_case'])
				// 	return LGen.str.to_title_case(LGen.translator.words[i][obj['lang']])
				// else
				return LGen.translator.words[i][obj['lang']]
			}
		}
		// if (obj['title_case'])
		// 	return LGen.str.to_title_case(obj['words'])
		// else
		return obj['words']
	},

	update : function (obj) {
		if (!obj.hasOwnProperty('type'))
			obj['type'] = 'innerText'

		if (obj.type === '')
			obj['type'] = 'innerText'

		if (obj.hasOwnProperty('text')) {
			animate(obj['type'], obj['elm'], obj['text'])
			return true;
		}

		if (
			obj['type'] !== 'innerText' && 
			obj['type'] !== 'placeholder' && 
			obj['type'] !== 'value' && 
			obj['type'] !== 'innerHTML'
		)
			var text = $(obj['elm']).attr(obj['type'])
		else
			var text = obj['elm'][obj['type']]
	
		// lprint(obj, text)
		// lprint('text', text)
		if (!obj.hasOwnProperty('from_lang') || obj['from_lang'] === '')
			obj['from_lang'] = LGen.Page.lang;

		if (obj['from_lang'] === obj['lang'])
			return false

		var lower_case_word = text.toLowerCase()
		for (var i=0; i<LGen.translator.words.length; i++) {
			var lower_case_word2 = LGen.translator.words[i][obj['from_lang']].toLowerCase()
			if (lower_case_word === lower_case_word2) {
				animate(obj['type'], obj['elm'], LGen.translator.words[i][obj['lang']])
				break
			}
		}

		function animate(type, elm, text) {
			$(elm).css({'opacity':0})
			// $(elm).addClass('color_transparent')
			setTimeout(function() {
				if (
					type !== 'innerText' && 
					type !== 'placeholder' && 
					type !== 'value' && 
					type !== 'innerHTML'
				)
					$(elm).attr(type, text)
				else
					elm[type] = text
				// $(elm).removeClass('color_transparent')
				$(elm).css({'opacity':1})
			}, LGen.Page.speed)
		}
	},
}

LGen.translator.set()