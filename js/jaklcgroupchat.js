/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.0.3                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

function lcjak_groupchatWidget(data) {

	// Chat container, important for inject code
	var lcjgroup_container = document.getElementById('jakgroup-chat-container');

	// Inject the chat/button into the page
	lcjgroup_container.innerHTML = data.widgethtml;

	return true;
}

function extractDomainlcg(url) {
    var domain;
    //find & remove protocol (http, ftp, etc.) and get domain
    if (url.indexOf("://") > -1) {
        domain = url.split('/')[2];
    }
    else {
        domain = url.split('/')[0];
    }

    //find & remove port number
    domain = domain.split(':')[0];

    return domain;
}

// Create the XHR object.
function createCORSRequestlcg(method, url) {
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

(function(w) {

	chatloc = JSON.parse(JSON.stringify(w.lcjUrl));

	// Same location no cross origin.
	if (extractDomainlcg(w.lcjUrl) == window.location.hostname) {

		// Now we check if we have an online operator
		var request = new XMLHttpRequest();
		request.open('GET', chatloc+'include/groupchat.php?id='+w.id, true);

		// time in milliseconds
		request.timeout = 3000; 

		// Request
		request.onload = function() {
		  if (request.status >= 200 && request.status < 400) {
		    // Success!
		    var data = JSON.parse(request.responseText);

		    // We have data
		    if (data.status) {

		    	// Load chat widget
		    	lcjak_groupchatWidget(data);
			    return true;

		    } else {
		    	console.log(data.error);
		    }
		    

		  } else {
		  	// We reached our target server, but it returned an error

		  }
		};

		request.onerror = function() {
			// There was a connection error of some sort
		};

		request.ontimeout = function (e) {
  			// XMLHttpRequest timed out. Do something here.
		};

		request.send();

	} else {

		// This is a sample server that supports CORS.
	  	var url = chatloc+'include/groupchat_cross.php?id='+w.id+'&callback=LiveChatGroupJAK';

	  	var request = createCORSRequestlcg('GET', url);
	  	if (!request) {
	    	console.log('CORS not supported');
	    	return;
	  	}

	  	// Response handlers.
	  	request.onload = function() {
	  		var data = JSON.parse(request.responseText);
	  		// We have data
			if (data.status) {

				// Load chat widget
				lcjak_groupchatWidget(data);
				return true;

			} else {
				console.log(data.error);
			}
	  	};

	  	request.onerror = function() {
	    	console.log('Woops, there was an error making the request.');
	  	};

	  	request.send();
	}

}(window));