<?php

// Get the font for the title
$titlefont = $backgroundc = $theme = $slideimg = $fontcolor = "";
if (isset($jakwidget['t_font']) && !empty($jakwidget['t_font'])) $titlefont = 'font-family:'.$jakwidget['t_font'].';';
if (isset($jakwidget['sucolor']) && !empty($jakwidget['sucolor'])) $backgroundc = 'background:'.$jakwidget['sucolor'].';';
if (isset($jakwidget["sutcolor"]) && !empty($jakwidget["sutcolor"])) $fontcolor = 'color:'.$jakwidget["sutcolor"].';';
if (isset($jakwidget['theme_colour']) && !empty($jakwidget['theme_colour'])) $theme = " ".$jakwidget['theme_colour'];

?>

<div id="lcjframesize" class="jrc_chat_form_slide <?php echo $jakwidget['theme_colour'];?> animated">

<div class="live-chat-su-header">
  <div class="lcj-chat-header" style="<?php echo $titlefont.$backgroundc.$fontcolor;?>"><span id="oname"></span> <span class="badge badge-pill badge-success" id="jrc_typing"></span></div> <a href="javascript:void(0)" class="btn-circle" id="soundoff" onclick="soundOff();"><i class="fa fa-volume-up"></i></a> <a href="<?php echo $chatdetails;?>" class="btn-circle"><i class="fa fa-pencil"></i></a> <a href="javascript:void(0)" class="btn-circle" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('<?php echo ($online_op ? $chatstarturlpop : $chatcontacturlpop);?>', 'livechat3_popup_window', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=780,height=600,resizable=1');this.newWindow.focus();this.newWindow.opener=window;lcjak_popupChat('<?php echo $chatcloseurl;?>');return false;"><i class="fa fa-window-maximize"></i></a> <a href="<?php echo $chatcloseurl;?>" class="btn-circle"><i class="fa fa-times"></i></a> <a href="<?php echo $parseurl;?>" class="btn-circle btn-red btn-confirm" data-title="<?php echo addslashes($jkl["g15"]);?>" data-text="<?php echo addslashes($jkl["g40"]);?>" data-type="" data-okbtn="<?php echo addslashes($jkl["g72"]);?>" data-cbtn="<?php echo addslashes($jkl["g73"]);?>"><i class="fa fa-power-off"></i></a>
</div>
		
<!--- Chat output -->
<div id="jrc_chat_output" class="direct-chat-messages"></div>
			
<div id="client_input_container">
	
	<!-- Client Input -->
	<form action="javascript:sendInput();" name="messageInput" id="MessageInput">
				
		<div class="slide-send-btn" id="msgError">
			<div class="emoji-picker">
				<div id="emoji"></div>
			</div>
			<input type="text" name="message" id="message" placeholder="<?php echo $jkl["g6"];?>" class="form-control">
			<div id="client-chat-upload">
				<span class="area dropzone fa fa-paperclip" id="cUploadDrop"></span>
			</div>
			<button type="button" class="btn btn-flat" id="sendMessage"><i class="fa fa-paper-plane-o"></i></button>
		</div>
					
		<input type="hidden" name="userID" id="userID" value="<?php echo $_SESSION['jrc_userid'];?>">
		<input type="hidden" name="userName" id="userName" value="<?php echo $_SESSION['jrc_name'];?>">
		<input type="hidden" name="convID" id="convID" value="<?php echo $_SESSION['convid'];?>">
					
	</form>
		
	<div id="jak_update"></div>
	
</div>
<?php if (!empty(JAK_COPYRIGHT_LINK)) echo '<div class="copyright text-center">'.JAK_COPYRIGHT_LINK.'</div>';?>
</div>