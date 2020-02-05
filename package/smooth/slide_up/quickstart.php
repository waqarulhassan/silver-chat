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

<div class="live-chat-slideup-quickstart">
<div class="smooth-form">
  <header>
    <p><?php echo $headermsg;?></p>
  </header>
  <form class="jak-ajaxform" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
    <div class="input-container">
      <div class="input-section name-section">
      	<label class="sr-only" for="message"><?php echo $jkl["g6"];?></label>
        	<input class="message mandatory" type="text" name="message" id="message" value="<?php if (isset($_REQUEST["message"])) echo $_REQUEST["message"];?>" placeholder="<?php echo $jkl["g6"];?>" autocomplete="off">
        	<div class="animated-button"><span class="icon-message"><i class="fa fa-question"></i></span><span class="next-button message"><button type="submit"><i class="fa fa-comments-o"></i></button></span></div>
      </div>
    </div>

    <input type="hidden" name="start_chat" value="1">
	  <input type="hidden" name="slide_chat" value="<?php if (isset($page1)) echo $page1;?>">
	  <input type="hidden" name="lang" value="<?php if (isset($page2)) echo $page2;?>">
  </form>
</div>
</div>
<?php if (!empty(JAK_COPYRIGHT_LINK)) echo '<div class="copyright text-center">'.JAK_COPYRIGHT_LINK.'</div>';?>
</div>
