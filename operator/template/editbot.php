<?php include_once 'header.php';?>

<?php if ($errors) { ?>
<div class="alert alert-danger"><?php if (isset($errors["e"])) echo $errors["e"];
	if (isset($errors["e1"])) echo $errors["e1"];?></div>
<?php } ?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
<div class="box">
<div class="box-header with-border">
  <h3 class="box-title"><?php echo $jkl["m24"];?></h3>
</div><!-- /.box-header -->
<div class="box-body">

<div class="table-responsive">
<table class="table table-striped table-hover">
<tr>
	<td><?php echo $jkl["g269"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h22"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td>
	 <div class="form-group">
		<input type="text" name="question" class="form-control<?php if ($errors["e"]) echo " is-invalid";?>" value="<?php echo $JAK_FORM_DATA["question"];?>" />
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $jkl['g291'];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h6"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td>
		<select name="jak_widgetid[]" multiple="multiple" class="form-control">
			<option value="0"<?php if ($JAK_FORM_DATA["widgetids"] == 0) { ?> selected="selected"<?php } ?>><?php echo $jkl["g105"];?></option>
			<?php if (isset($JAK_WIDGETS) && is_array($JAK_WIDGETS)) foreach($JAK_WIDGETS as $w) { ?>
			<option value="<?php echo $w["id"];?>"<?php if (in_array($w["id"], explode(',', $JAK_FORM_DATA["widgetids"]))) echo ' selected';?>><?php echo $w["title"];?></option>
			
			<?php } ?>
		</select>
	</td>
</tr>
<tr>
	<td><?php echo $jkl["g131"];?></td>
	<td>
	<div class="form-group">
		<select name="jak_depid" id="department" class="form-control">
	
		<option value="0"<?php if ($JAK_FORM_DATA["depid"] == 0) echo ' selected="selected"';?>><?php echo $jkl["g105"];?></option>
		<?php if (isset($JAK_DEPARTMENTS) && is_array($JAK_DEPARTMENTS)) foreach($JAK_DEPARTMENTS as $z) { ?>
	
		<option value="<?php echo $z["id"];?>"<?php if ($JAK_FORM_DATA["depid"] == $z["id"]) echo ' selected="selected"';?>><?php echo $z["title"];?></option>
	
		<?php } ?>
	
		</select>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $jkl["g22"];?></td>
	<td>
	<div class="form-group">
		<select name="jak_lang" class="form-control">
		<?php if (isset($lang_files) && is_array($lang_files)) foreach($lang_files as $lf) { ?><option value="<?php echo $lf;?>"<?php if ($JAK_FORM_DATA["lang"] == $lf) { ?> selected="selected"<?php } ?>><?php echo ucwords($lf);?></option><?php } ?>
		</select>
	</div>
	</td>
</tr>
<tr>
	<td><?php echo $jkl["g273"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h21"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></td>
	<td>
	 <div class="form-group">
		<textarea name="answer" rows="5" class="form-control<?php if ($errors["e1"]) echo " is-invalid";?>"><?php if (isset($_REQUEST["answer"])) { echo $_REQUEST["answer"]; } else { echo $JAK_FORM_DATA["answer"]; }?></textarea>
	</div>
	</td>
</tr>
</table>
</div>

</div>
<div class="box-footer">
	<a href="<?php echo JAK_rewrite::jakParseurl('bot');?>" class="btn btn-default"><?php echo $jkl["g103"];?></a>
	<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
</div>
</div>
</form>

</div>
</div>
		
<?php include_once 'footer.php';?>