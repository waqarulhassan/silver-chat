<?php if (JAK_USERID) { ?>
</section><!--Main Content -->

</div><!-- Content Wrapper -->

</div><!-- Wrapper -->

<?php } else { ?>
</div>
</div>
<?php } if (JAK_USERID) { ?>

<!-- Modal -->
<div id="jakModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="userModal" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"></div></div></div><!-- /.modal -->

<!-- New Pro Active Invitation -->
<div id="proActiveModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="proActiveModal" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	    	<h4 class="modal-title"><?php echo $jkl["u12"];?></h4>
	      	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    </div>
	    <div class="modal-body">
			<input type="text" name="proactivemsg" id="proactivemsg" class="form-control" value="<?php echo $jakuser->getVar("invitationmsg"); ?>">
			<input type="hidden" name="proactiveuid" id="proactiveuid">
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $jkl["g103"];?></button>
			<button class="btn btn-primary" onclick="sendInvitation();"><?php echo $jkl["g4"];?></button>
		</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php } ?>

<script type="text/javascript" src="<?php echo BASE_URL_ORIG;?>js/jquery.js?=<?php echo JAK_UPDATED;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL_ORIG;?>js/functions.js?=<?php echo JAK_UPDATED;?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/admin.js?=<?php echo JAK_UPDATED;?>"></script>

<?php if (JAK_USERID) { ?>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/client.ajax.js"></script>

<script type="text/javascript">
	ls.usrAvailable = <?php echo $jakuser->getVar("available");?>;
	ls.ls_ringing = "<?php echo $jakuser->getVar("ringing");?>";
	ls.opid = <?php echo $jakuser->getVar("id");?>;
	ls.oname = '<?php echo stripcslashes($jakuser->getVar("username"));?>';
	// Push Notifications
	ls.pushnotify = <?php echo $jakuser->getVar("push_notifications");?>;
	// sound
	ls.muted = <?php echo $jakuser->getVar("sound");?>;
	// Chat latency
	clatency = <?php echo $jakuser->getVar("chat_latency");?>;
	
	$("#jakModal").on("show.bs.modal", function(e) {
    	var link = $(e.relatedTarget);
    	$(this).find(".modal-content").load(link.attr("href"));
	});
		
	$('#jakModal').on('hidden.bs.modal', function() {
		$(this).removeData();
	});

	ls.main_url = "<?php echo BASE_URL_ADMIN;?>";
	ls.orig_main_url = "<?php echo BASE_URL_ORIG;?>";
	ls.main_lang = "<?php echo JAK_LANG;?>";

	// Finally start the event.
	sseJAK(<?php echo $jakuser->getVar("id");?>, <?php echo $jakuser->getVar("operatorlist");?>, <?php echo $jakuser->getVar("operatorchat");?>, <?php echo $JAK_UONLINE;?>);
	setInterval("setTimer(<?php echo $jakuser->getVar("id");?>);", 120000);
</script>
<!-- Operator Chat -->
<?php if ($jakuser->getVar("operatorchat") == 1 && JAK_OPENOP == 0){?>

<script type="text/javascript" src="<?php echo BASE_URL;?>js/operator.chat.js"></script>

<script type="text/javascript">
	sseJAKOPC(<?php echo $jakuser->getVar("id");?>);
</script>

<!-- reopen old opened chatboxes with the last state-->
<?php if (isset($_SESSION['chatbox_status'])) {
	echo '<script type="text/javascript">';
	echo '$(function() {';
	foreach ($_SESSION['chatbox_status'] as $openedchatbox) {
		echo 'PopupChat('.$openedchatbox['partner_id'].',"'.$openedchatbox['partner_username'].'",'.$openedchatbox['chatbox_status'].');';
	}
	echo "});";
	echo '</script>';
	}

} ?>
<?php } ?>

<script type="text/javascript">
<?php if (isset($_SESSION["infomsg"])) { ?>
$.notify({icon: 'fa fa-info-circle', message: '<?php echo addslashes($_SESSION["infomsg"]);?>'}, {type: 'info', animate: {
		enter: 'animated fadeInDown',
		exit: 'animated fadeOutUp'
	}});
<?php } if (isset($_SESSION["successmsg"])) { ?>
$.notify({icon: 'fa fa-check-square-o', message: '<?php echo addslashes($_SESSION["successmsg"]);?>'}, {type: 'success', animate: {
		enter: 'animated fadeInDown',
		exit: 'animated fadeOutUp'
	}});
<?php } if (isset($_SESSION["errormsg"])) { ?>
$.notify({icon: 'fa fa-exclamation-triangle', message: '<?php echo addslashes($_SESSION["errormsg"]);?>'}, {type: 'danger', animate: {
		enter: 'animated fadeInDown',
		exit: 'animated fadeOutUp'
	}});
<?php } ?>
</script>

<?php if ($js_file_footer) include_once(APP_PATH.JAK_OPERATOR_LOC.'/template/'.$js_file_footer);?>

</body>
</html>