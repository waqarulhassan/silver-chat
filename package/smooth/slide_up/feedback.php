<?php

// Get the font for the title
$titlefont = $backgroundc = $theme = $slideimg = $fontcolor = "";
if (isset($jakwidget['t_font']) && !empty($jakwidget['t_font'])) $titlefont = 'font-family:'.$jakwidget['t_font'].';';
if (isset($jakwidget['sucolor']) && !empty($jakwidget['sucolor'])) $backgroundc = 'background:'.$jakwidget['sucolor'].';';
if (isset($jakwidget["sutcolor"]) && !empty($jakwidget["sutcolor"])) $fontcolor = 'color:'.$jakwidget["sutcolor"].';';
if (isset($jakwidget['theme_colour']) && !empty($jakwidget['theme_colour'])) $theme = " ".$jakwidget['theme_colour'];

?>

<div id="lcjframesize" class="live-chat-start-container <?php echo $jakwidget['theme_colour'];?> animated">

<div class="lcj-start-header">
  <div class="lcj-chat-header" style="<?php echo $titlefont.$backgroundc.$fontcolor;?>"><?php echo $jakwidget['title'];?></div> <a href="javascript:void(0)" class="btn-circle" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('<?php echo ($online_op ? $chatstarturlpop : $chatcontacturlpop);?>', 'livechat3_popup_window', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=780,height=600,resizable=1');this.newWindow.focus();this.newWindow.opener=window;lcjak_popupChat('<?php echo $chatcloseurl;?>');return false;"><i class="fa fa-window-maximize"></i></a> <a href="<?php echo $chatcloseurl;?>" class="btn-circle"><i class="fa fa-times"></i></a>
</div>

<div class="live-chat-slideup-feedback">
<div class="smooth-form">
  	<header>
    	<p><?php echo $headermsg;?></p>
  	</header>
  	<?php if ($errors) { ?>
		<div class="alert alert-danger"><?php if (isset($errors["name"])) echo $errors["name"]; if (isset($errors["email"])) echo $errors["email"];?></div>
	<?php } ?>
		
	<div class="jak-thankyou"></div>
  	<form class="jak-ajaxform" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">

  	<?php if (JAK_CRATING) { ?>
  	<div class="container star-rating">
  		<div class="row text-center py-1">
  			<div class="col">
			<label class="control-label text-small" for="vote5"><?php echo $jkl["g23"];?></label>
			<div id="star-container">
				<i class="fa fa-star fa-2x star star-checked" id="star-1"></i>
				<i class="fa fa-star fa-2x star star-checked" id="star-2"></i>
				<i class="fa fa-star fa-2x star star-checked" id="star-3"></i>
				<i class="fa fa-star fa-2x star star-checked" id="star-4"></i>
				<i class="fa fa-star fa-2x star star-checked" id="star-5"></i>
			</div>
			<input type="hidden" name="fbvote" id="fbvote" value="5">
			</div>
		</div>
	</div>
	<?php } ?>

	<?php if (JAK_SEND_TSCRIPT == 1) { ?>
	<div class="container send-transcript">	
		<div class="row text-center py-1">
  			<div class="col">
  				<label class="custom-control custom-checkbox">
  					<input type="checkbox" class="custom-control-input" name="send_email">
					<input type="checkbox" class="custom-control-input">
				    <span class="custom-control-indicator"></span>
				    <span class="custom-control-description"><?php echo $jkl["g38"];?></span>
				</label>
			</div>
		</div>
	</div>		
	<?php } else { ?>
		<input type="hidden" name="send_email" value="0">
	<?php } ?>

	<div class="input-container">
	    <div class="input-section name-section">
	    	<label class="sr-only" for="name"><?php echo $jkl["g4"];?></label>
	      	<input class="name" type="text" name="name" id="name" value="<?php if (isset($_SESSION['jrc_name'])) echo $_SESSION['jrc_name'];?>" placeholder="<?php echo $jkl["g4"];?>" autocomplete="off">
	      	<div class="animated-button"><span class="icon-name next"><i class="fa fa-user"></i></span><span class="next-button name"><i class="fa fa-arrow-right"></i></span></div>
	    </div>
	    <div class="input-section email-section folded">
	    	<label class="sr-only" for="email"><?php echo $jkl["g5"];?></label>
	      	<input class="email" type="email" name="email" id="email" value="<?php if (isset($_SESSION['jrc_email'])) echo $_SESSION['jrc_email'];?>" placeholder="<?php echo $jkl["g5"];?>">
	      	<div class="animated-button"><span class="icon-email next"><i class="fa fa-envelope-o"></i></span><span class="next-button email"><i class="fa fa-arrow-right"></i></span></div>
	    </div>
	    <div class="input-section question-section folded">
	    	<label class="sr-only" for="question"><?php echo $jkl["g24"];?></label>
	      	<input class="question" type="text" name="message" id="question" value="<?php if (isset($_REQUEST["message"])) echo $_REQUEST["message"];?>" placeholder="<?php echo $jkl["g24"];?>">
	      	<div class="animated-button"><span class="icon-question next"><i class="fa fa-commenting-o"></i></span><span class="next-button question"><i class="fa fa-paper-plane"></i></span></div>
	    </div>
    </div>

    <input type="hidden" name="convid" value="<?php echo $fb[0];?>">
	<input type="hidden" name="send_feedback" value="1">
  </form>
</div>
</div>
<?php if (!empty(JAK_COPYRIGHT_LINK)) echo '<div class="copyright text-center">'.JAK_COPYRIGHT_LINK.'</div>';?>
</div>