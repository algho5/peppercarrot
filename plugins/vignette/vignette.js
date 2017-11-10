<!--
function _vignette () {
	
	this.openPopup = function(fichier,nom,width,height) {
		popup = window.open(unescape(fichier) , nom, "directories=no, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=yes, width="+width+" , height="+height);
		if(popup) {
			popup.focus();
		} else {
			alert('Ouverture de la fenêtre bloquée par un anti-popup!');
		}
		return;
	}
	
	this.addText = function(where, open, close) {
		close = close==undefined ? '' : close;
		var formfield = document.getElementsByName(where)['0'];
		// IE support
		if (document.selection && document.selection.createRange) {
			formfield.focus();
			sel = document.selection.createRange();
			sel.text = open + sel.text + close;
			formfield.focus();
		}
		// Moz support
		else if (formfield.selectionStart || formfield.selectionStart == '0') {
			var startPos = formfield.selectionStart;
			var endPos = formfield.selectionEnd;
			var restoreTop = formfield.scrollTop;
			formfield.value = formfield.value.substring(0, startPos) + open + formfield.value.substring(startPos, endPos) + close + formfield.value.substring(endPos, formfield.value.length);
			formfield.selectionStart = formfield.selectionEnd = endPos + open.length + close.length;
			if (restoreTop > 0) formfield.scrollTop = restoreTop;
			formfield.focus();
		}
		// Fallback support for other browsers
		else {
			formfield.value += open + close;
			formfield.focus();
		}
		return;
	}
					
}

var myVignette = new _vignette();
-->
