<?php

// Get the font for the title
$titlefont = $backgroundc = $theme = $slideimg = $fontcolor = "";
if (isset($jakwidget['t_font']) && !empty($jakwidget['t_font'])) $titlefont = 'font-family:'.$jakwidget['t_font'].';';
if (isset($jakwidget['sucolor']) && !empty($jakwidget['sucolor'])) $backgroundc = 'background:'.$jakwidget['sucolor'].';';
if (isset($jakwidget["sutcolor"]) && !empty($jakwidget["sutcolor"])) $fontcolor = 'color:'.$jakwidget["sutcolor"].';';
if (isset($jakwidget['theme_colour']) && !empty($jakwidget['theme_colour'])) $theme = " ".$jakwidget['theme_colour'];

?>

<div id="lcjframesize" class="live-chat-start-container animated">

<div class="lcj-chat-header <?php echo $jakwidget['theme_colour'];?>" style="<?php echo $titlefont.$backgroundc.$fontcolor;?>"><span class="lcj-sprite lcj-sprite-logo"></span><div class="lcj-title"><?php echo $jakwidget['title'];?></div><a href="javascript:void(0)" class="lcj-sprite lcj-sprite-popup" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('<?php echo ($online_op ? $chatstarturlpop : $chatcontacturlpop);?>', 'livechat3_popup_window', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=780,height=600,resizable=1');this.newWindow.focus();this.newWindow.opener=window;lcjak_popupChat('<?php echo $chatcloseurl;?>');return false;"></a> <a href="<?php echo $chatcloseurl;?>" class="lcj-sprite lcj-sprite-close"></a>
</div>

<div class="jrc_chat_header <?php echo $jakwidget['theme_colour'];?>">
	<!-- Display Operator Name -->
	<span id="oname"></span>
	<!-- Operator is typing -->
	<span class="badge badge-warning" id="jrc_typing"></span>

	<!-- Close Window -->
	<a href="javascript:void(0)" class="btn btn-sm btn-secondary" id="soundoff" onclick="soundOff();"><i class="fa fa-volume-up"></i></a>
	<a href="<?php echo $chatdetails;?>" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i></a>
	<a href="<?php echo $parseurl;?>" class="btn btn-sm btn-danger btn-confirm" data-title="<?php echo addslashes($jkl["g15"]);?>" data-text="<?php echo addslashes($jkl["g40"]);?>" data-type="" data-okbtn="<?php echo addslashes($jkl["g72"]);?>" data-cbtn="<?php echo addslashes($jkl["g73"]);?>"><i class="fa fa-power-off"></i></a>

</div>

<div class="jrc_chat_form_slide">
		
	<!--- Chat output -->
	<div class="direct-chat-<?php echo $jakwidget['theme_colour'];?>">
		<div id="jrc_chat_output" class="direct-chat-messages"></div>
	</div>
			
	<div id="client_input_container">
	
		<!-- Client Input -->
		<form action="javascript:sendInput();" name="messageInput" id="MessageInput">
				
			<div class="form-group slide-send-btn" id="msgError">
				<div class="input-group">
					<div class="emoji-picker">
						<div id="emoji"></div>
					</div>
				  	<input type="text" name="message" id="message" placeholder="<?php echo $jkl["g6"];?>" class="form-control">
				  	<div id="client-chat-upload">
						<span class="area dropzone fa fa-paperclip" id="cUploadDrop"></span>
					</div>
				  	<span class="input-group-btn">
				    	<button type="button" class="btn btn-success btn-flat" id="sendMessage"><i class="fa fa-paper-plane-o"></i></button>
				  	</span>
				</div>
			</div>
					
			<input type="hidden" name="userID" id="userID" value="<?php echo $_SESSION['jrc_userid'];?>">
			<input type="hidden" name="userName" id="userName" value="<?php echo $_SESSION['jrc_name'];?>">
			<input type="hidden" name="convID" id="convID" value="<?php echo $_SESSION['convid'];?>">
					
		</form>
		
		<div id="jak_update"></div>
			
	</div>
	<?php if (!empty(JAK_COPYRIGHT_LINK)) echo '<div class="copyright text-center">'.JAK_COPYRIGHT_LINK.'</div>';?>
</div>
</div>