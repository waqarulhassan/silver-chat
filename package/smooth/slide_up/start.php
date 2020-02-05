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

<div class="live-chat-slideup-start">
<div class="smooth-form">
  <header>
    <p><?php echo $headermsg;?></p>
  </header>

  <?php if ($jakwidget["whatsapp_online"] == 1) { $online_oplist_whatsapp = online_operator_list_whatsapp($LC_DEPARTMENTS, $jakwidget['depid'], $jakwidget['opid']); ?>

    <?php if (isset($online_oplist_whatsapp) && !empty($online_oplist_whatsapp)) foreach ($online_oplist_whatsapp as $o) { ?>

      <?php echo ($o["isonline"] ? '<a href="'.(isset($_SESSION["clientismobile"]) ? 'https://api.whatsapp.com/send?phone=' : 'https://web.whatsapp.com/send?phone=').$o["whatsappnumber"].'&amp;text='.urlencode($jakwidget["whatsapp_message"]).'" data-number="'.$o["whatsappnumber"].'" data-auto-text="'.$jakwidget["whatsapp_message"].'" target="_blank">' : '');?>
      <div class="media whatsapp_list">
        <div class="avatar_wpc">
          <img src="<?php echo BASE_URL.JAK_FILES_DIRECTORY.'/'.$o['picture'];?>" alt="<?php echo $o['name'];?>" width="60" class="align-self-start mr-3 rounded-circle">
          <img src="<?php echo BASE_URL;?>img/whatsapp_<?php echo ($o["isonline"] ? 'on' : 'off');?>.png" alt="whatsapp_<?php echo ($o["isonline"] ? 'online' : 'offline');?>" class="avatar_whatsapp">
        </div>
        <div class="media-body">
          <h6 class="mt-1 mb-0"><?php echo $o['name'];?></h6>
          <p><small class="text-muted"><?php echo ($o['title'] ? $o['title'] : $jkl['g88']);?></small></p>
        </div>
      </div>
      <?php echo ($o["isonline"] ? '</a>' : '');?>

    <?php } ?>

  <?php } else { ?>

  <form class="jak-ajaxform" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">

    <?php if ($jakwidget['show_avatar']) { ?>
    <div class="container avatars">
  <div class="row text-center py-1">
    <div class="col-2 tooltipwrap">
          <label>
            <span class="tooltip"><?php echo $jkl["g18"];?></span>
              <input type="radio" name="avatar" value="/package/smooth/avatar/standard.jpg" checked>
              <img src="<?php echo BASE_URL;?>/package/smooth/avatar/standard.jpg" class="rounded img-fluid" width="53" alt="avatar">
            </label>
        </div>
        <div class="col-2">
          <label>
              <input type="radio" name="avatar" value="/package/smooth/avatar/4.jpg">
              <img src="<?php echo BASE_URL;?>/package/smooth/avatar/4.jpg" class="rounded img-fluid" width="53" alt="avatar">
            </label>
        </div>
        <div class="col-2">
          <label>
              <input type="radio" name="avatar" value="/package/smooth/avatar/2.jpg">
              <img src="<?php echo BASE_URL;?>/package/smooth/avatar/2.jpg" class="rounded img-fluid" width="53" alt="avatar">
            </label>
        </div>
        <div class="col-2">
          <label>
              <input type="radio" name="avatar" value="/package/smooth/avatar/5.jpg">
              <img src="<?php echo BASE_URL;?>/package/smooth/avatar/5.jpg" class="rounded img-fluid" width="53" alt="avatar">
            </label>
        </div>
        <div class="col-2">
          <label>
              <input type="radio" name="avatar" value="/package/smooth/avatar/3.jpg">
              <img src="<?php echo BASE_URL;?>/package/smooth/avatar/3.jpg" class="rounded img-fluid" width="53" alt="avatar">
            </label>
        </div>
        <div class="col-2">
          <label>
              <input type="radio" name="avatar" value="/package/smooth/avatar/1.jpg">
              <img src="<?php echo BASE_URL;?>/package/smooth/avatar/1.jpg" class="rounded img-fluid" width="53" alt="avatar">
            </label>
        </div>
  </div>
  </div>
  <?php } ?>

  <?php if (!empty($jakwidget['dsgvo'])) { ?>
    <div class="container dsgvo">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="1" name="dsgvo" id="dsgvo" checked>
          <label class="form-check-label" for="dsgvo">
            <?php echo $jakwidget['dsgvo'];?>
          </label>
        </div>
    </div>
  <?php } ?>

  <div class="input-container">
  <?php if ($opdirect == 0 && $dep_direct != 0 && is_numeric($dep_direct)) { ?>
  <input type="hidden" name="department" value="<?php echo $dep_direct;?>">
  <?php $singlecon = true; } elseif ($opdirect == 0 && count($online_op) > 1) { ?>
  <div class="input-section department-section">
    <label class="sr-only" for="department"><?php echo $jkl["g30"];?></label>
    <select name="department" id="department">
    <?php foreach($online_op as $v) { if (in_array($v["id"], explode(',', $jakwidget["depid"])) || $jakwidget["depid"] == 0) { ?><option value="<?php echo $v["id"];?>"<?php if (isset($_REQUEST["department"]) && $_REQUEST["department"] == $v["id"]) { ?> selected="selected"<?php } ?>><?php echo $v["title"];?></option><?php } } ?>
    </select>
    <div class="animated-button"><span class="icon-department next"><i class="fa fa-university"></i></span><span class="next-button department"><i class="fa fa-arrow-right"></i></span></div>
  </div>
  <?php $singlecon = false; } else { ?>
  <input type="hidden" name="department" value="<?php echo $online_op[0]["id"];?>">
  <input type="hidden" name="opdirect" value="<?php echo $opdirect;?>">
  <?php $singlecon = true; } ?>

    <div class="input-section name-section<?php if (!$singlecon) echo ' folded';?>">
      <label class="sr-only" for="name"><?php echo $jkl["g4"];?></label>
        <input class="name" type="text" name="name" id="name" value="<?php if (isset($_REQUEST["name"])) echo $_REQUEST["name"];?>" placeholder="<?php echo $jkl["g4"];?>" autocomplete="off">
        <div class="animated-button"><span class="icon-name"><i class="fa fa-user"></i></span><span class="next-button name"><i class="fa fa-arrow-right"></i></span></div>
    </div>
    <?php if ($jakwidget['client_semail']) { ?>
    <div class="input-section email-section folded">
      <label class="sr-only" for="email"><?php echo $jkl["g5"];?></label>
        <input class="email<?php if ($jakwidget['client_email']) echo ' mandatory';?>" type="email" name="email" id="email" value="<?php if (isset($_REQUEST["email"])) echo $_REQUEST["email"];?>" placeholder="<?php echo $jkl["g5"];?>">
        <div class="animated-button"><span class="icon-email<?php if (!$jakwidget['client_email']) echo ' next';?>"><i class="fa fa-envelope-o"></i></span><span class="next-button email"><i class="fa fa-arrow-right"></i></span></div>
    </div>
    <?php } if ($jakwidget['client_sphone']) { ?>
    <div class="input-section phone-section folded">
      <label class="sr-only" for="phone"><?php echo $jkl["g49"];?></label>
        <input class="phone<?php if ($jakwidget['client_phone']) echo ' mandatory';?>" type="tel" name="phone" id="phone" value="<?php if (isset($_REQUEST["phone"])) echo $_REQUEST["phone"];?>" placeholder="<?php echo $jkl["g49"];?>">
        <div class="animated-button"><span class="icon-phone<?php if (!$jakwidget['client_phone']) echo ' next';?>"><i class="fa fa-phone"></i></span><span class="next-button phone"><i class="fa fa-arrow-right"></i></span></div>
    </div>
    <?php } if ($jakwidget['client_squestion']) { ?>
    <div class="input-section question-section folded">
      <label class="sr-only" for="question"><?php echo $jkl["g71"];?></label>
        <input class="question<?php if ($jakwidget['client_question']) echo ' mandatory';?>" type="text" name="question" id="question" value="<?php if (isset($_REQUEST["question"])) echo $_REQUEST["question"];?>" placeholder="<?php echo $jkl["g71"];?>" autocomplete="off">
        <div class="animated-button"><span class="icon-question<?php if (!$jakwidget['client_question']) echo ' next';?>"><i class="fa fa-question"></i></span><span class="next-button question"><i class="fa fa-comments-o"></i></span></div>
    </div>
    <?php } ?>
    </div>

    <input type="hidden" name="start_chat" value="1">
    <input type="hidden" name="slide_chat" value="<?php if (isset($page1)) echo $page1;?>">
    <input type="hidden" name="lang" value="<?php if (isset($page2)) echo $page2;?>">
  </form>
</div>
<?php } if (!empty(JAK_COPYRIGHT_LINK)) echo '<div class="copyright text-center">'.JAK_COPYRIGHT_LINK.'</div>';?>
</div>
</div>