<div class="navbar navbar-default">
	<div class="container">
    	<div class="navbar-header">
        	<a class="navbar-brand" href="<?php echo $_SERVER['REQUEST_URI'];?>"><?php echo $jkl["g"];?> - <?php echo JAK_TITLE;?></a>
    	</div>
	</div>
</div>

<!--- Container -->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php echo $headermsg;?>
		</div>
	</div>
	<hr>
	<div class="jrc_chat_form">

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
		
		<?php if ($errors) { ?>
		<div class="alert alert-danger"><?php if (isset($errors["name"])) echo $errors["name"]; if (isset($errors["email"])) echo $errors["email"]; if (isset($errors["phone"])) echo $errors["phone"]; if (isset($errors["question"])) echo $errors["question"];?></div>
		<?php } ?>
		
		<form class="jak-ajaxform" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
		
			<?php if ($jakwidget['show_avatar']) { ?>
			<label class="control-label" for="avatar"><?php echo $jkl["g18"];?></label>
			<div class="row text-center avatars px-3">
				<div class="col-2">
					<label>
						<input type="radio" name="avatar" id="avatar" value="/package/smooth/avatar/standard.jpg" checked>
						<img src="<?php echo BASE_URL;?>/package/smooth/avatar/standard.jpg" class="rounded img-fluid" alt="avatar standard">
					</label>
				</div>
				<div class="col-2">
					<label>
    					<input type="radio" name="avatar" value="/package/smooth/avatar/4.jpg">
    					<img src="<?php echo BASE_URL;?>/package/smooth/avatar/4.jpg" class="rounded img-fluid" alt="avatar4">
  					</label>
				</div>
				<div class="col-2">
					<label>
    					<input type="radio" name="avatar" value="/package/smooth/avatar/2.jpg">
    					<img src="<?php echo BASE_URL;?>/package/smooth/avatar/2.jpg" class="rounded img-fluid" alt="avatar2">
  					</label>
				</div>
				<div class="col-2">
					<label>
    					<input type="radio" name="avatar" value="/package/smooth/avatar/3.jpg">
    					<img src="<?php echo BASE_URL;?>/package/smooth/avatar/3.jpg" class="rounded img-fluid" alt="avatar3">
  					</label>
				</div>
				<div class="col-2">
					<label>
    					<input type="radio" name="avatar" value="/package/smooth/avatar/1.jpg">
    					<img src="<?php echo BASE_URL;?>/package/smooth/avatar/1.jpg" class="rounded img-fluid" alt="avatar">
  					</label>
				</div>
				<div class="col-2">
					<label>
						<input type="radio" name="avatar" value="/package/smooth/avatar/5.jpg">
						<img src="<?php echo BASE_URL;?>/package/smooth/avatar/5.jpg" class="rounded img-fluid" alt="avatar5">
					</label>
				</div>
			</div>
			<?php } ?>
			
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    <label class="control-label" for="name"><?php echo $jkl["g4"];?></label>
							<input type="text" name="name" id="name" class="form-control" value="<?php if (isset($_REQUEST["name"])) echo $_REQUEST["name"];?>" placeholder="<?php echo $jkl["g4"];?>">
					</div>
				</div>
			
			<?php if ($jakwidget['client_semail']) { ?>
			<div class="col-sm-6">
			<div class="form-group">
			    <label class="control-label" for="email"><?php echo $jkl["g5"];?></label>
				<input type="email" name="email" id="email" class="form-control" value="<?php if (isset($_REQUEST["email"])) echo $_REQUEST["email"];?>" placeholder="<?php echo $jkl["g5"];?>">
			</div>
			</div>
			<?php } if ($jakwidget['client_sphone']) { ?>
				<div class="col-sm-6">
			<div class="form-group">
			    <label class="control-label" for="phone"><?php echo $jkl["g49"];?></label>
				<input type="tel" name="phone" id="phone" class="form-control" value="<?php if (isset($_REQUEST["phone"])) echo $_REQUEST["phone"];?>" placeholder="<?php echo $jkl["g49"];?>">
			</div>
			</div>
			<?php } if ($opdirect == 0 && $dep_direct != 0 && is_numeric($dep_direct)) { ?>
				<input type="hidden" name="department" value="<?php echo $dep_direct;?>" />
			<?php } elseif ($opdirect == 0 && count($online_op) > 1) { ?>
				<div class="col-sm-6">
					<div class="form-group">
					    <label class="control-label" for="department"><?php echo $jkl["g30"];?></label>
						<select name="department" id="department" class="form-control">
							<?php foreach($online_op as $v) { if (in_array($v["id"], explode(',', $jakwidget["depid"])) || $jakwidget["depid"] == 0) { ?><option value="<?php echo $v["id"];?>"<?php if (isset($_REQUEST["department"]) && $_REQUEST["department"] == $v["id"]) { ?> selected="selected"<?php } ?>><?php echo $v["title"];?></option><?php } } ?>
							</select>
					</div>
				</div>
			<?php } else { ?>
				<input type="hidden" name="department" value="<?php echo $online_op[0]["id"];?>">
				<input type="hidden" name="opdirect" value="<?php echo $opdirect;?>">
			<?php } ?>
			
			</div>
			<?php if ($jakwidget['client_squestion']) { ?>
			<div class="form-group">
			    <label class="control-label" for="question"><?php echo $jkl["g71"];?></label>
				<input type="text" name="question" id="question" class="form-control" value="<?php if (isset($_REQUEST["question"])) echo $_REQUEST["question"];?>" placeholder="<?php echo $jkl["g71"];?>" autocomplete="off">
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
			
			<p><button type="submit" class="btn btn-primary btn-block ls-submit"><?php echo $jkl["g10"];?></button></p>
			
			<input type="hidden" name="start_chat" value="1">
			<input type="hidden" name="slide_chat" value="<?php if (isset($page1)) echo $page1;?>">
			<input type="hidden" name="lang" value="<?php if (isset($page2)) echo $page2;?>">
			
		</form>

		<?php } if (isset($jakhs['copyright']) && !empty($jakhs['copyright'])) echo '<div class="copyright text-center">'.$jakhs['copyright'].'</div>';?>
	</div>
</div>