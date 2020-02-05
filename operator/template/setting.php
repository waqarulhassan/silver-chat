<?php include_once 'header.php';?>

<?php if ($errors) { ?>
<div class="alert alert-danger">
<?php if (isset($errors["e"])) echo $errors["e"];
	  if (isset($errors["e1"])) echo $errors["e1"];
	  if (isset($errors["e2"])) echo $errors["e2"];
	  if (isset($errors["e3"])) echo $errors["e3"];
	  if (isset($errors["e4"])) echo $errors["e4"];
	  if (isset($errors["e5"])) echo $errors["e5"];
	  if (isset($errors["e6"])) echo $errors["e6"];
	  if (isset($errors["e7"])) echo $errors["e7"];?>
</div>
<?php } if ($success) { ?>
<div class="alert alert-success">
	<?php if (isset($success["e"])) echo $success["e"];?>
</div>
<?php } ?>
<form method="post" class="jak_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["g15"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td><?php echo $jkl["g16"];?></td>
			<td><input type="text" name="jak_title" class="form-control" value="<?php echo JAK_TITLE;?>" placeholder="<?php echo $jkl["g16"];?>"></td>
		</tr>
		<tr>
			<td><?php echo $jkl["l5"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></td>
			<td>
			<div class="form-group">
				<input type="text" name="jak_email" class="form-control<?php if (isset($errors["e1"])) echo " is-invalid";?>" value="<?php echo JAK_EMAIL;?>" placeholder="<?php echo $jkl["l5"];?>">
			</div>
			</td>
		</tr>
		<tr>
			<td><?php echo $jkl["g201"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h16"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></td>
			<td>
			<input type="text" name="jak_emailcc" class="form-control" value="<?php echo JAK_EMAILCC;?>" placeholder="<?php echo $jkl["l5"];?>">
			</td>
		</tr>
		<tr>
			<td><?php echo $jkl["g303"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_holidaym" value="0"<?php if (JAK_HOLIDAY_MODE == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g304"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_holidaym" value="1"<?php if (JAK_HOLIDAY_MODE == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g1"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_holidaym" value="2"<?php if (JAK_HOLIDAY_MODE == 2) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g305"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g242"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_showip" value="1"<?php if (JAK_SHOW_IPS == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_showip" value="0"<?php if (JAK_SHOW_IPS == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g92"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_rating" value="1"<?php if (JAK_CRATING == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_rating" value="0"<?php if (JAK_CRATING == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g234"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_trans" value="1"<?php if (JAK_SEND_TSCRIPT == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_trans" value="0"<?php if (JAK_SEND_TSCRIPT == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g119"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_captcha" value="1"<?php if (JAK_CAPTCHA == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_captcha" value="0"<?php if (JAK_CAPTCHA == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g266"];?></td>
			<td><div class="radio">
			<label><input type="radio" name="jak_openop" value="1"<?php if (JAK_OPENOP == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label>
			</div>
			<div class="radio">
			<label><input type="radio" name="jak_openop" value="0"<?php if (JAK_OPENOP == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label>
			</div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g327"];?></td>
			<td><input type="number" name="jak_proactive_time" class="form-control" min="1" max="30" step="1" value="<?php echo JAK_PROACTIVE_TIME;?>"></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g253"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h18"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></td>
			<td><input type="number" name="jak_user_left" class="form-control" min="30" max="1800" step="1" value="<?php echo JAK_CLIENT_LEFT;?>"></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g254"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h18"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></td>
			<td><input type="number" name="jak_user_expired" class="form-control" min="120" max="2000" step="1" value="<?php echo JAK_CLIENT_EXPIRED;?>"></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g311"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h12"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></td>
			<td><input type="number" name="jak_pushrem" class="form-control" min="30" max="300" step="1" value="<?php echo JAK_PUSH_REMINDER;?>"></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g22"];?></td>
			<td><select name="jak_lang" class="selectpicker form-control" data-live-search="true" data-size="4">
			<?php if (isset($lang_files) && is_array($lang_files)) foreach($lang_files as $lf) { ?><option value="<?php echo $lf;?>"<?php if (JAK_LANG == $lf) { ?> selected="selected"<?php } ?>><?php echo ucwords($lf);?></option><?php } ?>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g23"];?></td>
			<td>
			<div class="form-group">
				<input type="text" name="jak_date" class="form-control<?php if (isset($errors["e2"])) echo " is-invalid";?>" value="<?php echo JAK_DATEFORMAT;?>">
			</div>
			</td>
		</tr>
		<tr>
			<td><?php echo $jkl["g24"];?></td>
			<td>
			<div class="form-group">
				<input type="text" name="jak_time" class="form-control<?php if (isset($errors["e3"])) echo " is-invalid";?>" value="<?php echo JAK_TIMEFORMAT?>">
			</div>
			</td>
		</tr>
		<tr>
			<td><?php echo $jkl["g25"];?></td>
			<td><select name="jak_timezone_server" class="selectpicker form-control" data-live-search="true" data-size="4">
			<?php include_once "timezoneserver.php";?>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g109"];?></td>
			<td><input type="text" name="allowed_files" class="form-control" value="<?php echo ($jakhs['hostactive'] ? $jakhs['filetype'] : JAK_ALLOWED_FILES);?>" placeholder=".zip,.rar,.jpg,.jpeg,.png,.gif"<?php if ($jakhs['hostactive']) echo " readonly";?>></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g128"];?></td>
			<td><input type="text" name="allowedo_files" class="form-control" value="<?php echo ($jakhs['hostactive'] ? $jakhs['filetypeo'] : JAK_ALLOWEDO_FILES);?>" placeholder=".zip,.rar,.jpg,.jpeg,.png,.gif"<?php if ($jakhs['hostactive']) echo " readonly";?>></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g44"];?></td>
			<td>
			<div class="row">
			<div class="col-md-6">
			<input type="text" name="jak_avatwidth" class="form-control" value="<?php echo JAK_USERAVATWIDTH;?>" placeholder="<?php echo $jkl["g42"];?>">
			</div>
			<div class="col-md-6">
			<input type="text" name="jak_avatheight" class="form-control" value="<?php echo JAK_USERAVATHEIGHT;?>" placeholder="<?php echo $jkl["g43"];?>">
			</div>
			</div>
			</td>
		</tr>
		</table>
		</div>
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
		</div>
		</div>

		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $jkl["g312"];?></h3>
			</div><!-- /.box-header -->
			<div class="box-body">
			<div class="table-responsive">
			<table class="table table-striped">
			<tr>
				<td colspan="2">
					<div class="form-group">
						<label for="nativtok"><?php echo $jkl["u51"];?></label>
						<input type="text" name="jak_nativtok" id="nativtok" class="form-control" value="<?php echo JAK_NATIVE_APP_TOKEN;?>">
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="form-group">
						<label for="nativkey"><?php echo $jkl["u52"];?></label>
						<input type="text" name="jak_nativkey" id="nativkey" class="form-control" value="<?php echo JAK_NATIVE_APP_KEY;?>">
					</div>
				</td>
			</tr>
			</table>
			</div>
			</div>
			<div class="box-footer">
				<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
			</div>
		</div>

	</div>
	<div class="col-md-6">
	
		<div class="box box-info">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["g258"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td><?php echo $jkl["g256"];?></td>
			<td><select name="jak_ringtone" class="selectpicker form-control play-tone" data-live-search="true" data-size="4">
			<?php if (isset($sound_files) && is_array($sound_files)) foreach($sound_files as $sfc) { ?><option value="<?php echo $sfc;?>"<?php if (JAK_RING_TONE == $sfc) { ?> selected="selected"<?php } ?>><?php echo $sfc;?></option><?php } ?>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g257"];?></td>
			<td><select name="jak_msgtone" class="selectpicker form-control play-tone" data-live-search="true" data-size="4">
			<?php if (isset($sound_files) && is_array($sound_files)) foreach($sound_files as $sfn) { ?><option value="<?php echo $sfn;?>"<?php if (JAK_MSG_TONE == $sfn) { ?> selected="selected"<?php } ?>><?php echo $sfn;?></option><?php } ?>
			</select></td>
		</tr>
		</table>
		</div>
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
		</div>
		</div>

		<div class="box box-info">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["g318"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td><?php echo $jkl["g191"];?></td>
			<td><div class="radio"><label><input type="radio" name="showalert" value="1"<?php if (JAK_PRO_ALERT == 1) { ?> checked<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label>
			  <input type="radio" name="showalert" value="0"<?php if (JAK_PRO_ALERT == 0) { ?> checked<?php } ?>> <?php echo $jkl["g18"];?>
			</label></div>
			</td>
		</tr>
		<tr>
			<td><?php echo $jkl["g257"];?></td>
			<td><select name="jak_client_sound" class="selectpicker form-control play-tone" data-live-search="true" data-size="4">
			<?php if (isset($sound_files) && is_array($sound_files)) foreach($sound_files as $sfc) { ?><option value="<?php echo $sfc;?>"<?php if (JAK_CLIENT_SOUND == $sfc) { ?> selected="selected"<?php } ?>><?php echo $sfc;?></option><?php } ?>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g316"];?></td>
			<td><select name="jak_engage_sound" class="selectpicker form-control play-tone" data-live-search="true" data-size="4">
			<option value=""<?php if (empty(JAK_ENGAGE_SOUND)) echo ' selected="selected"';?>><?php echo $jkl['bw4'];?></option>
			<?php if (isset($sound_files) && is_array($sound_files)) foreach($sound_files as $sfc) { ?><option value="<?php echo $sfc;?>"<?php if (JAK_ENGAGE_SOUND == $sfc) { ?> selected="selected"<?php } ?>><?php echo $sfc;?></option><?php } ?>
			</select></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g317"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_client_push_not" value="1"<?php if (JAK_CLIENT_PUSH_NOT == 1) { ?> checked<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label>
			  <input type="radio" name="jak_client_push_not" value="0"<?php if (JAK_CLIENT_PUSH_NOT == 0) { ?> checked<?php } ?>> <?php echo $jkl["g18"];?>
			</label></div>
			</td>
		</tr>
		<tr>
			<td><?php echo $jkl["g319"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_live_online_status" value="1"<?php if (JAK_LIVE_ONLINE_STATUS == 1) { ?> checked<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label>
			  <input type="radio" name="jak_live_online_status" value="0"<?php if (JAK_LIVE_ONLINE_STATUS == 0) { ?> checked<?php } ?>> <?php echo $jkl["g18"];?>
			</label></div>
			</td>
		</tr>
		<tr>
			<td><?php echo $jkl["g331"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_chat_upload_standard" value="1"<?php if (JAK_CHAT_UPLOAD_STANDARD == 1) { ?> checked<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label>
			  <input type="radio" name="jak_chat_upload_standard" value="0"<?php if (JAK_CHAT_UPLOAD_STANDARD == 0) { ?> checked<?php } ?>> <?php echo $jkl["g18"];?>
			</label></div>
			</td>
		</tr>
		</table>
		</div>
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
		</div>
		</div>

		<div class="box box-danger">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["g97"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td><?php echo $jkl["g95"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h3"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></td>
			<td><textarea name="ip_block" rows="5" class="form-control"><?php echo JAK_IP_BLOCK;?></textarea></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g96"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h4"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></td>
			<td><textarea name="email_block" rows="5" class="form-control"><?php echo JAK_EMAIL_BLOCK;?></textarea></td>
		</tr>
		</table>
		</div>
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
		</div>
		</div>
		
		<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["g155"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td><a href="http://www.twilio.com">Twilio</a>, <a href="http://www.plivo.com">Plivo</a> <?php echo $jkl["g157"];?> <a href="http://www.nexmo.com">Nexmo</a></td>
			<td>
			<div class="radio">
			<label><input type="radio" name="jak_twilio_nexmo" value="1"<?php if (JAK_TWILIO_NEXMO == 1) { ?> checked="checked"<?php } ?>> Twilio</label>
			</div>
			<div class="radio">
			<label><input type="radio" name="jak_twilio_nexmo" value="0"<?php if (JAK_TWILIO_NEXMO == 0) { ?> checked="checked"<?php } ?>> Nexmo</label>
			</div>
			<div class="radio">
			<label><input type="radio" name="jak_twilio_nexmo" value="2"<?php if (JAK_TWILIO_NEXMO == 2) { ?> checked="checked"<?php } ?>> Plivo</label>
			</div>
			</td>
		</tr>
		<tr>
			<td><?php echo $jkl["g151"];?></td>
			<td><input type="text" name="jak_tw_msg" class="form-control" value="<?php echo JAK_TW_MSG;?>" maxlength="160"></td>
		</tr>
		
		<tr>
			<td><?php echo $jkl["g152"];?></td>
			<td><input type="text" name="jak_tw_phone" class="form-control" value="<?php echo JAK_TW_PHONE;?>"></td>
		</tr>
		
		<tr>
			<td><?php echo $jkl["g153"];?></td>
			<td><input type="text" name="jak_tw_sid" class="form-control" value="<?php echo JAK_TW_SID;?>"></td>
		</tr>
		
		<tr>
			<td><?php echo $jkl["g154"];?></td>
			<td><input type="text" name="jak_tw_token" class="form-control" value="<?php echo JAK_TW_TOKEN;?>"></td>
		</tr>
		
		</table>
		</div>
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
		</div>
		</div>
		
		<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["g212"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td><?php echo $jkl["g212"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_smpt" value="0"<?php if (JAK_SMTP_MAIL == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g204"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_smpt" value="1"<?php if (JAK_SMTP_MAIL == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g205"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g206"];?></td>
			<td><input type="text" class="form-control" name="jak_host" value="<?php echo JAK_SMTPHOST;?>"></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g207"];?></td>
			<td>
			<div class="form-group">
				<input type="text" name="jak_port" class="form-control<?php if ($errors["e3"]) echo " is-invalid";?>" value="<?php echo JAK_SMTPPORT?>" placeholder="25">
			</div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g208"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_alive" value="1"<?php if (JAK_SMTP_ALIVE == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_alive" value="0"<?php if (JAK_SMTP_ALIVE == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g209"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_auth" value="1"<?php if (JAK_SMTP_AUTH == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_auth" value="0"<?php if (JAK_SMTP_AUTH == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g219"];?></td>
			<td>
			<input type="text" name="jak_prefix" class="form-control" value="<?php echo JAK_SMTP_PREFIX;?>" placeholder="ssl/tls/true/false">
			</td>
		</tr>
		<tr>
			<td><?php echo $jkl["g210"];?></td>
			<td><input type="text" name="jak_smtpusername" class="form-control" value="<?php echo JAK_SMTPUSERNAME;?>" autocomplete="off"></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g211"];?></td>
			<td><input type="password" name="jak_smtppassword" class="form-control" value="<?php echo JAK_SMTPPASSWORD;?>" autocomplete="off"></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g218"];?></td>
			<td><button type="submit" name="testMail" class="btn btn-success" id="sendTM"><i id="loader" class="fa fa-spinner fa-pulse"></i> <?php echo $jkl["g216"];?></button></td>
		</tr>
		</table>
		</div>
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
		</div>
		</div>
	</div>
</div>

</form>

<?php include_once 'footer.php';?>