LGen.Mobile = new Mobile()

function Mobile () {

	this.create_file = create_file
	function create_file(obj) {
		var file_path = obj['file_path']
		var type = window.TEMPORARY;
		var size = 5*1024*1024;
		window.requestFileSystem(type, size, successCallback, errorCallback)

		function successCallback(fs) {
		  fs.root.getFile(file_path, {create: true, exclusive: true}, function(fileEntry) {
				alert('File creation successfull!')
		  }, errorCallback);
		}

		function errorCallback(error) {
		  alert("ERROR: " + error.code)
		}
	}

	this.read_file = read_file
	function read_file(obj) {
		var file_path = obj['file_path']
		var type = window.TEMPORARY;
		var size = 5*1024*1024;
		window.requestFileSystem(type, size, successCallback, errorCallback)

		function successCallback(fs) {
		  fs.root.getFile(file_path, {}, function(fileEntry) {

		     fileEntry.file(function(file) {
		        var reader = new FileReader();

		        reader.onloadend = function(e) {
		           // var txtArea = document.getElementById('textarea');
		           // txtArea.value = this.result;
		           var content = LGen.Elm.decrypt(this.result)
		           return content;
		        };
		        reader.readAsText(file);
		     }, errorCallback);
		  }, errorCallback);
		}

		function errorCallback(error) {
		  alert("ERROR: " + error.code)
		}
	}

	this.write_file = write_file
	function write_file(obj) {
		var file_path = obj['file_path']
		var string = LGen.Elm.encrypt(obj['content'])
		var type = window.TEMPORARY;
		var size = 5*1024*1024;
		window.requestFileSystem(type, size, successCallback, errorCallback)

		function successCallback(fs) {
		  fs.root.getFile(file_path, {create: true}, function(fileEntry) {

		     fileEntry.createWriter(function(fileWriter) {
		        fileWriter.onwriteend = function(e) {
		          alert('Write completed.');
		        };

		        fileWriter.onerror = function(e) {
		          alert('Write failed: ' + e.toString());
		        };

		        var blob = new Blob([string], {type: 'text/plain'});
		        fileWriter.write(blob);
		     }, errorCallback);
		  }, errorCallback);
		}

		function errorCallback(error) {
		  alert("ERROR: " + error.code)
		}
	}

	this.delete_file = delete_file
	function delete_file(obj) {
		var file_path = obj['file_path']
		var type = window.TEMPORARY;
		var size = 5*1024*1024;
		window.requestFileSystem(type, size, successCallback, errorCallback)

		function successCallback(fs) {
		  fs.root.getFile(file_path, {create: false}, function(fileEntry) {

		    fileEntry.remove(function() {
		      alert('File removed.');
		    }, errorCallback);
		  }, errorCallback);
		}

		function errorCallback(error) {
		  alert("ERROR: " + error.code)
		}
	}
}