<?php include_once 'header.php';?>

<?php if ($errors) { ?>
<div class="alert alert-danger"><?php if (isset($errors["e"])) echo $errors["e"];
	  if (isset($errors["e1"])) echo $errors["e1"];
	  if (isset($errors["e2"])) echo $errors["e2"];
	  if (isset($errors["e3"])) echo $errors["e3"];
	  if (isset($errors["e4"])) echo $errors["e4"];
	  if (isset($errors["e5"])) echo $errors["e5"];
	  if (isset($errors["e6"])) echo $errors["e6"];?></div>
<?php } ?>
<form class="jak_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
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
			<input type="text" name="jak_name" id="name" class="form-control<?php if ($errors["e1"]) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["jak_name"])) echo $_REQUEST["jak_name"];?>">
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<div class="form-group">
			<label for="email"><?php echo $jkl["u1"];?></label>
			<input type="text" name="jak_email" id="email" class="form-control<?php if ($errors["e2"]) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["jak_email"])) echo $_REQUEST["jak_email"];?>">
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<div class="form-group">
			<label for="username"><?php echo $jkl["u2"];?></label>
			<input type="text" name="jak_username" id="username" class="form-control<?php if ($errors["e3"] || $errors["e4"]) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["jak_username"])) echo $_REQUEST["jak_username"];?>">
		</div>
		</td>
	</tr>
	<tr>
		<td><?php echo $jkl["u43"];?></td>
		<td><div class="radio"><label><input type="radio" name="jak_uolist" value="1" checked="checked"> <?php echo $jkl["g19"];?></label></div>
		<div class="radio"><label><input type="radio" name="jak_uolist" value="0"> <?php echo $jkl["g18"];?></label></div></td>
	</tr>
	<tr>
		<td><?php echo $jkl["u3"];?></td>
		<td><div class="radio"><label><input type="radio" name="jak_access" value="1" checked="checked"> <?php echo $jkl["g19"];?></label></div>
		<div class="radio"><label><input type="radio" name="jak_access" value="0"> <?php echo $jkl["g18"];?></label></div></td>
	</tr>
	<tr>
		<td><?php echo $jkl["u6"];?></td>
		<td><div class="radio"><label><input type="radio" name="jak_responses" value="1" checked="checked"> <?php echo $jkl["g19"];?></label></div>
		<div class="radio"><label><input type="radio" name="jak_responses" value="0"> <?php echo $jkl["g18"];?></label></div></td>
	</tr>
	<?php if (!$jakhs['hostactive']) { ?>
	<tr>
		<td><?php echo $jkl["u7"];?></td>
		<td><div class="radio"><label><input type="radio" name="jak_files" value="1" checked="checked"> <?php echo $jkl["g19"];?></label></div>
		<div class="radio"><label><input type="radio" name="jak_files" value="0"> <?php echo $jkl["g18"];?></label></div></td>
	</tr>
	<tr>
		<td><?php echo $jkl["u13"];?></td>
		<td><div class="radio"><label><input type="radio" name="jak_chat" value="1" checked="checked"> <?php echo $jkl["g19"];?></label></div>
		<div class="radio"><label><input type="radio" name="jak_chat" value="0"> <?php echo $jkl["g18"];?></label></div></td>
	</tr>
	<tr>
		<td><?php echo $jkl["u41"];?></td>
		<td><div class="radio"><label><input type="radio" name="jak_chatpublic" value="1" checked="checked"> <?php echo $jkl["g19"];?></label></div>
		<div class="radio"><label><input type="radio" name="jak_chatpublic" value="0"> <?php echo $jkl["g18"];?></label></div></td>
	</tr>
	<?php } ?>
	<tr>
		<td><?php echo $jkl["g137"];?></td>
		<td><div class="radio"><label><input type="radio" name="jak_chatlist" value="1" checked="checked"> <?php echo $jkl["g19"];?></label></div>
		<div class="radio"><label><input type="radio" name="jak_chatlist" value="0"> <?php echo $jkl["g18"];?></label></div></td>
	</tr>
	<tr>
		<td><?php echo $jkl["u45"];?></td>
		<td><div class="radio"><label><input type="radio" name="jak_transfer" value="1" checked="checked"> <?php echo $jkl["g19"];?></label></div>
			<div class="radio"><label><input type="radio" name="jak_transfer" value="0"> <?php echo $jkl["g18"];?></label></div>
		</td>
	</tr>
	<tr>
		<td><?php echo $jkl["g239"];?></td>
		<td><div class="radio"><label><input type="radio" name="jak_latency" value="3000" checked="checked"> <?php echo $jkl["g240"];?></label></div>
		<div class="radio"><label><input type="radio" name="jak_latency" value="5000"> <?php echo $jkl["g241"];?></label></div></td>
	</tr>
	<tr>
		<td><?php echo $jkl["g2"];?></td>
		<td><div class="radio"><label><input type="radio" name="jak_sound" value="1" checked="checked"> <?php echo $jkl["g19"];?></label></div>
		<div class="radio"><label><input type="radio" name="jak_sound" value="0"> <?php echo $jkl["g18"];?></label></div></td>
	</tr>
	<tr>
		<td><?php echo $jkl["g200"];?></td>
		<td>
		<select name="jak_ringing" class="form-control">
			<?php for ($i = 1; $i < 30; $i++) {
			echo '<option value="'.$i.'">'.$i.'</option>';
			} ?>
		</select>
		</td>
	</tr>
	<tr>
		<td><?php echo $jkl["g22"];?></td>
		<td><select name="jak_lang" class="form-control">
		<option value=""><?php echo $jkl["u11"];?></option>
		<?php if (isset($lang_files) && is_array($lang_files)) foreach($lang_files as $lf) { ?><option value="<?php echo $lf;?>"><?php echo ucwords($lf);?></option><?php } ?>
		</select></td>
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
						<option value="0"<?php if (isset($_REQUEST["jak_depid"]) && $_REQUEST["jak_depid"] == '0') { ?> selected="selected"<?php } ?>><?php echo $jkl["g105"];?></option>
				
						<?php if (isset($JAK_DEPARTMENTS) && is_array($JAK_DEPARTMENTS)) foreach($JAK_DEPARTMENTS as $v) { ?>
						
						<option value="<?php echo $v["id"];?>"><?php echo $v["title"];?></option>
						
						<?php } ?>
					</select>
				</td>
			</tr>
			</table>
			</div>
			</div>
			</div>
	
			<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><?php echo $jkl["u12"];?></h3>
			</div><!-- /.box-header -->
			<div class="box-body">
			<div class="table-responsive">
			<table class="table table-striped">
			<tr>
				<td><input type="text" name="jak_inv" class="form-control" value="<?php if (isset($_REQUEST["jak_inv"])) echo $_REQUEST["jak_inv"]; ?>" class="form-control"></td>
			</tr>
			</table>
			</div>
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
					<input type="text" name="jak_password" id="pass" class="form-control<?php if ($errors["e5"] || $errors["e6"]) echo " is-invalid";?>" value="">
				</div>
				</td>
			</tr>
			<tr>
				<td><?php echo $jkl["u5"];?></td>
				<td>
				<div class="form-group">
					<input type="text" name="jak_confirm_password" class="form-control<?php if ($errors["e5"] || $errors["e6"]) echo " is-invalid";?>" value="">
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
				<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
			</div>
			</div>
			
			<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><?php echo $jkl["u29"];?></h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="leads"<?php if (isset($_REQUEST["jak_roles"]) && in_array("leads", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u30"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="leads_all"<?php if (isset($_REQUEST["jak_roles"]) && in_array("leads_all", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u30"].' ('.$jkl["g105"].')';?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="off_all"<?php if (isset($_REQUEST["jak_roles"]) && in_array("off_all", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g33"].' ('.$jkl["g105"].')';?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="ochat"<?php if (isset($_REQUEST["jak_roles"]) && in_array("ochat", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u31"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="ochat_all"<?php if (isset($_REQUEST["jak_roles"]) && in_array("ochat_all", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u31"].' ('.$jkl["g105"].')';?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="statistic"<?php if (isset($_REQUEST["jak_roles"]) && in_array("statistic", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u32"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="statistic_all"<?php if (isset($_REQUEST["jak_roles"]) && in_array("statistic_all", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u32"].' ('.$jkl["g105"].')';?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="files"<?php if (isset($_REQUEST["jak_roles"]) && in_array("files", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u33"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="proactive"<?php if (isset($_REQUEST["jak_roles"]) && in_array("proactive", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u34"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="usrmanage"<?php if (isset($_REQUEST["jak_roles"]) && in_array("usrmanage", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u42"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="responses"<?php if (isset($_REQUEST["jak_roles"]) && in_array("responses", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u35"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="departments"<?php if (isset($_REQUEST["jak_roles"]) && in_array("departments", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u36"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="settings"<?php if (isset($_REQUEST["jak_roles"]) && in_array("settings", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u37"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="maintenance"<?php if (isset($_REQUEST["jak_roles"]) && in_array("maintenance", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u38"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="logs"<?php if (isset($_REQUEST["jak_roles"]) && in_array("logs", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u39"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="answers"<?php if (isset($_REQUEST["jak_roles"]) && in_array("answers", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["u44"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="widget"<?php if (isset($_REQUEST["jak_roles"]) && in_array("widget", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["m26"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="groupchat"<?php if (isset($_REQUEST["jak_roles"]) && in_array("groupchat", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["m29"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="blacklist"<?php if (isset($_REQUEST["jak_roles"]) && in_array("blacklist", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["m27"];?></label>
				<label class="checkbox-inline"><input type="checkbox" name="jak_roles[]" value="blocklist"<?php if (isset($_REQUEST["jak_roles"]) && in_array("blocklist", $_REQUEST["jak_roles"])) { ?> checked="checked"<?php } ?>> <?php echo $jkl["g97"];?></label>
				
			</div>
			<div class="box-footer">
				<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
			</div>
			</div>
			
	</div>
</div>
</form>
		
<?php include_once 'footer.php';?>