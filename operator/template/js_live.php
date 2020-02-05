<?php if (JAK_SHOW_IPS) { ?>
<script src="<?php echo BASE_URL;?>js/leaflet.js" type="text/javascript"></script>
<?php } ?>
<script src="<?php echo BASE_URL;?>js/emoji.js" type="text/javascript"></script>
<?php if ($jakuser->getVar("files") && $livechat['status'] == 1 && $livechat['ended'] == 0) { ?>
<script type="text/javascript" src="<?php echo BASE_URL_ORIG;?>js/dropzone.js"></script>
<?php } ?>

<script type="text/javascript">

// We need to load the chat
activeConvID = <?php echo $page1;?>;
getInfo(activeConvID);

$(document).on("click", ".edit-msg", function(e) {
	e.preventDefault();

	if ($(this).hasClass('active')) {
		$('#msgeditid, #msgquoteid').val("");
		$('.edit-msg, .edit-quote').removeClass('active');
		$('.media-text').removeClass('highlight');
		$('#message').val("").focus();
	} else {
		$('#msgquoteid').val("");
		$('.edit-msg, .edit-quote').removeClass('active');
		$('.media-text').removeClass('highlight');
		$(this).addClass('active');
		var editid = $(this).data("id");
		var msgtoedit = $(this).data("msg");
		$('#msgeditid').val(editid);
		$('#msg'+editid).addClass('highlight');
		$('#message').val(msgtoedit).focus();
	}
});

$(document).on("click", ".edit-quote", function(e) {
	e.preventDefault();

	if ($(this).hasClass('active')) {
		$('#msgquoteid, #msgeditid, #message').val("");
		$('.edit-quote, .edit-msg').removeClass('active');
		$('.media-text').removeClass('highlight');
		$('#message').focus();
	} else {
		$('#msgeditid, #message').val("");
		$('.edit-quote, .edit-msg').removeClass('active');
		$('.media-text').removeClass('highlight');
		$(this).addClass('active');
		var editid = $(this).data("id");
		$('#msgquoteid').val(editid);
		$('#msg'+editid).addClass('highlight');
		$('#message').focus();
	}
});

$(document).on("click", ".edit-remove", function(e) {
	e.preventDefault();

	var _this = $(this);
	var msgid = $(_this).data("id");
	var plevel = $(_this).data("plevel");
					
	$.ajax({
		type: "POST",
		url: ls.main_url + 'ajax/oprequests.php',
		data: "oprq=hidemsg&id="+msgid+"&cid="+activeConvID+"&plevel="+plevel+"&uid="+ls.opid,
		dataType: 'json',
		success: function(msg){
							
			if (msg.status) {
				$(_this).toggleClass("text-danger");
				$(_this).data("plevel", msg.plevel);
				$.notify({icon: 'fa fa-info-circle', message: msg.txt}, {type: 'success', animate: {enter: 'animated fadeInDown', exit: 'animated fadeOutUp'}});
			} else {
				$.notify({icon: 'fa fa-exclamation-triangle', message: msg.txt}, {type: 'danger', animate: {enter: 'animated fadeInDown', exit: 'animated fadeOutUp'}});
			}
			return false;
		}
	});
});

$(document).on("click", ".edit-starred", function(e) {
	e.preventDefault();

	var _this = $(this);
	var msgid = $(_this).data("id");
	var starred = $(_this).data("starred");
					
	$.ajax({
		type: "POST",
		url: ls.main_url + 'ajax/oprequests.php',
		data: "oprq=starred&id="+msgid+"&cid="+activeConvID+"&starred="+starred+"&uid="+ls.opid,
		dataType: 'json',
		success: function(msg){
							
			if (msg.status) {
				if (starred == 1) {
					$(_this).find('i').removeClass("fa-star").addClass('fa-star-o');
				} else {
					$(_this).find('i').removeClass("fa-star-o").addClass('fa-star');
				}
				$(_this).data("starred", msg.starred);
				$.notify({icon: 'fa fa-info-circle', message: msg.txt}, {type: 'success', animate: {enter: 'animated fadeInDown', exit: 'animated fadeOutUp'}});
			} else {
				$.notify({icon: 'fa fa-exclamation-triangle', message: msg.txt}, {type: 'danger', animate: {enter: 'animated fadeInDown', exit: 'animated fadeOutUp'}});
			}
			return false;
		}
	});
});

$(document).on('click', '.btn-slidebar-info', function(e) {
      e.preventDefault();

    if ($(this).hasClass('active')) {
      $(".flex-client-info").html("");
      $('.btn-slidebar-info').removeClass('active');
      $('.main-chat-output').removeClass('flex-info-open');
    } else {
      $('.btn-slidebar-info').removeClass('active');
      $(this).addClass('active');

      if (!$('.main-chat-output').hasClass('flex-info-open')) $('.main-chat-output').addClass('flex-info-open');
      var creq = $(this).data('chat');

      if (creq && activeConvID) {

        $.ajax({
          type: "POST",
          url: ls.main_url + 'ajax/chatinfo.php',
          data: "creq="+creq+"&uid="+ls.opid+"&convid="+activeConvID,
          dataType: 'json',
          success: function(msg){
            
            if (msg.status == 1) {
              $(".flex-client-info").html(msg.html);
              return true;
            } else {
              $.notify({icon: 'fa fa-exclamation-triangle', message: msg.text}, {type: 'danger'});
              $(".flex-client-info").html("");
              $('.btn-slidebar-info').removeClass('active');
              $('.main-chat-output').removeClass('flex-info-open');
              return false;
            }
            
          }
        });

      }
    }
});

<?php if ($jakuser->getVar("files") && $livechat['status'] == 1 && $livechat['ended'] == 0) { ?>
Dropzone.autoDiscover = false;
	$(function() {
  		// Now that the DOM is fully loaded, create the dropzone, and setup the
  		// event listeners
  		var myDropzone = new Dropzone("#cUploadDrop", {dictResponseError: "SERVER ERROR",
	    dictDefaultMessage: "<?php echo $jkl['u9'];?>",
	    acceptedFiles: "<?php echo JAK_ALLOWEDO_FILES;?>",
	    url: "<?php echo BASE_URL_ORIG;?>uploader/uploadero.php"});
		myDropzone.on("sending", function(file, xhr, formData) {
  			// Will send the filesize along with the file as POST data.
  			formData.append("convID", activeConvID);
  			formData.append("userIDU", <?php echo $jakuser->getVar("id");?>);
  			formData.append("base_url", "<?php echo BASE_URL_ORIG;?>");
  			formData.append("operatorNameU", "<?php echo $jakuser->getVar("name");?>");
  			formData.append("operatorLanguage", "<?php echo $USER_LANGUAGE;?>");
		});
  		myDropzone.on("complete", function(file) {
  			myDropzone.removeAllFiles();
  			loadchat = true;
	        scrollchat = true;
	        getInput(activeConvID);
		});
	});
<?php } ?>

$(document).ready(function(){

	var clipboard = new Clipboard('.clipboard');

	clipboard.on('success', function(e) {

	    $.notify({icon: 'fa fa-check-square-o', message: '<?php echo addslashes($jkl["g284"]);?>'}, {type: 'success', animate: {
			enter: 'animated fadeInDown',
			exit: 'animated fadeOutUp'
		}});

	    e.clearSelection();
	});
	
});
</script>