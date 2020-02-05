<?php include_once 'header.php';?>

<div class="row">
<div class="col-md-4">

	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<div class="alert alert-dark">

		<div class="form-group">
			<label class="control-label" for="jak_lang"><?php echo $jkl["g22"];?></label>
			<select name="jak_lang_pack" class="selectpicker form-control" data-live-search="true" data-size="4" data-style="btn-warning">
			<?php if (isset($unique_lang) && is_array($unique_lang)) foreach($unique_lang as $lfu) { ?><option value="<?php echo $lfu;?>"><?php echo ucwords($lfu);?></option><?php } ?>
			</select>
		</div>

		<button type="submit" name="create_language_pack" class="btn btn-primary btn-block"><?php echo $jkl["g326"];?></button>
	</div>
	</form>

	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-pencil"></i> <?php echo $jkl["g244"];?></h3>
	  	</div><!-- /.box-header -->
	  	<div class="box-body">
				
				<?php if ($errors) { ?>
				<div class="alert alert-danger"><?php if (isset($errors["e"])) echo $errors["e"];
					  if (isset($errors["e1"])) echo $errors["e1"];
					  if (isset($errors["e2"])) echo $errors["e2"];?></div>
				<?php } ?>
				
				<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					
					<div class="form-group">
					    <label class="control-label" for="title"><?php echo $jkl["g16"];?></label>
						<input type="text" name="title" class="form-control<?php if (isset($errors["e"])) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["title"])) echo $_REQUEST["title"];?>" />
					</div>
					
					<div class="form-group">
						<label class="control-label" for="department"><?php echo $jkl["g131"];?></label>
						<select name="jak_depid" id="department" class="selectpicker form-control" data-live-search="true" data-size="4">
					
						<option value="0"><?php echo $jkl["g105"];?></option>
						<?php if (isset($JAK_DEPARTMENTS) && is_array($JAK_DEPARTMENTS)) foreach($JAK_DEPARTMENTS as $z) { ?>
					
						<option value="<?php echo $z["id"];?>"><?php echo $z["title"];?></option>
					
						<?php } ?>
					
						</select>
					</div>
					
					<div class="form-group">
						<label class="control-label" for="jak_lang"><?php echo $jkl["g22"];?></label>
						<select name="jak_lang" class="selectpicker form-control" data-live-search="true" data-size="4">
						<?php if (isset($lang_files) && is_array($lang_files)) foreach($lang_files as $lf) { ?><option value="<?php echo $lf;?>"<?php if (JAK_LANG == $lf) { ?> selected="selected"<?php } ?>><?php echo ucwords($lf);?></option><?php } ?>
						</select>
					</div>
					
					<div class="form-group">
						<label class="control-label" for="jak_msgtype"><?php echo $jkl["g250"];?></label>
						<select name="jak_msgtype" id="jak_msgtype" class="selectpicker form-control" data-live-search="true" data-size="4">
							<option value="1" checked> <?php echo $jkl["g246"];?></option>
							<option value="2"> <?php echo $jkl["g247"];?></option>
							<option value="3"> <?php echo $jkl["g248"];?></option>
							<option value="4"> <?php echo $jkl["g249"];?></option>
							<option value="5"> <?php echo $jkl["g255"];?></option>
							<option value="6"> <?php echo $jkl["g259"];?></option>
							<option value="7"> <?php echo $jkl["g260"];?></option>
							<option value="8"> <?php echo $jkl["g261"];?></option>
							<option value="9"> <?php echo $jkl["g262"];?></option>
							<option value="10"> <?php echo $jkl["g263"];?></option>
							<option value="11"> <?php echo $jkl["g307"];?></option>
							<option value="12"> <?php echo $jkl["g308"];?></option>
							<option value="13"> <?php echo $jkl["g309"];?></option>
							<option value="26"> <?php echo $jkl["g328"];?></option>
							<option value="27"> <?php echo $jkl["g329"];?></option>
						</select>
					</div>
					
					<div class="form-group">
					    <label class="control-label" for="fireup"><?php echo $jkl["g251"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h17"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></label>
					    <select name="jak_fireup" id="fireup" class="selectpicker form-control" data-live-search="true" data-size="4">
					    <option value="15">15 <?php echo $jkl["g196"];?></option>
					    <option value="30">30 <?php echo $jkl["g196"];?></option>
					    <option value="60">1 <?php echo $jkl["g197"];?></option>
					    <option value="120">2 <?php echo $jkl["g197"];?></option>
					    <option value="180">3 <?php echo $jkl["g197"];?></option>
					    <option value="240">4 <?php echo $jkl["g197"];?></option>
					    <option value="300">5 <?php echo $jkl["g197"];?></option>
					    <option value="360">6 <?php echo $jkl["g197"];?></option>
					    <option value="420">7 <?php echo $jkl["g197"];?></option>
					    <option value="480">8 <?php echo $jkl["g197"];?></option>
					    <option value="540">9 <?php echo $jkl["g197"];?></option>
					    <option value="600">10 <?php echo $jkl["g197"];?></option>
					    <option value="900">15 <?php echo $jkl["g197"];?></option>
					    <option value="1200">20 <?php echo $jkl["g197"];?></option>
					    </select>
					</div>
					
					<div class="form-group">
					    <label class="control-label" for="answer"><?php echo $jkl["g245"];?> <a href="javascript:void(0)" class="jakweb-help" data-content="<?php echo $jkl["h13"];?>" data-original-title="<?php echo $jkl["t"];?>"><i class="fa fa-question-circle"></i></a></label>
						<textarea name="answer" id="answer" class="form-control<?php if (isset($errors["e1"])) echo " is-invalid";?>" rows="5"><?php if (isset($_REQUEST["answer"])) echo $_REQUEST["answer"];?></textarea>
					</div>
					
					<div class="form-actions">
						<button type="submit" name="insert_answer" class="btn btn-primary btn-block"><?php echo $jkl["g38"];?></button>
					</div>

				</form>
		</div>
		
	</div>
</div>
<div class="col-md-8">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-pencil-square"></i> <?php echo $jkl["g243"];?></h3>
	  	</div><!-- /.box-header -->
	  	<div class="box-body">
			<div class="table-responsive">
			<table class="table table-striped">
			<thead>
			<tr>
			<th>#</th>
			<th><?php echo $jkl["g16"];?></th>
			<th><?php echo $jkl["g22"];?></th>
			<th><?php echo $jkl["g47"];?></th>
			<th><?php echo $jkl["g48"];?></th>
			</tr>
			</thead>
			<?php if (isset($ANSWERS_ALL) && is_array($ANSWERS_ALL)) foreach($ANSWERS_ALL as $v) { ?>
			<tr>
			<td><?php echo $v["id"];?></td>
			<td class="title"><a href="<?php echo JAK_rewrite::jakParseurl('answers', 'edit', $v["id"]);?>"><?php echo $v["title"];?></a></td>
			<td class="desc"><?php echo $v["lang"];?></td>
			<td><a class="btn btn-default btn-sm" href="<?php echo JAK_rewrite::jakParseurl('answers', 'edit', $v["id"]);?>"><i class="fa fa-pencil"></i></a></td>
			<td><a class="btn btn-danger btn-sm btn-confirm" href="<?php echo JAK_rewrite::jakParseurl('answers', 'delete', $v["id"]);?>" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e31"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-trash-o"></i></a></td>
			</tr>
			<?php } ?>
			</table>
			</div>

		</div>
	</div>
</div>		
</div>

<?php include_once 'footer.php';?>