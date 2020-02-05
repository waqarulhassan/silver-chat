<?php

// Get the font for the title
$titlefont = $backgroundc = $theme = $slideimg = $fontcolor = "";
if (isset($jakwidget['t_font']) && !empty($jakwidget['t_font'])) $titlefont = 'font-family:'.$jakwidget['t_font'].';';
if (isset($jakwidget['sucolor']) && !empty($jakwidget['sucolor'])) $backgroundc = 'background:'.$jakwidget['sucolor'].';';
if (isset($jakwidget["sutcolor"]) && !empty($jakwidget["sutcolor"])) $fontcolor = 'color:'.$jakwidget["sutcolor"].';';
if (isset($jakwidget['theme_colour']) && !empty($jakwidget['theme_colour'])) $theme = " ".$jakwidget['theme_colour'];

$online_oplist = array();
// Get the online operators
if (isset($_SESSION["select_operator"]) && is_numeric($_SESSION["select_operator"])) {
	// Get the selcted operator
	$selop = $jakdb->get("user", ["departments", "name", "picture"], ["id" => $_SESSION["select_operator"]]);
	$dep_title = '-';
	if ($selop["departments"] != 0 && is_numeric($selop["departments"])) {
		foreach ($LC_DEPARTMENTS as $d) {
			if ($selop["departments"] == $d["id"]) {
				$dep_title = $d['title'];
				$dep_direct = $selop["departments"];
				break;
			}
		}
	}

} else {
	if (isset($_SESSION['widgetid'])) $online_oplist = online_operator_list($LC_DEPARTMENTS, $jakwidget['depid'], $jakwidget['opid']);
}

?>

<div id="lcjframesize" class="live-chat-start-container animated">

<div class="lcj-chat-header <?php echo $jakwidget['theme_colour'];?>" style="<?php echo $titlefont.$backgroundc.$fontcolor;?>"><span class="lcj-sprite lcj-sprite-logo"></span><div class="lcj-title"><?php echo $jakwidget['title'];?></div><a href="javascript:void(0)" class="lcj-sprite lcj-sprite-popup" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('<?php echo ($online_op ? $chatstarturlpop : $chatcontacturlpop);?>', 'livechat3_popup_window', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=780,height=600,resizable=1');this.newWindow.focus();this.newWindow.opener=window;lcjak_popupChat('<?php echo $chatcloseurl;?>');return false;"></a> <a href="<?php echo $chatcloseurl;?>" class="lcj-sprite lcj-sprite-close"></a>
</div>

<?php if (isset($headermsg) && !empty($headermsg) && !isset($_SESSION["select_operator"])) { ?>
<div class="jrc_chat_header <?php echo $jakwidget['theme_colour'];?>">
	<!-- Display Operator Name -->
	<span><?php echo $headermsg;?></span>
</div>
<?php } ?>

<div class="jrc_chat_form_slide">
<div class="profile-spacer">

	<?php if ($jakwidget["whatsapp_online"] == 1) { $online_oplist_whatsapp = online_operator_list_whatsapp($HD_DEPARTMENTS, $jakwidget['depid'], $jakwidget['opid']); ?>

		<?php if (isset($online_oplist_whatsapp) && !empty($online_oplist_whatsapp)) foreach ($online_oplist_whatsapp as $o) { ?>

			<?php echo ($o["isonline"] ? '<a href="https://wa.me/'.$o["whatsappnumber"].'?text='.urlencode($jakwidget["whatsapp_message"]).'" data-number="'.$o["whatsappnumber"].'" data-auto-text="'.$jakwidget["whatsapp_message"].'" target="_blank">' : '');?>
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

	<?php if (($jakwidget['widget'] == 3 || $jakwidget['widget'] == 4) && !isset($_SESSION["select_operator"])) { ?>

	<?php if (isset($online_oplist) && !empty($online_oplist)) foreach ($online_oplist as $o) { ?>

	<div class="oplist" onclick="lcjak_slideout_operator(<?php echo $o['id'];?>, '<?php echo $_SERVER['REQUEST_URI'];?>');return false;">
		<img src="<?php echo BASE_URL.JAK_FILES_DIRECTORY.'/'.$o['picture'];?>" alt="<?php echo $o['name'];?>" class="user-image">
		<h6><?php echo $o['name'];?></h6>
		<small class="text-muted"><?php echo ($o['title'] ? $o['title'] : '-');?></small>
		<small class="text-muted c-orange"><i class="fa fa-thumbs-o-up"></i> <?php echo $o['sum'] ? $o['sum'] : '-';?></small>
	</div>
	<div class="clearfix"></div>
	<hr>

	<?php } ?>

	<?php } else { if (isset($selop) && !empty($selop)) { ?>

	<div class="oplist remove" onclick="lcjak_slideout_operator(0, '<?php echo $_SERVER['REQUEST_URI'];?>');return false;">
		<img src="<?php echo BASE_URL.JAK_FILES_DIRECTORY.'/'.$selop['picture'];?>" alt="<?php echo $selop['name'];?>" class="user-image">
		<h6><?php echo $selop['name'];?></h6>
		<small class="text-muted"><?php echo $dep_title;?></small>
		<small class="text-muted"><?php echo $jkl['g33'];?></small>
	</div>
	<div class="clearfix"></div>
	<hr>
		
	<?php } if ($errors) { ?>
	<div class="alert alert-danger"><?php if (isset($errors["name"])) echo $errors["name"]; if (isset($errors["email"])) echo $errors["email"]; if (isset($errors["phone"])) echo $errors["phone"]; if (isset($errors["question"])) echo $errors["question"];?></div>
	<?php } ?>
		
	<form class="jak-ajaxform" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">

		<?php if ($jakwidget['show_avatar']) { ?>
			<label class="sr-only" for="avatar"><?php echo $jkl["g18"];?></label>
			<div class="container">
			<div class="row text-center avatars py-1">
				<div class="col-4 tooltipwrap">
					<label>
						<span class="tooltip"><?php echo $jkl["g18"];?></span>
    					<input type="radio" name="avatar" value="/package/slideout/avatar/standard.jpg" checked>
    					<img src="<?php echo BASE_URL;?>/package/slideout/avatar/standard.jpg" class="rounded img-fluid" width="53" alt="avatar">
  					</label>
				</div>
				<div class="col-4">
					<label>
    					<input type="radio" name="avatar" value="/package/slideout/avatar/4.jpg">
    					<img src="<?php echo BASE_URL;?>/package/slideout/avatar/4.jpg" class="rounded img-fluid" width="53" alt="avatar">
  					</label>
				</div>
				<div class="col-4">
					<label>
    					<input type="radio" name="avatar" value="/package/slideout/avatar/2.jpg">
    					<img src="<?php echo BASE_URL;?>/package/slideout/avatar/2.jpg" class="rounded img-fluid" width="53" alt="avatar">
  					</label>
				</div>
			</div>
			<div class="row text-center avatars py-1">
				<div class="col-4">
					<label>
    					<input type="radio" name="avatar" value="/package/slideout/avatar/5.jpg">
    					<img src="<?php echo BASE_URL;?>/package/slideout/avatar/5.jpg" class="rounded img-fluid" width="53" alt="avatar">
  					</label>
				</div>
				<div class="col-4">
					<label>
    					<input type="radio" name="avatar" value="/package/slideout/avatar/3.jpg">
    					<img src="<?php echo BASE_URL;?>/package/slideout/avatar/3.jpg" class="rounded img-fluid" width="53" alt="avatar">
  					</label>
				</div>
				<div class="col-4">
					<label>
    					<input type="radio" name="avatar" value="/package/slideout/avatar/1.jpg">
    					<img src="<?php echo BASE_URL;?>/package/slideout/avatar/1.jpg" class="rounded img-fluid" width="53" alt="avatar">
  					</label>
				</div>
			</div>
			</div>
			<?php } ?>
			
			<div class="row text-center">
				<div class="col-12">
					<div class="form-group">
					    <label class="sr-only" for="name"><?php echo $jkl["g4"];?></label>
						<input type="text" name="name" id="name" class="form-control underlined" value="<?php if (isset($_REQUEST["name"])) echo $_REQUEST["name"];?>" placeholder="<?php echo $jkl["g4"];?>">
					</div>
					<?php if ($jakwidget['client_semail']) { ?>
					<div class="form-group">
					    <label class="sr-only" for="email"><?php echo $jkl["g5"];?></label>
						<input type="email" name="email" id="email" class="form-control underlined" value="<?php if (isset($_REQUEST["email"])) echo $_REQUEST["email"];?>" placeholder="<?php echo $jkl["g5"];?>">
					</div>
					<?php } ?>
					<?php if ($jakwidget['client_sphone']) { ?>
					<div class="form-group">
					    <label class="sr-only" for="phone"><?php echo $jkl["g49"];?></label>
						<input type="tel" name="phone" id="phone" class="form-control underlined" value="<?php if (isset($_REQUEST["phone"])) echo $_REQUEST["phone"];?>" placeholder="<?php echo $jkl["g49"];?>">
					</div>
					<?php } ?>
					<?php if ($opdirect == 0 && $dep_direct != 0 && is_numeric($dep_direct)) { ?>
					<input type="hidden" name="department" value="<?php echo $dep_direct;?>">
					<?php } elseif ($opdirect == 0 && count($online_op) > 1) { ?>
					<div class="form-group">
						<label class="sr-only" for="department"><?php echo $jkl["g30"];?></label>
						<select name="department" id="department" class="form-control underlined">
								<?php foreach($online_op as $v) { if (in_array($v["id"], explode(',', $jakwidget["depid"])) || $jakwidget["depid"] == 0) { ?><option value="<?php echo $v["id"];?>"<?php if (isset($_REQUEST["department"]) && $_REQUEST["department"] == $v["id"]) { ?> selected="selected"<?php } ?>><?php echo $v["title"];?></option><?php } } ?>
						</select>
					</div>
					<?php } else { ?>
					<input type="hidden" name="department" value="<?php echo $online_op[0]["id"];?>">
					<input type="hidden" name="opdirect" value="<?php echo $opdirect;?>">
					<?php } ?>
				</div>
			</div>
			<?php if ($jakwidget['client_squestion']) { ?>
			<div class="form-group">
			    <label class="sr-only" for="question"><?php echo $jkl["g71"];?></label>
				<input type="text" name="question" id="question" class="form-control underlined" value="<?php if (isset($_REQUEST["question"])) echo $_REQUEST["question"];?>" placeholder="<?php echo $jkl["g71"];?>" autocomplete="off">
			</div>
			
			<?php } if (!empty($jakwidget['dsgvo'])) { ?>
			<div class="form-group">
			    <div class="form-check">
			      <input class="form-check-input" type="checkbox" value="1" name="dsgvo" id="dsgvo">
			      <label class="form-check-label" for="dsgvo">
			        <?php echo $jakwidget['dsgvo'];?>
			      </label>
			    </div>
			</div>
		    <?php } ?>
			
			<button type="submit" class="btn btn-block btn-primary ls-submit"><?php echo $jkl["g10"];?></button>
			
			<input type="hidden" name="start_chat" value="1">
			<input type="hidden" name="slide_chat" value="<?php if (isset($page1)) echo $page1;?>">
			<input type="hidden" name="lang" value="<?php if (isset($page2)) echo $page2;?>">
			<input type="hidden" name="opdirect" value="<?php if (isset($_SESSION["select_operator"])) echo $_SESSION["select_operator"];?>">
			
		</form>

		<?php } } if (!empty(JAK_COPYRIGHT_LINK)) echo '<div class="copyright text-center">'.JAK_COPYRIGHT_LINK.'</div>';?>
		
	</div>
</div>
</div>