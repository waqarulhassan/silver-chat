<?php include_once 'header.php';?>

<div class="row">
<div class="col-md-9">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-inbox"></i> <?php echo $jkl["g98"];?></h3>
	  	</div><!-- /.box-header -->
	  	<div class="box-body">
			
			<?php if (isset($DEPARTMENTS_ALL) && is_array($DEPARTMENTS_ALL)) { ?>
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<div class="table-responsive">
			<table class="table table-striped">
			<thead>
			<tr>
			<th>#</th>
			<th><?php echo $jkl["g16"];?></th>
			<th><?php echo $jkl["g52"];?></th>
			<th><?php echo $jkl["g47"];?></th>
			<th><?php echo $jkl["g101"];?></th>
			<th><?php echo $jkl["g48"];?></th>
			<th><?php echo $jkl["g102"];?></th>
			</tr>
			</thead>
			<?php foreach($DEPARTMENTS_ALL as $v) { ?>
			<tr>
			<td><?php echo $v["id"];?><input type="hidden" name="real_dep_id[]" value="<?php echo $v["id"];?>" /></td>
			<td class="title"><a href="<?php echo JAK_rewrite::jakParseurl('departments', 'edit', $v["id"]);?>"><?php echo $v["title"];?></a></td>
			<td class="desc"><?php echo $v["description"];?></td>
			<td><a class="btn btn-default btn-sm" href="<?php echo JAK_rewrite::jakParseurl('departments', 'edit', $v["id"]);?>"><i class="fa fa-pencil"></i></a></td>
			<td><?php if ($v["id"] != 1) { ?><a class="btn btn-default btn-sm" href="<?php echo JAK_rewrite::jakParseurl('departments', 'lock', $v["id"]);?>" title="<?php if ($v["active"] == 1) { echo $jkl["d35"]; } else { echo $jkl["d36"];}?>"><i class="fa fa-<?php if ($v["active"] == '1') { ?>check<?php } else { ?>lock<?php } ?>"></i></a><?php } ?></td>
			<td><?php if ($v["id"] != 1) { ?><a class="btn btn-danger btn-sm btn-confirm" href="<?php echo JAK_rewrite::jakParseurl('departments', 'delete', $v["id"]);?>" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e30"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-trash-o"></i></a><?php } ?></td>
			<td><input type="text" name="corder[]" class="corder form-control" value="<?php echo $v["dorder"];?>" /></td>
			</tr>
			<?php } ?>
			</table>
			</div>
			
			<div class="box-footer">
			<button type="submit" name="save" class="btn btn-primary pull-right"><?php echo $jkl["g38"];?></button>
			</div>
			
			<?php } ?>
			</form>
	</div>		
</div>
			
</div>
<div class="col-md-3">
	<?php if ($newdep) { ?>
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-inbox"></i> <?php echo $jkl["g99"];?></h3>
	  	</div><!-- /.box-header -->
	  	<div class="box-body">
				
				<?php if ($errors) { ?>
				<div class="alert alert-danger"><?php if (isset($errors["e"])) echo $errors["e"];
					  if (isset($errors["e1"])) echo $errors["e1"];?></div>
				<?php } ?>
				
				<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
				
					<div class="form-group">
					    <label class="control-label" for="title"><?php echo $jkl["g16"];?></label>
						<input type="text" name="title" class="form-control<?php if (isset($errors["e"])) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["title"])) echo $_REQUEST["title"];?>" />
					</div>
					<div class="form-group">
					    <label class="control-label" for="email"><?php echo $jkl["g68"];?></label>
						<input type="text" name="email" class="form-control<?php if (isset($errors["e1"])) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["email"])) echo $_REQUEST["email"];?>" />
					</div>
					<div class="form-group">
					    <label class="control-label" for="faq"><?php echo $jkl["g278"];?></label>
						<input type="text" name="faq" class="form-control" value="<?php if (isset($_REQUEST["faq"])) echo $_REQUEST["faq"];?>" />
					</div>
					<div class="form-group">
					    <label class="control-label" for="description"><?php echo $jkl["g52"];?></label>
						<textarea name="description" class="form-control" rows="5"><?php if (isset($_REQUEST["description"])) echo $_REQUEST["description"];?></textarea>
					</div>
					
					<div class="form-actions">
					<button type="submit" name="insert_department" class="btn btn-primary btn-block"><?php echo $jkl["g38"];?></button>
					</div>

				</form>
		</div>
	</div>
	<?php } else { ?>
	<div class="alert alert-danger"><?php echo $jkl['i6'];?></div>
	<?php } ?>
</div>			
</div>

<?php include_once 'footer.php';?>