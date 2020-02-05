<?php

// Get the font for the title
$titlefont = $backgroundc = $theme = $slideimg = $fontcolor = "";
if (isset($jakwidget['t_font']) && !empty($jakwidget['t_font'])) $titlefont = 'font-family:'.$jakwidget['t_font'].';';
if (isset($jakwidget['sucolor']) && !empty($jakwidget['sucolor'])) $backgroundc = 'background:'.$jakwidget['sucolor'].';';
if (isset($jakwidget["sutcolor"]) && !empty($jakwidget["sutcolor"])) $fontcolor = 'color:'.$jakwidget["sutcolor"].';';
if (isset($jakwidget['theme_colour']) && !empty($jakwidget['theme_colour'])) $theme = " ".$jakwidget['theme_colour'];

?>

<div id="lcjframesize" class="live-chat-start-container animated fadeIn">

<div class="lcj-chat-header <?php echo $jakwidget['theme_colour'];?>" style="<?php echo $titlefont.$backgroundc.$fontcolor;?>"><span class="lcj-sprite lcj-sprite-logo"></span><div class="lcj-title"><?php echo $jakwidget['title'];?></div><a href="javascript:void(0)" class="lcj-sprite lcj-sprite-popup" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('<?php echo ($online_op ? $chatstarturlpop : $chatcontacturlpop);?>', 'livechat3_popup_window', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=780,height=600,resizable=1');this.newWindow.focus();this.newWindow.opener=window;lcjak_popupChat('<?php echo $chatcloseurl;?>');return false;"></a> <a href="<?php echo $chatcloseurl;?>" class="lcj-sprite lcj-sprite-close"></a>
</div>

<div class="jrc_chat_header <?php echo $jakwidget['theme_colour'];?>">
	<!-- Display Operator Name -->
	<span><?php echo $headermsg;?></span>
</div>
	
<div class="jrc_chat_form_slide">
<div class="profile-spacer">
			
		<?php if ($errors) { ?>
			<div class="alert alert-danger"><?php if (isset($errors["name"])) echo $errors["name"]; if (isset($errors["email"])) echo $errors["email"];?></div>
		<?php } ?>
		
		<div class="jak-thankyou"></div>
				
		<!--- Chat Rating -->
		<form role="form" class="jak-ajaxform" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
			<?php if (JAK_CRATING) { ?>
					<div class="form-group text-center">
					    <label class="control-label text-small" for="vote5"><?php echo $jkl["g23"];?></label>
					    <div id="star-container">
					    	<i class="fa fa-thumbs-down fa-2x updown" id="updown-1"></i>
							<i class="fa fa-thumbs-up fa-2x updown thumb-up" id="updown-2"></i>
					    </div>
					    <input type="hidden" name="fbvote" id="fbvote" value="5">
					</div>
			<?php } ?>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
					    <label class="sr-only" for="name"><?php echo $jkl["g4"];?></label>
					    <input type="text" name="name" id="name" class="form-control underlined" value="<?php if (isset($_SESSION['jrc_name'])) echo $_SESSION['jrc_name'];?>" placeholder="<?php echo $jkl["g4"];?>">
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
					    <label class="sr-only" for="email"><?php echo $jkl["g5"];?></label>
					    <input type="email" name="email" id="email" class="form-control underlined" value="<?php if (isset($_SESSION['jrc_email'])) echo $_SESSION['jrc_email'];?>" placeholder="<?php echo $jkl["g5"];?>">
					</div>
				</div>
			</div>
					<div class="form-group">
					    <label class="sr-only" for="feedback"><?php echo $jkl["g24"];?></label>
					    <textarea name="message" id="feedback" rows="1" class="form-control underlined" placeholder="<?php echo $jkl["g24"];?>"></textarea>
					</div>
					
					<?php if (JAK_SEND_TSCRIPT == 1) { ?>
					
					<div class="checkbox text-small">
						<label>
							<input type="checkbox" name="send_email" id="send_email"> <?php echo $jkl["g38"];?>
						</label>
					</div>
					
					<?php } else { ?>
						<input type="hidden" name="send_email" value="0">
					<?php } ?>
					
					<button type="submit" class="btn btn-block btn-primary ls-submit"><?php echo $jkl["g25"];?></button>

					<input type="hidden" name="convid" value="<?php echo $fb[0];?>">
					<input type="hidden" name="send_feedback" value="1">
				
			</form>
			
	</div>
	<?php if (!empty(JAK_COPYRIGHT_LINK)) echo '<div class="copyright text-center">'.JAK_COPYRIGHT_LINK.'</div>';?>
</div>
</div>