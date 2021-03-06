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
  <!-- Title -->
  <span><?php echo $jkl['g85'];?></span>
  <!-- Close Window -->
  <a href="<?php echo $chatstarturl;?>" class="btn btn-sm btn-secondary"><i class="fa fa-comments-o"></i></a>
  <a href="<?php echo $parseurl;?>" class="btn btn-sm btn-danger btn-confirm" data-title="<?php echo addslashes($jkl["g15"]);?>" data-text="<?php echo addslashes($jkl["g40"]);?>" data-type="" data-okbtn="<?php echo addslashes($jkl["g72"]);?>" data-cbtn="<?php echo addslashes($jkl["g73"]);?>"><i class="fa fa-power-off"></i></a>

</div>

<div class="jrc_chat_form_slide">
<div class="profile-spacer">

  <form class="jak-ajaxform" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">

    <?php if ($jakwidget['show_avatar']) { ?>
    <div class="container avatars">
      <div class="row text-center py-1 mb-3">
        <div class="col-4 tooltipwrap">
              <label>
                <span class="tooltip"><?php echo $jkl["g18"];?></span>
                  <input type="radio" name="avatar" value="/package/slideout/avatar/standard.jpg"<?php if (isset($_SESSION['jrc_avatar']) && $_SESSION['jrc_avatar'] == "/package/slideout/avatar/standard.jpg") echo ' checked';?>>
                  <img src="<?php echo BASE_URL;?>/package/slideout/avatar/standard.jpg" width="53" class="rounded img-fluid" alt="avatar">
                </label>
            </div>
            <div class="col-4">
              <label>
                  <input type="radio" name="avatar" value="/package/slideout/avatar/4.jpg"<?php if (isset($_SESSION['jrc_avatar']) && $_SESSION['jrc_avatar'] == "/package/slideout/avatar/4.jpg") echo ' checked';?>>
                  <img src="<?php echo BASE_URL;?>/package/slideout/avatar/4.jpg" width="53" class="rounded img-fluid" alt="avatar">
                </label>
            </div>
            <div class="col-4">
              <label>
                  <input type="radio" name="avatar" value="/package/slideout/avatar/2.jpg"<?php if (isset($_SESSION['jrc_avatar']) && $_SESSION['jrc_avatar'] == "/package/slideout/avatar/2.jpg") echo ' checked';?>>
                  <img src="<?php echo BASE_URL;?>/package/slideout/avatar/2.jpg" width="53" class="rounded img-fluid" alt="avatar">
                </label>
            </div>
          </div>
        <div class="row text-center avatars py-1">
            <div class="col-4">
              <label>
                  <input type="radio" name="avatar" value="/package/slideout/avatar/5.jpg"<?php if (isset($_SESSION['jrc_avatar']) && $_SESSION['jrc_avatar'] == "/package/slideout/avatar/5.jpg") echo ' checked';?>>
                  <img src="<?php echo BASE_URL;?>/package/slideout/avatar/5.jpg" width="53" class="rounded img-fluid" alt="avatar">
                </label>
            </div>
            <div class="col-4">
              <label>
                  <input type="radio" name="avatar" value="/package/slideout/avatar/3.jpg"<?php if (isset($_SESSION['jrc_avatar']) && $_SESSION['jrc_avatar'] == "/package/slideout/avatar/3.jpg") echo ' checked';?>>
                  <img src="<?php echo BASE_URL;?>/package/slideout/avatar/3.jpg" width="53" class="rounded img-fluid" alt="avatar">
                </label>
            </div>
            <div class="col-4">
              <label>
                  <input type="radio" name="avatar" value="/package/slideout/avatar/1.jpg"<?php if (isset($_SESSION['jrc_avatar']) && $_SESSION['jrc_avatar'] == "/package/slideout/avatar/1.jpg") echo ' checked';?>>
                  <img src="<?php echo BASE_URL;?>/package/slideout/avatar/1.jpg" width="53" class="rounded img-fluid" alt="avatar">
                </label>
            </div>
      </div>
  </div>
  <?php } ?>

    <div class="text-center">
          <div class="form-group">
              <label class="sr-only" for="name"><?php echo $jkl["g4"];?></label>
            <input type="text" name="name" id="name" class="form-control underlined" value="<?php if (isset($_SESSION['jrc_name'])) echo $_SESSION['jrc_name'];?>" placeholder="<?php echo $jkl["g4"];?>">
          </div>
          <div class="form-group">
              <label class="sr-only" for="email"><?php echo $jkl["g5"];?></label>
            <input type="<?php if ($jakwidget['client_email']) { echo 'email'; } else { echo 'text';}?>" name="email" id="email" class="form-control underlined" value="<?php if (isset($_SESSION['jrc_email'])) echo $_SESSION['jrc_email'];?>" placeholder="<?php echo $jkl["g5"];?>">
          </div>
          <div class="form-group">
              <label class="sr-only" for="phone"><?php echo $jkl["g49"];?></label>
            <input type="tel" name="phone" id="phone" class="form-control underlined" value="<?php if (isset($_SESSION['jrc_phone'])) echo $_SESSION["jrc_phone"];?>" placeholder="<?php echo $jkl["g49"];?>">
          </div>
      </div>
      
      <button type="submit" class="btn btn-block btn-primary ls-submit"><?php echo $jkl["g86"];?></button>
      <input type="hidden" name="edit_profile" value="1">
  </form>

<?php if (!empty(JAK_COPYRIGHT_LINK)) echo '<div class="copyright text-center">'.JAK_COPYRIGHT_LINK.'</div>';?>
</div>
</div>
</div>