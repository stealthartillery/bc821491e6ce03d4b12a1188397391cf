LGen.translator = new Translator()
LGen.translator.set()

function Translator () {

	this.set = set
	function set() {
	 	LGen.Json.read(LGen.system.home_url+'assets/lang/translator.lgen', function(obj) {
	 		LGen.translator.words = obj
		})
	}

	this.get = get
	function get(obj) {
		if (!obj.hasOwnProperty('lang') || !obj.hasOwnProperty('words'))
			return 'not valid'
		if (!obj.hasOwnProperty('from_lang') || obj['from_lang'] === '')
			obj['from_lang'] = LGen.Page.lang;
		if (obj['from_lang'] === obj['lang'])
			return obj['words']
		var lower_case_word = obj['words'].toLowerCase()
		for (var i=0; i<LGen.translator.words.length; i++) {
			var lower_case_word2 = LGen.translator.words[i][obj['from_lang']].toLowerCase()
			if (lower_case_word === lower_case_word2) {
				// if (obj['title_case'])
				// 	return LGen.String.to_title_case(LGen.translator.words[i][obj['lang']])
				// else
				return LGen.translator.words[i][obj['lang']]
			}
		}
		// if (obj['title_case'])
		// 	return LGen.String.to_title_case(obj['words'])
		// else
		return obj['words']
	}

	this.update = update
	function update(obj) {
		lprint(obj)
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
	
		lprint(obj, text)
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
			$(elm).addClass('color_transparent')
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
				$(elm).removeClass('color_transparent')
			}, 250)
		}
	}
}