/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.1                   # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Slide Up Main colour
$('#sumcolor').minicolors({
	theme: "bootstrap",
    change: function(value, opacity) {
    	$('.lcj-chat-header').css("background", value);
    }
});

// Slide Up Text colour
$('#sumtcolor').minicolors({
	theme: "bootstrap",
    change: function(value, opacity) {
    	$('.lcj-chat-header, .lcj-chat-main .lcj-chat-btn a').css("color", value);
    }
});

// Body
$('#pcolor').minicolors({
	theme: "bootstrap",
    change: function(value, opacity) {
    	$('.body-message-preview').css("background", value);
    }
});

// H1 color
$('#phead').minicolors({
	theme: "bootstrap",
    change: function(value, opacity) {
    	$('.h4-preview').css("color", value);
    }
});

// font color
$('#pfont').minicolors({
	theme: "bootstrap",
    change: function(value, opacity) {
    	$('.direct-chat-name, .classic-text-preview').css("color", value);
    }
});

// time color
$('#pheadcontent').minicolors({
	theme: "bootstrap",
    change: function(value, opacity) {
    	$('.direct-chat-timestamp').css("color", value);
    }
});

// link color
$('#pafont').minicolors({
	theme: "bootstrap",
    change: function(value, opacity) {
    	$('.chat-link-preview').css("color", value);
    }
});

// sidebar colour
$('#pfsidec').minicolors({
	theme: "bootstrap"
});

// Float button
$(document).on('change', '#jak_float', function(e) {
	e.preventDefault();
	if ($('input#jak_float').prop('checked')) {
		$("input#jak_floatpos").prop("checked", true);
	} else {
		$("input.jak_floatpos").prop("checked", false);
	}
});

// Chat colours
$(document).on('change', '#chat-colours-preview', function(e) {
	e.preventDefault();
	chatcol = $(this).val();
	
	$(".jrc_chat_form_slide").removeClass (function (index, css) {
	    return (css.match (/(^|\s)direct-chat-\S+/g) || []).join(' ');
	});
	
	$('.jrc_chat_form_slide').addClass('direct-chat-'+chatcol);
	
});

// body font
$(document).on('change', '#cFont', function() {
	tplfont = $(this).val();
	tplgfont = $('#gFont').val();
	
	$('.body-message-preview').css("font-family", tplfont);
	
	$('.scgoogle').remove();
	if (tplgfont != "NonGoogle") {
		$("head").append('<link rel="stylesheet" href="https://fonts.googleapis.com/css?family='+tplgfont+':regular,italic,bold,bolditalic" type="text/css" class="scgoogle" />');
		$('.h4-preview').css("font-family", tplgfont.replace("+", " "));
	}
	
});

// Google Fonts
$(document).on('change', '#gFont', function() {
	tplgfont = $(this).val();
	
	$('.scgoogle').remove();
	if (tplgfont != "NonGoogle") {
		$("head").append('<link rel="stylesheet" href="https://fonts.googleapis.com/css?family='+tplgfont+':regular,italic,bold,bolditalic" type="text/css" class="scgoogle" />');
		$('.h4-preview').css("font-family", tplgfont.replace("+", " "));
	}
	
});

$(document).on('change', '#sildecatchimg', function() {

		titlechat = $("#title").val();

		positionslideup = $('input[type=radio][name=jak_slideup]:checked').val();
		psl = '';
		if (positionslideup == 2) psl = ' left';

		slideimg = $("#sildecatchimg option:selected").val();

		if (slideimg != "") {
			$('.slideimg').html('<img src="'+ls.orig_main_url+ls.files_url+'/slideimg/'+slideimg+'" alt="live chat">');
		} else {
			$('.slideimg').html("");
		}

		// Get the colour from the input field
		$('.lcj-chat-header').css("background", $('#sumcolor').val());
		$('.lcj-chat-header, .lcj-chat-main .lcj-chat-btn a').css("color", $('#sumtcolor').val());
	
});

$(document).on('change', '#chatbutton', function() {
	widgettype = $('input[type=radio][name=jak_widget]:checked').val();
	
	if (widgettype != 1) {
		button = $(this).val();
		$('#chat_preview_button').html('<img src="'+ls.orig_main_url+ls.files_url+'/buttons/'+button+'" alt="button">').removeClass("hide");
	}
	
});