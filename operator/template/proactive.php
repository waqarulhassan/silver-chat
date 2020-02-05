<?php include_once 'header.php';?>

<div class="row">
<div class="col-md-4">
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><i class="fa fa-commenting-o"></i> <?php echo $jkl["g175"];?></h3>
  	</div><!-- /.box-header -->
  	<div class="box-body">
				
				<?php if ($errors) { ?>
				<div class="alert alert-danger"><?php if (isset($errors["e"])) echo $errors["e"];
					  if (isset($errors["e1"])) echo $errors["e1"];
					  if (isset($errors["e3"])) echo $errors["e3"];
	  				  if (isset($errors["e4"])) echo $errors["e4"];?></div>
				<?php } ?>
				
				<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					
					<div class="form-group">
					    <label class="control-label" for="path"><?php echo $jkl["g167"];?></label>
						<input type="text" name="path" class="form-control<?php if (isset($errors["e"])) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["path"])) echo $_REQUEST["path"];?>">
					</div>
					
					<div class="form-group">
					    <label class="control-label" for="response"><?php echo $jkl["g191"];?></label>
						<input type="radio" name="showalert" value="1"> <?php echo $jkl["g19"];?>
						<input type="radio" name="showalert" value="0" checked> <?php echo $jkl["g18"];?>
					</div>

					<div class="form-group">
						<label class="control-label" for="soundtype"><?php echo $jkl["g314"];?></label>
						<select name="jak_ringtone" id="soundtype" class="selectpicker form-control play-tone" data-live-search="true" data-size="4">
						<option value=""<?php if (!isset($_REQUEST["jak_ringtone"])) echo ' selected="selected"';?>><?php echo $jkl['bw4'];?></option>
						<?php if (isset($sound_files) && is_array($sound_files)) foreach($sound_files as $sfc) { ?><option value="<?php echo $sfc;?>"<?php if (isset($_REQUEST["jak_ringtone"]) && $_REQUEST["jak_ringtone"] == $sfc) echo ' selected="selected"';?>><?php echo $sfc;?></option><?php } ?>
						</select>
					</div>
					
					<div class="form-group">
					    <label class="control-label" for="response"><?php echo $jkl["g194"];?></label>
					    <select name="onsite" class="selectpicker form-control" data-live-search="true" data-size="4">
					    <option value="1">1 <?php echo $jkl["g196"];?></option>
					    <option value="5">5 <?php echo $jkl["g196"];?></option>
					    <option value="15">15 <?php echo $jkl["g196"];?></option>
					    <option value="30">30 <?php echo $jkl["g196"];?></option>
					    <option value="60">1 <?php echo $jkl["g197"];?></option>
					    <option value="120">2 <?php echo $jkl["g197"];?></option>
					    <option value="180">3 <?php echo $jkl["g197"];?></option>
					    <option value="240">4 <?php echo $jkl["g197"];?></option>
					    <option value="300">5 <?php echo $jkl["g197"];?></option>
					    </select>
					</div>
					
					<div class="form-group">
					    <label class="control-label" for="response"><?php echo $jkl["g195"];?></label>
						<select name="visited" class="selectpicker form-control" data-live-search="true" data-size="4">
						<?php for ($i = 1; $i <= 20; $i++) { ?>
						<option value="<?php echo $i ?>"><?php echo $i; ?> <?php echo $jkl["g198"];?></option>
						<?php } ?>
						</select>
					</div>
					
					<div class="form-group">
						<label for="title"><?php echo $jkl["g16"];?></label>
						<input type="text" name="title" id="title" class="form-control<?php if (isset($errors["e2"])) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["title"])) echo $_REQUEST["title"];?>" />
					</div>
					
					<div class="form-group">
						<label for="imgpath"><?php echo $jkl["g265"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h19"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></label>
						<input type="text" name="imgpath" id="imgpath" class="form-control<?php if (isset($errors["e"])) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["imgpath"])) echo $_REQUEST["imgpath"];?>" />
					</div>
					
					<div class="form-group">
					    <label class="control-label" for="response"><?php echo $jkl["g146"];?></label>
						<textarea name="message" class="form-control<?php if (isset($errors["e1"])) echo " is-invalid";?>" rows="5"><?php if (isset($_REQUEST["message"])) echo $_REQUEST["message"];?></textarea>
					</div>

					<div class="form-group">
						<label for="btn-s"><?php echo $jkl["g281"];?></label>
						<input type="text" name="btn-s" id="btn-s" class="form-control<?php if (isset($errors["e3"])) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["btn-s"])) echo $_REQUEST["btn-s"];?>" />
					</div>

					<div class="form-group">
						<label for="btn-c"><?php echo $jkl["g282"];?></label>
						<input type="text" name="btn-c" id="btn-c" class="form-control<?php if (isset($errors["e4"])) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["btn-c"])) echo $_REQUEST["btn-c"];?>" />
					</div>
					
					<div class="form-actions">
						<button type="submit" name="insert_proactive" class="btn btn-primary btn-block"><?php echo $jkl["g38"];?></button>
					</div>

				</form>
			</div>
		</div>
</div>
<div class="col-md-8">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-commenting"></i> <?php echo $jkl["g176"];?></h3>
	  	</div><!-- /.box-header -->
	  	<div class="box-body">

	  		<?php if (isset($PROACTIVE_ALL) && is_array($PROACTIVE_ALL) && !empty($PROACTIVE_ALL)) { ?>
			<div class="table-responsive">
			<table class="table table-striped">
			<thead>
			<tr>
			<th>#</th>
			<th><?php echo $jkl["g167"];?></th>
			<th><?php echo $jkl["g146"];?></th>
			<th><?php echo $jkl["g47"];?></th>
			<th><?php echo $jkl["g48"];?></th>
			</tr>
			</thead>
			<?php foreach($PROACTIVE_ALL as $v) { ?>
			<tr>
			<td><?php echo $v["id"];?></td>
			<td class="title"><a href="<?php echo JAK_rewrite::jakParseurl('proactive', 'edit', $v["id"]);?>"><?php echo $v["path"];?></a></td>
			<td class="desc"><?php echo $v["message"];?></td>
			<td><a class="btn btn-default btn-sm" href="<?php echo JAK_rewrite::jakParseurl('proactive', 'edit', $v["id"]);?>"><i class="fa fa-pencil"></i></a></td>
			<td><a class="btn btn-danger btn-sm btn-confirm" href="<?php echo JAK_rewrite::jakParseurl('proactive', 'delete', $v["id"]);?>" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e30"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-trash-o"></i></a></td>
			</tr>
			<?php } ?>
			</table>
			</div>
			<?php } else { ?>

			<div class="alert alert-info">
				<?php echo $jkl['i3'];?>
			</div>

			<?php } ?>

			</div>
		</div>
	</div>		
</div>

<?php include_once 'footer.php';?>