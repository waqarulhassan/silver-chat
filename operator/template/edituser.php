<?php include_once 'header.php';?>

<?php if ($errors) { ?>
<div class="alert alert-danger">
<?php if (isset($errors["e"])) echo $errors["e"];
	  if (isset($errors["e1"])) echo $errors["e1"];
	  if (isset($errors["e2"])) echo $errors["e2"];
	  if (isset($errors["e3"])) echo $errors["e3"];
	  if (isset($errors["e4"])) echo $errors["e4"];
	  if (isset($errors["e5"])) echo $errors["e5"];
	  if (isset($errors["e6"])) echo $errors["e6"];?>
</div>
<?php } ?>

<form class="jak_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">

<div class="row">
	<div class="col-md-6">
		
		<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["g40"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td colspan="2">
			<div class="form-group">
				<label for="name"><?php echo $jkl["u"];?></label>
				<input type="text" name="jak_name" id="name" class="form-control<?php if (isset($errors["e1"])) echo " is-invalid";?>" value="<?php echo $JAK_FORM_DATA["name"];?>">
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<div class="form-group">
				<label for="email"><?php echo $jkl["u1"];?></label>
				<input type="text" name="jak_email" id="email" class="form-control<?php if (isset($errors["e2"])) echo " is-invalid";?>" value="<?php echo $JAK_FORM_DATA["email"];?>">
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<div class="form-group">
				<label for="username"><?php echo $jkl["u2"];?></label>
				<input  type="text" name="jak_username" id="username" class="form-control<?php if (isset($errors["e3"]) || isset($errors["e4"])) echo " is-invalid";?>" value="<?php echo $JAK_FORM_DATA["username"];?>"><input type="hidden" name="jak_username_old" value="<?php echo $JAK_FORM_DATA["username"];?>">
			</div>
			</td>
		</tr>
		<?php if (jak_get_access("usrmanage", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) { ?>
		<tr>
			<td><?php echo $jkl["u43"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_uolist" value="1"<?php if ($JAK_FORM_DATA["useronlinelist"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_uolist" value="0"<?php if ($JAK_FORM_DATA["useronlinelist"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["u3"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_access" value="1"<?php if ($JAK_FORM_DATA["access"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_access" value="0"<?php if ($JAK_FORM_DATA["access"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["u6"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_responses" value="1"<?php if ($JAK_FORM_DATA["responses"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_responses" value="0"<?php if ($JAK_FORM_DATA["responses"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<?php if (!$jakhs['hostactive']) { ?>
		<tr>
			<td><?php echo $jkl["u7"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_files" value="1"<?php if ($JAK_FORM_DATA["files"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_files" value="0"<?php if ($JAK_FORM_DATA["files"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["u13"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_chat" value="1"<?php if ($JAK_FORM_DATA["operatorchat"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_chat" value="0"<?php if ($JAK_FORM_DATA["operatorchat"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["u41"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_chatpublic" value="1"<?php if ($JAK_FORM_DATA["operatorchatpublic"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_chatpublic" value="0"<?php if ($JAK_FORM_DATA["operatorchatpublic"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<?php } ?>
		<tr>
			<td><?php echo $jkl["g137"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_chatlist" value="1"<?php if ($JAK_FORM_DATA["operatorlist"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_chatlist" value="0"<?php if ($JAK_FORM_DATA["operatorlist"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["u45"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_transfer" value="1"<?php if ($JAK_FORM_DATA["transferc"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_transfer" value="0"<?php if ($JAK_FORM_DATA["transferc"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<?php } ?>
		<tr>
			<td><?php echo $jkl["g239"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_latency" value="3000"<?php if ($JAK_FORM_DATA["chat_latency"] == 3000) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g240"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_latency" value="5000"<?php if ($JAK_FORM_DATA["chat_latency"] == 5000) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g241"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g2"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_sound" value="1"<?php if ($JAK_FORM_DATA["sound"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_sound" value="0"<?php if ($JAK_FORM_DATA["sound"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g200"];?></td>
			<td>
			<select name="jak_ringing" class="form-control">
				<?php for ($i = 1; $i < 30; $i++) {
					if ($i == $JAK_FORM_DATA["ringing"]) {
						echo '<option value="'.$i.'" selected>'.$i.'</option>';
					} else {
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				} ?>
			</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"><a class="btn btn-mini btn-success" href="javascript:void(0)" onclick="dNotifyNew('<?php echo addslashes(JAK_TITLE);?>', '<?php echo addslashes($jkl['u26']);?>')"><?php echo $jkl["u26"];?></a></td>
		</tr>
		<tr>
			<td><?php echo $jkl["g22"];?></td>
			<td><select name="jak_lang" class="form-control">
			<option value=""><?php echo $jkl["u11"];?></option>
			<?php if (isset($lang_files) && is_array($lang_files)) foreach($lang_files as $lf) { ?><option value="<?php echo $lf;?>"<?php if ($JAK_FORM_DATA["language"] == $lf) { ?> selected="selected"<?php } ?>><?php echo ucwords($lf);?></option><?php } ?>
			</select></td>
		</tr>
		<tr>
			<td colspan="2">
				<div class="custom-file">
				  <input type="file" class="custom-file-input<?php if (isset($errors["e7"])) echo " is-invalid";?>" name="uploadpp" id="uploadpp" accept="image/*">
				  <label class="custom-file-label" for="customFile"><?php echo $jkl["u10"];?></label>
				</div>
			</td>
		</tr>
		<tr>
			<td><?php echo $jkl["u46"];?></td>
			<td><input type="checkbox" name="jak_delete_avatar"></td>
		</tr>
		</table>
		</div>
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right form-submit"><?php echo $jkl["g38"];?></button>
		</div>
		</div>
		
	</div>
	<div class="col-md-6">

		<?php if (jak_get_access("usrmanage", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) { ?>
		<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["m9"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h6"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td>
			
			<select name="jak_depid[]" multiple="multiple" class="form-control">
			
			<option value="0"<?php if ($JAK_FORM_DATA["departments"] == 0) { ?> selected="selected"<?php } ?>><?php echo $jkl["g105"];?></option>
			<?php if (isset($JAK_DEPARTMENTS) && is_array($JAK_DEPARTMENTS)) foreach($JAK_DEPARTMENTS as $z) { ?>
			
			<option value="<?php echo $z["id"];?>"<?php if (in_array($z["id"], explode(',', $JAK_FORM_DATA["departments"]))) { ?> selected="selected"<?php } ?>><?php echo $z["title"];?></option>
			
			<?php } ?>
			
			</select>
			
			</td>
		</tr>
		</table>
		</div>
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right form-submit"><?php echo $jkl["g38"];?></button>
		</div>
		</div>
		<?php } ?>
		
		<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["u12"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td><input type="text" name="jak_inv" class="form-control" value="<?php echo $JAK_FORM_DATA["invitationmsg"]; ?>" class="form-control"></td>
		</tr>
		</table>
		</div>
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right form-submit"><?php echo $jkl["g38"];?></button>
		</div>
		</div>
		
		<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["g39"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">
		<tr>
			<td><?php echo $jkl["u4"];?></td>
			<td>
			<div class="form-group">
				<input type="password" name="jak_password" class="form-control<?php if (isset($errors["e5"]) || isset($errors["e6"])) echo " is-invalid";?>" id="pass" value="">
			</div>
			</td>
		</tr>
		<tr>
			<td><?php echo $jkl["u5"];?></td>
			<td>
			<div class="form-group">
				<input type="password" name="jak_confirm_password" class="form-control<?php if (isset($errors["e5"]) || isset($errors["e6"])) echo " is-invalid";?>" value="">
			</div>
			</td>
		</tr>
		<tr>
		<td colspan="2">
			<div class="progress">
				<div id="jak_pstrength" class="progress-bar progress-bar-striped progress-bar-animated" style="width:0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		</td>
		</tr>
		</table>
		</div>
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right form-submit"><?php echo $jkl["g38"];?></button>
		</div>
		</div>
		
		<?php if (jak_get_access("usrmanage", $jakuser->getVar("permissions"), JAK_SUPERADMINACCESS)) { ?>
		<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["u29"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="leads"<?php if (in_array("leads", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u30"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="leads_all"<?php if (in_array("leads_all", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u30"].' ('.$jkl["g105"].')';?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="off_all"<?php if (in_array("off_all", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g33"].' ('.$jkl["g105"].')';?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="ochat"<?php if (in_array("ochat", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u31"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="ochat_all"<?php if (in_array("ochat_all", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u31"].' ('.$jkl["g105"].')';?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="statistic"<?php if (in_array("statistic", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u32"];?></label><br>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="statistic_all"<?php if (in_array("statistic_all", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u32"].' ('.$jkl["g105"].')';?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="files"<?php if (in_array("files", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u33"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="proactive"<?php if (in_array("proactive", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u34"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="usrmanage"<?php if (in_array("usrmanage", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u42"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="responses"<?php if (in_array("responses", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u35"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="departments"<?php if (in_array("departments", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u36"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="settings"<?php if (in_array("settings", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u37"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="maintenance"<?php if (in_array("maintenance", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u38"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="logs"<?php if (in_array("logs", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u39"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="answers"<?php if (in_array("answers", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u44"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="widget"<?php if (in_array("widget", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["m26"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="groupchat"<?php if (in_array("groupchat", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["m29"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="blacklist"<?php if (in_array("blacklist", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["m27"];?></label>
			<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="blocklist"<?php if (in_array("blocklist", explode(',', $JAK_FORM_DATA["permissions"]))) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g97"];?></label>
			
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right form-submit"><?php echo $jkl["g38"];?></button>
		</div>
		</div>
		<?php } ?>
		
		<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title"><?php echo $jkl["u17"];?></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<div class="table-responsive">
		<table class="table table-striped">

			<tr>
				<td><?php echo $jkl["u25"];?></td>
				<td><div class="radio"><label><input type="radio" name="jak_alwaysnot" value="1" <?php if ($JAK_FORM_DATA["alwaysnot"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
				<div class="radio"><label><input type="radio" name="jak_alwaysnot" value="0" <?php if ($JAK_FORM_DATA["alwaysnot"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
			</tr>
		
		<tr>
			<td><?php echo $jkl["g214"];?></td>
			<td><div class="radio"><label><input type="radio" name="jak_emailnot" value="1" <?php if ($JAK_FORM_DATA["emailnot"] == 1) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_emailnot" value="0" <?php if ($JAK_FORM_DATA["emailnot"] == 0) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g18"];?></label></div></td>
		</tr>
		<tr>
			<td colspan="2">
				<div class="form-group">
					<label for="whatsphone"><?php echo $jkl["u53"];?></label>
					<input  type="text" name="jak_whatsphone" id="whatsphone" class="form-control" value="<?php echo $JAK_FORM_DATA["whatsappnumber"];?>">
				</div>
			</td>
		</tr>
		<?php if (JAK_TW_SID && JAK_TW_TOKEN) { ?>
		<tr>
			<td colspan="2">
				<div class="form-group">
					<label for="phone"><?php echo $jkl["u14"];?></label>
					<input  type="text" name="jak_phone" id="phone" class="form-control" value="<?php echo $JAK_FORM_DATA["phonenumber"];?>">
				</div>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="2">
				<div class="form-group">
					<label for="pushot"><?php echo $jkl["u49"];?></label>
					<input  type="text" name="jak_pushot" id="pushot" class="form-control" value="<?php echo $JAK_FORM_DATA["pusho_tok"];?>">
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div class="form-group">
					<label for="pushok"><?php echo $jkl["u50"];?></label>
					<input  type="text" name="jak_pushok" id="pushok" class="form-control" value="<?php echo $JAK_FORM_DATA["pusho_key"];?>">
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<h4><?php echo $jkl["u15"];?></h4>
				<div id="bHoursM"></div>
				<div class="clearfix"></div>
				<span class="help-block"><?php echo $jkl["u47"];?></span>
				<input type="hidden" name="bhours" id="bhours" value="<?php echo $JAK_FORM_DATA["hours_array"];?>">
				<p><a href="<?php echo JAK_rewrite::jakParseurl('users', 'resethours', $page2);?>" class="btn btn-sm btn-danger"><?php echo $jkl['g229'];?></a></p>
			</td>
		</tr>
		
		</table>
		</div>
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right form-submit"><?php echo $jkl["g38"];?></button>
		</div>
		</div>

	</div>
</div>
</form>
		
<?php include_once 'footer.php';?>