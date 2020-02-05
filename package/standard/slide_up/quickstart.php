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
	<span><?php echo $headermsg;?></span>
</div>

<div class="jrc_chat_form_slide">

	<!--- Chat output -->
	<div class="direct-chat-messages quickstart">
	<?php if (isset($proactivemsg) && !empty($proactivemsg)) { ?>
		<div class="media <?php echo $jakwidget['theme_colour'];?>">
			<div class="media-space"><div class="media-content"><a class="media-left" href="javascript:void(0)"><img class="media-object rounded" src="<?php echo BASE_URL.JAK_FILES_DIRECTORY;?>/system.jpg" width="53" alt="<?php echo $jkl["g56"];?>"></a>
		    <div class="media-body">
		    	<h4 class="media-heading"><?php echo $jkl["g56"];?><span class="small pull-right chat-timestamp"><?php echo JAK_base::jakTimesince(time(), JAK_DATEFORMAT, JAK_TIMEFORMAT);?></span></h4>
		        <p><?php echo $proactivemsg;?></p>
		    </div>
		</div>
		</div>
		</div>
	<?php } else { ?>
		<div class="media"><div class="media-space">&nbsp;</div></div>
	<?php } ?>
		
	</div>

	<div id="client_input_container">
	
		<form class="jak-ajaxform" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
			
			<div class="form-group slide-send-btn">
				<label class="sr-only" for="message"><?php echo $jkl["g6"];?></label>
				<div class="input-group">
					<div class="emoji-picker">
						<div id="emoji"></div>
					</div>
				  	<input type="text" name="message" id="message" placeholder="<?php echo $jkl["g6"];?>" class="form-control chat_txt_msg" autocomplete="off">
				  	<span class="input-group-btn">
				    	<button type="submit" class="btn btn-success btn-flat"><i class="fa fa-paper-plane-o"></i></button>
				  	</span>
				</div>
			</div>
			
			<input type="hidden" name="start_chat" value="1">
			<input type="hidden" name="slide_chat" value="<?php if (isset($page1)) echo $page1;?>">
			<input type="hidden" name="lang" value="<?php if (isset($page2)) echo $page2;?>">
			
		</form>

	</div>
</div>
</div>