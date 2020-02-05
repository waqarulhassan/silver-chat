function lcjak_popupChat(urlgo) {

  $('#lcjframesize').fadeOut();
  window.location = urlgo;
  return true;

}

function lcjak_slideout_operator(id, urlpost) {

	var request = $.ajax({
	  url: urlpost,
	  type: "POST",
	  data: "template=slideout&opid="+id,
	  dataType: "json",
	  cache: false
	});
	
	request.done(function(data) {
		if (data.status == 1) window.location = urlpost;
	});

}