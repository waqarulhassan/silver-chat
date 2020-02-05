<?php

// Get the font for the title
$titlefont = $backgroundc = $theme = $slideimg = $fontcolor = "";
if (isset($jakwidget['t_font']) && !empty($jakwidget['t_font'])) $titlefont = 'font-family:'.$jakwidget['t_font'].';';
if (isset($jakwidget['sucolor']) && !empty($jakwidget['sucolor'])) $backgroundc = 'background:'.$jakwidget['sucolor'].';';
if (isset($jakwidget["sutcolor"]) && !empty($jakwidget["sutcolor"])) $fontcolor = 'color:'.$jakwidget["sutcolor"].';';
if (isset($jakwidget['theme_colour']) && !empty($jakwidget['theme_colour'])) $theme = " ".$jakwidget['theme_colour'];

?>

<div id="lcjframesize" class="live-chat-engage-container animated">

<div id="success-box">
	<div class="icon">
		<?php echo ($_SESSION["engage"]["imgurl"] ? '<img src="'.$_SESSION["engage"]["imgurl"].'" alt="engage_img" class="img-fluid">' : '<i class="material-icons">'.$_SESSION["engage"]["imgpath"].'</i>');?>
		
	</div>
    <div class="message"><?php echo ($_SESSION["engage"]["title"] ? '<h1 class="alert">'.$_SESSION["engage"]["title"].'</h1>' : '');?><p><?php echo $_SESSION["engage"]["message"];?></p></div>
    <a href="<?php echo $backtobtn;?>" class="btn button-box red"><?php echo ($_SESSION["engage"]["nobtn"] ? $_SESSION["engage"]["nobtn"] : $jkl['g73']);?></a>
    <a<?php echo ($jakwidget['widget'] == 5 ? ' href="javascript:void(0)" onclick="if(navigator.userAgent.toLowerCase().indexOf(\'opera\') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open(\''.$chatstarturlpop.'\', \'livechat3_popup_window\', \'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=780,height=600,resizable=1\');this.newWindow.focus();lcjak_closeEngage(\''.$backtobtn.'\');"' : ' href="'.$chatstarturl.'"');?> class="btn button-box1 green"><?php echo ($_SESSION["engage"]["yesbtn"] ? $_SESSION["engage"]["yesbtn"] : $jkl['g72']);?></a>
  </div>

</div>