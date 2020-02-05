<?php include_once 'header.php';?>

<?php if ($errors) { ?>
<div class="alert alert-danger">
<?php if (isset($errors["e"])) echo $errors["e"];
	  if (isset($errors["e1"])) echo $errors["e1"];
	  if (isset($errors["e3"])) echo $errors["e3"];
	  if (isset($errors["e4"])) echo $errors["e4"];?>
</div>
<?php } ?>

<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
<div class="box">
<div class="box-header with-border">
  <h3 class="box-title"><?php echo $jkl["g47"];?></h3>
</div><!-- /.box-header -->
<div class="box-body">
<div class="table-responsive">
<table class="table table-striped">
<tr>
	<td>
	<div class="form-group">
		<label for="url"><?php echo $jkl["g167"];?></label>
		<input type="text" name="path" id="url" class="form-control<?php if (isset($errors["e"])) echo " is-invalid";?>" value="<?php echo $JAK_FORM_DATA["path"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td>
	<div class="form-group">
	<label for="alert"><?php echo $jkl["g191"];?></label>
	<div class="radio"><label><input type="radio" name="showalert" id="alert" value="1"<?php if ($JAK_FORM_DATA["showalert"] == 1) { ?> checked<?php } ?>> <?php echo $jkl["g19"];?></label></div>
	<div class="radio"><label><input type="radio" name="showalert" value="0"<?php if ($JAK_FORM_DATA["showalert"] == 0) { ?> checked<?php } ?>> <?php echo $jkl["g18"];?></label></div>
	</td>
</tr>
<tr>
	<td>
		<div class="form-group">
			<label for="jak_ringtone"><?php echo $jkl["g314"];?></label>
			<select name="jak_ringtone" id="jak_ringtone" class="form-control play-tone">
				<option value=""<?php if (empty($JAK_FORM_DATA["soundalert"])) echo ' selected="selected"';?>><?php echo $jkl['bw4'];?></option>
				<?php if (isset($sound_files) && is_array($sound_files)) foreach($sound_files as $sfc) { ?><option value="<?php echo $sfc;?>"<?php if ($JAK_FORM_DATA["soundalert"] == $sfc) { ?> selected="selected"<?php } ?>><?php echo $sfc;?></option><?php } ?>
			</select>
		</div>
	</td>
	</tr>
<tr>
	<td>
	<div class="form-group">
	<label for="onsite"><?php echo $jkl["g194"];?></label>
	<select name="onsite" id="onsite" class="form-control">
	<option value="2"<?php if ($JAK_FORM_DATA["timeonsite"] == 1) { ?> selected="selected"<?php } ?>>1 <?php echo $jkl["g196"];?></option>
	<option value="5"<?php if ($JAK_FORM_DATA["timeonsite"] == 5) { ?> selected="selected"<?php } ?>>5 <?php echo $jkl["g196"];?></option>
	<option value="15"<?php if ($JAK_FORM_DATA["timeonsite"] == 15) { ?> selected="selected"<?php } ?>>15 <?php echo $jkl["g196"];?></option>
	<option value="30"<?php if ($JAK_FORM_DATA["timeonsite"] == 30) { ?> selected="selected"<?php } ?>>30 <?php echo $jkl["g196"];?></option>
	<option value="60"<?php if ($JAK_FORM_DATA["timeonsite"] == 60) { ?> selected="selected"<?php } ?>>1 <?php echo $jkl["g197"];?></option>
	<option value="120"<?php if ($JAK_FORM_DATA["timeonsite"] == 120) { ?> selected="selected"<?php } ?>>2 <?php echo $jkl["g197"];?></option>
	<option value="180"<?php if ($JAK_FORM_DATA["timeonsite"] == 180) { ?> selected="selected"<?php } ?>>3 <?php echo $jkl["g197"];?></option>
	<option value="240"<?php if ($JAK_FORM_DATA["timeonsite"] == 240) { ?> selected="selected"<?php } ?>>4 <?php echo $jkl["g197"];?></option>
	<option value="300"<?php if ($JAK_FORM_DATA["timeonsite"] == 300) { ?> selected="selected"<?php } ?>>5 <?php echo $jkl["g197"];?></option>
	</select>
	</div>
	</td>
</tr>
<tr>
	<td>
	<div class="form-group">
	<label for="visited"><?php echo $jkl["g195"];?></label>
	<select name="visited" id="visited" class="form-control">
	<?php for ($i = 1; $i <= 20; $i++) { ?>
	<option value="<?php echo $i ?>"<?php if ($JAK_FORM_DATA["visitedsites"] == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?> <?php echo $jkl["g198"];?></option>
	<?php } ?>
	</select>
	</div>
	</td>
</tr>
<tr>
	<td>
	<div class="form-group">
		<label for="title"><?php echo $jkl["g16"];?></label>
		<input type="text" name="title" id="title" class="form-control<?php if (isset($errors["e2"])) echo " is-invalid";?>" value="<?php echo $JAK_FORM_DATA["title"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td>
	<div class="form-group">
		<label for="imgpath"><?php echo $jkl["g265"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h19"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></label>
		<input type="text" name="imgpath" id="imgpath" class="form-control<?php if (isset($errors["e"])) echo " is-invalid";?>" value="<?php echo $JAK_FORM_DATA["imgpath"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td>
	<div class="form-group">
		<label for="message"><?php echo $jkl["g146"];?></label>
		<textarea name="message" id="message" rows="5" class="form-control<?php if (isset($errors["e1"])) echo " is-invalid";?>"><?php echo $JAK_FORM_DATA["message"];?></textarea>
	</div>
	</td>
</tr>
<tr>
	<td>
	<div class="form-group">
		<label for="btn-s"><?php echo $jkl["g281"];?></label>
		<input type="text" name="btn-s" id="btn-s" class="form-control<?php if (isset($errors["e3"])) echo " is-invalid";?>" value="<?php echo $JAK_FORM_DATA["btn_confirm"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td>
	<div class="form-group">
		<label for="btn-c"><?php echo $jkl["g282"];?></label>
		<input type="text" name="btn-c" id="btn-c" class="form-control<?php if (isset($errors["e4"])) echo " is-invalid";?>" value="<?php echo $JAK_FORM_DATA["btn_cancel"];?>" />
	</div>
	</td>
</tr>
</table>
</div>
</div>
<div class="box-footer">
	<a href="<?php echo JAK_rewrite::jakParseurl('proactive');?>" class="btn btn-default"><?php echo $jkl["g103"];?></a>
	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
</div>
</div>
</form>
		
<?php include_once 'footer.php';?>