/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 1.0                   # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

var lcjakint = livechat3_popup_window = null;
var lcjakwidgetid = 1;
var base_url = "";
var debugme = false;

document.addEventListener("DOMContentLoaded", function() { 
	lcjak_engage(lcjakwidgetid);
	lcjakint = setInterval(function(){lcjak_engage(lcjakwidgetid)}, 5000);
});

function lcjak_handleEngage(data) {

	// We have a widget change
	if (data.widget) {
		location.reload();
		return true;
	}

	// Get the knock knock
	if (data.knockknock) {

		if (data.soundalert) {
			var lcjsound = new Howl({
				src: [base_url+'/'+data.soundalert+'.webm', base_url+'/'+data.soundalert+'.mp3']
			});
			lcjsound.play();
		}
		if (parent.postMessage) {
        	parent.postMessage('knockknock::'+data.knockknock, data.baseurl);
    	} else {
			alert(msg.knockknock);
		}
		
		return true;
	}

	// New Message Play the sound
	if (data.newmessage) {

		if (data.soundalert) {
			var lcjsound = new Howl({
				src: [base_url+'/'+data.soundalert+'.webm', base_url+'/'+data.soundalert+'.mp3']
			});
			lcjsound.play();
		}

		if (data.widgettype == 4) {

			if(livechat3_popup_window && !livechat3_popup_window.closed) {
			    livechat3_popup_window.focus(); //If already Open Set focus
			} else {
			    livechat3_popup_window = window.open(data.newmsgpopurl, 'livechat3_popup_window', 'width=580,height=510');
			}
			
		} else {
			window.location = data.newmsgurl;
		}
		
		return true;
	}

	// Fire engage
	if (data.status) {

		if (data.showalert == 1) {

			// Fire the engage in a new and great way
			lcjak_engageWindow(data);

		} else {

		  	if (!data.ended) lcjak_engageOpen();

		}
		
	} else {
		return false;
	}

}

function lcjak_engageClose() {

	// Now we check if we have an online operator
	var xhrc = new XMLHttpRequest();
	xhrc.open('GET', base_url+'include/clientinform.php?id='+lcjakwidgetid+'&run=close', true);

	// time in milliseconds
	xhrc.timeout = 3000; 

	// Request
	xhrc.onload = function() {
		if (xhrc.status >= 200 && xhrc.status < 400) {
			// Success!
			var data = JSON.parse(xhrc.responseText);

			// We have data
			if (data.status) {
				if (!lcjakint) lcjakint = setInterval("lcjak_engage(lcjakwidgetid);", 5000);

				// Display the proactive message
				var lcj_proactive = document.getElementById('lcj-proactive');

				lcj_proactive.setAttribute("style", "opacity:0;");

				// Reset the Iframe Height/Width
				var width = document.getElementById('lcjframesize').offsetWidth;
				var height = document.getElementById('lcjframesize').offsetHeight;
				iframe_resize(width, height, data.widgetstyle, data.baseurl);

				if (debugme) console.log(data)

			} else {
		    	if (debugme) console.log(data.error);
			}

		} else {
			// We reached our target server, but it returned an error

		}
	};

	xhrc.onerror = function() {
		// There was a connection error of some sort
	};

	xhrc.ontimeout = function (e) {
  		// XMLHttpRequest timed out. Do something here.
	};

	xhrc.send();
}

function lcjak_engageWindow() {

	// Now we check if we have an online operator
	var xhro = new XMLHttpRequest();
	xhro.open('GET', base_url+'include/clientinform.php?id='+lcjakwidgetid+'&run=windowopen', true);

	// time in milliseconds
	xhro.timeout = 3000; 

	// Request
	xhro.onload = function() {
		if (xhro.status >= 200 && xhro.status < 400) {
			// Success!
			var data = JSON.parse(xhro.responseText);

			// We have data
			if (data.status) {
				if (!lcjakint) lcjakint = setInterval("lcjak_engage(lcjakwidgetid);", 5000);
				
				// Go to the engage window
				window.location = data.url;

				// log the data if set so
				if (debugme) console.log(data)

			} else {
		    	if (debugme) console.log(data.error);
			}

		} else {
			// We reached our target server, but it returned an error

		}
	};

	xhro.onerror = function() {
		// There was a connection error of some sort
	};

	xhro.ontimeout = function (e) {
  		// XMLHttpRequest timed out. Do something here.
	};

	xhro.send();
}

function lcjak_engageOpen() {

	// Now we check if we have an online operator
	var xhro = new XMLHttpRequest();
	xhro.open('GET', base_url+'include/clientinform.php?id='+lcjakwidgetid+'&run=open', true);

	// time in milliseconds
	xhro.timeout = 3000; 

	// Request
	xhro.onload = function() {
		if (xhro.status >= 200 && xhro.status < 400) {
			// Success!
			var data = JSON.parse(xhro.responseText);

			// We have data
			if (data.status) {
				if (!lcjakint) lcjakint = setInterval("lcjak_engage(lcjakwidgetid);", 5000);
				if (data.widget == "2") {
		  			window.open(data.url, 'livechat3_popup_window', 'width=580,height=510');
		  		} else {
					window.location = data.url;
				}
				if (debugme) console.log(data)

			} else {
		    	if (debugme) console.log(data.error);
			}

		} else {
			// We reached our target server, but it returned an error

		}
	};

	xhro.onerror = function() {
		// There was a connection error of some sort
	};

	xhro.ontimeout = function (e) {
  		// XMLHttpRequest timed out. Do something here.
	};

	xhro.send();
}

function lcjak_engage(id) {

	if (livechat3_popup_window) return false;

	// Now we check if we have an online operator
	var xhr = new XMLHttpRequest();
	xhr.open('GET', base_url+'include/clientinform.php?id='+id+'&run=check', true);

	// time in milliseconds
	xhr.timeout = 5000; 

	// Request
	xhr.onload = function() {
		if (xhr.status >= 200 && xhr.status < 400) {
			// Success!
			var data = JSON.parse(xhr.responseText);

			// We have data
			if (data.status) {

				lcjak_handleEngage(data);
				if (debugme) console.log(data)

			} else {
		    	if (debugme) console.log(data.error);
			}

		} else {
			// We reached our target server, but it returned an error

		}
	};

	xhr.onerror = function() {
		// There was a connection error of some sort
	};

	xhr.ontimeout = function (e) {
  		// XMLHttpRequest timed out. Do something here.
	};

	xhr.send();

}

// Create the XHR object.
function createCORSRequest(method, url) {
	var xhr = new XMLHttpRequest();
	xhr.withCredentials = true;
  	if ("withCredentials" in xhr) {
    	// XHR for Chrome/Firefox/Opera/Safari.
    	xhr.open(method, url, true);
  	} else if (typeof XDomainRequest != "undefined") {
    	// XDomainRequest for IE.
    	xhr = new XDomainRequest();
    	xhr.open(method, url);
  	} else {
    	// CORS not supported.
    	xhr = null;
  	}
  	return xhr;
}