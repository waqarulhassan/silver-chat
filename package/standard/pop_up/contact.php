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
			<?php if (isset($_SESSION['chatbox_redirected'])) {
				echo '<p>'.$jkl["g64"].'</p>';
			} else {
				echo '<p>'.$headermsg.'</p>';
			}?>
		</div>
	</div>
	<hr>
	<div class="jrc_chat_form">

	<?php if ($jakwidget["whatsapp_offline"] == 1) { $online_oplist_whatsapp = online_operator_list_whatsapp($LC_DEPARTMENTS, $jakwidget['depid'], $jakwidget['opid']); ?>

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
		<div class="alert alert-danger"><?php if (isset($errors["name"])) echo $errors["name"];
			if (isset($errors["email"])) echo $errors["email"];
			if (isset($errors["message"])) echo $errors["message"];
			if (isset($USR_IP_BLOCKED)) echo $USR_IP_BLOCKED;?></div>
		<?php } ?>
		
				
		<?php if (isset($_SESSION['ls_msg_sent']) && $_SESSION['ls_msg_sent'] == 1) { ?>
			<div class="alert alert-success"><?php echo $jkl["g65"];?></div>
			<div class="text-center">
				<a href="javascript:window.close();" class="btn btn-primary"><?php echo $jkl["g3"];?></a>
			</div>
		
		<?php } ?>
		
		<div class="jak-thankyou"></div>
			
		<form role="form" class="jak-ajaxform" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>">
			
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label" for="name"><?php echo $jkl["g4"];?></label>
						<input type="text" name="name" id="name" class="form-control" placeholder="<?php echo $jkl["g4"];?>">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label" for="email"><?php echo $jkl["g5"];?></label>
						<input type="text" name="email" id="email" class="form-control" placeholder="<?php echo $jkl["g5"];?>">
					</div>
				</div>
			</div>
			<?php if ($jakwidget['client_sphone']) { ?>
			<div class="form-group">
				<label class="control-label" for="phone"><?php echo $jkl["g49"];?></label>
				<input type="text" name="phone" id="phone" class="form-control" placeholder="<?php echo $jkl["g49"];?>">
			</div>
			<?php } ?>
			<div class="form-group">
				<label class="control-label" for="contactmsg"><?php echo $jkl["g6"];?></label>
				<textarea name="message" id="contactmsg" rows="5" class="form-control"></textarea>
			</div>

			<?php if (!empty($jakwidget['dsgvo'])) { ?>
			<div class="form-group">
			    <div class="form-check">
			      <input class="form-check-input" type="checkbox" value="1" name="dsgvo" id="dsgvo">
			      <label class="form-check-label" for="dsgvo">
			        <?php echo $jakwidget['dsgvo'];?>
			      </label>
			    </div>
			</div>
		    <?php } ?>
				
			<button type="submit" class="btn btn-primary btn-block ls-submit"><?php echo $jkl["g7"];?></button>
				
			<input type="hidden" name="send_email" value="1">
			<input type="hidden" name="department" value="<?php if (isset($page3)) echo $page3;?>">
				
		</form>

		<?php } if (isset($jakhs['copyright']) && !empty($jakhs['copyright'])) echo '<div class="copyright text-center">'.$jakhs['copyright'].'</div>';?>
	</div>		
</div>