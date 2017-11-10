function addDepositFiles(idElement) {
	var result = null;
	var form_medias = document.getElementById(idElement);
	if (form_medias) {
		var bodies = form_medias.getElementsByTagName('tbody');
		if (bodies.length > 0)
			result = bodies[0];
	}
	else
		console.log('Element widh id="'+idElement+'" not found');
	return result;
}

// id for element to fade in/out, duration in miliseconds
function fadeInOut(id, duration) {
	var el = document.getElementById(id);
	if (el) {
		if (typeof(duration) === 'undefined') duration = 5000;
		var val = 0, valMax = 20;
		var freq = 100;
		var timer1, timer2;
		var fadeIn1 = function() {
			if (val <= valMax) {
				var opacity1 = val / valMax;
				document.getElementById(id).style.opacity = opacity1.toFixed(2);
				val++;
			}
		}
		var fadeOut1 = function() {
			if (val >= 0) {
				var opacity1 = val / valMax;
				el.style.opacity =  opacity1.toFixed(2);
				val--;
			}
			else {
				clearTimeout(timer2);
				clearTimeout(timer1); // Hara-Kiri !!!
			}
		}
		var flipflop = function() {
			clearTimeout(timer1);
			timer1 = setInterval(fadeOut1, freq);
		}
		timer1 = setInterval(fadeIn1, freq);
		timer2 = setTimeout(flipflop, duration);
	}
	else
		console.log('Element with "' + id + '" id not found');
}

function progressBar(aPercent) {
	var progressBar1 = document.getElementById('progressBar');
	if (progressBar1) {
		if (aPercent > 0) {
			progressBar1.style.display = 'visible';
			var theBar = '▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒';
			var i = Math.round(theBar.length * aPercent / 100);
			progressBar1.innerHTML = theBar.substr(0, i);
		}
		else
			aPercent.style.display = 'none';
	}
}

function checkUploadOk(files) {
	var result = false;
	if ((max_file_uploads > 0) && (files.length > max_file_uploads))
		alert(max_file_uploads + max_file_uploadsWarn);
	else {
		var total = 0;
		var badFiles = '';
		for (var i=0; i < files.length; i++) {
			var file1 = files[i];
			var n = file1.size;
			if (n > upload_max_filesize)
				badFiles += '\n' + file1.name;
			else
				total +=  n;
		}
		if (badFiles.length > 0)
			alert(upload_max_filesizeWarn + '\n' + (upload_max_filesize / 1024) + Kbytes + ' :' + badFiles);
		else if (total > post_max_size)
			alert(post_max_sizeWarn + (post_max_size / 1024) + Kbytes);
		else
			result = true;
	}
	return result;
}

// list of files to transmit, aForm provides some inputs we need, aUrl is the url for uploading files
// status is the id of element to display the result of uploading
// fileReader.readAsBinary function is deprecated. Use FormData object instead. compatible with more browsers (IE) and easier
var AJAXSubmit2 = function(files, aForm, aUrl, status) {

	function ajaxSuccess(event) {
		if (isJSON) { // defined by html5uploader.php
			var result = JSON.parse(this.responseText);
		}
		else {
			// Free.fr doesn't support JSON in PHP ( version < 5.2 )
			var buf = this.responseText.split('aZErTy');
			var result = {};
			result.msg = buf[0];
			if (buf.length > 1)
				result.inner = buf[1];
		}
		console.log(result.msg);
		if (result.inner) {
			if (result.inner.length > 0) {
				if (dropZone) {
					dropZone.innerHTML = result.inner;
				} else
					console.log('dropZone is undefined');
			}
			var msg = document.getElementById(status);
			if (msg) {
				msg.innerHTML = result.msg;
				fadeInOut(status);
			}
		}
		else
			alert(result.msg);
	}

	function ajaxProgress(event) {
		if (event.lengthComputable) {
			//event.loaded the bytes browser receive
			//event.total the total bytes seted by the header
			progressBar((event.loaded / event.total) * 100);
		}
	}

	function ajaxError(event) {
		alert('Oups! Something goes wrong.');
		console.log('Error on Ajax transfer');
    }

	if (checkUploadOk(files)) {

		var data = new FormData();

		for (var i=0; i<aForm.elements.length; i++) {
			var field = aForm.elements[i];
			if ((field.nodeName.toUpperCase() == 'INPUT') && field.hasAttribute('name')) {
				var fieldType = (field.getAttribute('type')) ? field.getAttribute('type').toUpperCase() : 'TEXT';
				if ((fieldType == 'FILE') && (files.length > 0)) {
					for (var f=0; f < files.length; f++)
						data.append('myFiles[]', files[f])
					}
				else if (((fieldType !== 'RADIO') &&  (fieldType !== 'CHECKBOX')) || field.checked) {
					data.append(field.name, field.value);
				}
			}
		}

		// console.log('Uploading of the post in progress...!');
		var ajaxReq = new XMLHttpRequest();
		ajaxReq.addEventListener('load', ajaxSuccess);
		ajaxReq.addEventListener('progress', ajaxProgress);
		ajaxReq.addEventListener('error', ajaxError);
		ajaxReq.open('POST', aUrl, true);
		ajaxReq.send(data);
		status
		var msg = document.getElementById(status);
		if (msg) {
			msg.innerHTML = post_is_doneMsg;
			fadeInOut(status);
		}
		// console.log('Transfer is done !');
	}
}

function uploader(dropZone, targetPHP, formUploader, status) {

	// Function drop file
	this.drop = function(event) {
		event.preventDefault();
	 	var dt = event.dataTransfer;
	 	var files = dt.files;
	 	// We need the form_uploader form to retrieve some input values
		var aForm = document.getElementById(formUploader);
		if (aForm && (aForm.nodeName.toUpperCase() == 'FORM'))
			AJAXSubmit2(files, aForm, targetPHP, status);
		else
			console.log('Element with id="' + formUploader + '" not found or not a form')
		this.style.opacity = '';
	}

	// The inclusion of the event listeners (DragOver and drop)
	this.uploadPlace =  dropZone;
	if (uploadPlace.addEventListener) {
		this.uploadPlace.addEventListener('dragover',
			function(event) {
				event.stopPropagation();
				event.preventDefault();
				this.style.opacity = '0.3';
			}, true
		);
		this.uploadPlace.addEventListener('dragleave',
			function(e) {
				// console.log('dragleave ' + e.target.nodeName.toUpperCase());
				this.style.opacity = '';
			},
			false
		);
		this.uploadPlace.addEventListener('drop', this.drop, false);
		/*
		this.uploadPlace.addEventListener('dragenter',
			function(e) {
				// console.log('dragenter ' + e.target.nodeName.toUpperCase());
				this.style.opacity = '0.3';
			},
			false
		);
		this.uploadPlace.addEventListener('dragend',
			function(e) {
				console.log('dragend ' + e.target.nodeName.toUpperCase());
			},
			false
		);
		this.uploadPlace.addEventListener('dragstart',
			function(e) {
				console.log('dragstart ' + e.target.nodeName.toUpperCase());
			},
			false
		);
		* */
	}
	else
		console.log('Your browser doesn\'t support addEventListener function. Change it !!!');
}

