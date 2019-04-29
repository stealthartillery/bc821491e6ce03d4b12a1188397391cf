<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lanterlite.gen.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
	<title></title>
</head>
<body>
	<div class="canvas_apply"> </div>
	<div class="canvas">
		<div class="header"></div>
		<div class="canvas1"></div>
	</div>

</body>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/lanterlite.gen.js"></script>

<script type="text/javascript">
	// readJson("hadith2/enlite_db/", "fix_hadith_v1.json", function(obj){
	// 		// console.log(obj[DATA])
	// 	for (var i=0; i<obj[DATA].length; i++) {
	// 		// console.log(obj[DATA][i]['id'])
	// 		// console.log(obj[DATA][i])
	// 		saveJson('hadith2/enlite_db/each_hadith/', obj[DATA][i]['id']+'.json', obj[DATA][i], function(obj){console.log(obj)})
	// 	}
	// })
	var dir = 'dbms/each_hadith/BM/'
	// adjustTextarea()
	setFloatingCanvas()
	// var tbl = document.createElement('table')
	setHeader()
	setSnackBar()
	var sidebar = []
	sidebar.push({'id':'01', 'title':'Add New'})
	sidebar.push({'id':'02', 'title':'Many To One (Full)'})
	sidebar.push({'id':'03', 'title':'Many To One (Light)'})
	sidebar.push({'id':'04', 'title':'One To Many (Full)'})
	sidebar.push({'id':'05', 'title':'Q: One (F) To One (L)'})
	sidebar.push({'id':'06', 'title':'All to Words'})
	sidebar.push({'id':'05', 'title':'One To Many (Light)'})
	setSideBar(sidebar, function(e) {
		// console.log(e)
		if (e == '01') {
			for (var i=0; i<sidebar.length; i++) {
				if (e == sidebar[i]['id']) {
					$('#fcanvas').show()
					var obj = {}
					obj['id'] = ''
					obj['narrator'] = ''
					obj['ar_hadith'] = ''
					obj['hadith'] = ''
					// obj['hadith_no'] = ''
					obj['degree'] = ''
					obj['comment'] = ''
					obj['page'] = ''
					// obj['chapter'] = ''
					// obj['chapter_no'] = ''
					obj['collector'] = ''
					// obj['source'] = ''
					var save = {'file_dir':dir}
					var tbl = createMgmtTbl(obj, save)
					var div = document.createElement('div')
					div.appendChild(tbl)
					div.setAttribute('id', "mgmt")

					var canvas = document.querySelector('#fcanvas #canvas')
					canvas.appendChild(div)

					closeSideBar()
				}
			}
		}

		else if (e == '02') {
			getFileNamesInsideDir(dir, function (obj) {
				closeSideBar()
				var final_obj = []
				for (var i=0; i<obj[DATA].length; i++) {
					readJson(dir, obj[DATA][i], function(obj2){
						final_obj.push(completeHadith(obj2[DATA]))
					})
				}
			  setTimeout(function(){
					saveJson('hadith2/enlite_db/each_hadith/', 'final.json', final_obj, function(obj){
						console.log(obj)
						showSnackBar('apply done!')
					})
			  },5000);
			})
		}

		else if (e == '03') {
				closeSideBar()
				var final_obj = []
				readJson('hadith2/enlite_db/each_hadith/', 'final.json', function(obj2){
					for (var i=0; i<obj2[DATA].length; i++)
						final_obj.push(lightHadith(obj2[DATA][i]))
				})
			  setTimeout(function(){
					saveJson('hadith2/enlite_db/each_hadith/', 'final_light.json', final_obj, function(obj){
						console.log(obj)
						showSnackBar('apply done!')
					})
			  },5000);
		}

		else if (e == '04') {
			closeSideBar()
			readJson('hadith2/enlite_db/each_hadith/', 'final.json', function(obj2){
				for (var i=0; i<obj2[DATA].length; i++)
					saveJson('hadith2/enlite_db/each_hadith/full/', obj2[DATA][i]['id']+'.json', obj2[DATA][i], function(resp){
						console.log(resp)
				})
			})
		  setTimeout(function(){
				showSnackBar('apply done!')
		  },5000);
		}

		else if (e == '05') {
				closeSideBar()
				var final_obj = []
				readJson('hadith2/enlite_db/', 'fix_alquran_v1.json', function(obj){
						// console.log(obj[DATA])

					for (var i=0; i<obj[DATA].length; i++) {
						final_obj.push(lightQuran(obj[DATA][i]))
					}
				})
			  setTimeout(function(){
					saveJson('hadith2/enlite_db/each_hadith/', 'qlight.json', final_obj, function(obj){
						console.log(obj)
						showSnackBar('apply done!')
					})
			  },5000);
		}

		else if (e == '06') {
				closeSideBar()
				var all_words = []
				readJson('hadith2/enlite_db/each_hadith/', 'qlight.json', function(obj){
					for (var i=0; i<obj[DATA].length; i++) {
						var str = clean_str(obj[DATA][i]['content'])
						str = str_to_json(str, ' ')
						// console.log(str)
						for (var j=0; j<str.length; j++) {
							if (!is_str_in_array(all_words, str[j]))
								all_words.push(str[j])
						}
					}
				})
			  setTimeout(function(){
					readJson('hadith2/enlite_db/each_hadith/', 'final_light.json', function(obj){
						for (var i=0; i<obj[DATA].length; i++) {
							console.log(obj[DATA][i]['content'])
							var str = clean_str(obj[DATA][i]['content'])
							console.log(str)
							str = str_to_json(str, ' ')
							console.log(str)
							for (var j=0; j<str.length; j++) {
								if (!is_str_in_array(all_words, str[j]))
									all_words.push(str[j])
							}
						}
					})			  	
			  },5000);
			  setTimeout(function(){
					saveJson('hadith2/enlite_db/each_hadith/', 'words.json', all_words, function(obj){
						console.log(obj)
						showSnackBar('process done!')
					})
			  },10000);
		}

	})

	getFileNamesInsideDir(dir, function (obj) {
		for (var i=0; i<obj[DATA].length; i++) {
			var _obj = {}
			_obj['title'] = 'ID'
			_obj['value'] = obj[DATA][i]
			var tr = createMgmtRow(i, _obj, function (id) {
				// console.log(id)
				readJson(dir, id, function(obj2){
					var save = {'file_dir':dir, 'file_name':obj[DATA][i]}
					var div = createMgmtTbl(obj2[DATA], save)
					var canvas = document.querySelector('#fcanvas #canvas')
					canvas.appendChild(div)
				})
			})
			var canvas = document.querySelector('div.canvas1')
			canvas.appendChild(tr)
		}
	})


	// canvas.appendChild(tbl)

// var textarea = document.querySelector('textarea');

// textarea.addEventListener('keydown', autosize);
             

</script>
</html>