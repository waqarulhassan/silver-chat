<?php include_once 'header.php';?>

<div class="row">
<div class="col-md-4">
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><i class="fa fa-list-alt"></i> <?php echo $jkl["g184"];?></h3>
  	</div><!-- /.box-header -->
  	<div class="box-body">
				
				<?php if ($errors) { ?>
				<div class="alert alert-danger"><?php if (isset($errors["e"])) echo $errors["e"];
					  if (isset($errors["e1"])) echo $errors["e1"];?></div>
				<?php } ?>
				
				<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					
					<div class="form-group">
					    <label class="control-label" for="path"><?php echo $jkl["g167"];?></label>
						<input type="text" name="path" class="form-control<?php if (isset($errors["e"])) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["path"])) echo $_REQUEST["path"];?>" />
					</div>
					
					<div class="form-group">
						<label for="title"><?php echo $jkl["g16"];?></label>
						<input type="text" name="title" id="title" class="form-control<?php if (isset($errors["e1"])) echo " is-invalid";?>" value="<?php if (isset($_REQUEST["title"])) echo $_REQUEST["title"];?>" />
					</div>
					
					<div class="form-actions">
						<button type="submit" name="insert_blacklist" class="btn btn-primary btn-block"><?php echo $jkl["g38"];?></button>
					</div>

				</form>
			</div>
		</div>
</div>
<div class="col-md-8">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-th-list"></i> <?php echo $jkl["m27"];?></h3>
	  	</div><!-- /.box-header -->
	  	<div class="box-body">

	  		<?php if (isset($BLACKLIST_ALL) && is_array($BLACKLIST_ALL) && !empty($BLACKLIST_ALL)) { ?>
			<div class="table-responsive">
			<table class="table table-striped">
			<thead>
			<tr>
			<th>#</th>
			<th><?php echo $jkl["g16"];?></th>
			<th><?php echo $jkl["g167"];?></th>
			<th><?php echo $jkl["g47"];?></th>
			<th><?php echo $jkl["g48"];?></th>
			</tr>
			</thead>
			<?php foreach($BLACKLIST_ALL as $v) { ?>
			<tr>
			<td><?php echo $v["id"];?></td>
			<td><a href="<?php echo JAK_rewrite::jakParseurl('blacklist', 'edit', $v["id"]);?>"><?php echo $v["title"];?></a></td>
			<td><?php echo $v["path"];?></td>
			<td><a class="btn btn-default btn-sm" href="<?php echo JAK_rewrite::jakParseurl('blacklist', 'edit', $v["id"]);?>"><i class="fa fa-pencil"></i></a></td>
			<td><a class="btn btn-danger btn-sm btn-confirm" href="<?php echo JAK_rewrite::jakParseurl('blacklist', 'delete', $v["id"]);?>" data-title="<?php echo addslashes($jkl["g48"]);?>" data-text="<?php echo addslashes($jkl["e30"]);?>" data-type="warning" data-okbtn="<?php echo addslashes($jkl["g279"]);?>" data-cbtn="<?php echo addslashes($jkl["g280"]);?>"><i class="fa fa-trash-o"></i></a></td>
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