<!-- Style Changer -->
<script type="text/javascript" src="<?php echo BASE_URL;?>js/minicolor.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/changer.js"></script>

<!-- JavaScript for select all -->
<script type="text/javascript">
$(document).ready(function() {

    var clipboard = new Clipboard('.clipboard');

	clipboard.on('success', function(e) {

	    $.notify({icon: 'fa fa-check-square-o', message: '<?php echo addslashes($jkl["g284"]);?>'}, {type: 'success', animate: {
			enter: 'animated fadeInDown',
			exit: 'animated fadeOutUp'
		}});

	    e.clearSelection();
	});

    // Set mandatory to 0 if not shown
    $('input[type=radio][name=jak_scemail]').change(function() {
        if (this.value == '0') {
            $('input[type=radio][name=jak_cemail]').val(["0"]);
        }
    });
    $('input[type=radio][name=jak_scphone]').change(function() {
        if (this.value == '0') {
            $('input[type=radio][name=jak_cphone]').val(["0"]);
        }
    });
    $('input[type=radio][name=jak_squestion]').change(function() {
        if (this.value == '0') {
            $('input[type=radio][name=jak_question]').val(["0"]);
        }
    });
    $('#department').change(function() {
        if (this.value != '0') {
            $('#operator').val(["0"]);
        }
    });
    $('#operator').change(function() {
        if (this.value != '0') {
            $('#department').val(["0"]);
        }
    });

	$('.body-message-preview').css("background", "<?php echo $JAK_FORM_DATA["body_colour"];?>");
    $('.h4-preview').css("color", "<?php echo $JAK_FORM_DATA["h_colour"];?>");
    $('.direct-chat-name, .classic-text-preview').css("color", "<?php echo $JAK_FORM_DATA["c_colour"];?>");
    $('.direct-chat-timestamp').css("color", "<?php echo $JAK_FORM_DATA["time_colour"];?>");
    $('.chat-link-preview').css("color", "<?php echo $JAK_FORM_DATA["link_colour"];?>");

    /* Style Changer */
    <?php if (isset($JAK_FORM_DATA['template'])) { ?>
	$("head").append('<link rel="stylesheet" href="<?php echo BASE_URL_ORIG.'package/'.$JAK_FORM_DATA['template'].'/'.$jakgraphix["csspreview"];?>" type="text/css" class="csspreview">');
    
    <?php } if ($JAK_FORM_DATA["h_font"] != "NonGoogle") { ?>
    $("head").append('<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=<?php echo str_replace("+", " ", $JAK_FORM_DATA["h_font"]);?>:regular,italic,bold,bolditalic" type="text/css" class="scgoogle" />');
    $('.h4-preview').css("font-family", <?php if ($JAK_FORM_DATA["h_font"] != "NonGoogle") echo '"'.str_replace("+", " ", $JAK_FORM_DATA["h_font"]).'"';?>)
    <?php } ?>
					
});

ls.files_url = "<?php echo JAK_FILES_DIRECTORY;?>";
</script>