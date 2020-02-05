<script type="text/javascript">
$(document).ready(function(){
    
    $("#loader").hide();
    
    <!-- JavaScript to disable send button and show loading.gif image -->
    $("#sendTM").click(function() {
    	$("#loader").show();
    	$('#sendTM').attr("disabled", "disabled");
    	$('.jak_form').submit();
    });
    
    $(".play-tone").change(function() {
    	var playtone = $(this).val();
    	var sound = new Howl({
    	  src: ['../'+playtone+'.mp3', '../'+playtone+'.webm']
    	});
    	
    	// Finally play the sound, also on mobiles
    	sound.play();
    });
                
});

ls.main_url = "<?php echo BASE_URL_ADMIN;?>";
ls.orig_main_url = "<?php echo BASE_URL_ORIG;?>";
ls.main_lang = "<?php echo JAK_LANG;?>";
</script>